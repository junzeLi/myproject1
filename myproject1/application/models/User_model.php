<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 //put your code here
 class User_model extends CI_Model{

    // Register
    public function register($register_email, $register_username, $register_password) {
        $register_time = time();
        $hased_password = password_hash($register_password, PASSWORD_DEFAULT); // hash the password before writing into the database
        $token = md5($register_username.$hased_password.$register_time);


        $new_user = array(
            'username' => $register_username,
            'email' => $register_email,
            'password' => $hased_password,
            'created_at' => $register_time,
            'email_verified' => false, //set email verification status
            'token' => $token, // create token based on username, password and time
            ); 
        $this->db->insert('users', $new_user);
        
        return $token;
    }

    // Validate email used or not, return true if the email is used
    public function email_used($register_email) {
        $result = $this->db->get_where('users', array('email' => $register_email));
        if ($result->num_rows() != 0) {
            return true;
        } else {
            return false;
        }
    }

    // Validate username used or not, return true if the username is used
    public function username_used($register_username) {
        $result = $this->db->get_where('users', array('username' => $register_username));
        if ($result->num_rows() != 0) {
            return true;
        } else {
            return false;
        }
    }

    // Log in
    public function login($username, $password){
        // get user with the logged username
        $result = $this->db->get_where('users', array('username' => $username));
        if($result->num_rows() != 1){ // no existing user
            return false;
        } else { //check for password
            $row = $result -> row();
            $row = $row -> password;
            return password_verify($password, $row); //check the hashed password
        }
    }

    // verify the token 
    public function verify($token) {
        $current_time = time();
        $result = $this->db->get_where('users', array('token' => $token));
        $msg = '';
        $update = array('email_verified' => '1', 'token' => ""); //set up status and also empty token
        if($result -> num_rows() != 1) { // no matching website
            $msg = 'Error, please sign up again.';
        } else {
            $row = $result->row();
            $status = $row -> email_verified;
            if ($status == '1') { //verified already
                $msg = 'The account is already activated.';
            } else {
                $register_time = $row -> created_at;
                if ($current_time - $register_time > 60*60*24) {
                    $msg = 'Activation link expired, please sign up again.';
                } else {
                    $msg = 'Activated successfully! You can now visit BLUE. and start sharing!';
                    $this->db->where('token', $token);
                    $this->db->update('users', $update);
                }
            }
            
        }
        return $msg;
    }

    public function reset_token($reset_email) {
        $reset_time = time();
        $reset_token = md5($reset_email.$reset_time); // set up a token for reseting email
        $update = array('email_verified' => '1', 'token' => $reset_token);
        $this->db->where('email', $reset_email);
        $this->db->update('users', $update);
        return $reset_token;
    }

    public function reset_password($reset_token, $new_password) {
        $result = $this->db->get_where('users', array('token' => $reset_token));
        $hased_password = password_hash($new_password, PASSWORD_DEFAULT); // hash the password before writing into the database
        $update = array('password' => $hased_password, 'token' => ""); // set up new password also empty reset token 
        if ($result -> num_rows() != '1') { //no matching token
            return false;
        } else {
            $this->db->where('token', $reset_token);
            $this->db->update('users', $update);
            return true;
        }
    }

    public function email_verified ($username) {
        // check if the user has verified email, return true if email is verified
        $result = $this->db->get_where('users', array('username' => $username));
        $row = $result->row();
        $status = $row -> email_verified;
        if ($status == '1') { //verified
            return true;
        } else {
            return false;
        }
    }

    public function change_email ($username, $new_email) {
        $update = array('email' => $new_email, 'email_verified' =>false); 
        $this->db->where('username', $username);
        $this->db->update('users', $update);
    }

}
?>
