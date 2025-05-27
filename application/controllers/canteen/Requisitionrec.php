<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Requisitionrec extends My_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('canteen/Requisition_model');
        $this->load->model('canteen/Requisitionrec_model');
     }
    
    function lists(){
      if($this->session->userdata('user_id')) {
      $data=array();
      if($this->input->post('perpage')!='') $perpage=$this->input->post('perpage'); else $perpage=10;
      ////////////////////////////////////
      $this->load->library('pagination');
      $config['base_url']=base_url().'canteen/Requisition/lists/';
      $config['suffix'] = '?' . http_build_query($_GET, '', "&");
      $config["uri_segment"] = 4;
      $config['total_rows'] = $this->Requisitionrec_model->get_count();
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
      $total_rows=$config['total_rows'];
      $pagination = $this->pagination->create_links();
      $data['pagination']='<p>We have ' . $total_rows . ' records in ' . $choice . ' pages ' . $pagination . '</p>';
      $data['list']=$this->Requisitionrec_model->lists($config["per_page"],$data['page'] );
      ////////////////////////////////////////
      $data['heading']='Requisition Lists';
      $data['slist']=$this->Look_up_model->getSupplier();
      $data['supplier_id']=$this->input->get('supplier_id');
      $data['for_canteen']=$this->input->get('for_canteen');
      $data['requisition_no']=$this->input->get('requisition_no');
      $data['from_date']=$this->input->get('from_date');
      $data['to_date']=$this->input->get('to_date');
      $data['display']='canteen/requisitionrec_lists';
      $this->load->view('admin/master',$data);
      } else {
        redirect("Logincontroller");
      }
  }

    function view2($requisition_id=FALSE){
      $data['controller']=$this->router->fetch_class();
      $data['info']=$this->Requisition_model->get_info($requisition_id);
      $data['detail']=$this->Requisition_model->getDetails($requisition_id);
      $data['display']='canteen/requisitionView';
      $this->load->view('admin/master',$data);
    }
    function view($requisition_id=FALSE){
    if ($this->session->userdata('user_id')) {
        $data['heading']='Requisition Form';
            $data['info']=$this->Requisition_model->get_info($requisition_id);
            $data['detail']=$this->Requisition_model->getDetails($requisition_id);
            $pdfFilePath='Requisition'.date('Y-m-d H:i').'.pdf';
            require 'vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4', 'margin_left' => 15, 'margin_right' => 15, 'margin_top' => 10, 'margin_bottom' => 18,]);
            $mpdf->useAdobeCJK = true;
            
            $mpdf->autoScriptToLang = true;
            $mpdf->autoLangToFont = true;
            $mpdf->AddPage('L');
            $header = $this->load->view('header', $data, true);
            $footer = $this->load->view('footer', $data, true);
            $html=$this->load->view('canteen/requisitionViewpdf', $data, true);
            $mpdf->setHtmlFooter($footer);
            $mpdf->WriteHTML($html);
            $mpdf->Output();
        } else {
           redirect("Logincontroller");
        }
      }
 
    function received($requisition_id=FALSE){
      $check=$this->Requisitionrec_model->received($requisition_id);
        if($check){ 
           $this->session->set_userdata('exception','Receive successfully');
         }else{
           $this->session->set_userdata('exception','Send Failed');
        }
      redirect("canteen/Requisitionrec/lists");
    }

   
 }