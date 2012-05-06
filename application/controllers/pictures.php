<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pictures extends CI_Controller {

	public function index()	{
		$pid = $this->uri->segment(2);
		$this->load->library(array('form_validation'));

		$picture = $this->mongo_db->where(array('_id' => $pid))->get('pictures');
		$picture = $picture[0];

		$data['title'] = $picture['file']['file_name'];

		// Content Data
		$data['picture'] = $picture;
		$data['content'] = $this->load->view('pictures/single', $data, true);

		$this->load->view('layouts/default', $data);
	}

	public function gallery() {

	}

	public function submit() {
		$this->load->library('form_validation');

		$config['upload_path'] = './uploads/pictures/';
		$config['allowed_types'] = 'png|jpg|jpeg';
		$config['max_size'] = '0';

		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('file')) {
			$this->session->set_flashdata('error', $this->upload->display_errors());

			echo 'upload filed';

			//redirect($_SERVER['HTTP_REFERRER']);
		} else {
			$picture = array(
				'url' => $this->input->post('url'),
				'username' => $this->session->userdata('username'),
				'date' => time(),
				'file' => $this->upload->data()
			);

			$id = $this->mongo_db->insert('pictures', $picture);

			redirect('picture/'.$id);
		}


	}

	public function post() {
		if (!$this->Account_model->loggedin())
			redirect('account/login');

		$this->load->library(array('form_validation'));
		$this->load->model(array('Mods_model','Comments_model'));

		$this->form_validation->set_rules('title', 'Title', 'required|min_length[4]|max_length[40]');
		$this->form_validation->set_rules('content', 'Comment Content', 'required');

		if ($this->form_validation->run() == FALSE) {
			$this->load->helper('markdown');
			$this->load->library(array('form_validation'));

			$picture = $this->mongo_db->where(array('_id' => $pid))->get('pictures');
			$picture = $picture[0];

			$data['title'] = $picture['file']['file_name'];
			$data['picture'] = $picture;
			$data['content'] = $this->load->view('pictures/single', $data, true);

			$this->load->view('layouts/default', $data);
		} else {
			$url = $this->uri->segment(1).'/'.$this->uri->segment(2);

			$this->Comments_model->postComment($this->session->userdata('username'), $this->input->post('title'), $this->input->post('content'), $url);
			redirect($url);
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */