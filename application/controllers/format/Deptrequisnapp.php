<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Deptrequisnapp extends My_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('format/Deptrequisn_model');
        $this->load->model('format/Deptrequisnapp_model');
     }
    function lists(){
      if($this->session->userdata('user_id')) {
      $data=array();
      if($this->input->post('perpage')!='') $perpage=$this->input->post('perpage'); else $perpage=10;
      ////////////////////////////////////
      $this->load->library('pagination');
      $config['base_url']=base_url().'format/Deptrequisn/lists/';
      $config['suffix'] = '?' . http_build_query($_GET, '', "&");
      $config["uri_segment"] = 4;
      $config['total_rows'] = $this->Deptrequisnapp_model->get_count();
      $total_rows=$config['total_rows'];
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
      $pagination = $this->pagination->create_links();
      $data['pagination']='<p>We have ' . $total_rows . ' records in ' . $choice . ' pages ' . $pagination . '</p>';      
      $data['list']=$this->Deptrequisnapp_model->lists($config["per_page"],$data['page'] );
      ////////////////////////////////////////
      $data['dlist']=$this->Look_up_model->departmentList();
      $data['heading']='Safety Stock PI Lists (固定资产购买缩进清单) ';
      $data['display']='format/deptrequisnapplist';
      $this->load->view('admin/master',$data);
      } else {
        redirect("Logincontroller");
      }
  }
 
  function approved($pi_id=FALSE){
      $this->load->model('Communication');
      $data['info']=$this->Deptrequisn_model->get_info($pi_id); 
      $emailaddress="sarwar.hossen@bdventura.com";
      $subject="PI Verify Notification";
      $message=$this->load->view('for_verified_email', $data,true); 
     // $this->Communication->send($emailaddress,$subject,$message);
      ////////////////////////////////////
      $check=$this->Deptrequisnapp_model->approved($pi_id);
      if($check){ 
         $this->session->set_userdata('exception','Confirmation successfully');
       }else{
         $this->session->set_userdata('exception','Failed');
      }
      redirect("format/Deptrequisnapp/lists");
    }
    function returns($pi_id=FALSE){
      $check=$this->Deptrequisn_model->returns($pi_id);
        if($check){ 
           $this->session->set_userdata('exception','Return successfully');
         }else{
           $this->session->set_userdata('exception','Failed');
        }
      redirect("format/Deptrequisnapp/lists");
    }
      function rejected($pi_id=FALSE){
      $check=$this->Deptrequisn_model->rejected($pi_id);
        if($check){ 
          $this->session->set_userdata('exception','Reject successfully');
         }else{
          $this->session->set_userdata('exception','Failed');
        }
      redirect("format/Purhrequisn/lists");
    }

   
 }