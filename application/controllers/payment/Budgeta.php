<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Budgeta extends My_Controller {
  function __construct(){
      parent::__construct();
      $this->load->model('payment/Budgeta_model');
      $this->load->model('payment/Applications_model');
   }
    
  function lists(){
    $data=array();
    if($this->session->userdata('user_id')) {
    $data['heading']='Monthly Budget Adjustment Lists';
    $data['lists']=$this->Budgeta_model->lists();
    $data['display']='payment/balists';
    $this->load->view('admin/master',$data);
    } else {
      redirect("Logincontroller");
    }
  }
  function add(){
      if($this->session->userdata('user_id')) {
        $data['heading']='Add Budget Adjustment';
        $data['hlist']=$this->Budgeta_model->getDetails();
        $data['display']='payment/addbudgeta';
        $this->load->view('admin/master',$data);
      }else{
        redirect("Logincontroller");
      }
    }
    
    function edit($master_id){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Edit Budget Adjustment';
        $data['master_id']=$master_id;
        $data['info']=$this->Budgeta_model->get_info($master_id);
        $data['hlist']=$this->Budgeta_model->getDetails($master_id);
        $data['display']='payment/addbudgeta';
        $this->load->view('admin/master',$data);
        } else {
          redirect("Logincontroller");
        }
    }

  function save($master_id=FALSE){
    $check=$this->Budgeta_model->save($master_id);
      if($check && !$master_id){
       $this->session->set_userdata('exception','Saved successfully');
       }elseif($check&& $master_id){
           $this->session->set_userdata('exception','Update successfully');
       }else{
         $this->session->set_userdata('exception','Submission Failed');
       }
    redirect("payment/Budgeta/lists");
  }
   function deletes($master_id=FALSE){
       $check=$this->Budgeta_model->deletes($master_id);
         if($check){ 
         $this->session->set_userdata('exception','Delete successfully');
       }else{
         $this->session->set_userdata('exception','Delete Failed');
       }
      redirect("payment/Budgeta/lists");
    }
    function view($master_id=FALSE){
      $data['heading']='Budget Adjustment View';
      $data['controller']=$this->router->fetch_class();
      $data['info']=$this->Budgeta_model->get_info($master_id);
      $data['hlist']=$this->Budgeta_model->getDetails($master_id);
      $data['display']='payment/budgetaviewhtml';
      $this->load->view('admin/master',$data);
    }
  function loadExcel($master_id=FALSE,$year=FALSE){
    if ($this->session->userdata('user_id')) {
        $data['heading']='Budget Adjustment View';
        $data['info']=$this->Budgeta_model->get_info($master_id);
        $data['hlist']=$this->Budgeta_model->getDetails($master_id);
        $data['master_id']=$master_id;
        $this->load->view('payment/budgetaviewExcel', $data);
       } else {
         redirect("Logincontroller");
      }
    }

    function submit($master_id){
      $data['status']=2;
      $this->db->where('master_id', $master_id);
      $this->db->update('budget_adjustment_master',$data);
      $this->session->set_userdata('exception','Submit successfully');
      redirect("payment/Budgeta/lists");
    }
  

 }