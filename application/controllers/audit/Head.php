<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Head extends My_Controller {
	function __construct(){
        parent::__construct();
        $this->load->model('audit/Head_model');
     }
    
    function lists(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Add New Head';
        $data['list']=$this->Head_model->lists();
        $data['display']='audit/headinfo';
        $this->load->view('admin/master',$data);
        } else {
           redirect("Logincontroller");
        }
    	
    }

    function edit($head_id){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Edit Head';
        $data['list']=$this->Head_model->lists();
        $data['info']=$this->Head_model->get_info($head_id);
        $data['display']='audit/headinfo';
        $this->load->view('admin/master',$data);
        } else {
           redirect("Logincontroller");
        }

    }
    
    function save($head_id=FALSE){
        $this->form_validation->set_rules('head_name','Head','trim|required');
         if ($this->form_validation->run() == TRUE) {
            $check=$this->Head_model->save($head_id);

            if($check && !$head_id){
               $this->session->set_userdata('exception','Saved successfully');
               }elseif($check&& $head_id){
                   $this->session->set_userdata('exception','Update successfully');
               }else{
                  $this->session->set_userdata('exception','Submission Failed');
                }
             redirect("audit/Head/lists");

         }else{
            $data['heading']='Add New Head';
            $data['list']=$this->Head_model->lists();
            if($head_id){
              $data['heading']='Edit Head';
              $data['info']=$this->Head_model->get_info($head_id);  
            }
            $data['display']='audit/headinfo';
            $this->load->view('admin/master',$data);
         }

    }
    function delete($head_id=FALSE){
           $check=$this->Head_model->delete($head_id);
        if($check){ 
           $this->session->set_userdata('exception','Delete successfully');
         }else{
           $this->session->set_userdata('exception','Delete Falied');
         }
        redirect("audit/Head/lists");

    }
    //////////////////AJAX FOR DELETIN PRODUCT/////////////
    function checkDelete($head_id){
        $chk=$this->db->query("SELECT *
         FROM audit_package
          WHERE head_id=$head_id")->result();
        if(count($chk)>0){
            echo "EXISTS";
        }else{
            echo "DELETABLE";
        }
    }


 }