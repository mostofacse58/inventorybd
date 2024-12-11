<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Budgety extends My_Controller {
  function __construct(){
      parent::__construct();
      $this->load->model('payment/Budgety_model');
      $this->load->model('payment/Applications_model');
   }
    
  function lists(){
    $data=array();
    if($this->session->userdata('user_id')) {
    $data['heading']='Monthly Yearly Budget Lists';
    $data['lists']=$this->Budgety_model->lists();
    $data['display']='payment/yearlylist';
    $this->load->view('admin/master',$data);
    } else {
      redirect("Logincontroller");
    }
  }
  function add(){
      if($this->session->userdata('user_id')) {
        $data['heading']='Add Yearly Budget';
        $data['hlist']=$this->Budgety_model->getDetails();
        $data['display']='payment/addbudgety';
        $this->load->view('admin/master',$data);
      }else{
        redirect("Logincontroller");
      }
    }
    
    function edit($master_id){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Edit Yearly Budget';
        $data['master_id']=$master_id;
        $data['info']=$this->Budgety_model->get_info($master_id);
        $data['hlist']=$this->Budgety_model->getDetails($master_id);
        $data['display']='payment/addbudgety';
        $this->load->view('admin/master',$data);
        } else {
          redirect("Logincontroller");
        }
    }

  function save($master_id=FALSE){
    $check=$this->Budgety_model->save($master_id);
      if($check && !$master_id){
       $this->session->set_userdata('exception','Saved successfully');
       }elseif($check&& $master_id){
           $this->session->set_userdata('exception','Update successfully');
       }else{
         $this->session->set_userdata('exception','Submission Failed');
       }
    redirect("payment/Budgety/lists");
  }
   function deletes($master_id=FALSE){
       $check=$this->Budgety_model->deletes($master_id);
         if($check){ 
         $this->session->set_userdata('exception','Delete successfully');
       }else{
         $this->session->set_userdata('exception','Delete Failed');
       }
      redirect("payment/Budgety/lists");
    }
    function view($master_id=FALSE){
      $data['heading']='Yearly Budget View';
      $data['controller']=$this->router->fetch_class();
      $data['info']=$this->Budgety_model->get_info($master_id);
      $data['hlist']=$this->Budgety_model->getDetails($master_id);
      $data['display']='payment/budgetyviewhtml';
      $this->load->view('admin/master',$data);
    }
  function loadExcel($master_id=FALSE,$year=FALSE){
    if ($this->session->userdata('user_id')) {
        $data['heading']='Yearly Budget View';
        $data['info']=$this->Budgety_model->get_info($master_id);
        $data['hlist']=$this->Budgety_model->getDetails($master_id);
        $data['master_id']=$master_id;
        $this->load->view('payment/budgetyviewExcel', $data);
       } else {
         redirect("Logincontroller");
      }
    }

    function submit($master_id){
      $data['status']=2;
      $this->db->where('master_id', $master_id);
      $this->db->update('budget_yearly_master',$data);
      $this->session->set_userdata('exception','Submit successfully');
      redirect("payment/Budgety/lists");
    }
  

 }