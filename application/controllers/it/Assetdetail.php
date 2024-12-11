<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Assetdetail extends My_Controller {
	function __construct()
    {
        parent::__construct();
        $this->load->model('it/Assetdetail_model');
     }
   function searchForm(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Checking Asset Detail';
        $data['display']='it/assetDetails';
        $this->load->view('admin/master',$data);
        } else {
           redirect("Logincontroller");
        }
    }
  public  function search(){
    if($this->session->userdata('user_id')){
    $ventura_code=$this->input->post('ventura_code');
    $data['info']=$this->Assetdetail_model->search();
    $data['details']=$this->Assetdetail_model->movementhistory();
    $data['spareslist']=$this->Assetdetail_model->getSparesList();
    $data['servlist']=$this->Assetdetail_model->servicinghistory($ventura_code);
    $data['glist']=$this->Assetdetail_model->gatepassHistory($ventura_code);
    $data['heading']='Checking Asset Detail';
    $data['display']='it/assetDetails';
    $this->load->view('admin/master',$data);
    }else{
    redirect("admin/index");
  }
 }
}