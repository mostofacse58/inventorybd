<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Bareceived extends My_Controller {
  function __construct(){
      parent::__construct();
      $this->load->model('payment/Budgeta_model');
      $this->load->model('payment/Bareceived_model');
   
   }
    
  function lists(){
    $data=array();
    if($this->session->userdata('user_id')) {
    $data['heading']='Budget Adjustment Lists';
    $data['lists']=$this->Bareceived_model->lists();
    $data['display']='payment/rbalists';
    $this->load->view('admin/master',$data);
    } else {
      redirect("Logincontroller");
    }
   }  
    function view($master_id=FALSE){
      $data['heading']='Budget Adjustment View';
      $data['controller']=$this->router->fetch_class();
      $data['info']=$this->Budgeta_model->get_info($master_id);
      $data['hlist']=$this->Budgeta_model->getDetails($master_id);
      $data['display']='payment/budgetaviewhtml';
      $this->load->view('admin/master',$data);
    }
    
  function approved($master_id=FALSE){
    $check=$this->Bareceived_model->approved($master_id);
    if($check){ 
      $this->session->set_userdata('exception','Confirm successfully');
     }else{
      $this->session->set_userdata('exception','Send Failed');
    }
  redirect("payment/Bareceived/lists");
  }

 
  function decisions($master_id=FALSE){
    $check=$this->Budgeta_model->decisions($master_id);
      if($check){ 
        $this->session->set_userdata('exception','Return successfully');
       }else{
        $this->session->set_userdata('exception','Failed');
      }
    redirect("payment/Bareceived/lists");
  }
  

 }