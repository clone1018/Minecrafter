<?php

class Search_model extends CI_Model {

	var $database = '';
	var $field    = '';
	var $query    = '';

	function __construct() {
		// Call the Model constructor
		parent::__construct();
	}

	function search($database, $field, $query) {
		if($database == 'mods') $results = $this->mongo_db->like($field, $query, 'ims')->where(array('active' => true))->get($database);
		else $results = $this->mongo_db->like($field, $query, 'ims')->get($database);

		return $results;
	}

	function searchServers($field, $query) {
		$servers = $this->mongo_db->like($field, $query, 'ims')->get('servers');

		return $servers;
	}

	function countCategory($category) {
		return $this->mongo_db->count($category);
	}
}