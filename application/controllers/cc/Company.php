<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Company extends My_Controller {
	function __construct()
    {
        parent::__construct();
        $this->output->nocache();
        $this->load->model('cc/Company_model');
     }
    
    function lists(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Add Courier Company';
        $data['list']=$this->Company_model->lists();
        $data['display']='cc/companyinfo';
        $this->load->view('admin/master',$data);
        } else {
           redirect("Logincontroller");
        }
    	
    }

    function edit($courier_name_id){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Edit Courier Company';
        $data['list']=$this->Company_model->lists();
        $data['info']=$this->Company_model->get_info($courier_name_id);
        $data['display']='cc/companyinfo';
        $this->load->view('admin/master',$data);
        } else {
           redirect("Logincontroller");
        }

    }
    
    function save($courier_name_id=FALSE){
        $this->form_validation->set_rules('courier_company','Name','trim|required');
        $this->form_validation->set_rules('courier_address','Address','trim');
         if ($this->form_validation->run() == TRUE) {
            $check=$this->Company_model->save($courier_name_id);
            if($check && !$courier_name_id){
               $this->session->set_userdata('exception','Saved successfully');
               }elseif($check&& $courier_name_id){
                   $this->session->set_userdata('exception','Update successfully');
               }else{
                  $this->session->set_userdata('exception','Submission Failed');
                }
             redirect("cc/Company/lists");

         }else{
            $data['heading']='Add Courier Company';
            $data['list']=$this->Company_model->lists();
            if($courier_name_id){
              $data['heading']='Edit Issue To';
              $data['info']=$this->Company_model->get_info($courier_name_id);  
            }
            $data['display']='cc/companyinfo';
            $this->load->view('admin/master',$data);
         }

    }
    function delete($courier_name_id=FALSE){
        $check=$this->Company_model->delete($courier_name_id);
        if($check){ 
           $this->session->set_userdata('exception','Delete successfully');
         }else{
           $this->session->set_userdata('exception','Delete Falied');
         }
        redirect("cc/Company/lists");

    }

 }