<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Archievemachine extends My_Controller {
    function __construct()
    {
        parent::__construct();
        $this->load->model('me/Archievemachine_model');
     }
    
    function lists(){
      $data=array();
        if($this->session->userdata('user_id')) {
        $data['heading']='Archieve Machine List';
        $data['list']=$this->Archievemachine_model->lists();
        $data['display']='me/archievemachinelist';
        $this->load->view('admin/master',$data);
        } else {
          redirect("Logincontroller");
        }
       }
    
   
 }