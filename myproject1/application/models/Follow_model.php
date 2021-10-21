<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 //put your code here
 class Follow_model extends CI_Model{

    // get user follower
    public function get_follower($username) {
        $this->db->select("follower");
        $this->db->from('users');
        $this->db->where('username', $username);
        $result=$this->db->get();
        $row = $result->row();
        return $row->follower;
    }

    // get user following number
    public function get_following($username) {
        $this->db->select("following");
        $this->db->from('users');
        $this->db->where('username', $username);
        $result=$this->db->get();
        $row = $result->row();
        return $row->following;
    }
 }