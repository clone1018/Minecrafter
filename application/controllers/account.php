<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Account extends CI_Controller {

	public function index() {
		if (!$this->Account_model->loggedin())
			redirect('account/login');
		$this->load->helper(array('text', 'inflector', 'markdown'));
		$this->load->model('Mods_model');
		$this->load->library('Servers');

		$user = $this->session->userdata('username');

		$data['title'] = $user;
		$data['description'] = '';
		$data['user'] = $this->Account_model->info($user);
		$data['servers'] = $this->Account_model->getFrom('servers', $user);
		$data['skins'] = $this->Account_model->getFrom('skins', $user);
		$data['mods'] = $this->Account_model->getFrom('mods', $user);
		$data['comments'] = $this->Account_model->getFrom('comments', $user);
		$data['content'] = $this->load->view('account/home', $data, true);


		$this->load->view('layouts/default', $data);
	}

	public function user() {
		$this->load->helper(array('text', 'inflector', 'markdown'));
		$this->load->model(array('Mods_model','Comments_model'));
		$this->load->library('Servers');
		$user = $this->uri->segment(2);

		$data['title'] = $user;
		$data['description'] = '';
		$data['user'] = $this->Account_model->info($user);
		$data['mods'] = $this->Mods_model->getUserMods($user);
		$data['servers'] = $this->Account_model->getFrom('servers', $user);
		$data['skins'] = $this->Account_model->getFrom('skins', $user);
		$data['comments'] = $this->Account_model->getFrom('comments', $user);
		$data['content'] = $this->load->view('account/home', $data, true);

		$this->load->view('layouts/default', $data);
	}

	public function auth() {
		$user = $this->uri->segment(3);

		$muser = $this->mongo_db->where(array('mcname' => $user))->get('users');

		if($muser[0]) {
			header('Content-type: text/plain');
			exit();
		} else {
			header('Content-type: text/plain');
			echo "Register at minecrafter.com to build!";
		}
	}

	public function login() {
		if ($this->Account_model->loggedin())
			redirect('account');

		$this->load->library(array('form_validation', 'encrypt'));

		$this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[3]|max_length[16]|callback_logincheck');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]');

		if ($this->form_validation->run() == FALSE) {
			$data['title'] = 'Login';
			$data['description'] = 'Here you can login, with your login!';
			$data['button'] = anchor('account/register', 'Register', array('class' => 'btn btn-primary', 'style' => 'float: right;'));
			$data['content'] = $this->load->view('account/login', $data, true);

			$this->load->view('layouts/default', $data);
		} else {
			redirect($this->input->server('HTTP_REFERER'));
		}
	}

	public function register() {
		if ($this->Account_model->loggedin())
			redirect('account');

		$this->load->library(array('email', 'form_validation', 'encrypt'));

		$this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[3]|alpha_numeric|max_length[16]|callback_usercheck');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|matches[confirmpass]|min_length[6]');
		$this->form_validation->set_rules('confirmpass', 'Password Confirmation', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
		$this->form_validation->set_rules('name', 'Name', '');
		$this->form_validation->set_rules('terms', 'tos', 'callback_checked');

		if ($this->form_validation->run() == FALSE) {
			$data['title'] = 'Register';
			$data['description'] = 'This is the register description!';
			$data['button'] = anchor('account/login', 'Login', array('class' => 'btn btn-primary', 'style' => 'float: right;'));
			$data['content'] = $this->load->view('account/register', $data, true);

			$this->load->view('layouts/default', $data);
		} else {
			$validate = base64_encode($this->input->post('email'));

			$this->email->from('hello@minecrafter.com', 'The Minecrafter Team');
			$this->email->to($this->input->post('email'));

			$this->email->subject('Welcome to the Minecrafter Beta!');
			$msg = "Thanks for signing up at Minecrafter, now you have everything Minecraft at your fingertips! You're not far away from acessing all of Minecrafter's features. All you need to do is verify you account.

To verify your account, click this link: " . base_url('account/verify/' . $validate) . "

If you want to know more, or just say hello, join us on IRC at http://webchat.esper.net/?nick=minecrafter..&channels=minecrafter&prompt=1.

Thanks,
The Minecrafter Team";
			$this->email->message($msg);

			$this->email->send();

			$user = array(
				'username' => $this->input->post('username'),
				'password' => md5($this->input->post('password')),
				'email' => $this->input->post('email'),
				'ip' => $this->input->ip_address(),
				'registered' => time(),
				'name' => $this->input->post('name'),
				'mcname' => $this->input->post('mcname'),
				'group' => 'none',
				'newsletter' => $this->input->post('newsletter'));

			$this->mongo_db->insert('users', $user);

			redirect('account/verify');
		}
	}
