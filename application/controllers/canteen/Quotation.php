<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Quotation extends My_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('canteen/Quotation_model');
     }
    
    function lists(){
      if($this->session->userdata('user_id')) {
      $data=array();
      if($this->input->post('perpage')!='') $perpage=$this->input->post('perpage'); else $perpage=10;
      ////////////////////////////////////
      $this->load->library('pagination');
      $config['base_url']=base_url().'canteen/Quotation/lists/';
      $config['suffix'] = '?' . http_build_query($_GET, '', "&");
      $config["uri_segment"] = 4;
      $config['total_rows'] = $this->Quotation_model->get_count();
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
      $data['list']=$this->Quotation_model->lists($config["per_page"],$data['page'] );
      ////////////////////////////////////////
      $data['heading']='Quotation Lists';
      $data['dlist']=$this->Look_up_model->departmentList();
      $data['display']='canteen/quotation_lists';
      $this->load->view('admin/master',$data);
      } else {
        redirect("Logincontroller");
      }
  }
  function add(){
    if($this->session->userdata('user_id')) {
      $data['heading']='Add Quotation';
      $data['display']='canteen/addquotation';
      $data['flist']=$this->Import_model->getdata('shipping_file_style_info');
      $this->load->view('admin/master',$data);
    }else{
      redirect("Logincontroller");
    }
  }
  function edit($quotation_id){
    if ($this->session->userdata('user_id')) {
    $data['heading']='Edit Quotation';
    $data['llist']=$this->Look_up_model->getlocation();
    $data['flist']=$this->Import_model->getdata('shipping_file_style_info');
    $data['dlist']=$this->Look_up_model->departmentList();
    $data['info']=$this->Quotation_model->get_info($quotation_id);
    $data['detail']=$this->Quotation_model->getDetails($quotation_id);
    $data['display']='canteen/addquotation';
    $this->load->view('admin/master',$data);
    } else {
       redirect("Logincontroller");
    }
    }
   function save($quotation_id=FALSE){
      $check=$this->Quotation_model->save($quotation_id);
      if($check && !$quotation_id){
       $this->session->set_userdata('exception','Saved successfully');
       }elseif($check&& $quotation_id){
           $this->session->set_userdata('exception','Update successfully');
       }else{
         $this->session->set_userdata('exception','Submission Failed');
       }
      redirect("canteen/Quotation/lists");
    }
    function delete($quotation_id=FALSE){
      $check=$this->Quotation_model->delete($quotation_id);
        if($check){ 
           $this->session->set_userdata('exception','Delete successfully');
         }else{
           $this->session->set_userdata('exception','Delete Failed');
        }
      redirect("canteen/Quotation/lists");
    }
////////////////////////
public function suggestions(){
        $term = $this->input->get('term', true);
        $responsible_department = $this->input->get('responsible_department', true);
        if (strlen($term) < 1 || !$term) {
            die("<script type='text/javascript'>setTimeout(function(){ window.top.location.href = '" . base_url('dashboard') . "'; }, 10);</script>");
        }
        $rows = $this->Quotation_model->getQuotationProduct($responsible_department,$term);
        if ($rows){
            $c = str_replace(".", "", microtime(true));
            $r = 0;
            foreach ($rows as $row) {
              $product_name="$row->product_name($row->product_code)";
                $pr[] = array('id' => ($c + $r), 'product_id' => $row->product_id, 'label' => $row->product_name . " (" . $row->product_code . ")". " (Stock=" . $row->main_stock . ")", 'category_name' => $row->category_name ,'unit_name' => $row->unit_name,'product_name' =>$product_name ,'product_code' => $row->product_code, 'unit_price' => $row->unit_price,'image_link' => $row->product_image, 'stock' =>$row->main_stock);
                $r++;
            }
            header('Content-Type: application/json');
            die(json_encode($pr));
            exit;
        }else{
            $dsad='';
            header('Content-Type: application/json');
            die(json_encode($dsad));
            exit;
        }
    }
    function view2($quotation_id=FALSE){
      $data['controller']=$this->router->fetch_class();
      $data['info']=$this->Quotation_model->get_info($quotation_id);
      $data['detail']=$this->Quotation_model->getDetails($quotation_id);
      $data['display']='canteen/quotationView2';
      $this->load->view('admin/master',$data);
    }
    function view($quotation_id=FALSE){
    if ($this->session->userdata('user_id')) {
        $data['heading']='Quotation Form';
            $data['info']=$this->Quotation_model->get_info($quotation_id);
            $data['detail']=$this->Quotation_model->getDetails($quotation_id);
            $pdfFilePath='Quotation'.date('Y-m-d H:i').'.pdf';
            require 'vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4', 'margin_left' => 15, 'margin_right' => 15, 'margin_top' => 10, 'margin_bottom' => 18,]);
            $mpdf->useAdobeCJK = true;
            
            $mpdf->autoScriptToLang = true;
            $mpdf->autoLangToFont = true;
            $mpdf->AddPage('L');
            $header = $this->load->view('header', $data, true);
            $footer = $this->load->view('footer', $data, true);
            $html=$this->load->view('canteen/quotationView', $data, true);
            $mpdf->setHtmlFooter($footer);
            $mpdf->WriteHTML($html);
            $mpdf->Output();
        } else {
           redirect("Logincontroller");
        }
      }
    function excelload($quotation_id=FALSE){
      $data['heading']='Quotation Form';
      $data['info']=$this->Quotation_model->get_info($quotation_id);
      $data['detail']=$this->Quotation_model->getDetails($quotation_id);
      $this->load->view('canteen/quotationExcel', $data);
    }
    function submit($quotation_id=FALSE){
      //$this->load->model('Communication');
      $data['info']=$this->Quotation_model->get_info($quotation_id); 
      $department_id=$data['info']->department_id;
      $emailaddress=$this->db->query("SELECT dept_head_email FROM department_info 
        WHERE department_id=$department_id")->row('dept_head_email');
      $subject="Quotation Approval Notification";
      $message=$this->load->view('req_email_format', $data,true); 
     // $this->Communication->send($emailaddress,$subject,$message);
      $check=$this->Quotation_model->submit($quotation_id);
        if($check){ 
           $this->session->set_userdata('exception','Send successfully');
         }else{
           $this->session->set_userdata('exception','Send Failed');
        }
      redirect("canteen/Quotation/lists");
    }

   
 }