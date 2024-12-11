<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Ditem extends My_Controller {
	function __construct()
    {
        parent::__construct();
        $this->load->model('Ditem_model');
     }
    function lists(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Add Item';
        $data['list']=$this->Ditem_model->lists();
        $data['display']='admin/ditem';
        $this->load->view('admin/master',$data);
        } else {
           redirect("Logincontroller");
        }
    }
    function edit($id){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Edit Item';
        $data['list']=$this->Ditem_model->lists();
        $data['info']=$this->Ditem_model->get_info($id);
        $data['display']='admin/ditem';
        $this->load->view('admin/master',$data);
        } else {
           redirect("Logincontroller");
        }
    }
    function save($id=FALSE){
        $this->form_validation->set_rules('product_name','Item Name','trim|required');
        $this->form_validation->set_rules('unit','unit','trim|required');
        $this->form_validation->set_rules('unit_price','Price','trim|required');
         if ($this->form_validation->run() == TRUE) {
            $check=$this->Ditem_model->save($id);
            if($check && !$id){
               $this->session->set_userdata('exception','Saved successfully');
               }elseif($check&& $id){
                   $this->session->set_userdata('exception','Update successfully');
               }else{
                  $this->session->set_userdata('exception','Submission Failed');
                }
             redirect("Ditem/lists");

         }else{
            $data['heading']='Add New Item';
            $data['list']=$this->Ditem_model->lists();
            if($id){
              $data['heading']='Edit Item';
              $data['info']=$this->Ditem_model->get_info($id);  
            }
            $data['display']='admin/ditem';
            $this->load->view('admin/master',$data);
         }

    }
    function delete($id=FALSE){
           $check=$this->Ditem_model->delete($id);
        if($check){ 
           $this->session->set_userdata('exception','Item delete successfully');
         }else{
           $this->session->set_userdata('exception','Delete Falied');
         }
        redirect("Ditem/lists");

    }


 }