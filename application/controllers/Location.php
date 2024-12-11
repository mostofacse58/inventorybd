<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Location extends My_Controller {
	function __construct(){
        parent::__construct();
        
        $this->load->model('Location_model');
     }
    
    function lists(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Add New Location';
        $data['list']=$this->Location_model->lists();
        $data['display']='admin/location';
        $this->load->view('admin/master',$data);
        } else {
           redirect("Logincontroller");
        }
    	
    }

    function edit($location_id){
        if($this->session->userdata('user_id')){
        $data['heading']='Edit Location';
        $data['list']=$this->Location_model->lists();
        $data['info']=$this->Location_model->get_info($location_id);
        $data['display']='admin/location';
        $this->load->view('admin/master',$data);
        } else {
           redirect("Logincontroller");
        }

    }
    
    function save($location_id=FALSE){
        $this->form_validation->set_rules('location_name','Location','trim|required');
         if ($this->form_validation->run() == TRUE) {
            $check=$this->Location_model->save($location_id);

            if($check && !$location_id){
               $this->session->set_userdata('exception','Saved successfully');
               }elseif($check&& $location_id){
                   $this->session->set_userdata('exception','Update successfully');
               }else{
                  $this->session->set_userdata('exception','Submission Failed');
                }
             redirect("Location/lists");

         }else{
            $data['heading']='Add New Location';
            $data['list']=$this->Location_model->lists();
            if($location_id){
              $data['heading']='Edit Location';
              $data['info']=$this->Location_model->get_info($location_id);  
            }
            $data['display']='admin/location';
            $this->load->view('admin/master',$data);
         }

    }
    //////////////////AJAX FOR DELETIN PRODUCT/////////////
    function checkLocation($location_id){
        $chk=$this->db->query("SELECT * FROM product_info WHERE location_id=$location_id")->result();
        if(count($chk)>0){
            echo "EXISTS";
        }else{
            echo "DELETABLE";
        }
    }
    function delete($location_id=FALSE){
      $check=$this->Location_model->delete($location_id);
        if($check){ 
           $this->session->set_userdata('exception','Location Info delete successfully');
         }else{
           $this->session->set_userdata('exception','Delete Falied');
         }
        redirect("Location/lists");

    }


 }