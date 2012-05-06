<?php if( PHP_SAPI != 'cli') exit('Nope.jpg');
error_reporting(E_ALL);

class Tools extends CI_Controller {

	public function index() {
		echo "Hello derp!".PHP_EOL;
	}

	public function fifteenminutes() {
		$this->servers();
		$this->clearOldUsers();
	}

	private function servers()	{
		$this->load->library('servers');

		$servers = $this->mongo_db->get('servers');

		foreach($servers as $server) {
			$query = $this->servers->query($server['ip'], $server['port'], 5);
			if($query == false) {
				$query['status'] = 'offline'; 

				$params = array('from' => 'system', 
								'url' => 'server/'.$server['url'], 
								'title' => $server['name'].' is down!',
								'content' => 'Your server went down on '.date('M j, Y', time()).' at '.date('g:i:s a', time()));
				$this->notifications->send($server['username'], $params);
			} else $query['status'] = 'online'; 
			$query['server'] = $server['url'];
			$query['time'] = time();

			$players = $query['players'];
			if($query['status'] == 'offline') $server['rank'] = (float)$server['rank'] - .05;
			(float)$server['rank'] = (float)$server['rank'] + "0.00$players";

			$this->mongo_db->where(array('url' => $server['url']))->set('query', $query)->set('rank', $server['rank'])->update('servers');

			$this->mongo_db->insert('checks', $query);
		}

		echo count($servers) . " servers queried";

	}

	private function clearOldUsers() {
		$online = $this->mongo_db->get('online');

		foreach($online as $user) {
			if(( time() - $user['time'] ) / 60 >= 10) {
				$this->mongo_db->where(array('username' => $user['username']))->delete('online');
			}
		}
	}
	/*
	public function derp() {
		$users = $this->mongo_db->get('users');

		foreach($users as $user) {
			if(!isset($user['mcname']) || $user['mcname'] == '') {
				$user['mcname'] = $user['username'];
				unset($user['_id']);
				$this->mongo_db->where(array('username' => $user['username']))->set('mcname', $user['mcname'])->update('users');
			}
				
		}
	}
	*/
}

/* End of file tools.php */
/* Location: ./application/controllers/tools.php */
?>