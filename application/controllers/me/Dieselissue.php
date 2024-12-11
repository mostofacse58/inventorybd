<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Dieselissue extends My_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('me/Dieselissue_model');
     }

     function lists(){
      if($this->session->userdata('user_id')) {
      $data=array();
      if($this->input->post('perpage')!='') $perpage=$this->input->post('perpage'); else $perpage=10;
        ////////////////////////////////////
        $this->load->library('pagination');
        $config['base_url']=base_url().'me/Dieselissue/lists/';
        $config["uri_segment"] = 4;
        $config['total_rows'] = $this->Dieselissue_model->get_count();
        $config['per_page'] = $perpage;
        $total_rows=$config['total_rows'];
        $choice = ceil($config["total_rows"] / $config["per_page"]);
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

        //echo $data["page"]; exit();///////////
        $data['list']=$this->Dieselissue_model->lists($config["per_page"],$data['page'] );
        
        ////////////////////////////////////////
        $data['heading']='Diesel Issue  Info';
        //$data['list']=$this->Machineregister_model->lists();
        $data['display']='me/dieselissuelist';
        $this->load->view('admin/master',$data);
        } else {
          redirect("Logincontroller");
        }
    }
    function lists2(){
      $data=array();
        if($this->session->userdata('user_id')) {
        $data['heading']='Diesel Issue';
        $data['list']=$this->Dieselissue_model->lists();
        $data['display']='me/dieselissuelist';
        $this->load->view('admin/master',$data);
        } else {
          redirect("Logincontroller");
        }
       }
    function add(){
      if ($this->session->userdata('user_id')) {
      $data['heading']='Add New Diesel Issue';
      $data['mlist']=$this->Dieselissue_model->getDropdown('motor_info');
      $data['tlist']=$this->Dieselissue_model->getDropdown('driver_info');
      $data['dlist']=$this->Dieselissue_model->getDropdown('fuel_using_dept');
      $data['display']='me/adddiesel';
      $this->load->view('admin/master',$data);
      } else {
         redirect("Logincontroller");
      }
    }
    function edit($fuel_issue_id){
      if ($this->session->userdata('user_id')) {
      $data['heading']='Edit Diesel Issue';
      $data['info']=$this->Dieselissue_model->get_info($fuel_issue_id);
      $data['mlist']=$this->Dieselissue_model->getDropdown('motor_info');
      $data['tlist']=$this->Dieselissue_model->getDropdown('driver_info');
      $data['dlist']=$this->Dieselissue_model->getDropdown('fuel_using_dept');
      $data['display']='me/adddiesel';
      $this->load->view('admin/master',$data);
      } else {
         redirect("Logincontroller");
      }
    }
  function save($fuel_issue_id=FALSE){
    $this->form_validation->set_rules('issue_date','Date','trim|required');
    $this->form_validation->set_rules('motor_id','Vehicle Name','trim|required');
    $this->form_validation->set_rules('fuel_using_dept_id','Department','trim|required');
    $this->form_validation->set_rules('taken_by','Taken By','trim|required');
    if ($this->form_validation->run() == TRUE) {
    $check=$this->Dieselissue_model->save($fuel_issue_id);
      if($check && !$fuel_issue_id){
        $this->session->set_userdata('exception','Saved successfully');
       }elseif($check&& $fuel_issue_id){
        $this->session->set_userdata('exception','Update successfully');
       }else{
        $this->session->set_userdata('exception','Submission Failed');
       }
      redirect("me/Dieselissue/lists");
     }else{
      $data['heading']='Add New Diesel Issue';
        if($fuel_issue_id){
        $data['heading']='Edit Diesel Issue';
        $data['info']=$this->Dieselissue_model->get_info($fuel_issue_id);  
        }
    $data['mlist']=$this->Dieselissue_model->getDropdown('motor_info');
    $data['tlist']=$this->Dieselissue_model->getDropdown('driver_info');
    $data['dlist']=$this->Dieselissue_model->getDropdown('fuel_using_dept');
    $data['display']='me/adddiesel';
    $this->load->view('admin/master',$data);
  }
  }
    function delete($fuel_issue_id=FALSE){
      $check=$this->Dieselissue_model->delete($fuel_issue_id);
        if($check){ 
           $this->session->set_userdata('exception','Delete successfully');
         }else{
           $this->session->set_userdata('exception','Delete Failed');
        }
      redirect("me/machine/lists");
    }

    
    //////////////////AJAX FOR DELETIN PRODUCT/////////////
    function checkDiesel($fuel_issue_id){
        $chk=$this->db->query("SELECT * FROM fuel_issue_master WHERE fuel_issue_id=$fuel_issue_id")->result();
        if(count($chk)>0){
            echo "EXISTS";
        }else{
            echo "DELETABLE";
        }
    }
    function views($fuel_issue_id){
      if ($this->session->userdata('user_id')) {
        $data['heading']='Diesel Issue Details Information';
        $data['info']=$this->Dieselissue_model->get_info($fuel_issue_id);
        $data['display']='me/viewmachineInfo';
        $this->load->view('admin/master',$data);
        } else {
           redirect("Logincontroller");
        }
    }
   
 }