<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 class File_model extends CI_Model{

    // upload file
    public function upload($filename, $path, $username, $description, $tags_name){
        // add file data to db
        $upload_time = time();
        $data = array(
            'filename' => $filename,
            'path' => $path,
            'username' => $username,
            'upload_time' => $upload_time,
            'description' => $description,
        );
        $query = $this->db->insert('files', $data);
        
        // add tag data to db
        $result = $this->db->get_where('files', array('path' => $path));
        $row = $result->row();
        $file_id = $row -> id;
        foreach ($tags_name as $tag){ 
            $data = array(
                'file_id' => $file_id,
                'tag' => $tag
            );
            $this->db->insert('file_tag', $data);
        }

    }

    // upload profile pic
    public function upload_profile($filename, $path, $username){
        $data = array(
            'profile_name' => $filename,
            'profile_path' => $path,
        );
        $this->db->where('username', $username);
        $this->db->update('users',$data );
    }

    // get profile pic location
    public function get_profile_pic($username) {
        $this->db->select("*");
        $this->db->from("users");
        $this->db->where('username', $username);
        $result=$this->db->get();
        $row = $result -> row();
        if ($row == null) {
            return '';
        } else {
            return $row -> profile_path;
        }
    }

    function fetch_data($query)
    {
        if($query == '')
        {
            return null;
        }else{
            $this->db->select("*");
            $this->db->from("files");
            $this->db->like('filename', $query);
            $this->db->or_like('username', $query);
            $this->db->or_like('description', $query);
            $this->db->order_by('filename', 'DESC');
            return $this->db->get();
        }
    }

    function load_user_post($username) {
        // return posts shared by certain user
        if($username == '') {
            return null;
        } else {
            $this->db->select("*");
            $this->db->from("files");
            $this->db->where('username', $username);
            $this->db->order_by('upload_time', 'DESC');
            $result=$this->db->get();
            $row = $result ->result_array();
            return $row;
        }
    }

    function match_file_tag($file_id) {
        // return tags related to one file
        //
        if($file_id == '') {
            return null;
        } else {
            $this->db->select("*");
            $this->db->from("file_tag");
            $this->db->where('file_id', $file_id);
            $result=$this->db->get();
            $row = $result ->result_array();
            return $row;
        }
    }

    function load_all_post() {
        // retrun all posts in the webpage
        $this->db->select("*");
        $this->db->from("files");
        $this->db->order_by('upload_time', 'DESC');
        $result=$this->db->get();
        $row = $result ->result_array();
        return $row;
    }

    function match_file_id($file_id) {
        $this->db->select("*");
        $this->db->from("files");
        $this->db->where('id', $file_id);
        $result=$this->db->get();
        $row = $result ->result_array();
        return $row[0];
    }

    function load_tagged_post($tag) {
        $this->db->distinct();
        $this->db->from('files');
        $this->db->join('file_tag', 'files.id = file_tag.file_id');
        $this->db->where('tag', $tag);
        $result=$this->db->get();
        $row = $result ->result_array();
        return $row;
    }

    function calculate_likes() {
        //calculate likes for each post
        $this->db->select("*");
        $this->db->from("files");
        $result=$this->db->get();
        $rows = $result->result_array();
        
        foreach ($rows as $row) {
            $file_id = $row['id'];
            $this->db->distinct();
            $this->db->from('files');
            $this->db->join('user_like_file', 'files.id = user_like_file.file_id');
            $this->db->where(array('files.id'=> $file_id, 'user_like_file.status'=> '1'));
            $liked_record=$this->db->get();
            //$liked_record = $liked_record ->row();
            if ($liked_record == null) {
                $total_likes = 0;
            } else {
                $total_likes = $liked_record->num_rows();
            }
            
            $data = array(
                'likes' => $total_likes,
            );
            $this->db->where('id', $file_id);
            $this->db->update('files', $data);
        }
    }

    function like_post($file_id, $username) {
        //like a post
        //match username
        $this->db->select("*");
        $this->db->from('users');
        $this->db->where('username', $username);
        $result=$this->db->get();
        $row = $result->row();
        $user_id = $row -> id;

        // check if the user has liked the post or not
        $this->db->select("*");
        $this->db->from('user_like_file');
        $this->db->where(array('user_id'=> $user_id, 'file_id'=> $file_id));
        $result=$this->db->get();
        $row = $result->row();
        if ($row == null) { // no data exists
            $data = array(
                'file_id' => $file_id,
                'user_id' =>$user_id,
                'status' => '1'
            );
            $this->db->insert('user_like_file', $data);
        } else { // data exist
            if (!$row->status) { //unliked
                $data = array(
                    'status' => '1'
                );
                $this->db->where(array('user_id'=> $user_id, 'file_id'=> $file_id));
                $this->db->update('user_like_file', $data);
            } else { //liked already, need to unlike
                $data = array(
                    'status' => '0'
                );
                $this->db->where(array('user_id'=> $user_id, 'file_id'=> $file_id));
                $this->db->update('user_like_file', $data);

            }
        }
        // get like number
        $this->calculate_likes();
        $this->db->select('*');
        $this->db->from('files');
        $this->db->where('id', $file_id);
        $result=$this->db->get();
        $row = $result->row();
        return $row -> likes;
    }

    function check_like($username, $file_id) {
        //check if the user liked a post or not
        //match username
        $this->db->select("*");
        $this->db->from('users');
        $this->db->where('username', $username);
        $result=$this->db->get();
        $row = $result->row();
        $user_id = $row -> id;

        // check if the user has liked the post or not
        $this->db->select("*");
        $this->db->from('user_like_file');
        $this->db->where(array('user_id'=> $user_id, 'file_id'=> $file_id));
        $result=$this->db->get();
        $row = $result->row();

        if ($row == null) { // no data exists
            return false;
        } else { // data exist
            if (!$row->status) { //unliked
                return false;
            } else { //liked already, need to unlike
                return true;
            }
        }
    }


    function get_likes_for_file($file_id) {
        // get like number
        $this->calculate_likes();
        $this->db->select('*');
        $this->db->from('files');
        $this->db->where('id', $file_id);
        $result=$this->db->get();
        $row = $result->row();
        return $row -> likes;
    }

    function get_liked_files($username) {
        //match username
        $this->db->select("*");
        $this->db->from('users');
        $this->db->where('username', $username);
        $result=$this->db->get();
        $row = $result->row();
        $user_id = $row -> id;

        $this->db->select('*');
        $this->db->from('files');
        $this->db->join('user_like_file', 'files.id = user_like_file.file_id');
        $this->db->where(array('user_like_file.user_id'=> $user_id, 'user_like_file.status'=> '1'));
        $result=$this->db->get();
        $liked_record = $result ->result_array();
        return $liked_record;
    }

    public function remove_post($postID) {
        //delete post info from all relationship
        $this->db->delete('user_like_file', array('file_id' => $postID)); 
        $this->db->delete('file_tag', array('file_id' => $postID)); 
        $this->db->delete('file_comments', array('file_id' => $postID)); 
        
        //get path
        $this->db->select('*');
        $this->db->from('files');
        $this->db->where('id', $postID);
        $result=$this->db->get();
        $path = $result->row()->path;

        //delete from file
        $this->db->delete('files', array('id' => $postID)); 
        return $path;
    }

}