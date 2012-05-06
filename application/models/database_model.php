<?php
class Database_model extends CI_Model {

	var $id = '';
	var $title = '';
	var $type = '';

	function __construct() {
		// Call the Model constructor
		parent::__construct();
	}
	
	function getDatabase() {
		$query = $this->mongo_db->order_by(array('hex' => 1))->get('database');

		return $query;
	}

	function getType($type) {
		$query = $this->mongo_db->order_by(array('dec' => 'asc'))->where(array('category' => $type))->get('database');

		return $query;
	}

	function getSingle($dec) {
		$query = $this->mongo_db->where(array('dec' => $dec))->get('database');

		return $query;
	}

}