<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Email extends CI_Controller {

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

        
        $message =  "Dear ".$username.": <br/> Thank you for signing up with BLUE., we can't wait to see your first post! <br/> To start sharing, please click the link below to verify your email address: <br/> <a href='".base_url()."register/activate?token=".$token."' target='_blank'> ".base_url()."register/activate?token=".$token."</a> <br/> If the above link does not work, please copy it to your broswer's address line to visit. The link will be valid for 24 hours.";

        $this->email->message($message);
        $this->email->send();

    }

}