<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Laptop extends My_Controller {
	function __construct()
    {
        parent::__construct();
        $this->output->nocache();
        $this->load->model('gatep/Laptop_model');
     }
    
    function lists(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Add New Laptop';
        $data['elist']=$this->Laptop_model->getTableInfo('employee_info');
        $data['blist']=$this->Laptop_model->getTableInfo('brand_info');
        $data['list']=$this->Laptop_model->lists();
        $data['display']='gatep/laptopInfo';
        $this->load->view('admin/master',$data);
        } else {
           redirect("Logincontroller");
        }
    	
    }

    function edit($laptop_id){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Edit Laptop';
        $data['elist']=$this->Laptop_model->getTableInfo('employee_info');
        $data['blist']=$this->Laptop_model->getTableInfo('brand_info');
        $data['list']=$this->Laptop_model->lists();
        $data['info']=$this->Laptop_model->get_info($laptop_id);
        $data['display']='gatep/laptopInfo';
        $this->load->view('admin/master',$data);
        } else {
           redirect("Logincontroller");
        }

    }
    
    function save($laptop_id=FALSE){
        $this->form_validation->set_rules('employee_id','Employee Name','trim|required');
        $this->form_validation->set_rules('brand_id','Brand Name','trim|required');
        $this->form_validation->set_rules('sn_no','Serial NO','trim|required');
        $this->form_validation->set_rules('user_no','User NO','trim|required');
         if ($this->form_validation->run() == TRUE) {
            $check=$this->Laptop_model->save($laptop_id);
            if($check && !$laptop_id){
               $this->session->set_userdata('exception','Saved successfully');
               }elseif($check&& $laptop_id){
                   $this->session->set_userdata('exception','Update successfully');
               }else{
                  $this->session->set_userdata('exception','Submission Failed');
                }
             redirect("gatep/Laptop/lists");

         }else{
            $data['heading']='Add New Laptop';
            $data['elist']=$this->Laptop_model->getTableInfo('employee_info');
            $data['blist']=$this->Laptop_model->getTableInfo('brand_info');
            $data['list']=$this->Laptop_model->lists();
            if($laptop_id){
              $data['heading']='Edit Laptop';
              $data['info']=$this->Laptop_model->get_info($laptop_id);  
            }
            $data['display']='gatep/laptopInfo';
            $this->load->view('admin/master',$data);
         }

    }
    function delete($laptop_id=FALSE){
        $check=$this->Laptop_model->delete($laptop_id);
        if($check){ 
           $this->session->set_userdata('exception','Information delete successfully');
         }else{
           $this->session->set_userdata('exception','Delete Falied');
         }
        redirect("gatep/Laptop/lists");

    }
    //////////////////AJAX FOR DELETIN PRODUCT/////////////
    function checkDelete($laptop_id){
        $chk=$this->db->query("SELECT * FROM gatepass_master 
          WHERE laptop_id=$laptop_id")->result();
        if(count($chk)>0){
            echo "EXISTS";
        }else{
            echo "DELETABLE";
        }
    }
    function showbar(){
      $data['lists']=$this->db->query("SELECT * FROM laptop_info 
      WHERE 1
      ORDER BY laptop_id ASC 
      ")->result();
      //echo count($data['lists']); exit();
      $this->load->view('gatep/printbar',$data);

    }
    function approved($laptop_id){
      $data['status']=1;
      $this->db->WHERE('laptop_id',$laptop_id);
      $query=$this->db->update('laptop_info',$data);
      $this->session->set_userdata('exception','Approved successfully');
      redirect("gatep/Laptop/lists");
    }
    function reject($laptop_id){
      $data['status']=2;
      $this->db->WHERE('laptop_id',$laptop_id);
      $query=$this->db->update('laptop_info',$data);
      $this->session->set_userdata('exception','Reject successfully');
      redirect("gatep/Laptop/lists");
    }
    

    


 }