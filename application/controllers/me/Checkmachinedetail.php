<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Checkmachinedetail extends My_Controller {
	function __construct()
    {
        parent::__construct();
        $this->load->model('me/Checkmachinedetail_model');
        $this->load->model('it/Assetdetail_model');
     }
    
    function index(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Checking Machine Detail';
        $data['display']='me/checkmDetails';
        $this->load->view('admin/master',$data);
        } else {
           redirect("Logincontroller");
        }
    	
    }
    public  function forms(){
      if($this->session->userdata('user_id')){
        $data['heading']='Checking Machine Detail';
        $data['display']='admin/printform';
        $this->load->view('admin/master',$data);
        }else{
        redirect("admin/index");
      }
    }

  public  function search(){
    $tpm_serial_code=$this->input->post('tpm_serial_code');
    $data['info']=$this->Checkmachinedetail_model->search($tpm_serial_code);
    $data['details']=$this->Checkmachinedetail_model->getdowntime($tpm_serial_code);
    $data['spareslist']=$this->Checkmachinedetail_model->getUseSparesList($tpm_serial_code);
    $data['movelist']=$this->Checkmachinedetail_model->getMovementList($tpm_serial_code);
    $data['servlist']=$this->Assetdetail_model->servicinghistory($tpm_serial_code);
    $data['glist']=$this->Assetdetail_model->gatepassHistory($tpm_serial_code);
    $data['tpm_serial_code']=$tpm_serial_code;
    $data['heading']='Checking Machine Detail';
    $data['display']='me/checkmDetails';
    $this->load->view('admin/master',$data);
}
 public  function downloadExcel($tpm_serial_code){
    $data['info']=$this->Checkmachinedetail_model->search($tpm_serial_code);
    $data['details']=$this->Checkmachinedetail_model->getdowntime($tpm_serial_code);
    $data['movelist']=$this->Checkmachinedetail_model->getMovementList($tpm_serial_code);
    $data['spareslist']=$this->Checkmachinedetail_model->getUseSparesList($tpm_serial_code);
    $data['servlist']=$this->Assetdetail_model->servicinghistory($tpm_serial_code);
    $data['glist']=$this->Assetdetail_model->gatepassHistory($tpm_serial_code);
    $data['tpm_serial_code']=$tpm_serial_code;
    $this->load->view('me/checkmDetailsExcel',$data);
}
function showbar(){
    if ($this->session->userdata('user_id')) {
        $data['details']=$this->Checkmachinedetail_model->prints();
        $this->load->view('admin/qcode',$data);
        } else {
           redirect("Logincontroller");
        }
}
function prints(){
        if ($this->session->userdata('user_id')) {
        $data['details']=$this->Checkmachinedetail_model->prints();
        $this->load->view('admin/qcode',$data);
        } else {
           redirect("Logincontroller");
        }
        
    }


 }