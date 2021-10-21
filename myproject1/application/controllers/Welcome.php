<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {
	public function index()
	{
		$this->load->view('template/header');
		$this->load->view('template/secondary_nav');
		$this->load->model('file_model');
		$data['all_post'] = $this->file_model->load_all_post();
		$data['num_post'] = sizeof($this->file_model->load_all_post());
		if(!$this->session->userdata('logged_in')){
			// if not logged in, need to reset the page position
			$user_data = array(
				'homepage_page' => 1
			);
			$this->session->set_userdata($user_data); 
		}
		$this->file_model->calculate_likes();
		$this->load->view('homepage', $data);
		$this->load->view('template/footer');
	}

	public function find_tags($file_id) {
		$this->load->model('file_model');
		foreach ($this->file_model->match_file_tag($file_id) as $tag) {
			echo $tag["tag"];
		};
	}

	public function load_tagged_content($tag) {
		$this->load->model('file_model');
		$this->load->view('template/header');
		$this->load->view('template/secondary_nav');
		$data['tag'] = $tag;
		$data['files'] = $this->file_model->load_tagged_post($tag);
		$this->file_model->calculate_likes();
		$this->load->view('template/tag_page', $data);
		$this->load->view('template/footer');
	}

	public function check_like() {
		$this->load->model('file_model');
		$file_id = $this->input->get('file_id');
		$username = $this->session->userdata('username');
		$data['liked'] = $this->file_model->check_like($username, $file_id);
		$data['likes'] = $this->file_model->get_likes_for_file($file_id);
		echo json_encode($data);
	}


	public function uploader_profile() {
		$this->load->model('file_model');
		$username = $this->input->get('username');
		$data['profile_path'] = $this->file_model->get_profile_pic($username);
		echo json_encode($data);
	}

	public function load_more() {
		$this->load->model("file_model");
		$current_page = $this->session->userdata['homepage_page']+1;
		$user_data = array(
			'homepage_page' => $current_page	
		);
		$data = null;
		$this->session->set_userdata($user_data); 
		
		$all_post = $this->file_model->load_all_post();
		for ($j = $current_page * 4 - 4; $j<= $current_page *4 -1; $j++) {
			if ($j < sizeof($all_post)) {
				$get_post['post'] = $all_post[$j];
				$data[$j] = $this->load->view('template/load_more_template.php', $get_post);
			}
		}

		if(!$data == null){
            echo json_encode($data); // send res
        }else{
            echo '';
        }
	}
}
