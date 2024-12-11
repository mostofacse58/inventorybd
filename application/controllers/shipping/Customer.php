<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Customer extends My_Controller {
	function __construct(){
        parent::__construct();
        $this->load->model('shipping/Customer_model');
     }
    
    function lists(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Add New Customer';
        $data['list']=$this->Customer_model->lists();
        $data['display']='shipping/customerinfo';
        $this->load->view('admin/master',$data);
        } else {
           redirect("Logincontroller");
        }
    	
    }

    function edit($id){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Edit Customer';
        $data['list']=$this->Customer_model->lists();
        $data['info']=$this->Customer_model->get_info($id);
        $data['display']='shipping/customerinfo';
        $this->load->view('admin/master',$data);
        } else {
           redirect("Logincontroller");
        }

    }
    
    function save($id=FALSE){
        $this->form_validation->set_rules('customer_name','Customer','trim|required');
        $this->form_validation->set_rules('address','Address ','trim');
         if ($this->form_validation->run() == TRUE) {
            $check=$this->Customer_model->save($id);

            if($check && !$id){
               $this->session->set_userdata('exception','Saved successfully');
               }elseif($check&& $id){
                   $this->session->set_userdata('exception','Update successfully');
               }else{
                  $this->session->set_userdata('exception','Submission Failed');
                }
             redirect("shipping/Customer/lists");

         }else{
            $data['heading']='Add New Customer';
            $data['list']=$this->Customer_model->lists();
            if($id){
              $data['heading']='Edit Customer';
              $data['info']=$this->Customer_model->get_info($id);  
            }
            $data['display']='shipping/customerinfo';
            $this->load->view('admin/master',$data);
         }

    }
    function delete($id=FALSE){
           $check=$this->Customer_model->delete($id);
        if($check){ 
           $this->session->set_userdata('exception','Delete successfully');
         }else{
           $this->session->set_userdata('exception','Delete Falied');
         }
        redirect("shipping/Customer/lists");

    }
    //////////////////AJAX FOR DELETIN PRODUCT/////////////
    function checkDelete($id){
        $chk=$this->db->query("SELECT i.*
         FROM shipping_imcustomer_master i,shipping_customer_info p 
          WHERE i.customer_name=p.customer_name 
          AND p.id=$id")->result();
        if(count($chk)>0){
            echo "EXISTS";
        }else{
            echo "DELETABLE";
        }
    }


 }