<?php
class Mods_model extends CI_Model {

	var $id = '';
	var $title = '';
	var $type = '';

	function __construct() {
		// Call the Model constructor
		parent::__construct();
	}
	
	function getMods() {
		$query = $this->mongo_db->where(array('active' => true))->order_by(array('date' => FALSE))->get('mods');

		return $query;
	}

	function getUserMods($user) { 
		$query = $this->mongo_db->where(array('active' => true, 'username' => $user))->order_by(array('date' => FALSE))->get('mods');

		return $query;
	}

	function getMod($url) {
		$query = $this->mongo_db->where(array('url' => $url))->get('mods');

		return $query;
	}

	function getPrimaryVersion($url) {
		$mod = $this->mongo_db->where(array('url' => $url))->get('mods');
		$mod = $mod[0];
		foreach($mod['files']["0"] as $key => $value) {
			if($mod['version'] == $key) {
				$query = $value;
			}
		}

		return $query;
	}

}