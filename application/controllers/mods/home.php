<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	public function index()	{
		$this->load->model('Mods_model');
		$this->load->helper('text');
		$this->load->helper('markdown');

		$data['title'] = 'Minecraft Mod Index';
		$data['description'] = 'A list of user submitted Minecraft Mods (and tools)';
		$data['button'] = anchor('mods/upload', 'Upload Mod', array('class' => 'btn btn-primary large', 'style' => 'float: right;'));
		$data['mods'] = $this->Mods_model->getMods();

		$data['content'] = $this->load->view('mods/list', $data, true);

		$this->load->view('layouts/default', $data);
	}

	public function mod() {
		$this->load->helper('markdown');
		$this->load->model(array('Mods_model','Comments_model'));
		$this->load->library(array('form_validation','notifications'));

		$url = $this->uri->segment(2);
		$data['mod'] = $this->Mods_model->getMod($url);
		$data['primary'] = $this->Mods_model->getPrimaryVersion($url);
		$data['user'] = $this->Account_model->info($data['mod'][0]['username']);
		$data['comments'] = $this->Comments_model->getComments(uri_string());
		$data['subscribed'] = $this->notifications->subscribed($this->session->userdata('username'), 'mods', $url);
		$data['mod'] = $data['mod'][0];
		$data['title'] = $data['mod']['name'];
		$data['content'] = $this->load->view('mods/single', $data, true);

		$this->load->view('layouts/default', $data);
	}

	public function upload() {
		if (!$this->Account_model->loggedin())
			redirect('account/login');
		$this->load->model(array('Mods_model'));
		$this->load->library(array('form_validation'));

		$this->form_validation->set_rules('name', 'Mod Name', 'required|callback_validateName');
		$this->form_validation->set_rules('titletags', 'Title Tags', '');
		$this->form_validation->set_rules('tags', 'Search Tags', '');
		$this->form_validation->set_rules('content', 'Page Content', 'required');
		$this->form_validation->set_rules('file', 'File', '');
		$this->form_validation->set_rules('modurl', 'Mod URL', '');
		$this->form_validation->set_rules('version', 'Version', 'required');
		$this->form_validation->set_rules('mcversion', 'Minecraft Version', 'required');

		$this->form_validation->set_rules('tos', 'Terms of Service', 'callback_checked');

		if ($this->form_validation->run() == FALSE) {
			$data['title'] = 'Mod Upload';
			$data['description'] = 'Submit your mod to our mod index';
			$data['content'] = $this->load->view('mods/upload', $data, true);

			$this->load->view('layouts/default', $data);
		} else {
			mkdir('./uploads/mods/'.$this->formatName($this->input->post('name')));
			$config['upload_path'] = './uploads/mods/'.$this->formatName($this->input->post('name'));
			$config['allowed_types'] = 'jar|zip|rar|7z|tar|tar.bz2|tar.gz';
			$config['max_size'] = '0';

			$this->load->library('upload', $config);

			if (!$this->upload->do_upload('file')) {
				$data['error'] = array('error' => $this->upload->display_errors());

				$data['title'] = 'Mod Upload';
				$data['description'] = 'Submit your mod to our mod index';
				$data['content'] = $this->load->view('mods/upload', $data, true);

				$this->load->view('layouts/default', $data);
			} else {
				$data = array('upload_data' => $this->upload->data(), 'mcversion' => $this->input->post('mcversion'), 'date' => time(),'downloads' => 0 );

				$name = $this->formatName($this->input->post('name'));

				$mod = array(
					'name' => $this->input->post('name'),
					'url' => $name,
					'titletags' => $this->input->post('titletags'),
					'tags' => $this->input->post('tags'),
					'content' => $this->input->post('content'),
					'version' => $this->input->post('version'),
					'username' => $this->session->userdata('username'),
					'date' => time(),
					'files' => array(
						"0" => array($this->input->post('version') => $data)
					)
				);

				$this->mongo_db->insert('mods', $mod);

				redirect('mod/'.$name);
			}
		}
	}

	public function edit() {
		if (!$this->Account_model->loggedin())
			redirect('account/login');

		$this->load->model(array('Mods_model'));
		$this->load->library('form_validation');

		$url = $this->uri->segment(2);
		$mod = $this->Mods_model->getMod($url);
		$mod = $mod[0];
		if($mod['username'] != $this->session->userdata('username'))
			redirect('mod/'.$mod['url']);

		$this->form_validation->set_rules('titletags', 'Title Tags', '');
		$this->form_validation->set_rules('tags', 'Search Tags', '');
		$this->form_validation->set_rules('content', 'Page Content', 'required');
		$this->form_validation->set_rules('version', 'Current Version', 'required');

		if ($this->form_validation->run() == FALSE) {
			$data['mod'] = $mod;
			$data['title'] = 'Edit '.$mod['name'];
			$data['description'] = 'Change your mod page';
			$data['content'] = $this->load->view('mods/edit', $data, true);

			$this->load->view('layouts/default', $data);
		} else {
			if($this->input->post('titletags') != '') {
				$mod['titletags'] = $this->input->post('titletags');
			}
			if($this->input->post('tags') != '') {
				$mod['tags'] = $this->input->post('tags');
			}
			if($this->input->post('content') != '') {
				$mod['content'] = $this->input->post('content');
			}
			if($this->input->post('version') != '') {
				$mod['version'] = $this->input->post('version');
			}
			unset($mod['_id']);

			$this->mongo_db->where(array('url' => $url))->update('mods', $mod);

			redirect('mod/'.$mod['url']);
		}
	}

	public function newfile() {
		if (!$this->Account_model->loggedin())
			redirect('account/login');
		$this->load->model(array('Mods_model'));
		$this->load->library('form_validation');
		$url = $this->uri->segment(2);

		$this->form_validation->set_rules('file', 'File', '');
		$this->form_validation->set_rules('description', 'File Description', 'required');
		$this->form_validation->set_rules('version', 'Version', 'required');
		$this->form_validation->set_rules('mcversion', 'Minecraft Version', 'required');

		$mod = $this->mongo_db->where(array('url' => $url))->get('mods');
		$mod = $mod[0];

		if($this->session->userdata('username') != $mod['username'])
			redirect('mods');

		if ($this->form_validation->run() == FALSE) {
			$data['title'] = 'Update '.$mod['name'];
			$data['description'] = 'You can upload your new releases here!';
			$data['content'] = $this->load->view('mods/new', $data, true);

			$this->load->view('layouts/default', $data);
		} else {
			if(!file_exists('./uploads/mods/'.$url)) mkdir('./uploads/mods/'.$url);
			
			$config['upload_path'] = './uploads/mods/'.$url;
			$config['allowed_types'] = 'jar|zip|rar|7z|tar|tar.bz2|tar.gz';
			$config['max_size'] = '0';

			$this->load->library('upload', $config);

			if (!$this->upload->do_upload('file')) {
				$data['error'] = array('error' => $this->upload->display_errors());

				$data['title'] = 'Update '.$mod['name'];
				$data['description'] = 'You can upload your new releases here!';
				$data['content'] = $this->load->view('mods/new', $data, true);


				$this->load->view('layouts/default', $data);
			} else {
				$version = $this->input->post('version');
				$description = $this->input->post('description');
				$mcversion = $this->input->post('mcversion');

				$data = array(  'upload_data' => $this->upload->data(),
								'description' => $description,
								'mcversion' => $mcversion);

				$mod['files'][0][$version] = $data;
				unset($mod['_id']);

				$this->mongo_db->where(array('url' => $url))->update('mods', $mod);

				if(isset($mod['subscribers']) && !empty($mod['subscribers'])) {
					$params = array(
						'from' => $mod['username'],
						'url' => 'mod/'.$url,
						'title' => $mod['name']. ' updated to '.$version,
						'content' => $description);

					foreach($mod['subscribers'] as $subscriber) {
						$this->notifications->send($subscriber, $params);
					}
				}

				redirect('mod/'.$url);
			}
		}
	}

	public function editVersion() {
		
	}

	public function post() {
		if (!$this->Account_model->loggedin())
			redirect('account/login');

		$this->load->library(array('form_validation'));
		$this->load->model(array('Mods_model','Comments_model'));

		$this->form_validation->set_rules('title', 'Title', 'required|min_length[4]|max_length[40]');
		$this->form_validation->set_rules('content', 'Comment Content', 'required');

		if ($this->form_validation->run() == FALSE) {
			$this->load->helper('markdown');
			$this->load->library(array('form_validation'));

			$url = $this->uri->segment(2);
			$data['primary'] = $this->Mods_model->getPrimaryVersion($url);
			$data['mod'] = $this->Mods_model->getMod($url);
			$data['comments'] = $this->Comments_model->getComments(uri_string());
			$data['subscribed'] = $this->notifications->subscribed($this->session->userdata('username'), 'mods', $url);
			$data['mod'] = $data['mod'][0];
			$data['title'] = $data['mod']['name'];
			$data['content'] = $this->load->view('mods/single', $data, true);

			$this->load->view('layouts/default', $data);
		} else {
			$url = $this->uri->segment(1).'/'.$this->uri->segment(2);

			$this->Comments_model->postComment($this->session->userdata('username'), $this->input->post('title'), $this->input->post('content'), $url);
			redirect($url);
		}
	}

	function formatName($name) {
		$name = str_replace(' ', '', $name);

		return $name;
	} 

	function validateName($name) {
		if(preg_match('/^[a-zA-Z0-9 ]+$/', $name)) {
			return true;
		} else {
			$this->form_validation->set_message('validateName', 'Invalid mod name!');
			return false;
		}
	}
	function validateTags($tags) {
		if(preg_match('/^[a-zA-Z0-9 \[\]]+$/', $name)) {
			return true;
		} else {
			$this->form_validation->set_message('validateName', 'Invalid tags!');
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

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */