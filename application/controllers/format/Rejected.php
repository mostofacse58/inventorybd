<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Rejected extends My_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('format/Deptrequisn_model');
        $this->load->model('format/Pi_model');
        $this->load->model('format/Pi_reject_model');
     }
    
    function lists(){
    $data=array();
    if($this->input->post('perpage')!='') $perpage=$this->input->post('perpage'); 
      else $perpage=15;
      ////////////////////////////////////
      $this->load->library('pagination');
      $config['base_url']=base_url().'format/Rejected/lists/';
      $config['suffix'] = '?' . http_build_query($_GET, '', "&");
      $config["uri_segment"] = 4;
      $config['total_rows'] = $this->Pi_reject_model->get_count();
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
      $data['list']=$this->Pi_reject_model->lists($config["per_page"],$data['page'] );
      $data['dlist']=$this->Look_up_model->departmentList();
      ////////////////////////////////////////
      $data['pi_no']=$this->input->get('pi_no');
      $data['department_id']=$this->input->get('department_id');
      $data['pi_status']=$this->input->get('pi_status');
      $data['rejcount']=$this->Pi_model->statuscount(8);

      $data['heading']='PI Lists';
      $data['display']='format/rejectlist';
      $this->load->view('admin/master',$data);
     
  }
  function viewpihtml(){
      $data['heading']='Purchase Indent';
      $data['collapse']='YES';
      $data['lists']=$this->Deptrequisn_model->getpendingPi(5);
      if(count($data['lists'])==0)
      redirect("format/Pi/lists");
      $data['display']='format/pihtmlsafety';
      $this->load->view('admin/master',$data);
    }

 function viewpihtmlonly($pi_id=FALSE){
    $data['controller']=$this->router->fetch_class(); 
    $data['heading']='Purchase Indent';
    $data['info']=$this->Deptrequisn_model->get_info($pi_id);
    $data['detail']=$this->Deptrequisn_model->getDetails($pi_id);
    $data['display']='format/viewpihtmlonly';
  $this->load->view('admin/master',$data);     
  }



   
 }