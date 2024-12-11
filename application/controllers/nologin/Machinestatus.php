<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Machinestatus extends CI_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('nologin/Machinestatus_model');
     }


    function index(){
        $data['heading']='Machinery Report ';
        $data['resultdetail']=$this->Machinestatus_model->reportResult();
        $this->load->view('nologin/machinestatus',$data);
    }

    
}