<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Breceived extends My_Controller {
  function __construct(){
      parent::__construct();
      $this->load->model('payment/Budget_model');
      $this->load->model('payment/Applications_model');
      $this->load->model('payment/Breceived_model');
   
   }
    
  function lists(){
    $data=array();
    if($this->session->userdata('user_id')) {
    $data['heading']='Monthly Budget Lists';
    $data['lists']=$this->Breceived_model->lists();
    $data['display']='payment/rblists';
    $this->load->view('admin/master',$data);
    } else {
      redirect("Logincontroller");
    }
   }  
    function view($master_id=FALSE){
      $data['heading']='Budget View';
      $data['controller']=$this->router->fetch_class();
      $data['info']=$this->Budget_model->get_info($master_id);
      $data['hlist']=$this->Budget_model->getDetails($master_id);
      $data['display']='payment/budgetviewhtml';
      $this->load->view('admin/master',$data);
    }
    
  
 
  function approved($master_id=FALSE){
    $check=$this->Breceived_model->approved($master_id);
    if($check){ 
      $this->session->set_userdata('exception','Confirm successfully');
     }else{
      $this->session->set_userdata('exception','Send Failed');
    }
  redirect("payment/Breceived/lists");
  }

 
  function decisions($master_id=FALSE){
    $check=$this->Budget_model->decisions($master_id);
      if($check){ 
        $this->session->set_userdata('exception','Return successfully');
       }else{
        $this->session->set_userdata('exception','Failed');
      }
    redirect("payment/Breceived/lists");
  }
  

 }