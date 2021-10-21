<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class ajax extends CI_Controller
{
    public function fatch()
    // fatch data for search box
    { 
        $this->load->model('file_model'); // load model
        $output = '';
        $query = '';
        if($this->input->get('query')){
            $query = $this->input->get('query'); // get search query from ajax form
        } 

        // sanitising input value to avoid query injection
        $query = str_replace("'", "", $query);
        $query = str_replace(";", " ", $query);
        
        $data = $this->file_model->fetch_data($query); // send query to file model and get res
        if(!$data == null){
            echo json_encode($data->result()); // send res
        }else{
            echo "";
            }
    }


    public function like_post() {
        //like a post, return the likes number
        $username = $this->session->userdata('username');
        $this->load->model('file_model'); 
        $output = '';
        $postID = '';
        $data['likes'] = '';
        if($this->input->get('postID')){
            $postID = $this->input->get('postID');
            $data['likes'] = $this->file_model->like_post($postID, $username);
        }
        $data['user_liked'] = $this->file_model->check_like($username, $postID);
        if(!$data == null){
            echo json_encode($data); // send res
        }else{
            echo '';
        }
    }

    
  
}

