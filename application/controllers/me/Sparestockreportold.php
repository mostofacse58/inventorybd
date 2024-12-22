<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Sparestockreport extends My_Controller {
    function __construct()
    {
        parent::__construct();
        
        $this->load->model('report/Sparestockreport_model');
     }
    function SearchForm(){
        if ($this->session->userdata('user_id')) {
        $data['collapse']='YES';
        $data['heading']='Spares Stock Report';
        $data['flist']=$this->Look_up_model->getFloor();
		$data['clist']=$this->Look_up_model->getCategory(12);
	    $data['display']='report/Sparestockreport';
        $this->load->view('admin/master',$data);
        } else {
           redirect("Logincontroller");
        }
    }

    function reportrResult(){
       if ($this->session->userdata('user_id')) {
        $data['collapse']='YES';
        $data['heading']='Spares Stock Report ';
        $data['flist']=$this->Look_up_model->getFloor();
        $data['clist']=$this->Look_up_model->getCategory(12);
        $this->form_validation->set_rules('category_id','Category Name','trim|required');
        $this->form_validation->set_rules('product_code','ITEM CODE','trim');
        $this->form_validation->set_rules('rack_id','Rack Name','trim|required');
        $this->form_validation->set_rules('box_id','Box Name','trim');
        $this->form_validation->set_rules('color_code','Box Name','trim');
        if($this->form_validation->run() == TRUE) {
        $category_id=$this->input->post('category_id');
        $rack_id=$this->input->post('rack_id');
        $product_code=$this->input->post('product_code');
        $data['category_id']=$this->input->post('category_id');
        $data['product_code']=$this->input->post('product_code');
        $data['rack_id']=$this->input->post('rack_id');
        $data['box_id']=$this->input->post('box_id');
        $data['color_code']=$this->input->post('color_code');
        $data['resultdetail']=$this->Sparestockreport_model->reportrResult($category_id,$rack_id,$data['box_id'],$data['color_code'],$product_code);
        $data['display']='report/Sparestockreport';
        $this->load->view('admin/master',$data);
        }else{
        $data['display']='report/Sparestockreport';
        $this->load->view('admin/master',$data);
        }
        } else {
           redirect("Logincontroller");
      } 
    }

    function downloadExcel($category_id=FALSE,$rack_id=FALSE,$box_id=FALSE,$color_code=FALSE,$product_code=FALSE) {
        $data['heading']='Spares Stock Report ';
        $data['category_id']=$category_id;
        $data['product_code']=$product_code;
        $data['color_code']=$color_code;
        $data['rack_id']=$rack_id;
        $data['resultdetail']=$this->Sparestockreport_model->reportrResult($category_id,$rack_id,$box_id,$color_code,$product_code);
        $this->load->view('excel/SparestockreportExcel',$data);
    }

    function getBox(){
          $rack_id=$this->input->post('rack_id');
           $result=$this->db->query("SELECT *
            FROM box_info 
            WHERE department_id=12 
            and rack_id=$rack_id")->result();
        echo '<option value="All">All</option>';
      foreach ($result as $value) {
        echo '<option value="'.$value->box_id.'" >'.$value->box_name.'</option>';
      }
    exit;
   }

    function checkLastDate($product_id){
        $purchase_date=$this->db->query("SELECT p.purchase_date
            FROM purchase_detail pd,purchase_master p
            WHERE pd.purchase_id=p.purchase_id
            AND pd.product_id=$product_id 
            ORDER BY pd.purchase_detail_id")->row('purchase_date');
        return $purchase_date;

   }
function downloadPdf($category_id=FALSE,$rack_id=FALSE,$box_id=FALSE,$color_code=FALSE,$product_code=FALSE) {
  if($this->session->userdata('user_id')) {
    $data['heading']='Spares Stock Report ';
    $data['category_id']=$category_id;
    $data['product_code']=$product_code;
    $data['color_code']=$color_code;
    $data['rack_id']=$rack_id;
    $data['resultdetail']=$this->Sparestockreport_model->reportrResult($category_id,$rack_id,$box_id,$color_code,$product_code);
    $pdfFilePath='sparesStockPdf'.date('Y-m-d H:i').'.pdf';
    $this->load->library('mpdf');
    $mpdf = new mPDF('bn','L','','','15','15','30','18');
    $mpdf->useAdobeCJK = true;
    
    $mpdf->autoScriptToLang = true;
    $mpdf->autoLangToFont = true;
    $header = $this->load->view('header', $data, true);
    $html=$this->load->view('pdf/SparestockreportPdf', $data, true);
    $mpdf->setHtmlHeader($header);
    $mpdf->pagenumPrefix = '  Page ';
    $mpdf->pagenumSuffix = ' - ';
    $mpdf->nbpgPrefix = ' out of ';
    $mpdf->nbpgSuffix = '';
    $mpdf->setFooter('{DATE H:i:s j/m/Y}{PAGENO}{nbpg}');
    $mpdf->WriteHTML($html);
    $mpdf->Output();
    } else {
       redirect("Logincontroller");
    }
}
    
}