<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mods extends CI_Controller {

	public function index()	{
		echo "function: all, mod/url";
	}

	public function all() {
		$mods = $this->mongo_db->where(array('active' => true))->get('mods');

		foreach($mods as $key => $mod) {
			unset($mods[$key]['_id']);
			unset($mods[$key]['minequeryport']);
		}

		echo json_encode($mods);
	}

	public function mod() {
		$url = $this->uri->segment(4);
		$mod = $this->mongo_db->where(array('url' => $url))->get('mods');
		$mod = $mod[0];
		unset($mod['_id']);

		echo json_encode($mod);
	}

}

/* End of file servers.php */
/* Location: ./application/controllers/api/servers.php */