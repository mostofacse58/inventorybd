<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Invoice  extends My_Controller {
    function __construct(){
        parent::__construct();
        $this->output->nocache();
        $this->load->model('merch/Invoice_model');
     }
    
    function lists(){
      if($this->session->userdata('user_id')) {
      $data=array();
      if($this->input->post('perpage')!='') $perpage=$this->input->post('perpage'); 
        else $perpage=10;
        ////////////////////////////////////
        $this->load->library('pagination');
        $config['base_url']=base_url().'merch/Invoice/lists/';
        $config['suffix'] = '?' . http_build_query($_GET, '', "&");
        $config["uri_segment"] = 4;
        $config['total_rows'] = $this->Invoice_model->get_count();
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
        $data['list']=$this->Invoice_model->lists($config["per_page"],$data['page'] );
        ////////////////////////////////////////
        $data['heading']='Invoice  Lists';
        $data['display']='merch/lists';
        $this->load->view('admin/master',$data);
        } else {
          redirect("Logincontroller");
        }
    }

    function add(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Add Invoice ';
        $data['collapse']='YES';
        $data['ulist']=$this->Invoice_model->Userlists();
        $data['display']='merch/add';
        $this->load->view('admin/master',$data);
        } else {
           redirect("Logincontroller");
        }
    }
    function edit($invoice_id){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Edit Invoice ';
        $data['collapse']='YES';
        $data['info']=$this->Invoice_model->get_info($invoice_id);
        $data['detail']=$this->Invoice_model->get_detail($invoice_id);
        $data['ulist']=$this->Invoice_model->Userlists();
        $data['display']='merch/add';
        $this->load->view('admin/master',$data);
        } else {
           redirect("Logincontroller");
        }
    }
  
    function save($invoice_id=FALSE){
        $this->form_validation->set_rules('employee_idno','ID','trim|required');
        $this->form_validation->set_rules('employee_name','NAme','trim|required');
        $this->form_validation->set_rules('create_date','create_date','trim|required');
         if ($this->form_validation->run() == TRUE) {
            $check=$this->Invoice_model->save($invoice_id);
            if($check && !$invoice_id){
               $this->session->set_userdata('exception','Saved successfully');
               }elseif($check&& $invoice_id){
                   $this->session->set_userdata('exception','Update successfully');
               }else{
                   $this->session->set_userdata('exception','Submission Failed');
               }
          redirect("merch/Invoice/lists");
         }else{
            $data['heading']='Add Invoice ';
            if($invoice_id){
              $data['heading']='Edit Invoice ';
              $data['info']=$this->Invoice_model->get_info($invoice_id); 
              $data['detail']=$this->Invoice_model->get_detail($invoice_id); 
            }
            $data['ulist']=$this->Invoice_model->Userlists();
            $data['display']='merch/add';
            $this->load->view('admin/master',$data);
         }

    }
    function delete($invoice_id){
      $this->Invoice_model->delete($invoice_id); 
      $this->session->set_userdata('exception','Delete successfully');
      redirect("merch/Invoice/lists");
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
    function loadpdf($invoice_id=FALSE){
    if ($this->session->userdata('user_id')) {
        $data['heading']='Invoice';
        $data['info']=$this->Invoice_model->get_info($invoice_id);
        $data['detail']=$this->Invoice_model->get_detail($invoice_id);
        $data['invoice_id']=$invoice_id;
        $file_name='Invoice'.date('Ymdhi')."-$invoice_id".'.pdf';
         $pdfFilePath = $_SERVER['DOCUMENT_ROOT'] . str_replace('index.php', '', $_SERVER['SCRIPT_NAME'])."/pdf/".$file_name.".pdf";
        
        $this->load->library('mpdf');
        $mpdf = new mPDF('bn','A4','','','15','15','15','18');
        $html=$this->load->view('merch/invoicePdf', $data, true);
        $mpdf->pagenumPrefix = '  Page ';
        $mpdf->pagenumSuffix = ' - ';
        $mpdf->nbpgPrefix = ' out of ';
        $mpdf->nbpgSuffix = '';
        $mpdf->setFooter('{DATE H:i:s j/m/Y}');
        $mpdf->WriteHTML($html);
        $mpdf->Output($pdfFilePath,'F');
        } else {
        redirect("Logincontroller");
        }
      }
    public function submit($invoice_id=FALSE){
        $data2['status']=2;
        $this->db->where('invoice_id', $invoice_id);
        $this->db->update('invoice_master',$data2);
        $this->session->set_userdata('exception','Submit successfully');
      redirect("merch/Invoice/lists");
    }
   
    
 
   
 }