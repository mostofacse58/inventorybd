<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Symptoms extends My_Controller {
	function __construct(){
        parent::__construct();
        
        $this->load->model('Symptoms_model');
     }
    
    function lists(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Add Symptom';
        $data['list']=$this->Symptoms_model->lists();
        $data['display']='admin/symptoms';
        $this->load->view('admin/master',$data);
        } else {
           redirect("Logincontroller");
        }
    	
    }

    function edit($symptoms_id){
        if($this->session->userdata('user_id')){
        $data['heading']='Edit Symptom';
        $data['list']=$this->Symptoms_model->lists();
        $data['info']=$this->Symptoms_model->get_info($symptoms_id);
        $data['display']='admin/symptoms';
        $this->load->view('admin/master',$data);
        } else {
           redirect("Logincontroller");
        }
    }
    
    function save($symptoms_id=FALSE){
        $this->form_validation->set_rules('symptoms_name','Symptom','trim|required');
         if ($this->form_validation->run() == TRUE) {
            $check=$this->Symptoms_model->save($symptoms_id);
            if($check && !$symptoms_id){
               $this->session->set_userdata('exception','Saved successfully');
               }elseif($check&& $symptoms_id){
                   $this->session->set_userdata('exception','Update successfully');
               }else{
                  $this->session->set_userdata('exception','Submission Failed');
            }
            redirect("Symptoms/lists");
         }else{
            $data['heading']='Add Symptom';
            $data['list']=$this->Symptoms_model->lists();
            if($symptoms_id){
              $data['heading']='Edit Symptom';
              $data['info']=$this->Symptoms_model->get_info($symptoms_id);  
            }
            $data['display']='admin/symptoms';
            $this->load->view('admin/master',$data);
         }

    }
    //////////////////AJAX FOR DELETIN PRODUCT/////////////
    function checkSymptom($symptoms_id){
        $chk=$this->db->query("SELECT * FROM issued_symptoms WHERE symptoms_id=$symptoms_id")->result();
        if(count($chk)>0){
            echo "EXISTS";
        }else{
            echo "DELETABLE";
        }
    }
    function delete($symptoms_id=FALSE){
      $check=$this->Symptoms_model->delete($symptoms_id);
        if($check){ 
           $this->session->set_userdata('exception','Delete successfully');
         }else{
           $this->session->set_userdata('exception','Delete Falied');
         }
        redirect("Symptoms/lists");

    }


 }