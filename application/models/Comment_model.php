<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 class Comment_model extends CI_Model{
    public function load_all_comment($file_id) {
        $this->db->select('comment_id,username,comment,comment_time');
        $this->db->from("file_comments");
        $this->db->join('users', 'users.id = file_comments.user_id');
        $this->db->where('file_id', $file_id);
        $this->db->order_by('comment_time', 'desc');
        $result=$this->db->get();
        $rows = $result->result_array();
        return $rows;
    }


    public function make_comment($file_id,$username,$comment) {
        $this->db->select("*");
        $this->db->from('users');
        $this->db->where('username', $username);
        $result=$this->db->get();
        $row = $result->row();
        $user_id = $row -> id;
        $data = array(
            'file_id' => $file_id,
            'user_id' => $user_id,
            'comment' => $comment,
        );
        $query = $this->db->insert('file_comments', $data);
        
    }
 }