<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Itassetreport extends CI_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('nologin/Itassetreport_model');
     }


    function index(){
        $data['heading']='Asset Report ';
        $data['resultdetail']=$this->Itassetreport_model->reportResult();
        $this->load->view('nologin/itassetreport',$data);
    }

    
}