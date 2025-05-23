<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Checkgatepass extends MY_Controller {
	function __construct(){
        parent::__construct();
        $this->output->nocache();
        $this->load->model('gatep/Checking_model');
        $this->load->model('gatep/Gatepass_model');
     }

     function lists(){
      if($this->session->userdata('user_id')) {
      $data=array();
      if($this->input->post('perpage')!='') $perpage=$this->input->post('perpage'); else $perpage=10;
        ////////////////////////////////////
        $this->load->library('pagination');
        $config['base_url']=base_url().'gatep/Checkgatepass/lists/';
        $config['suffix'] = '?' . http_build_query($_GET, '', "&");
        $config["uri_segment"] = 4;
        $config['total_rows'] = $this->Checking_model->get_count();
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
        $data['pagination'] = $this->pagination->create_links();
        //echo $data["page"]; exit();///////////
        $data['list']=$this->Checking_model->lists($config["per_page"],$data['page'] );
        ////////////////////////////////////////
        $data['heading']='Gate Pass Lists';
        $data['display']='gatep/checklists';
        $this->load->view('admin/master',$data);
        } else {
          redirect("Logincontroller");
        }
    }
    function view($gatepass_id){
      if ($this->session->userdata('user_id')) {
        $data['controller']=$this->router->fetch_class();
        $data['gatepass_id']=$gatepass_id;
        $data['heading']='Gate Pass Details Information';
        $data['info']=$this->Gatepass_model->get_info($gatepass_id);
        $data['detail']=$this->Gatepass_model->get_detail($gatepass_id);
        $data['display']='gatep/viewpass';
        $this->load->view('admin/master',$data);
        } else {
           redirect("Logincontroller");
        }
    }
    function searchForm(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Ckecking Gate Pass';
        $data['display']='gatep/checking';
        $this->load->view('admin/master',$data);
        } else {
           redirect("Logincontroller");
        }
    }

    function search(){
       if ($this->session->userdata('user_id')) {
        $data['heading']='Ckecking Gate Pass';
        $data['info']=$this->Checking_model->checkingBarcode();
        if(count($data['info'])>0){
        $gatepass_id=$data['info']->gatepass_id;
        $data['gatepass_id']=$gatepass_id;
        $data['heading']='Gate Pass Details Information';
        $data['info']=$this->Gatepass_model->get_info($gatepass_id);
        $data['detail']=$this->Gatepass_model->get_detail($gatepass_id);
        $data['view']='gatep/callgatepassview';
        $data['display']='gatep/checkView';
           $this->load->view('admin/master',$data);
        }else{
           $this->session->set_userdata('exception','Not Found');
        }
        $data['display']='gatep/checking';
        $this->load->view('admin/master',$data);
        } else {
           redirect("Logincontroller");
        } 
    }
    
     function viewapproved($gatepass_id){
      if ($this->session->userdata('user_id')) {
        $data['gatepass_id']=$gatepass_id;
        $data['heading']='Gate Pass Details Information';
        $data['info']=$this->Gatepass_model->get_info($gatepass_id);
        $data['detail']=$this->Gatepass_model->get_detail($gatepass_id);
         $data['view']='gatep/callgatepassview';
        $data['display']='gatep/checkView';
        $this->load->view('admin/master',$data);
        } else {
           redirect("Logincontroller");
        }
    }

 public function approved($gatepass_id=FALSE){
    $data2['gatepass_status']=5;
    $data2['checked_by']=$this->session->userdata('user_id');
    $data2['checked_date']=date('Y-m-d');
    $data2['checked_time']=date('h:i A');
    $this->db->where('gatepass_id', $gatepass_id);
    $this->db->update('gatepass_master',$data2);
    $this->session->set_userdata('exception','Checkout successfully');
    redirect("gatep/Checkgatepass/lists");

   }
   public function returns(){
    $gatepass_id=$this->input->post('gatepass_id');
    $data2['gatepass_status']=1;
    $data2['checked_by']=$this->session->userdata('user_id');
    $data2['checked_date']=date('Y-m-d');
    $data2['checked_time']=date('h:i A');
    $data2['reject_note']=$this->input->post('reject_note');
    $this->db->where('gatepass_id', $gatepass_id);
    $this->db->update('gatepass_master',$data2);
    $this->session->set_userdata('exception','Return successfully');
    redirect("gatep/Checkgatepass/lists");
   }
 
   
 }