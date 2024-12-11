<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cbudgeta extends My_Controller {
  function __construct(){
      parent::__construct();
      $this->load->model('payment/Budgeta_model');
      $this->load->model('payment/Applications_model');
      $this->load->model('payment/Cbudgeta_model');
   
   }
    
  function lists(){
    $data=array();
    if($this->session->userdata('user_id')) {
    $data['heading']='Budget Adjustment Lists';
    $data['lists']=$this->Cbudgeta_model->lists();
    $data['display']='payment/cbalists';
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
      $this->load->model('Communication');
      $data['info']=$this->Budgeta_model->get_info($master_id);
      $emailaddress="finance.accounts@bdventura.com";
      $subject="Budget Request Receive Notification";
      $message=$this->load->view('payment/budget_received_email', $data,true); 
      //$this->Communication->send($emailaddress,$subject,$message);
  ////////////////////////
    $check=$this->Cbudgeta_model->approved($master_id);
    if($check){ 
      $this->session->set_userdata('exception','Confirm successfully');
     }else{
      $this->session->set_userdata('exception','Send Failed');
    }
  redirect("payment/Cbudgeta/lists");
  }

 
  function decisions($master_id=FALSE){
    $check=$this->Budgeta_model->decisions($master_id);
      if($check){ 
        $this->session->set_userdata('exception','Return successfully');
       }else{
        $this->session->set_userdata('exception','Failed');
      }
    redirect("payment/Cbudgeta/lists");
  }
  

 }