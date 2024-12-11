<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Injury extends My_Controller {
	function __construct(){
        parent::__construct();
        
        $this->load->model('Injury_model');
     }
    
    function lists(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Add Injury';
        $data['list']=$this->Injury_model->lists();
        $data['display']='admin/injury';
        $this->load->view('admin/master',$data);
        } else {
           redirect("Logincontroller");
        }
    	
    }

    function edit($injury_id){
        if($this->session->userdata('user_id')){
        $data['heading']='Edit Injury';
        $data['list']=$this->Injury_model->lists();
        $data['info']=$this->Injury_model->get_info($injury_id);
        $data['display']='admin/injury';
        $this->load->view('admin/master',$data);
        } else {
           redirect("Logincontroller");
        }
    }
    
    function save($injury_id=FALSE){
        $this->form_validation->set_rules('injury_name','Injury','trim|required');
         if ($this->form_validation->run() == TRUE) {
            $check=$this->Injury_model->save($injury_id);
            if($check && !$injury_id){
               $this->session->set_userdata('exception','Saved successfully');
               }elseif($check&& $injury_id){
                   $this->session->set_userdata('exception','Update successfully');
               }else{
                  $this->session->set_userdata('exception','Submission Failed');
            }
            redirect("Injury/lists");
         }else{
            $data['heading']='Add Injury';
            $data['list']=$this->Injury_model->lists();
            if($injury_id){
              $data['heading']='Edit Injury';
              $data['info']=$this->Injury_model->get_info($injury_id);  
            }
            $data['display']='admin/injury';
            $this->load->view('admin/master',$data);
         }

    }
    //////////////////AJAX FOR DELETIN PRODUCT/////////////
    function checkInjury($injury_id){
        $chk=$this->db->query("SELECT * FROM store_issue_master WHERE injury_id=$injury_id")->result();
        if(count($chk)>0){
            echo "EXISTS";
        }else{
            echo "DELETABLE";
        }
    }
    function delete($injury_id=FALSE){
      $check=$this->Injury_model->delete($injury_id);
        if($check){ 
           $this->session->set_userdata('exception','Delete successfully');
         }else{
           $this->session->set_userdata('exception','Delete Falied');
         }
        redirect("Injury/lists");

    }


 }