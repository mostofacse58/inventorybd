<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Me extends My_Controller {
	function __construct(){
        parent::__construct();
        $this->load->model('me/Me_model');
     }
    
    function lists(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Add New ME';
        $data['plist']=$this->Look_up_model->postList();
        $data['list']=$this->Me_model->lists();
        $data['display']='me/meinfo';
        $this->load->view('admin/master',$data);
        } else {
           redirect("Logincontroller");
        }
    	
    }

    function edit($me_id){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Edit ME';
        $data['list']=$this->Me_model->lists();
        $data['plist']=$this->Look_up_model->postList();
        $data['info']=$this->Me_model->get_info($me_id);
        $data['display']='me/meinfo';
        $this->load->view('admin/master',$data);
        } else {
           redirect("Logincontroller");
        }

    }
    
    function save($me_id=FALSE){
        $this->form_validation->set_rules('me_name','ME Name','trim|required');
        $this->form_validation->set_rules('post_id','Designation Name','trim|required');
        $this->form_validation->set_rules('mobile_no','Mobile No','trim');
        $this->form_validation->set_rules('id_no','ID NO','trim|required');
         if ($this->form_validation->run() == TRUE) {
            $check=$this->Me_model->save($me_id);

            if($check && !$me_id){
               $this->session->set_userdata('exception','Saved successfully');
               }elseif($check&& $me_id){
                   $this->session->set_userdata('exception','Update successfully');
               }else{
                  $this->session->set_userdata('exception','Submission Failed');
                }
             redirect("me/Me/lists");

         }else{
            $data['heading']='Add New ME';
            $data['list']=$this->Me_model->lists();
            $data['plist']=$this->Look_up_model->postList();
            if($me_id){
              $data['heading']='Edit ME';
              $data['info']=$this->Me_model->get_info($me_id);  
            }
            $data['display']='me/meinfo';
            $this->load->view('admin/master',$data);
         }

    }
    function delete($me_id=FALSE){
           $check=$this->Me_model->delete($me_id);
        if($check){ 
           $this->session->set_userdata('exception','ME delete successfully');
         }else{
           $this->session->set_userdata('exception','Delete Falied');
         }
        redirect("me/Me/lists");

    }
    //////////////////AJAX FOR DELETIN PRODUCT/////////////
    function checkDelete($me_id){
        $chk=$this->db->query("SELECT * FROM machine_downtime_info 
          WHERE me_id=$me_id")->result();
        if(count($chk)>0){
            echo "EXISTS";
        }else{
            echo "DELETABLE";
        }
    }


 }