<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Supplier extends My_Controller {
	function __construct(){
        parent::__construct();
        $this->load->model('shipping/Supplier_model');
     }
    
    function lists(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Add New Supplier';
        $data['list']=$this->Supplier_model->lists();
        $data['display']='shipping/supplierinfo';
        $this->load->view('admin/master',$data);
        } else {
           redirect("Logincontroller");
        }
    	
    }

    function edit($id){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Edit Supplier';
        $data['list']=$this->Supplier_model->lists();
        $data['info']=$this->Supplier_model->get_info($id);
        $data['display']='shipping/supplierinfo';
        $this->load->view('admin/master',$data);
        } else {
           redirect("Logincontroller");
        }

    }
    
    function save($id=FALSE){
        $this->form_validation->set_rules('supplier_name','Supplier','trim|required');
        $this->form_validation->set_rules('description','Address ','trim');
         if ($this->form_validation->run() == TRUE) {
            $check=$this->Supplier_model->save($id);

            if($check && !$id){
               $this->session->set_userdata('exception','Saved successfully');
               }elseif($check&& $id){
                   $this->session->set_userdata('exception','Update successfully');
               }else{
                  $this->session->set_userdata('exception','Submission Failed');
                }
             redirect("shipping/Supplier/lists");

         }else{
            $data['heading']='Add New Supplier';
            $data['list']=$this->Supplier_model->lists();
            if($id){
              $data['heading']='Edit Supplier';
              $data['info']=$this->Supplier_model->get_info($id);  
            }
            $data['display']='shipping/supplierinfo';
            $this->load->view('admin/master',$data);
         }

    }
    function delete($id=FALSE){
           $check=$this->Supplier_model->delete($id);
        if($check){ 
           $this->session->set_userdata('exception','Delete successfully');
         }else{
           $this->session->set_userdata('exception','Delete Falied');
         }
        redirect("shipping/Supplier/lists");

    }
    //////////////////AJAX FOR DELETIN PRODUCT/////////////
    function checkDelete($id){
        $chk=$this->db->query("SELECT i.*
         FROM shipping_imsupplier_master i,shipping_supplier_info p 
          WHERE i.supplier_name=p.supplier_name 
          AND p.id=$id")->result();
        if(count($chk)>0){
            echo "EXISTS";
        }else{
            echo "DELETABLE";
        }
    }


 }