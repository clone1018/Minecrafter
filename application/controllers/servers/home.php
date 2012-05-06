<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	public function index()	{
		$this->load->model('Servers_model');
		$this->load->library('Servers');

		$data['title'] = 'Minecraft Server List';
		$data['description'] = 'A huge list of the best Minecraft Servers!';
		$data['button'] = anchor('servers/add', 'Add Server', array('class' => 'btn btn-primary large', 'style' => 'float: right;'));
		$data['hot'] = $this->Servers_model->getHot();
		$data['top'] = $this->Servers_model->getTop();
		$data['new'] = $this->Servers_model->getNew();

		$data['content'] = $this->load->view('servers/home', $data, true);

		$this->load->view('layouts/default', $data);
	}

	public function server() {
		$this->load->helper('markdown');
		$this->load->model(array('Servers_model','Comments_model'));
		$this->load->library(array('form_validation'));

		$url = $this->uri->segment(2);
		$data['server'] = $this->Servers_model->getServer($url);
		$data['server'] = $data['server'][0];

		/*if(isset($data['server']['rconpass'])) {
			$this->load->library('Rcon', array('host' => $data['server']['ip'], 'port' => $data['server']['rconport'], 'password' => $data['server']['rconpass']));
			if($this->rcon->Auth()){
				$data['players'] = $this->rcon->rconCommand("list");
			}
		}*/

		$data['checks'] = $this->mongo_db->where(array('server' => $data['server']['url']))->order_by(array('time' => 'DESC'))->get('checks');
		$data['user'] = $this->Account_model->info($data['server']['username']);
		$data['comments'] = $this->Comments_model->getComments(uri_string());
		$data['title'] = $data['server']['name'];
		$data['content'] = $this->load->view('servers/single', $data, true);

		$this->load->view('layouts/default', $data);
	}

	public function add() {
		if (!$this->Account_model->loggedin())
			redirect('account/login');
		$this->load->model(array('Servers_model'));
		$this->load->library(array('form_validation','servers'));

		$this->form_validation->set_rules('name', 'Server Name', 'required|max_length[50]|callback_validateName');
		$this->form_validation->set_rules('ip', 'Server IP', 'required');
		$this->form_validation->set_rules('port', 'Server Port', 'required|max_length[5]');
		$this->form_validation->set_rules('content', 'Page Content', 'required');
		$this->form_validation->set_rules('rconport', 'RCON Port', '');
		$this->form_validation->set_rules('rconpass', 'RCON Pass', '');

		$this->form_validation->set_rules('tos', 'Terms of Service', 'callback_checked');

		if ($this->form_validation->run() == FALSE) {
			$data['title'] = 'Submit Server';
			$data['description'] = 'Add your server to our growing list';
			$data['content'] = $this->load->view('servers/new', $data, true);

			$this->load->view('layouts/default', $data);
		} else {
			$url =  $this->formatName($this->input->post('name'));

			$query = $this->servers->query($this->input->post('ip'), $this->input->post('port'), 5);
			if($query == false) $query['status'] = 'offline'; else $query['status'] = 'online'; 
			$query['server'] = $url;
			$query['time'] = time();

			$this->mongo_db->where(array('url' => $server['url']))->set('query', $query)->update('servers');

			$server = array(
				'name' => $this->input->post('name'),
				'url' => $url,
				'ip' => $this->input->post('ip'),
				'port' => $this->input->post('port'),
				'content' => $this->input->post('content'),
				'rconport' => $this->input->post('rconport'),
				'rconpass' => $this->input->post('rconpass'),
				'minequeryport' => $this->input->post('minequeryport'),
				'comments' => $this->input->post('comments'),
				'username' => $this->session->userdata('username'),
				'query' => $query,
				'rank' => 10,
				'date' => time()
			);

			$this->mongo_db->insert('servers', $server);

			redirect('server/'.$url);
		}
	}

	public function post() {
		if (!$this->Account_model->loggedin())
			redirect('account/login');

		$this->load->library(array('form_validation','servers'));
		$this->load->model(array('Mods_model','Comments_model'));

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

	public function edit() {
		if (!$this->Account_model->loggedin())
			redirect('account/login');

		$this->load->model(array('Servers_model'));
		$this->load->library(array('form_validation','servers'));

		$url = $this->uri->segment(2);
		$server = $this->Servers_model->getServer($url);
		$server = $server[0];
		if($server['username'] != $this->session->userdata('username'))
			redirect('server/'.$server['url']);

		$this->form_validation->set_rules('ip', 'Server IP', 'required');
		$this->form_validation->set_rules('port', 'Server Port', 'required|max_length[5]');
		$this->form_validation->set_rules('content', 'Page Content', 'required');
		$this->form_validation->set_rules('rconport', 'RCON Port', 'max_length[5]');
		$this->form_validation->set_rules('rconpass', 'RCON Pass', '');
		$this->form_validation->set_rules('minequeryport', 'MineQuery Port', 'max_length[5]');

		if ($this->form_validation->run() == FALSE) {
			$data['server'] = $server;
			$data['title'] = 'Edit '.$server['name'];
			$data['description'] = 'Change your server page';
			$data['content'] = $this->load->view('servers/edit', $data, true);

			$this->load->view('layouts/default', $data);
		} else {
			$query = $this->servers->query($this->input->post('ip'), $this->input->post('port'), 5);
			if($query == false) $query['status'] = 'offline'; else $query['status'] = 'online'; 
			$query['server'] = $url;
			$query['time'] = time();

			$this->mongo_db->where(array('url' => $server['url']))->set('query', $query)->update('servers');
			
			if($this->input->post('ip') != '') {
				$server['ip'] = $this->input->post('ip');
			}
			if($this->input->post('port') != '') {
				$server['port'] = $this->input->post('port');
			}
			if($this->input->post('content') != '') {
				$server['content'] = $this->input->post('content');
			}
			if($this->input->post('rconport') != '') {
				$server['rconport'] = $this->input->post('rconport');
			}
			if($this->input->post('rconpass') != '') {
				$server['rconpass'] = $this->input->post('rconpass');
			}
			if($this->input->post('minequeryport') != '') {
				$server['minequeryport'] = $this->input->post('minequeryport');
			}
			unset($server['_id']);

			$this->mongo_db->where(array('url' => $url))->update('servers', $server);

			redirect('server/'.$server['url']);
		}
	}

	public function testing() {
		

		$params = array(
			'host' => '127.0.0.1',
			'port' => 25575,
			'password' => 'testing');

		$this->load->library('Rcon', $params);
		
		if($this->rcon->Auth()){
			echo $this->rcon->rconCommand("list");//send a command, echo returned value

			var_dump($this->rcon->read());

		}
	}

	function formatName($name) {
		$name = str_replace(' ', '', $name);

		return $name;
	} 

	function validateName($name) {
		if(preg_match('/^[a-zA-Z0-9. ]+$/', $name)) {
			return true;
		} else {
			$this->form_validation->set_message('validateName', 'Invalid server name!');
			return false;
		}
	}

	public function derp() {
		$beginning_time = microtime(true);

		$fp = fsockopen('smp.tehkrush.net', 25565, $errno, $errstr, 5);
    	if (!$fp) return false;

    	$end_time = microtime(true);
    
    	fwrite($fp, "\xFE");
    	$d = fread($fp, 256);
    	if ($d[0] != "\xFF") return false;
    	$d = substr($d, 3);
    	$d = mb_convert_encoding($d, 'auto', 'UCS-2');
    	$d = explode("\xA7", $d);

    	var_dump($d);
    	//return array(
    	//	'motd'        =>        $d[0],
    //		'players'     => intval($d[1]),
   //		'max_players' => intval($d[2]),
   // 		'latency'     => ($end_time - $beginning_time) * 1000);
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