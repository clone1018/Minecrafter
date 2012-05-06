<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Servers extends CI_Controller {

	public function index()	{
		echo "function: all, server/url";
	}

	public function all() {
		$servers = $this->mongo_db->get('servers');

		foreach($servers as $key => $server) {
			unset($servers[$key]['_id']);
			unset($servers[$key]['rconpass']);
			unset($servers[$key]['rconport']);
			unset($servers[$key]['minequeryport']);
		}

		echo json_encode($servers);
	}

	public function server() {
		
	}

}

/* End of file servers.php */
/* Location: ./application/controllers/api/servers.php */