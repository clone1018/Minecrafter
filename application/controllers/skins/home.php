<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	public function index()	{
		$this->load->model('Skins_model');

		$data['title'] = 'Minecraft Skins';
		$data['description'] = 'A huge list of the best Minecraft Skins!';
		$data['button'] = anchor('skins/add', 'Add a Skin', array('class' => 'btn btn-primary', 'style' => 'float: right;'));
		$data['skins'] = $this->Skins_model->getSkins();

		$data['content'] = $this->load->view('skins/home', $data, true);

		$this->load->view('layouts/default', $data);
	}

	public function skin() {
		$this->load->helper('markdown');
		$this->load->model(array('Skins_model','Comments_model'));
		$this->load->library(array('form_validation','Skins'));

		$id = $this->uri->segment(2);
		$data['skin'] = $this->Skins_model->getSkin($id);
		$user = explode('.', $data['skin']['file']['file_name']);
		$this->skins->minecraft_skin_download($id, $user[0]);

		$data['user'] = $this->Account_model->info($data['skin']['username']);
		$data['comments'] = $this->Comments_model->getComments(uri_string());
		$data['title'] = $data['skin']['name'];
		$data['content'] = $this->load->view('skins/single', $data, true);

		$this->load->view('layouts/default', $data);
	}

	public function add() {
		if (!$this->Account_model->loggedin())
			redirect('account/login');
		$this->load->model(array('Skins_model'));
		$this->load->library(array('form_validation'));

		$this->form_validation->set_rules('name', 'Skin Name', 'required|callback_validateName');
		$this->form_validation->set_rules('tags', 'Tags', '');
		$this->form_validation->set_rules('content', 'Skin Description', 'required');
		$this->form_validation->set_rules('file', 'File', '');

		$this->form_validation->set_rules('tos', 'Terms of Service', 'callback_checked');

		if ($this->form_validation->run() == FALSE) {
			$data['title'] = 'Add a Skin';
			$data['description'] = 'Submit your skin to our list';
			$data['content'] = $this->load->view('skins/upload', $data, true);

			$this->load->view('layouts/default', $data);
		} else {
			$config['upload_path'] = './uploads/skins/';
			$config['allowed_types'] = 'png';
			$config['max_size']	= '10';
			$config['max_width']  = '64';
			$config['max_height']  = '32';

			$this->load->library('upload', $config);

			if (!$this->upload->do_upload('file')) {
				$data['error'] = array('error' => $this->upload->display_errors());

				$data['title'] = 'Add a Skin';
				$data['description'] = 'Submit your skin to our list';
				$data['content'] = $this->load->view('skins/upload', $data, true);

				$this->load->view('layouts/default', $data);
			} else {

				$skin = array(
					'name' => $this->input->post('name'),
					'tags' => $this->input->post('tags'),
					'content' => $this->input->post('content'),
					'username' => $this->session->userdata('username'),
					'date' => time(),
					'downloads' => 0,
					'file' => $this->upload->data()
				);

				$id = $this->mongo_db->insert('skins', $skin);

				redirect('skin/'.$id);
			}
		}
	}

	public function post() {
		if (!$this->Account_model->loggedin())
			redirect('account/login');

		$this->load->library(array('form_validation'));
		$this->load->model(array('Skins_model','Comments_model'));

		$this->form_validation->set_rules('title', 'Title', 'required|min_length[4]|max_length[40]');
		$this->form_validation->set_rules('content', 'Comment Content', 'required');

		if ($this->form_validation->run() == FALSE) {
			$this->load->helper('markdown');
			$this->load->library(array('form_validation'));

			$url = $this->uri->segment(2);
			$data['mod'] = $this->Mods_model->getMod($url);
			$data['comments'] = $this->Comments_model->getComments(uri_string());
			$data['mod'] = $data['mod'][0];
			$data['title'] = $data['mod']['name'];
			$data['content'] = $this->load->view('mods/single', $data, true);

			$this->load->view('layouts/default', $data);
		} else {
			$this->Comments_model->postComment($this->session->userdata('username'), $this->input->post('title'), $this->input->post('content'), $this->input->post('url'));
			redirect($this->input->post('url'));
		}
	}

	function formatName($name) {
		$name = str_replace(' ', '', $name);

		return $name;
	} 

	function validateName($name) {
		if(preg_match('/^[a-zA-Z0-9 ]+$/', $name)) {
			return true;
		} else {
			$this->form_validation->set_message('validateName', 'Invalid mod name!');
			return false;
		}
	}
	function validateTags($tags) {
		if(preg_match('/^[a-zA-Z0-9 \[\]]+$/', $name)) {
			return true;
		} else {
			$this->form_validation->set_message('validateName', 'Invalid tags!');
			return false;
		}
	}
	function checked($option) {
		if($option == true || $option == 'true' || $option == 'on') {
			return true;
		} else {
			$this->form_validation->set_message('checked', 'You must agree to the Terms of Service.');
			return false;
		}
	}


}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */