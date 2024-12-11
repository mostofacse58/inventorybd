<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Floorline extends My_Controller {
	function __construct()
    {
        parent::__construct();
        
        $this->load->model('Floorline_model');
     }
    
    function lists(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Add New Line No';
        $data['flist']=$this->Floorline_model->flists();
        $data['list']=$this->Floorline_model->lists();
        $data['display']='admin/floorline';
        $this->load->view('admin/master',$data);
        } else {
           redirect("Logincontroller");
        }
    	
    }

    function edit($line_id){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Edit Line Line';
        $data['list']=$this->Floorline_model->lists();
        $data['flist']=$this->Floorline_model->flists();
        $data['info']=$this->Floorline_model->get_info($line_id);
        $data['display']='admin/floorline';
        $this->load->view('admin/master',$data);
        } else {
           redirect("Logincontroller");
        }

    }
    
    function save($line_id=FALSE){
        $this->form_validation->set_rules('line_no','Line Info','trim|required');
        $this->form_validation->set_rules('floor_id','Floor No','trim|required');
         if ($this->form_validation->run() == TRUE) {
            $check=$this->Floorline_model->save($line_id);

            if($check && !$line_id){
               $this->session->set_userdata('exception','Saved successfully');
               }elseif($check&& $line_id){
                   $this->session->set_userdata('exception','Update successfully');
               }else{
                  $this->session->set_userdata('exception','Submission Failed');
                }
             redirect("Floorline/lists");

         }else{
            $data['heading']='Add New Line No';
            $data['list']=$this->Floorline_model->lists();
            $data['dlist']=$this->Floorline_model->dlists();
            if($line_id){
              $data['heading']='Edit Line No';
              $data['info']=$this->Floorline_model->get_info($line_id);  
            }
            $data['display']='admin/floorline';
            $this->load->view('admin/master',$data);
         }

    }
    function delete($line_id=FALSE){
           $check=$this->Floorline_model->delete($line_id);
        if($check){ 
           $this->session->set_userdata('exception','Line No delete successfully');
         }else{
           $this->session->set_userdata('exception','Delete Falied');
         }
        redirect("Floorline/lists");

    }
//////////////////AJAX FOR DELETIN PRODUCT/////////////
    function checkDelete($line_id){
        $chk=$this->db->query("SELECT * FROM product_status_info 
          WHERE line_id=$line_id")->result();
        if(count($chk)>0){
            echo "EXISTS";
        }else{
            echo "DELETABLE";
        }
    }

 }