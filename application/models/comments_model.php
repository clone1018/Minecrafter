<?php
class Comments_model extends CI_Model {

	var $username = '';
	var $title = '';
	var $content = '';
	var $url = '';

	function __construct() {
		// Call the Model constructor
		parent::__construct();
	}

	function getComments($url) {
		if($this->contains($url, 'post')) {
			$newurl = explode('/', $url);
			$url = $newurl[0] . '/' . $newurl[1] . '/' . $newurl[2];
		}
		$comments = $this->mongo_db->where(array('url' => $url))->get('comments');

		return $comments;
	}
	
	function postComment($username, $title, $content, $url) {
		$this->load->helper('inflector');

		if($this->contains($url, 'post')) {
			$newurl = explode('/', $url);
			$url = $newurl[0] . '/' . $newurl[1] . '/' . $newurl[2];
		}
		
		$comment = array(
			'username' => $username,
			'title' => $title,
			'content' => $content,
			'url' => $url,
			'hostinfo' => $_SERVER);

		$this->mongo_db->insert('comments', $comment);

		$curl = explode('/', $url);
		if($curl[0] == 'mod' || $curl[0] == 'server') {
			$category = $curl[0];
			$nurl = $curl[1];

			$thing = $this->mongo_db->where(array('url' => $nurl))->get(plural($category));
			$thing = $thing[0];

			$params = array(
				'from' => $username,
				'url' => $url,
				'title' => 'New comment at '.$thing['name'],
				'content' => $content);

			$this->notifications->send($thing['username'], $params);
		}
	}

	function contains($string, $needle) {
        return strpos($string, $needle) !== false;
    }
}