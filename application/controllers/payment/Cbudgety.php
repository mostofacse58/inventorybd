<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cbudgety extends My_Controller {
  function __construct(){
      parent::__construct();
      $this->load->model('payment/Budgety_model');
      $this->load->model('payment/Applications_model');
      $this->load->model('payment/Cbudgety_model');
   
   }
    
  function lists(){
    $data=array();
    if($this->session->userdata('user_id')) {
    $data['heading']='Yearly Budget Lists';
    $data['lists']=$this->Cbudgety_model->lists();
    $data['display']='payment/cbudgety';
    $this->load->view('admin/master',$data);
    } else {
      redirect("Logincontroller");
    }
   }
  function view($master_id=FALSE){
      $data['heading']='Yearly Budget View';
      $data['controller']=$this->router->fetch_class();
      $data['info']=$this->Budgety_model->get_info($master_id);
      $data['hlist']=$this->Budgety_model->getDetails($master_id);
      $data['display']='payment/budgetyviewhtml';
      $this->load->view('admin/master',$data);
    }

    function approved($master_id=FALSE){
      $this->load->model('Communication');
      $data['info']=$this->Budgety_model->get_info($master_id);
      $emailaddress="finance.accounts@bdventura.com";
      $subject="Budget Request Receive Notification";
      $message=$this->load->view('payment/budget_received_email', $data,true); 
      //$this->Communication->send($emailaddress,$subject,$message);
  ////////////////////////
    $check=$this->Cbudgety_model->approved($master_id);
    if($check){ 
      $this->session->set_userdata('exception','Confirm successfully');
     }else{
      $this->session->set_userdata('exception','Send Failed');
    }
  redirect("payment/Cbudgety/lists");
  }

 
  function decisions($master_id=FALSE){
    $check=$this->Budgety_model->decisions($master_id);
      if($check){ 
        $this->session->set_userdata('exception','Return successfully');
       }else{
        $this->session->set_userdata('exception','Failed');
      }
    redirect("payment/Cbudgety/lists");
  }
  

 }