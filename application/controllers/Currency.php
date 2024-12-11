<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Currency extends My_Controller {
	function __construct()
    {
        parent::__construct();
        
        $this->load->model('Currency_model');
     }
    
    function lists(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Add Currency Rate';
        $data['clist']=$this->Look_up_model->clist();
        $data['list']=$this->Currency_model->lists();
        $data['display']='admin/currency';
        $this->load->view('admin/master',$data);
        } else {
           redirect("Logincontroller");
        }
    	
    }

    function edit($id){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Edit Currency Rate';
        $data['list']=$this->Currency_model->lists();
        $data['clist']=$this->Look_up_model->clist();
        $data['info']=$this->Currency_model->get_info($id);
        $data['display']='admin/currency';
        $this->load->view('admin/master',$data);
        } else {
           redirect("Logincontroller");
      }
    }
    function save($id=FALSE){
        $this->form_validation->set_rules('currency','From','trim|required');
        $this->form_validation->set_rules('in_currency','From','trim|required');
        $this->form_validation->set_rules('convert_rate','Rate','trim');
         if ($this->form_validation->run() == TRUE) {
            $check=$this->Currency_model->save($id);
            if($check && !$id){
               $this->session->set_userdata('exception','Saved successfully');
               }elseif($check&& $id){
                   $this->session->set_userdata('exception','Update successfully');
               }else{
                  $this->session->set_userdata('exception','Submission Failed');
                }
             redirect("Currency/lists");
         }else{
            $data['heading']='Add Currency Rate';
            $data['list']=$this->Currency_model->lists();
            if($id){
              $data['heading']='Edit Currency Rate';
              $data['info']=$this->Currency_model->get_info($id);  
            }
            $data['clist']=$this->Look_up_model->clist();
            $data['display']='admin/currency';
            $this->load->view('admin/master',$data);
         }

    }
    function delete($id=FALSE){
      $check=$this->Currency_model->delete($id);
        if($check){ 
           $this->session->set_userdata('exception','Department Info delete successfully');
         }else{
           $this->session->set_userdata('exception','Delete Falied');
         }
        redirect("Currency/lists");

    }


 }