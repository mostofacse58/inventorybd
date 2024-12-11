<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Idcard extends My_Controller {
    function __construct()
    {
        parent::__construct();
        $this->load->model('Idcard_model');
     }
	  function index(){
         if ($this->session->userdata('user_id')) {
        $data['details']=$this->Idcard_model->prints();
        $this->load->view('admin/idcardCode',$data);
        } else {
           redirect("Logincontroller");
        }

    	
    }
    


 }