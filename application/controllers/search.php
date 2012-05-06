<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Search extends CI_Controller {

	public function index()	{
		$this->load->model('Search_model');
		$this->load->library('servers');
		$this->load->helper('text');

		$query = $this->uri->segment(2);
		if($this->input->get_post('q') != '') $query = $this->input->get_post('q');
		if($query == '') {
			$data['title'] = 'Search';
			$data['content'] = "<p>You need to enter search terms to search.</p>";
		} else {
			$data['blocks'] = $this->mongo_db->where(array('category' => 'blocks'))->like('description', $query, 'ims')->get('database');
			$data['items'] = $this->mongo_db->where(array('category' => 'items'))->like('description', $query, 'ims')->get('database');
			$data['mods'] = $this->Search_model->search('mods', 'content', $query);
			$data['hot'] = $this->Search_model->searchServers('content', $query);
			$data['users'] = $this->Search_model->search('users', 'username', $query);

			$data['title'] = 'Search';
			$data['description'] = 'You\'re searching for: '.$query;
			$data['content'] = $this->load->view('root/search', $data, true);
		}

		$this->load->view('layouts/default', $data);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */