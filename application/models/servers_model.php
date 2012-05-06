<?php
class Servers_model extends CI_Model {

	var $start = 0;
	var $limit = 20;
	var $url = '';

	function __construct() {
		// Call the Model constructor
		parent::__construct();
	}
	
	function getServers() {
		$query = $this->mongo_db->where(array('query' => array('status' => 'online')))->get('servers');

		return $query;
	}

	function getHot($start = 0, $limit = 20) {
		$servers = $this->mongo_db->order_by(array('rank' => 'DESC'))->get('servers');

		foreach($servers as $key => $server){ 
			if($server['query']['status'] != 'online') {
				unset($servers[$key]);
			}
			if((double)$server['rank'] < 10)
				unset($servers[$key]);
			//if(date('W', $server['date']) != date('W', time())) {
			//	unset($servers[$key]);
			//}
		}

		return $servers;
	}

	function getTop($start = 0, $limit = 20) {
		$servers = $this->mongo_db->order_by(array('rank' => 'DESC'))->get('servers');

		foreach($servers as $key => $server){ 
			if($server['query']['status'] != 'online') {
				unset($servers[$key]);
			}
		}

		return $servers;
	}

	function getNew($start = 0, $limit = 20) {
		$servers = $this->mongo_db->order_by(array('date' => 'DESC'))->get('servers');

		foreach($servers as $key => $server){ 
			if($server['query']['status'] != 'online') {
				unset($servers[$key]);
			}
		}

		return $servers;
	}

	function getServer($url) {
		$query = $this->mongo_db->where(array('url' => $url))->get('servers');

		return $query;
	}

	function addServer() {
		
	}

}