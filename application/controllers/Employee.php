<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Employee extends My_Controller {
	function __construct(){
        parent::__construct();
        
        $this->load->model('Employee_model');
        $this->load->model('Config_model');
     }
    function lists(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Add New Employee Info';
        $data['list']=$this->Employee_model->lists();
        $data['display']='admin/employee';
        $this->load->view('admin/master',$data);
        } else {
           redirect("Logincontroller");
        }
    }
    function edit($employee_id){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Edit Employee Info';
        $data['list']=$this->Employee_model->lists();
        $data['info']=$this->Employee_model->get_info($employee_id);
        $data['display']='admin/employee';
        $this->load->view('admin/master',$data);
        } else {
           redirect("Logincontroller");
        }

    }
    function save($employee_id=FALSE){
        $this->form_validation->set_rules('employee_name','Employee Name','trim|required');
        $this->form_validation->set_rules('designation','Designation','trim|required');
        $this->form_validation->set_rules('employee_cardno','ID No','trim|required');

         if ($this->form_validation->run() == TRUE) {
            $check=$this->Employee_model->save($employee_id);
            if($check && !$employee_id){
               $this->session->set_userdata('exception','Saved successfully');
               }elseif($check&& $employee_id){
                   $this->session->set_userdata('exception','Update successfully');
               }else{
                  $this->session->set_userdata('exception','Submission Failed');
                }
             redirect("Employee/lists");

         }else{
            $data['heading']='Add New Employee Info';
            $data['list']=$this->Employee_model->lists();
            if($employee_id){
              $data['heading']='Edit Employee Info';
              $data['info']=$this->Employee_model->get_info($employee_id);  
            }
            
            $data['display']='admin/employee';
            $this->load->view('admin/master',$data);
         }

    }
    function delete($employee_id=FALSE){
           $check=$this->Employee_model->delete($employee_id);
        if($check){ 
           $this->session->set_userdata('exception','Delete successfully');
         }else{
           $this->session->set_userdata('exception','Delete Falied');
         }
        redirect("Employee/lists");

    }


 }