<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Notificationscontroller extends CI_Controller {

	public function index() {
		redirect('/');
	}

	public function read() {
		$id = $this->uri->segment(3);

		$this->mongo_db->where(array('_id' => $id))->set('status', 'read')->update('notifications');

		$url = $this->mongo_db->where(array('_id' => $id))->get('notifications');
		$url = $url[0];
		//$this->mongo_db->where(array('to' => $this->session->userdata('username'), 'status' => 'unread'))->set('status', 'read')->update_all('notifications');

		redirect($url['url']);
	}

	public function readAll() {
		$notifications = $this->mongo_db->where(array('to' => $this->session->userdata('username')))->get('notifications');

		foreach($notifications as $notification) {
			$this->mongo_db->where(array('_id' => $notification['_id']['$id']))->set('status', 'read')->update('notifications');
		}
		redirect($_SERVER['HTTP_REFERRER']);
	}

	public function subscribe() {
		$this->load->helper('inflector');

		$category = $this->uri->segment(3);
		$page = $this->uri->segment(4);
		$username = $this->session->userdata('username');

		$item = $this->mongo_db->where(array('url' => $page))->get($category);
		$item = $item[0];
		if(!isset($item['subscribers'])) $item['subscribers'] = array();
		array_push($item['subscribers'], $username);

		$this->mongo_db->where(array('url' => $page))->set('subscribers', $item['subscribers'])->update($category);

		redirect(singular($category).'/'.$page);
	}

	public function unsubscribe() {
		$this->load->helper('inflector');

		$category = $this->uri->segment(3);
		$page = $this->uri->segment(4);
		$username = $this->session->userdata('username');

		$item = $this->mongo_db->where(array('url' => $page))->get($category);
		$item = $item[0];
		foreach($item['subscribers'] as $key => $subscriber) {
			if($username == $subscriber) {
				unset($item['subscribers'][$key]);
			}

		}
		$this->mongo_db->where(array('url' => $page))->set('subscribers', $item['subscribers'])->update($category);

		redirect(singular($category).'/'.$page);
	}

	public function subscribed($user, $category, $page) {
		$thing = $this->mongo_db->where(array('url' => $page))->get($category);

		if(isset($thing['subscribers'])) {

			foreach($thing['subscribers'] as $subscriber ) {
				if($user == $subscriber) return true;
				else return false;
			}

		} else {
			return false;
		}
		echo "derp";
	}

}

/* End of file notifications.php */
/* Location: ./application/controllers/notifications.php */