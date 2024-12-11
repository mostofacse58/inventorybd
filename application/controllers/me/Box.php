<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Box extends My_Controller {
	function __construct()
    {
        parent::__construct();
        
        $this->load->model('me/Box_model');
        $this->load->model('me/Rack_model');
     }
    
    function lists(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Add New Box';
        $data['list']=$this->Box_model->lists();
        $data['rlist']=$this->Rack_model->lists();
        $data['display']='me/boxinfo';
        $this->load->view('admin/master',$data);
        } else {
           redirect("Logincontroller");
        }
    	
    }

    function edit($box_id){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Edit Box';
        $data['list']=$this->Box_model->lists();
        $data['info']=$this->Box_model->get_info($box_id);
        $data['rlist']=$this->Rack_model->lists();
        $data['display']='me/boxinfo';
        $this->load->view('admin/master',$data);
        } else {
           redirect("Logincontroller");
        }

    }
    
    function save($box_id=FALSE){
        $this->form_validation->set_rules('box_name','Box Name','trim|required');
        $this->form_validation->set_rules('rack_id','Rack Name','trim|required');
         if ($this->form_validation->run() == TRUE) {
            $check=$this->Box_model->save($box_id);

            if($check && !$box_id){
               $this->session->set_userdata('exception','Saved successfully');
               }elseif($check&& $box_id){
                   $this->session->set_userdata('exception','Update successfully');
               }else{
                  $this->session->set_userdata('exception','Submission Failed');
                }
             redirect("me/Box/lists");

         }else{
            $data['heading']='Add New Box';
            $data['list']=$this->Box_model->lists();
            if($box_id){
              $data['heading']='Edit Box';
              $data['info']=$this->Box_model->get_info($box_id);  
            }
            $data['rlist']=$this->Rack_model->lists();
            $data['display']='me/boxinfo';
            $this->load->view('admin/master',$data);
         }

    }
    function delete($box_id=FALSE){
           $check=$this->Box_model->delete($box_id);
        if($check){ 
           $this->session->set_userdata('exception','Box delete successfully');
         }else{
           $this->session->set_userdata('exception','Delete Falied');
         }
        redirect("me/lists");

    }
    //////////////////AJAX FOR DELETIN PRODUCT/////////////
    function checkDelete($box_id){
        $chk=$this->db->query("SELECT * FROM product_info 
          WHERE box_id=$box_id")->result();
        if(count($chk)>0){
            echo "EXISTS";
        }else{
            echo "DELETABLE";
        }
    }


 }