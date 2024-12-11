<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ainvoice  extends My_Controller {
    function __construct(){
        parent::__construct();
        $this->output->nocache();
        $this->load->model('merch/Invoice_model');
        $this->load->model('merch/Ainvoice_model');
     }
    
    function lists(){
      if($this->session->userdata('user_id')) {
      $data=array();
      if($this->input->post('perpage')!='') $perpage=$this->input->post('perpage'); 
        else $perpage=10;
        ////////////////////////////////////
        $this->load->library('pagination');
        $config['base_url']=base_url().'merch/Ainvoice/lists/';
        $config['suffix'] = '?' . http_build_query($_GET, '', "&");
        $config["uri_segment"] = 4;
        $config['total_rows'] = $this->Ainvoice_model->get_count();
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
        $data['list']=$this->Ainvoice_model->lists($config["per_page"],$data['page'] );
        ////////////////////////////////////////
        $data['heading']='Invoice  Lists';
        $data['display']='merch/alists';
        $this->load->view('admin/master',$data);
        } else {
          redirect("Logincontroller");
        }
    }

   
    function view($invoice_id){
      if ($this->session->userdata('user_id')) {
        $data['controller']=$this->router->fetch_class();
        $data['invoice_id']=$invoice_id;
        $data['heading']='Invoice  Details Information';
        $data['info']=$this->Invoice_model->get_info($invoice_id);
        $data['detail']=$this->Invoice_model->get_detail($invoice_id);
        $data['display']='merch/view';
        $this->load->view('admin/master',$data);
        } else {
           redirect("Logincontroller");
        }
    }
  
    public function approved($invoice_id=FALSE){
        $data2['approved_by']=$this->session->userdata('user_id');
        $data2['approved_date']=date('Y-m-d');
        $data2['approved_time']=date('Y-m-d h:iA');
        $data2['status']=3;
        $this->db->where('invoice_id', $invoice_id);
        $this->db->update('invoice_master',$data2);
        $this->session->set_userdata('exception','Approved successfully');
      redirect("merch/Ainvoice/lists");
    }
   
    
 
   
 }