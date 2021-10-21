<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class login extends CI_Controller {
	public function index()
	{
		$data['error']= "";
		$this->load->model('user_model');
		$this->load->model('file_model');
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->view('template/header');
		$this->load->view('template/secondary_nav');
		// $this->load->helper('captcha');

		/*
		$vals = array(
			'word' => rand(1111,9999),
			'img_path' => './captcha/',
			'img_url' => base_url().'/captcha/',
			'img_width' => 150,
			'img_height' => 30,
			'expiration' => 7200,
			);
		
		$cap = create_captcha($vals);
		$data['cap_img'] = $cap['image']; 
		$cap_word = $cap['word'];
		$data['cap_word'] = $cap_word;
		$this->session->set_userdata('cap_word', $cap_word); */

		if (!$this->session->userdata('logged_in'))//check if user already login
		{	
			if (get_cookie('remember')) { // check if user activate the "remember me" feature  
				$username = get_cookie('username'); //get the username from cookie
				$password = get_cookie('password'); //get the username from cookie
				if ( $this->user_model->login($username, $password) )//check username and password correct
				{
					if ($this->file_model->get_profile_pic($username) != '') {
						$profile_path = $this->file_model->get_profile_pic($username);
					} else {
						$profile_path = './assets/img/default_profile.JPG';
					}
					$user_data = array(
						'username' => $username,
						'logged_in' => true,
						'email_verified' => $this->user_model->email_verified($username),
						'profile_path'=> $profile_path,
						'homepage_page' => 1	
					);
					$this->session->set_userdata($user_data); //set user status to login in session
					$data['all_post'] = $this->file_model->load_all_post();
					$data['num_post'] = sizeof($this->file_model->load_all_post());
					$this->file_model->calculate_likes();
					$this->load->view('homepage', $data);
				}
			}else{
				$this->load->view('login', $data);	//if username password incorrect, show error msg and ask user to login
			}
		}else{
			$data['all_post'] = $this->file_model->load_all_post();
			$data['num_post'] = sizeof($this->file_model->load_all_post());
			$this->file_model->calculate_likes();
			$this->load->view('homepage', $data);
		}
		$this->load->view('template/footer');
	}

	public function check_login()
	{
		$data['error']= "";
		$this->load->model('user_model');
		$this->load->model('file_model');
		$data['error']= "<div class=\"alert alert-danger\" role=\"alert\"> Incorrect username or password, please try again. </div> ";
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->view('template/header');
		
		$username = $this->input->post('username'); //getting username from login form
		$password = $this->input->post('password'); //getting password from login form
		$remember = $this->input->post('remember'); //getting remember checkbox from login form
		if(!$this->session->userdata('logged_in')){	//Check if user already login
			//if ($this->input->post('cap') == $this->session->userdata('cap_word')) {
			if (true) {
			if ( $this->user_model->login($username, $password) )//check username and password
			{
				if ($this->file_model->get_profile_pic($username) != '') {
					$profile_path = $this->file_model->get_profile_pic($username);
				} else {
					$profile_path = './assets/img/default_profile.JPG';
				}
				$user_data = array(
					'username' => $username,
					'logged_in' => true,
					'email_verified' => $this->user_model->email_verified($username),
					'profile_path'=> $profile_path,
					'homepage_page' => 1
				);
				if($remember) { // if remember me is activated create cookie
					set_cookie("username", $username, '1800'); //set cookie username
					set_cookie("password", $password, '1800'); //set cookie password
					set_cookie("remember", $remember, '1800'); //set cookie remember
				}	
				$this->session->set_userdata($user_data); //set user status to login in session
				redirect('login'); // direct user home page
			} /*else
			{
				$vals = array(
					'word' => rand(1111,9999),
					'img_path' => './captcha/',
					'img_url' => base_url().'/captcha/',
					'img_width' => 150,
					'img_height' => 30,
					'expiration' => 7200,
					);
				
				$cap = create_captcha($vals);
				$data['cap_img'] = $cap['image']; 
				$cap_word = $cap['word'];
				$data['cap_word'] = $cap_word;
				$this->session->set_userdata('cap_word', $cap_word);
		
				echo $cap_word;
				$this->load->view('login', $data);	//if username password incorrect, show error msg and ask user to login
			} */
		} /*else {
			$vals = array(
				'word' => rand(1111,9999),
				'img_path' => './captcha/',
				'img_url' => base_url().'/captcha/',
				'img_width' => 150,
				'img_height' => 30,
				'expiration' => 7200,
				);
			
			$cap = create_captcha($vals);
			$data['cap_img'] = $cap['image']; 
			$cap_word = $cap['word'];
			$data['cap_word'] = $cap_word;
			$this->session->set_userdata('cap_word', $cap_word);
	
			echo $cap_word;
			$this->load->view('login', $data);
		}*/
		}else{
			{
				redirect('login'); //if user already logined direct user to home page
			}
		$this->load->view('template/footer');
		}
	}

	public function logout()
	{
		$this->session->unset_userdata('logged_in'); //delete login status
		$this->session->unset_userdata('username');
		$this->session->unset_userdata('email_verified');
		$this->session->unset_userdata('profile_path');
		$this->session->unset_userdata('homepage_page');
		// $this->session->unset_userdata('cap_word');
		redirect('welcome'); // redirect user back to login
	}

	public function timeout() {
		$this->session->unset_userdata('logged_in'); //delete login status
		$this->session->unset_userdata('username');
		$this->session->unset_userdata('email_verified');
		$this->session->unset_userdata('profile_path');
		$this->session->unset_userdata('homepage_page');
		$this->load->view('template/header');
		$this->load->view('template/timeout');
		$this->load->view('template/footer');

	}

	public function reset() {
		$data['error'] = "";
		$this->load->view('template/header');
		$this->load->view('template/reset_password', $data);
		$this->load->view('template/footer');
	}

	public function reset_email() {
		// set up reset token in database and send the reset email
		$data['error'] = "";
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->model('user_model');
		$this->load->view('template/header');
		$reset_email = $this->input->post('reset_email'); 
		// sanitising input value to avoid query injection
        $reset_email = str_replace("'", "", $reset_email);
        $reset_email = str_replace(";", " ", $reset_email);
        
		
		if (!$this->user_model->email_used($reset_email)) { //no user matches the given email
			$data['error'] = "<div class=\"alert alert-danger\" role=\"alert\"> There is no account matching this email, please enter again. </div> ";
			$this->load->view('template/reset_password', $data);
		} else {

			$reset_token = $this->user_model->reset_token($reset_email); //reset token in the database

			//send email
			$config = Array(
				'protocol' => 'smtp',
				'smtp_host' => 'mailhub.eait.uq.edu.au',
				'smtp_port' => 25,
				'mailtype' => 'html',
				'charset' => 'iso-8859-1',
				'wordwrap' => TRUE ,
				'mailtype'  => 'html',
				'starttls'  => true,
				'newline'   => "\r\n"
			);

			$this->email->initialize($config);
			$this->email->from('s4518552@student.uq.edu.au', 'Junze Li');
			$this->email->to($reset_email);
			$this->email->cc('s4518552@student.uq.edu.au');
			$this->email->subject('BLUE. Password reset email');

			
			$message =  "Please click the link below to reset your password: <br/> <a href='".base_url()."login/reset_password?reset_token=".$reset_token."' target='_blank'> ".base_url()."login/reset_password?reset_token=".$reset_token."</a> <br/> If the above link does not work, please copy it to your broswer's address line to visit. <br/> BLUE.";

			$this->email->message($message);
			$this->email->send();
			$data['success_msg'] = "An email has been sent to your email address, please follow the steps indicated in the email to reset your password.";
			$this->load->view('template/success', $data);
		}
		$this->load->view('template/footer');
	}

	public function reset_password() {
		$this->load->helper('url');
		$this->load->model('user_model'); 
		$reset_token = stripslashes(trim($_GET['reset_token']));
		$data['reset_token'] = $reset_token;
		$data['error'] = "";

		$this->load->view('template/header');
		$this->load->view('template/new_password', $data);
		$this->load->view('template/footer');
	
	}

	public function set_password() {
		$this->load->helper('url');
		$this->load->model('user_model'); 
		$data['error'] = "";
		$reset_token = stripslashes(trim($_GET['reset_token']));
		$data['reset_token'] = $reset_token;
		$new_password = $this->input->post('new_password'); 
		$new_confirmed_password = $this->input->post('new_confirm_password'); 
		// sanitising input value to avoid query injection
		$new_password = str_replace("'", "", $new_password);
		$new_password = str_replace(";", " ", $new_password);
		$new_confirmed_password = str_replace("'", "", $new_confirmed_password);
		$new_confirmed_password = str_replace(";", " ", $new_confirmed_password);
        
		$this->load->view('template/header');
		
		if ($new_password != $new_confirmed_password) { // password not matching
			$data['error'] = "<div class=\"alert alert-danger\" role=\"alert\"> Password did not match, please try again.</div> ";
			$this->load->view('template/new_password', $data);
		} elseif(strlen($new_password) < 6) {
			$data['error'] = "<div class=\"alert alert-danger\" role=\"alert\"> Password must have at least 6 characters. </div> ";
			$this->load->view('template/new_password', $data);
			
		} else { // valid password
			if ($this->user_model->reset_password($reset_token, $new_password)) { //success reset
				$data['success_msg'] = "Reset password successfully.";
				$this->load->view('template/success', $data);
			} else {
				$data['error'] = "<div class=\"alert alert-danger\" role=\"alert\"> Something went wrong, please resubmit your reset request.</div> ";
				$this->load->view('template/new_password', $data);
			}
		}
		$this->load->view('template/footer');
	}

}
?>