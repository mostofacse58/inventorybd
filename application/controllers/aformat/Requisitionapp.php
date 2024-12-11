<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
   class Requisitionapp extends My_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('aformat/Requisition_model');
        $this->load->model('aformat/requisitionapp_model');
        
     }
    
    function lists(){
      if($this->session->userdata('user_id')) {
      $data=array();
      if($this->input->post('perpage')!='') $perpage=$this->input->post('perpage'); else $perpage=10;
      ////////////////////////////////////
      $this->load->library('pagination');
      $config['base_url']=base_url().'aformat/Requisitionapp/lists/';
      $config["uri_segment"] = 4;
      $config['total_rows'] = $this->Requisitionapp_model->get_count();
      $config['per_page'] = $perpage;
      $choice = $config["total_rows"] / $config["per_page"];
      $config["num_links"] = 2;
      $config['full_tag_open'] = '<ul class="pagination pagination-sm pull-right">';
      $config['full_tag_close'] = '</ul>';
      $config['first_link'] = 'First';
      $config['last_link'] = 'Last';
      $config['first_tag_open'] = '<li>';
      $config['first_tag_close'] = '</li>';
      $config['prev_link'] = '<span aria-hidden="true">&laquo Prev</span>';
      $config['prev_tag_open'] = '<li class="prev">';
      $config['prev_tag_close'] = '</li>';
      $config['next_link'] = '<span aria-hidden="true">Next »</span>';
      $config['next_tag_open'] = '<li>';
      $config['next_tag_close'] = '</li>';
      $config['last_tag_open'] = '<li>';
      $config['last_tag_close'] = '</li>';
      $config['cur_tag_open'] = '<li class="active"><a href="#">';
      $config['cur_tag_close'] = "</a></li>";
      $config['num_tag_open'] = '<li>';
      $config['num_tag_close'] = '</li>';
      ////////////////////////////////////////
      $this->pagination->initialize($config); 
      $data['page'] = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
      $data['pagination'] = $this->pagination->create_links();
      $data['list']=$this->Requisitionapp_model->lists($config["per_page"],$data['page'] );
      ////////////////////////////////////////
      $data['heading']='Fixed Asset PR Lists';
      $data['display']='aformat/Requisitionapp_lists';
      $this->load->view('admin/master',$data);
      } else {
        redirect("Logincontroller");
      }
  }
  function edit($requisition_id){
    if ($this->session->userdata('user_id')) {
    $data['heading']='Edit Requisition';
    $data['dlist']=$this->Look_up_model->departmentList();
    $data['info']=$this->Requisition_model->get_info($requisition_id);
    $data['detail']=$this->Requisition_model->getDetails($requisition_id);
    $data['display']='aformat/addrequisitionapp';
    $this->load->view('admin/master',$data);
    } else {
       redirect("Logincontroller");
    }
    }
   function save($requisition_id=FALSE){
      $check=$this->Requisition_model->save($requisition_id);
      if($check && !$requisition_id){
       $this->session->set_userdata('exception','Saved successfully');
       }elseif($check&& $requisition_id){
           $this->session->set_userdata('exception','Update successfully');
       }else{
         $this->session->set_userdata('exception','Submission Failed');
       }
      redirect("aformat/Requisitionapp/lists");
    }
 
    function delete($requisition_id=FALSE){
      $check=$this->Requisitionapp_model->delete($requisition_id);
        if($check){ 
           $this->session->set_userdata('exception','Delete successfully');
         }else{
           $this->session->set_userdata('exception','Delete Failed');
        }
      redirect("aformat/Requisitionapp/lists");
    }
////////////////////////

    function approved($requisition_id=FALSE){
      $this->load->model('Communication');
      $data['info']=$this->Requisition_model->get_info($requisition_id); 
      $department_id=$data['info']->responsible_department;
      $emailaddress=$this->db->query("SELECT dept_head_email FROM department_info 
        WHERE department_id=$department_id")->row('dept_head_email');
      $subject="Requisition Receive Notification";
      $message=$this->load->view('req_rec_email', $data,true); 
      //$this->Communication->send($emailaddress,$subject,$message);
      /////////////////////
      $check=$this->Requisitionapp_model->approved($requisition_id);
        if($check){ 
           $this->session->set_userdata('exception','Approved successfully');
         }else{
           $this->session->set_userdata('exception','Send Failed');
        }
      redirect("aformat/Requisitionapp/lists");
    }
    function rejected($requisition_id=FALSE){
      $check=$this->Requisitionapp_model->rejected($requisition_id);
        if($check){ 
           $this->session->set_userdata('exception','Reject successfully');
         }else{
           $this->session->set_userdata('exception','Send Failed');
        }
      redirect("aformat/Requisitionapp/lists");
    }
    function returns($requisition_id=FALSE){
      $check=$this->Requisitionapp_model->returns($requisition_id);
      if($check){ 
         $this->session->set_userdata('exception','Approved successfully');
       }else{
         $this->session->set_userdata('exception','Send Failed');
      }
      redirect("aformat/Requisitionapp/lists");
    }

   
 }