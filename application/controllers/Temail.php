<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Temail extends CI_Controller{
    
    function  __construct(){
        parent::__construct();
        $this->load->model('Communication');
    }
    function send(){
        // Load PHPMailer library
          $this->Communication->send();
    }
    
}