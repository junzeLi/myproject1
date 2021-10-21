<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {
	public function index()
	{
		$this->load->view('template/header'); 
		$this->load->model('file_model');
		$this->load->model('follow_model');
		$data['user_post'] = '';
		$data['user_liked'] = '';
    	if (!$this->session->userdata('logged_in'))//check if user already login
		{	
			if (get_cookie('remember')) { // check if user activate the "remember me" feature  
				$username = get_cookie('username'); //get the username from cookie
				$password = get_cookie('password'); //get the username from cookie
				if ( $this->user_model->login($username, $password) )//check username and password correct
				{
					$user_data = array('username' => $username,'logged_in' => true );
					$this->session->set_userdata($user_data); //set user status to login in session
					$data['user_post'] = $this->file_model->load_user_post($username);
					$data['user_liked'] = $this->file_model->get_liked_files($username);
					$data['follower'] = $this->follow_model->get_follower($username);
					$data['following'] = $this->follow_model->get_following($username);
					$this->load->view('profile', $data); //if user already logined show profile page
				}
			}else{
				$this->load->view('template/login_required');//load the page to notify user to log in
			}
		}else{
			$username = $this->session->userdata('username');
			$data['user_post'] = $this->file_model->load_user_post($username);
			$data['user_liked'] = $this->file_model->get_liked_files($username);
			$data['follower'] = $this->follow_model->get_follower($username);
			$data['following'] = $this->follow_model->get_following($username);
			$this->load->view('profile', $data);  //if user already logined show profile
		}
		$this->load->view('template/footer');
	}


	public function edit_profile() {
		$this->load->view('template/header'); 
    	if (!$this->session->userdata('logged_in'))//check if user already login
		{	
			if (get_cookie('remember')) { // check if user activate the "remember me" feature  
				$username = get_cookie('username'); //get the username from cookie
				$password = get_cookie('password'); //get the username from cookie
				if ( $this->user_model->login($username, $password) )//check username and password correct
				{
					$user_data = array('username' => $username,'logged_in' => true );
					$this->session->set_userdata($user_data); //set user status to login in session
					$this->load->view('edit_profile',array('error' => '')); 
				}
			}else{
				$this->load->view('template/login_required');//load the page to notify user to log in
			}
		}else{
			$this->load->view('edit_profile',array('error' => '')); 
		}
		$this->load->view('template/footer');
	}

	public function upload_profile_photo() {
		$this->load->model('file_model');
        $config['upload_path'] = './uploads/';
		$config['allowed_types'] = 'png|jpg|JPG|PNG';
		$config['max_size'] = 10000;
		$config['max_width'] = 1024;
		$config['max_height'] = 1024;
		$data['error'] ='';
		$this->load->library('upload', $config);
		if ( ! $this->upload->do_upload('profilePhoto')) {
			$data = array('error' => $this->upload->display_errors());
        } else {
			$this->file_model->upload_profile($this->upload->data('file_name'), $this->upload->data('full_path'),$this->session->userdata('username')); //update info in db
			
			$data['error'] ='';
			$data['profile_path'] = $this->upload->data('file_name');
		}
		echo json_encode($data);
	
	}

	public function change_email() {
		$this->load->model('user_model');
		$new_email = $this->input->post('new_email');
		$username = $this->session->userdata('username');
		$this->user_model->change_email($username, $new_email);
		
		
		$this->edit_profile();
	}
}
