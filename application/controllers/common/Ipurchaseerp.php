<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Ipurchaseerp extends CI_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('common/Ipurchase_model');
        
     }
   function save($purchase_id=FALSE){
      $check=$this->Ipurchase_model->save($purchase_id);
      if($check && !$purchase_id){
       $this->session->set_userdata('exception','Saved successfully');
       }elseif($check&& $purchase_id){
           $this->session->set_userdata('exception','Update successfully');
       }else{
         $this->session->set_userdata('exception','Submission Failed');
       }
    redirect("common/Ipurchase/lists");
  }
  

      
 }