/*
	public function convert() {
		$this->load->library(array('email', 'form_validation', 'encrypt'));

		$this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[4]|max_length[16]');
		$this->form_validation->set_rules('oldpassword', 'Old Password', 'required|callback_oldLoginCheck');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|matches[confirmpass]|min_length[6]');
		$this->form_validation->set_rules('confirmpass', 'Password Confirmation', 'trim|required');

		if ($this->form_validation->run() == FALSE) {
			$data['title'] = 'Convert';
			$data['description'] = 'Easily convert to the new account system.';
			$data['content'] = $this->load->view('account/convert', $data, true);

			$this->load->view('layouts/default', $data);
		} else {
			$user = $this->mongo_db->where(array('username' => $this->input->post('username')))->get('users');
			$user = $user[0];

			$user['password'] = $this->encrypt->encode($this->input->post('password'));
			$user['group'] = 'users';
			unset($user['_id']);

			$this->mongo_db->where(array('username' => $this->input->post('username')))->update('users', $user);

			redirect('account/login');
		}
	}
*/
	public function verify() {
		$validate = base64_decode($this->uri->segment(3));
		if (!isset($validate) OR $validate == '') {
			$data['title'] = 'Verify';
			$data['content'] = $this->load->view('account/verify', $data, true);

			$this->load->view('layouts/default', $data);
		} else {
			$this->mongo_db->where(array('email' => $validate))->set('group', 'users')->update('users');

			redirect('account/login');
		}
	}

	public function forgot() {
		if ($this->Account_model->loggedin())
			redirect('account');

		$this->load->library(array('form_validation', 'email'));

		$this->form_validation->set_rules('email', 'Email', 'trim|required|callback_emailcheck');

		if ($this->form_validation->run() == FALSE) {
			$data['title'] = 'Forgot Password';
			$data['description'] = 'It\'s not good to forget things :(';
			$data['content'] = $this->load->view('account/forgot', $data, true);

			$this->load->view('layouts/default', $data);
		} else {
			$validate = base64_encode($this->input->post('email'));

			$this->email->from('hello@minecrafter.com', 'The Minecrafter Team');
			$this->email->to($this->input->post('email'));

			$this->email->subject('Forgot Password');
			$msg = "We're sorry you forgot your password at Minecrafter, click the link below to get a new one:

" . base_url('account/remember/' . $validate) . "

You're welcome,
The Minecrafter Team";
			$this->email->message($msg);

			$this->email->send();

			$data['sent'] = true;
			$data['title'] = 'Forgot Password';
			$data['description'] = 'It\'s not good to forget things :(';
			$data['content'] = $this->load->view('account/forgot', $data, true);

			$this->load->view('layouts/default', $data);
		}
	}

	public function remember() {
		if ($this->Account_model->loggedin())
			redirect('account');

		$validate = base64_decode($this->uri->segment(3));
		if (!isset($validate) OR $validate == '')
			redirect('account/forgot');
		if(!$this->emailcheck($validate)) redirect('account/forgot');

		$this->load->library(array('form_validation', 'email'));

		$this->form_validation->set_rules('password', 'New Password', 'trim|matches[password2]|min_length[6]');
		$this->form_validation->set_rules('password2', 'New Password Confirmation', 'trim');

		if ($this->form_validation->run() == FALSE) {
			$data['title'] = 'New Password';
			$data['description'] = 'for: '.$validate;
			$data['content'] = $this->load->view('account/remember', $data, true);

			$this->load->view('layouts/default', $data);
		} else {
			$this->mongo_db->where(array('email' => $validate))->set('password', md5($this->input->post('password')))->update('users');

			redirect('account/login');
		}
	}

	public function edit() {
		if (!$this->Account_model->loggedin())
			redirect('account/login');

		$this->load->library(array('form_validation', 'email', 'encrypt'));

		$this->form_validation->set_rules('currentpassword', 'Current Password', 'trim|required');
		$this->form_validation->set_rules('password', 'New Password', 'trim|matches[password2]|min_length[6]');
		$this->form_validation->set_rules('password2', 'New Password Confirmation', 'trim');
		$this->form_validation->set_rules('email', 'Email', 'trim|valid_email');
		$this->form_validation->set_rules('name', 'Full Name', '');
		$this->form_validation->set_rules('paypal', 'PayPal Email', 'trim|valid_email');

		if ($this->form_validation->run() == FALSE) {
			$user = $this->mongo_db->where(array('username' => $this->session->userdata('username')))->get('users');
			$user = $user[0];

			$data['user'] = $user;
			$data['title'] = 'Edit Account';
			$data['description'] = 'Change your stuff!';
			$data['content'] = $this->load->view('account/edit', $data, true);

			$this->load->view('layouts/default', $data);
		} else {
			$user = $this->mongo_db->where(array('username' => $this->session->userdata('username')))->get('users');
			$user = $user[0];

			if (md5($this->input->post('currentpassword')) != $user['password'])
				$this->form_validation->set_message('currentpassword', 'Current Password is incorrect!');

			if ($this->input->post('password') != '')
				$user['password'] = md5($this->input->post('password'));
			
			if ($this->input->post('email') != '')
				$user['email'] = $this->input->post('email');

			if ($this->input->post('mcname') != '')
				$user['mcname'] = $this->input->post('mcname');

			if ($this->input->post('name') != '')
				$user['name'] = $this->input->post('name');

			if ($this->input->post('donate') != '')
				$user['donate'] = $this->input->post('donate');

			unset($user['_id']);

			$this->mongo_db->where(array('username' => $this->session->userdata('username')))->update('users', $user);
			
			$data['user'] = $user;
			$data['title'] = 'Edit Account';
			$data['content'] = $this->load->view('account/edit', $data, true);

			$this->load->view('layouts/default', $data);
		}
	}

	public function logout() {
		if (!$this->Account_model->loggedin())
			redirect('/');
		$this->mongo_db->where(array('username' => $this->session->userdata('username')))->delete('online');
		$this->session->sess_destroy();

		redirect('/');
	}

	function usercheck() {
		$username = $this->mongo_db->where(array('username' => $this->input->post('username')))->get('users');
		$email = $this->mongo_db->where(array('email' => $this->input->post('email')))->get('users');

		if (count($username) + count($email) != 0) {
			$this->form_validation->set_message('usercheck', 'This username or email is already taken!');
			return false;
		} else {
			return true;
		}
	}

	function logincheck() {
		$this->load->library('encrypt');

		$username = $this->input->post('username');
		$password = $this->input->post('password');

		$user = $this->mongo_db->where(array('username' => $username))->where_ne('group', 'none')->get('users');
		if (isset($user[0]))
			$user = $user[0];

		if($user['group'] == 'none') {
			$this->form_validation->set_message('logincheck', 'You account hasn\'t been activated!');
			return false;
		}

		if ($user['password'] == md5($password)) {
			$this->session->set_userdata(array('username' => $username, 'logged_in' => true));
			return true;
		} else {
			$this->form_validation->set_message('logincheck', 'Your login details are incorrect!');
			return false;
		}
	}

	function oldLoginCheck() {
		$this->load->library('encrypt');

		$username = $this->input->post('username');
		$password = $this->input->post('oldpassword');

		$user = $this->mongo_db->where(array('username' => $username, 'oldpassword' => md5($password)))->get('users');
		if (isset($user[0]))
			$user = $user[0];


		if (isset($user['username'])) {
			return true;
		} else {
			$this->form_validation->set_message('oldLoginCheck', 'Your old password is incorrect!');
			return false;
		}
	}

	function emailCheck($email) {
		$user = $this->mongo_db->where(array('email' => $email))->get('users');

		if(isset($user[0]))
			$user = $user[0];

		if(isset($user['username'])) {
			return true;
		} else {
			$this->form_validation->set_message('emailCheck', 'Incorrect email!');
			return false;
		}
	}

	function betaCheck($key) {
		$this->load->library('encrypt');

		if($this->encrypt->decode($key) == 'minecrafter') {
			return true;
		} else {
			$this->form_validation->set_message('betaCheck', 'Your beta key is incorrect!');
			return false;
		}
	}

	function checked($option) {
		if($option == true || $option == 'true' || $option == 'on') {
			return true;
		} else {
			$this->form_validation->set_message('checked', 'You must agree to the Terms of Service.');
			return false;
		}
	}
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */