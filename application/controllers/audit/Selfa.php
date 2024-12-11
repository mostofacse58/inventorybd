<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Selfa extends My_Controller {
  function __construct(){
      parent::__construct();
      $this->load->model('audit/Self_model');
   
   }
    
  function lists(){
    $data=array();
    if($this->session->userdata('user_id')) {
    $data['heading']='Audit Panel';
    $data['list']=$this->Self_model->lists();
    $data['display']='audit/selflist';
    $this->load->view('admin/master',$data);
    } else {
      redirect("Logincontroller");
    }
   }
  function edit($master_id){
    if ($this->session->userdata('user_id')) {
    $data['heading']='Audit Panel';
    $data['master_id']=$master_id;
    $data['info']=$this->Self_model->get_info($master_id);
    $data['plists']=$this->Self_model->getallPackage($data['info']);
    $data['display']='audit/addself';
    $this->load->view('admin/master',$data);
    } else {
       redirect("Logincontroller");
    }

  }

  function save($master_id=FALSE){
    $check=$this->Self_model->save($master_id);
      if($check && !$master_id){
       $this->session->set_userdata('exception','Saved successfully');
       }elseif($check&& $master_id){
           $this->session->set_userdata('exception','Update successfully');
       }else{
         $this->session->set_userdata('exception','Submission Failed');
       }
    redirect("audit/selfa/lists");
  }
   function delete($master_id=FALSE){
         $check=$this->Self_model->delete($master_id);
           if($check){ 
           $this->session->set_userdata('exception','Delete successfully');
         }else{
           $this->session->set_userdata('exception','Delete Failed');
         }
        redirect("audit/selfa/lists");
    }
  function loadExcel($master_id=FALSE,$year=FALSE){
    if ($this->session->userdata('user_id')) {
        $data['heading']='Audit Report';
        $data['info']=$this->Self_model->get_info($master_id);
        $data['hlist']=$this->Self_model->getHeadList($data['info']);
        $data['master_id']=$master_id;
        $this->load->view('audit/auditExcel', $data);
       } else {
         redirect("Logincontroller");
      }
    }
    function submit($master_id){
      $data['status']=3;
      $this->db->where('master_id', $master_id);
      $this->db->update('audit_master',$data);
      $this->session->set_userdata('exception','Submit successfully');
      redirect("audit/selfa/lists");
    }
  

 }