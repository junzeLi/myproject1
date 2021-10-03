<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class register extends CI_Controller {
	public function index()
	{
        // Display register form
        // Don't check if cookies exist for users to register new account
        $data['error']= "";
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->view('template/header');
		$this->load->view('template/secondary_nav');
        $this->load->model('user_model');
        $this->load->view('register', $data);
        $this->load->view('template/footer');

    }
    
    public function register_account()
    {
        $data['error']= "";
        $data['success_msg'] = "";
        $this->load->helper('form');
		$this->load->helper('url');
        $this->load->model('user_model'); 
        $this->load->view('template/header');
        $this->load->view('template/secondary_nav');
        
        // get information from input form
        $register_username = $this->input->post('register_username'); 
		$register_password = $this->input->post('register_password'); 
        $register_email = $this->input->post('register_email'); 
        $register_confirm_password = $this->input->post('register_confirm_password');

        // sanitising input value to avoid query injection
        $register_username = str_replace("'", "", $register_username);
        $register_username = str_replace(";", " ", $register_username);
        $register_password = str_replace("'", "", $register_password);
        $register_password = str_replace(";", " ", $register_password);
        $register_email = str_replace("'", "", $register_email);
        $register_email = str_replace(";", " ", $register_email);
        $register_confirm_password = str_replace("'", "", $register_confirm_password);
        $register_confirm_password = str_replace(";", " ", $register_confirm_password);
        


        // preset error message
        $pwd_not_match= "<div class=\"alert alert-danger\" role=\"alert\"> Password did not match, please try again.</div> ";
        $invalid_pwd= "<div class=\"alert alert-danger\" role=\"alert\"> Password must have at least 10 characters. </div> ";
        $email_error_used= "<div class=\"alert alert-danger\" role=\"alert\"> This email address has been used, please try another one. </div> ";
        $email_error_invalid= "<div class=\"alert alert-danger\" role=\"alert\"> Please provide a valid email address. </div> ";
        $username_error= "<div class=\"alert alert-danger\" role=\"alert\"> This username already exists, please try another one. </div> ";
        
        
        if ($register_password != $register_confirm_password) { //not matching password
            $data['error']= $pwd_not_match;
            $this->load->view('register', $data);
        } elseif (strlen($register_password) < 10) { // too short password
            $data['error']= $invalid_pwd;
            $this->load->view('register', $data);
        } elseif ($this->user_model->email_used($register_email)){ // No obvious error found, proceed to check email
            $data['error']= $email_error_used;
            $this->load->view('register', $data);
        } elseif ($this->user_model->username_used($register_username)){ // check username
            $data['error']= $username_error;
            $this->load->view('register', $data);
        } elseif (!$this->form_validation->valid_email($register_email)) { //check valid email address
            $data['error']= $email_error_invalid;
            $this->load->view('register', $data);
        } elseif (empty($_POST['g-recaptcha-response'])) {
            $data['error']= "Recaptcha unverified. Please try again.";
            $this->load->view('register', $data);
        } else { // no other error identified, create user in database
            $secret = '6LflI9caAAAAAM31bOslXGW6E6quJfHESUDmS0Ue';
            $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
            $responseData = json_decode($verifyResponse);
            if($responseData->success) {
                $token = $this->user_model->register($register_email, $register_username, $register_password);
                $data['success_msg'] = "Congratulation! You have just sign up successfully! A verification email has been sent to the address you provided, please verify your email address by following the steps indicated in the email.";
                $this->load->view('template/success', $data);
                $this->send_email($register_email, $token, $register_username);
            } else {
                $message = "Some errors in verifying g-recaptcha, try again.";
                $data['error'] = $message;
                $this->load->view('register', $data);
            }
        }
        $this->load->view('template/footer');
    }

    public function send_email($email, $token, $username){
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
        $this->email->to($email);
        $this->email->cc('s4518552@student.uq.edu.au');
        $this->email->subject('BLUE. New account email verification');

        
        $message =  "Dear ".$username.": <br/> Thank you for signing up with BLUE., we can't wait to see your first post! <br/> To start sharing, please click the link below to verify your email address: <br/> <a href='".base_url()."register/activate?token=".$token."' target='_blank'> ".base_url()."register/activate?token=".$token."</a> <br/> If the above link does not work, please copy it to your broswer's address line to visit. The link will be valid for 24 hours. <br/> BLUE.";

        $this->email->message($message);
        $this->email->send();
    }

    public function activate() {
        $this->load->helper('url');
        $this->load->model('user_model'); 
        // verify user's email
        $token = stripslashes(trim($_GET['token']));
        $msg = $this->user_model->verify($token); // verify the token with database, get the returned message
        echo $msg;
        $link = " Click here to go back to <a href='".base_url()."'> BLUE. </a>";
        echo $link;
    }

    


}
?>