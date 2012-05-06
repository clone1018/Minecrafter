<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	public function index()	{
		$data['title'] = 'Minecrafter';
		$data['description'] = 'Welcome to Minecrafter';

		// Content Data
		$data['users'] = $this->mongo_db->order_by(array('registered' => 'desc'))->limit(42)->get('users');
		$data['skins'] = $this->mongo_db->order_by(array('date' => 'desc'))->limit(21)->get('skins');
		$data['mods'] = $this->mongo_db->order_by(array('date' => 'desc'))->where(array('active' => true))->limit(5)->get('mods');
		$data['servers'] = $this->mongo_db->order_by(array('date' => 'desc'))->limit(5)->get('servers');

		$data['content'] = $this->load->view('root/home', $data, true);

		$this->load->view('layouts/default', $data);
	}

	public function chat() {
		$data['title'] = 'Community Chat';
		$data['description'] = 'Come chat with us! irc.esper.net #minecrafter';
		$data['content'] = $this->load->view('root/chat', $data, true);

		$this->load->view('layouts/default', $data);
	}

	public function forums() {
		$data['title'] = 'Forums';
		$data['content'] = $this->load->view('root/forums', $data, true);

		$this->load->view('layouts/default', $data);
	}

	public function terms() {
		$data['title'] = 'Terms of Service';
		$data['description'] = 'A required read!';
		$data['content'] = $this->load->view('root/terms', $data, true);

		$this->load->view('layouts/default', $data);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */