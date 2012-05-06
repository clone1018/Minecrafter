<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	public function index()	{
		$this->load->helper('text');
		$this->load->model('Database_model');

		$data['title'] = 'The Minecraft Database';
		$data['description'] = 'A complete database of all that is Minecraft';
		//$data['button'] = anchor('database/add', 'Add to Database', array('class' => 'btn primary large', 'style' => 'float: right;'));
		$data['blocks'] = $this->Database_model->getType('blocks');
		$data['items'] = $this->Database_model->getType('items');

		$data['content'] = $this->load->view('database/home', $data, true);

		$this->load->view('layouts/default', $data);
	}

	public function category() {
		$this->load->helper('markdown');
		$this->load->model(array('Database_model','Comments_model'));
		$this->load->library(array('form_validation'));

		$dec = $this->uri->segment(3);
		$data['database'] = $this->Database_model->getSingle($dec);
		$data['comments'] = $this->Comments_model->getComments(uri_string());
		//$data['button'] = anchor('database', 'Back', array('class' => 'btn success large', 'style' => 'float: left; margin-right: 20px')) . " " . anchor('database/add', 'Add to Database', array('class' => 'btn primary large', 'style' => 'float: right;'));
		$data['db'] = $data['database'][0];
		$data['title'] = $data['db']['name'];
		$data['description'] = "DEC: <strong>". $data['db']['dec'] ."</strong> HEX: <strong>". $data['db']['hex'] ."</strong>";
		$data['content'] = $this->load->view('database/single', $data, true);

		$this->load->view('layouts/default', $data);
	}

	
	public function rename() {
		$this->load->model('Database_model');

		$database = $this->Database_model->getDatabase();
		foreach($database as $db) {
			$db['dec'] = (string)$db['dec'];
			unset($db['_id']);
			$this->mongo_db->where(array('hex' => $db['hex']))->update('database', $db);
			/*
			if($db['category'] == 'Item') {
				$db['category'] = 'items';
				unset($db['_id']);
				$this->mongo_db->where(array('dec' => $db['dec']))->update('database', $db);
			}
			if($db['category'] == 'Block') {
				$db['category'] = 'blocks';
				unset($db['_id']);
				$this->mongo_db->where(array('dec' => $db['dec']))->update('database', $db);
			}
			*/
		}
	}

	public function post() {
		if (!$this->Account_model->loggedin())
			redirect('account/login');

		$this->load->library(array('form_validation'));
		$this->load->model(array('Database_model','Comments_model'));

		$this->form_validation->set_rules('title', 'Title', 'required|min_length[4]|max_length[40]');
		$this->form_validation->set_rules('content', 'Comment Content', 'required');

		if ($this->form_validation->run() == FALSE) {
			$this->load->helper('markdown');
			$this->load->library(array('form_validation'));

			$dec = $this->uri->segment(3);
			$data['database'] = $this->Database_model->getSingle($dec);
			$data['comments'] = $this->Comments_model->getComments(uri_string());
			$data['db'] = $data['database'][0];
			$data['title'] = $data['db']['name'];
			$data['content'] = $this->load->view('database/single', $data, true);

			$this->load->view('layouts/default', $data);
		} else {
			$this->Comments_model->postComment($this->session->userdata('username'), $this->input->post('title'), $this->input->post('content'), $this->input->post('url'));
			redirect($this->input->post('url'));
		}
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */