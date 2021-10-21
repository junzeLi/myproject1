<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Crop extends CI_Controller {
    public function crop_and_save() {
        $this->load->model('file_model');
        $jpeg_quality = 90;
        $crop = $this->input->post('crop');
        $src =$this->input->post('url');
        $img= imagecreatefromstring(file_get_contents($src));
        $dst = ImageCreateTrueColor( $crop['w'],$crop['h'] ); 
        imagecopyresampled($dst,$img,0,0,$crop['x'],$crop['y'],
        $crop['w'],$crop['h'],$crop['w'],$crop['h']);
        $ext=pathinfo($src, PATHINFO_EXTENSION);
        $photoname=pathinfo($src, PATHINFO_FILENAME ); //filename
        $newphoto=$src; //location
        imagejpeg($dst,$newphoto,$jpeg_quality); 
        imagedestroy($img); 
        imagedestroy($dst);
        $this->file_model->upload_profile($photoname, $newphoto, $this->session->userdata('username')); //upload info to db
        $data['newphoto'] = $newphoto;

        // update userdata in session
        $this->session->unset_userdata('profile_path');
        $this->session->set_userdata('profile_path', $data['newphoto']);

        echo json_encode($data);
    }
}

