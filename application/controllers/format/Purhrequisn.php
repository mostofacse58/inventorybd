<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Purhrequisn extends My_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('format/Purhrequisn_model');
        $this->load->model('format/Deptrequisnapp_model');
        $this->load->model('format/Deptrequisn_model');
     }
    
    function lists(){
      if($this->session->userdata('user_id')) {
      $data=array();
      if($this->input->post('perpage')!='') $perpage=$this->input->post('perpage'); else $perpage=30;
      ////////////////////////////////////
      $this->load->library('pagination');
      $config['base_url']=base_url().'format/Purhrequisn/lists/';
      $config['suffix'] = '?' . http_build_query($_GET, '', "&");
      $config["uri_segment"] = 4;
      $config['total_rows'] = $this->Purhrequisn_model->get_count();
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
      $data['list']=$this->Purhrequisn_model->lists($config["per_page"],$data['page'] );
      ////////////////////////////////////////
      $data['dlist']=$this->Look_up_model->departmentList();
      $data['ptlist']=$this->Look_up_model->getPIType();
      $data['heading']='PI Lists';
      $data['display']='format/purhrequisn_list';
      $this->load->view('admin/master',$data);
      } else {
        redirect("Logincontroller");
      }
    }
    function addprice($pi_id){
      $data['collapse']='YES';
      $data['clist']=$this->Look_up_model->clist();
      $data['slist']=$this->Look_up_model->getSupplier();
      $data['heading']='Add Price in PI';
      $data['info']=$this->Deptrequisn_model->get_info($pi_id);
      $data['detail']=$this->Deptrequisn_model->getDetails($pi_id);
      $data['display']='format/addprice';
      $this->load->view('admin/master',$data);
    }

  function save($pi_id=FALSE){
    $check=$this->Purhrequisn_model->save($pi_id);
    if($check && !$pi_id){
     $this->session->set_userdata('exception','Saved successfully');
     }elseif($check&& $pi_id){
         $this->session->set_userdata('exception','Update successfully');
     }else{
       $this->session->set_userdata('exception','Submission Failed');
     }
    redirect("format/Purhrequisn/lists");
  }
 
    function received($pi_id=FALSE){
      //$this->load->model('Communication');
      //$data['info']=$this->Deptrequisn_model->get_info($pi_id); 
      //$emailaddress="malik.ma@ms.hkthewell.com";
      //$subject="PI Approval Notification";
      //$message=$this->load->view('for_approval_email', $data,true); 
      //$this->Communication->send($emailaddress,$subject,$message);
      ////////////////////////////////////
      $check=$this->Purhrequisn_model->received($pi_id);
        if($check){ 
           $this->session->set_userdata('exception','Receive successfully');
         }else{
           $this->session->set_userdata('exception','Failed');
        }
      redirect("format/Purhrequisn/lists");
    }
    function returns($pi_id=FALSE){
      $check=$this->Deptrequisn_model->returns($pi_id);
        if($check){ 
           $this->session->set_userdata('exception','Return successfully');
         }else{
           $this->session->set_userdata('exception','Failed');
        }
      redirect("format/Purhrequisn/lists");
    }
    function rejected(){
      $check=$this->Purhrequisn_model->rejected();
      if($check){ 
        if($this->input->post('pi_status1')==8)
        $this->session->set_userdata('exception','Reject successfully');
        else 
        $this->session->set_userdata('exception','Return successfully');
       }else{
        $this->session->set_userdata('exception','Failed');
      }
      redirect("format/Purhrequisn/lists");
    }
  function viewpihtmlonly($pi_id=FALSE){
    $data['controller']=$this->router->fetch_class(); 
    $data['heading']='Purchase Indent';
    $data['info']=$this->Deptrequisn_model->get_info($pi_id);
    $data['detail']=$this->Deptrequisn_model->getDetails($pi_id);
    $data['display']='format/viewpihtmlonly';
    $this->load->view('admin/master',$data);     
  }
  function erpview($pi_id=FALSE){
    $data['controller']=$this->router->fetch_class(); 
    $data['heading']='Purchase Indent';
    $data['info']=$this->Deptrequisn_model->get_info($pi_id);
    $data['detail']=$this->Deptrequisn_model->getDetails($pi_id);
    $data['display']='format/erpview';
    $this->load->view('admin/master',$data);     
  }
  
 }