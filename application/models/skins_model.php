<?php

class Skins_model extends CI_Model {

	function __construct() {
		// Call the Model constructor
		parent::__construct();
	}

	function getSkins() {
		$skins = $this->mongo_db->get('skins');

		return $skins;
	}

	function getSkin($id) {
		$skin = $this->mongo_db->where(array('_id' => $id))->get('skins');
		$skin = $skin[0];

		return $skin;
	}
}