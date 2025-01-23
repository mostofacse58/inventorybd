<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kaizencronjob extends CI_Controller {
  function __construct() {
    parent::__construct();
  }

  
function pending(){
    $kaizen = $this->load->database('kaizen', TRUE);
    $this->load->model('Communication');
    $applists=$kaizen->query("SELECT u.*
      FROM  user u 
      LEFT JOIN department_info d ON(u.id=d.review_id)
      GROUP BY u.id")->result();
    foreach ($applists as  $value) {
        $user_id=$value->id;
        ///////////////////
        $data['klist']=$kaizen->query("SELECT k.*,d.department_name
            FROM  kaizen_information k
            LEFT JOIN department_info d ON(d.department_id=k.department_id)
            WHERE k.kaizen_status=2 
            AND d.review_id=$user_id
            ORDER BY k.kaizen_id DESC")->result();
       // print_r($data['klist']); 

        if(count($data['klist'])>0){
          /////////////////////////////
          $emailaddress=$value->email_address;
         // $emailaddress="golam.mostofa@bdventura.com";
          $subject="KAIZEN Approval Notification";
          $message=$this->load->view('admin/kaizen_approved_email', $data,true); 
          $this->Communication->send($emailaddress,$subject,$message);
        }
      }
      exit;
    

  }


  
}