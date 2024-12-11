<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rack extends My_Controller {
	function __construct()
    {
        parent::__construct();
        
        $this->load->model('me/Rack_model');
     }
    
    function lists(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Add New Rack';
        $data['list']=$this->Rack_model->lists();
        $data['display']='me/rack';
        $this->load->view('admin/master',$data);
        } else {
           redirect("Logincontroller");
        }
    	
    }

    function edit($rack_id){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Edit Rack';
        $data['list']=$this->Rack_model->lists();
        $data['info']=$this->Rack_model->get_info($rack_id);
        $data['display']='me/rack';
        $this->load->view('admin/master',$data);
        } else {
           redirect("Logincontroller");
        }

    }
    
    function save($rack_id=FALSE){
        $this->form_validation->set_rules('rack_name','Rack','trim|required');
         if ($this->form_validation->run() == TRUE) {
            $check=$this->Rack_model->save($rack_id);
            if($check && !$rack_id){
               $this->session->set_userdata('exception','Saved successfully');
               }elseif($check&& $rack_id){
                   $this->session->set_userdata('exception','Update successfully');
               }else{
                  $this->session->set_userdata('exception','Submission Failed');
                }
             redirect("me/Rack/lists");

         }else{
            $data['heading']='Add New Rack';
            $data['list']=$this->Rack_model->lists();
            if($rack_id){
              $data['heading']='Edit Rack';
              $data['info']=$this->Rack_model->get_info($rack_id);  
            }
            $data['display']='me/rack';
            $this->load->view('admin/master',$data);
         }

    }
    function delete($rack_id=FALSE){
           $check=$this->Rack_model->delete($rack_id);
        if($check){ 
           $this->session->set_userdata('exception','Rack delete successfully');
         }else{
           $this->session->set_userdata('exception','Delete Falied');
         }
        redirect("me/Rack/lists");

    }
    //////////////////AJAX FOR DELETIN PRODUCT/////////////
    function checkBrand($rack_id){
        $chk=$this->db->query("SELECT * FROM product_info WHERE rack_id=$rack_id")->result();
        if(count($chk)>0){
            echo "EXISTS";
        }else{
            echo "DELETABLE";
        }
    }


 }