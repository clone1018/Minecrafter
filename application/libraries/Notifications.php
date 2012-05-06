<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Notifications {

	public function __construct() {
		$this->CI =& get_instance();
	}

	public function send($username, $params) {
		// Get the event
		if(!isset($params['from'])) $params['from'] = 'system';

		$notification = array(
			'to' => $username,
			'from' => $params['from'],
			'url' => $params['url'],
			'title' => $params['title'],
			'content' => $params['content'],
			'status' => 'unread',
			'time' => time());

		// Get the users who want to know

		// Add to notifcation quene

		$this->CI->mongo_db->insert('notifications', $notification);

		// Send to email quene
	}

	public function get($username, $status = 'unread') {
		$notifications = $this->CI->mongo_db->order_by(array('time' => 'DESC'))->where(array('to' => $username, 'status' => $status))->get('notifications');
		return $notifications;
	}

	public function number($username, $status = 'unread') {
		$count = $this->CI->mongo_db->where(array('to' => $username, 'status' => $status))->count('notifications');
		return $count;
	}

	public function subscribed($user, $category, $page) {
		$thing = $this->CI->mongo_db->where(array('url' => $page))->get($category);
		$thing = $thing[0];

		if(isset($thing['subscribers'])) {

			foreach($thing['subscribers'] as $subscriber ) {
				if($user == $subscriber) return true;
				else return false;
			}

		} else {
			return false;
		}
	}
}

/* End of file Notifications.php */