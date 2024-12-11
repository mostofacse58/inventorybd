<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Purchaserequisition extends CI_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('nologin/purchaseRequisition_model');
     }
    function reportResult(){
        $data['heading']='Requisition Report ';
        $data['resultdetail']=$this->purchaseRequisition_model->reportResult();
        $this->load->view('nologin/purchaserequisition',$data);
    }
  
}