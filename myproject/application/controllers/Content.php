<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Content extends CI_Controller {
    public function load_content($file_id)
	{
		$this->load->model('file_model');
		$this->load->view('template/header');
		$this->load->view('template/secondary_nav');
		$data['file'] = $this->file_model->match_file_id($file_id);
		$data['tags'] = $this->file_model->match_file_tag($file_id);
		$this->file_model->calculate_likes();

		// load comment
		$this->load->model('comment_model');
		$data['comments'] = $this->comment_model->load_all_comment($file_id);

		$this->load->view('template/content_page', $data);
		$this->load->view('template/footer');
	}


	public function post_comment() {
		$file_id = $this->input->get('file_id');
		$comment = $this->input->get('comment');
		$username = $this->session->userdata('username');
		$this->load->model('comment_model');
		$this->comment_model->make_comment($file_id,$username,$comment);
		echo "";
	}

	
}
