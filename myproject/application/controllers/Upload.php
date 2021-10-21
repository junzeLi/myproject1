<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Upload extends CI_Controller
{
    public function index()
    {
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
					$this->load->view('file',array('error' => ' ')); //if user already logined show upload page
				}
			}else{
				$this->load->view('template/login_required');//load the page to notify user to log in
			}
		}else{
			$this->load->view('file',array('error' => ' ')); //if user already logined show login page
		}
		$this->load->view('template/footer');
	}
	
    public function do_upload() {
		$this->load->model('file_model');
        $config['upload_path'] = './uploads/';
		$config['allowed_types'] = 'png|jpg|mp4|mkv';
		$config['max_size'] = 10000;
		$config['max_width'] = 1024;
		$config['max_height'] = 1024;
		$this->load->library('upload', $config);
		if ( ! $this->upload->do_upload('userfile')) {
            $this->load->view('template/header');
            $data = array('error' => $this->upload->display_errors());
            $this->load->view('file', $data);
            $this->load->view('template/footer');
        } else {
			$tags_name = $this->input->post('tag');
			$description = $this->input->post('post-description');
			// sanitising input value to avoid query injection
			$description = str_replace("'", "", $description);
			$description = str_replace(";", " ", $description);
			
			$this->file_model->upload($this->upload->data('file_name'), $this->upload->data('full_path'),$this->session->userdata('username'), $description, $tags_name);
			$this->load->view('template/header');
			$data = array('error' => '<p>File upload success. <br/></p>');
            $this->load->view('file', $data);
            $this->load->view('template/footer');
        }
	}


	public function delete() {
		$this->load->model('file_model');
		$postID = $this->input->get('postID');
		echo $postID;
		$file_path = $this->file_model->remove_post($postID); //remove file from db and get path
		unlink($file_path); //delete file from server
	}
}

