<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Modelwisereport extends My_Controller {
    function __construct(){
        parent::__construct();
        
        $this->load->model('report/Modelwisereport_model');
        $this->load->model('report/Dailymachinestatus_model');
     }
    function searchForm(){
        $data['heading']='Model Wise Machine Report';
        $data['flist']=$this->Look_up_model->getFloor();
        $data['plist']=$this->Look_up_model->getMainProductMachine(12);
	    $data['display']='report/modelwisereport';
        $this->load->view('admin/master',$data);
    }
    function reportResult(){
        $data['heading']='Model Wise Machine Report';
        $product_id=$this->input->post('product_id');
        $data['product_id']=$this->input->post('product_id');
        $data['flist']=$this->Look_up_model->getFloor();
        $data['plist']=$this->Look_up_model->getMainProductMachine(12);
        $data['resultdetail']=$this->Modelwisereport_model->reportResult($product_id);
        $this->load->view("excel/modelwisereportExcel",$data);
    }
// function gets($category_id=FALSE,$product_id=FALSE,$floor_id=FALSE,$tpm_serial_code=FALSE) {
//         $data['heading']='Model Wise Machine Report ';
//         $data['category_id']=$category_id;
//         $data['product_id']=$product_id;
//         $data['resultdetail']=$this->Modelwisereport_model->reportResult($category_id,$product_id,$floor_id,$tpm_serial_code);
//         $this->load->view('excel/modelwisereportExcel',$data);
//     }
    
}