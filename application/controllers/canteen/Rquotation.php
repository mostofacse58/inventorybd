<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Rquotation extends My_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('canteen/Rquotation_model');
        $this->load->model('canteen/Quotation_model');
     }
    
    function lists(){
      if($this->session->userdata('user_id')) {
      $data=array();
      if($this->input->post('perpage')!='') $perpage=$this->input->post('perpage'); else $perpage=10;
      ////////////////////////////////////
      $this->load->library('pagination');
      $config['base_url']=base_url().'canteen/Rquotation/lists/';
      $config['suffix'] = '?' . http_build_query($_GET, '', "&");
      $config["uri_segment"] = 4;
      $config['total_rows'] = $this->Rquotation_model->get_count();
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
      $data['list']=$this->Rquotation_model->lists($config["per_page"],$data['page'] );
      ////////////////////////////////////////
      $data['heading']='Rquotation Lists';
      $data['display']='canteen/rquotationlists';
      $this->load->view('admin/master',$data);
      } else {
        redirect("Logincontroller");
      }
  }

  function view($quotation_id=FALSE){
    $data['controller']=$this->router->fetch_class();
    $data['info']=$this->Quotation_model->get_info($quotation_id);
    $data['detail']=$this->Quotation_model->getDetails($quotation_id);
    $data['display']='canteen/quotationView';
    $this->load->view('admin/master',$data);
  }



  function viewpdf($quotation_id=FALSE){
    if ($this->session->userdata('user_id')) {
        $data['heading']='Rquotation Form';
            $data['info']=$this->Quotation_model->get_info($quotation_id);
            $data['detail']=$this->Quotation_model->getDetails($quotation_id);
            $pdfFilePath='Rquotation'.date('Y-m-d H:i').'.pdf';
            require 'vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4', 'margin_left' => 10, 'margin_right' => 10, 'margin_top' => 10, 'margin_bottom' => 15,]);
            $mpdf->useAdobeCJK = true;
            
            $mpdf->autoScriptToLang = true;
            $mpdf->autoLangToFont = true;
            $mpdf->AddPage('L');
            $header = $this->load->view('header', $data, true);
            $footer = $this->load->view('footer', $data, true);
            $html=$this->load->view('canteen/quotationViewPdf', $data, true);
            $mpdf->setHtmlFooter($footer);
            $mpdf->WriteHTML($html);
            $mpdf->Output();
        } else {
           redirect("Logincontroller");
        }
      }
  
    function approved($quotation_id=FALSE){
      $check=$this->Rquotation_model->approved($quotation_id);
        if($check){ 
           $this->session->set_userdata('exception','Approved successfully');
         }else{
           $this->session->set_userdata('exception','Send Failed');
        }
      redirect("canteen/Rquotation/lists");
    }

   
 }