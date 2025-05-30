<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Invoiceaudit extends My_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('shipping/Import_model');
        $this->load->model('canteen/Invoice_model');
        $this->load->model('canteen/Invoiceaudit_model');
        
     }
    function lists(){
        $data=array();
        if($this->input->post('perpage')!='') 
        $perpage=$this->input->post('perpage'); else $perpage=20;
        $this->load->library('pagination');
        $config['base_url']=base_url().'canteen/Invoiceaudit/lists/';
        $config['suffix'] = '?' . http_build_query($_GET, '', "&");
        $config["uri_segment"] = 4;
        $config['total_rows'] = $this->Invoiceaudit_model->get_count();
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
        //////////////////////////////////////////
        $this->pagination->initialize($config); 
        $data['page'] = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $pagination = $this->pagination->create_links();
        $data['pagination']='<p>We have ' . $total_rows . ' records in ' . $choice . ' pages ' . $pagination . '</p>';
        $data['list']=$this->Invoiceaudit_model->lists($config["per_page"],$data['page']);
        $this->form_validation->set_rules('location','Location','trim');
        $this->form_validation->set_rules('employee_name','Name','trim');
        $data['dlist']=$this->Look_up_model->departmentList();
        $data['slist']=$this->Look_up_model->getSupplier();
        ////////////////////////////
        $data['heading']='Invoice List';
        $data['display']='canteen/Invoiceauditlist';
        $this->load->view('admin/master',$data);
    }
    
    function view($invoice_id=FALSE){
        $data['show']=1;
        $data['controller']=$this->router->fetch_class();
        $data['heading']='Invoice Details';
        $data['info']=$this->Invoice_model->get_info($invoice_id);
        $data['detail']=$this->Invoice_model->getDetails($invoice_id);
        $data['display']='canteen/invoiceview';
        $this->load->view('admin/master',$data);
      }
  function viewpdf($invoice_id=FALSE){
    if ($this->session->userdata('user_id')) {
    $data['heading']='Receive Items ';
        $data['info']=$this->Invoice_model->get_info($invoice_id);
        $data['detail']=$this->Invoice_model->getDetails($invoice_id);
        $pdfFilePath='ItemReceiveInvoice'.date('Y-m-d H:i').'.pdf';
        require 'vendor/autoload.php';
        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4', 'margin_left' => 10, 'margin_right' => 10, 'margin_top' => 15, 'margin_bottom' => 10,]);
        $mpdf->useAdobeCJK = true;
        
        $mpdf->autoScriptToLang = true;
        $mpdf->autoLangToFont = true;
        $header = $this->load->view('canteen/header', $data, true);
        $html=$this->load->view('canteen/invoiceviewpdf', $data, true);
        $mpdf->setHtmlHeader($header);
        $mpdf->pagenumPrefix = '  Page ';
        $mpdf->pagenumSuffix = ' - ';
        $mpdf->nbpgPrefix = ' out of ';
        $mpdf->nbpgSuffix = '';
        $mpdf->setFooter('{DATE H:i:s j/m/Y}{PAGENO}{nbpg}');
        $mpdf->WriteHTML($html);
        $mpdf->Output($pdfFilePath,'D');
    } else {
       redirect("Logincontroller");
    }
  }
  
  function checkform($invoice_id=FALSE){
    $data['show']=1;
    $data['controller']=$this->router->fetch_class();
    $data['heading']='Invoice Details';
    $data['info']=$this->Invoice_model->get_info($invoice_id);
    $data['detail']=$this->Invoice_model->getDetails($invoice_id);
    $data['display']='canteen/invoiceAuditview';
    $this->load->view('admin/master',$data);
  }
  function updated($invoice_id=FALSE){
    $check=$this->Invoiceaudit_model->updated($invoice_id);
    if($check){
         $this->session->set_userdata('exception','Update successfully');
    }else{
       $this->session->set_userdata('exception','Submission Failed');
    }
    redirect("canteen/Invoiceaudit/lists");
  }

  function received($invoice_id=FALSE){
      $check=$this->Invoiceaudit_model->received($invoice_id);
      if($check){ 
        $this->session->set_userdata('exception','Received successfully');
       }else{
        $this->session->set_userdata('exception','Send Failed');
      }
      redirect("canteen/Invoiceaudit/lists");
    }

        
 }