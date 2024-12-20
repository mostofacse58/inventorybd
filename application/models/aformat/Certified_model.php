<?php
class Certified_model extends CI_Model {
  public function get_count(){
    $condition=' ';
    $department_id=$this->session->userdata('department_id');
    if($department_id==8||$department_id==15||$department_id==22||$department_id==6){
      $condition=$condition."  AND (pm.department_id=8 OR pm.department_id=15 OR pm.department_id=22 OR pm.department_id=6) ";
    }elseif($department_id==9){
      $condition=$condition."  AND (pm.department_id=9) ";
    }elseif($department_id==4){
      $condition=$condition."  AND (pm.department_id=4) ";
    }elseif($department_id==28){
      $condition=$condition."  AND (pm.department_id=28) ";
    }elseif($department_id==29){
      $condition=$condition."  AND (pm.department_id=29) ";
    }elseif($department_id==5){
      $condition=$condition."  AND (pm.department_id=17) ";
    }else{
      $condition=$condition."  AND (pm.department_id=1 OR pm.department_id=2 OR pm.department_id=3 OR pm.department_id=12 OR pm.department_id=16 OR pm.department_id=18) ";
    }
    if($_GET){
      if($this->input->get('pi_no')!=''){
        $pi_no=$this->input->get('pi_no');
        $condition=$condition."  AND pm.pi_no='$pi_no' ";
      }
      if($this->input->get('department_id')!='All'){
        $department_id=$this->input->get('department_id');
        $condition=$condition."  AND pm.department_id='$department_id' ";
      }
     }
     $query=$this->db->query("SELECT pm.*,pt.department_name,u.user_name,
          d.department_name as responsible_department_name       
          FROM  pi_master pm 
          LEFT JOIN department_info pt ON(pm.department_id=pt.department_id)
          LEFT JOIN department_info d ON(pm.responsible_department=d.department_id) 
          LEFT JOIN user u ON(u.id=pm.requested_by) 
          WHERE pm.pi_status>=3 AND pm.pi_type=2 $condition");
      $data = count($query->result());
      return $data;
    }
    function lists($limit,$start) {
      $condition=' ';
      $department_id=$this->session->userdata('department_id');
      if($department_id==8||$department_id==15||$department_id==22||$department_id==6){
      $condition=$condition."  AND (pm.department_id=8 OR pm.department_id=15 OR pm.department_id=22 OR pm.department_id=6) ";
    }elseif($department_id==9){
      $condition=$condition."  AND (pm.department_id=9) ";
    }elseif($department_id==4){
      $condition=$condition."  AND (pm.department_id=4) ";
    }elseif($department_id==28){
      $condition=$condition."  AND (pm.department_id=28) ";
    }elseif($department_id==29){
      $condition=$condition."  AND (pm.department_id=29) ";
    }elseif($department_id==5){
      $condition=$condition."  AND (pm.department_id=17) ";
    }else{
      $condition=$condition."  AND (pm.department_id=1 OR pm.department_id=2 OR pm.department_id=3 OR pm.department_id=12 OR pm.department_id=16 OR pm.department_id=18) ";
    }
      if($_GET){
        if($this->input->get('pi_no')!=''){
          $pi_no=$this->input->get('pi_no');
          $condition=$condition."  AND pm.pi_no='$pi_no' ";
        }
        if($this->input->get('department_id')!='All'){
          $department_id=$this->input->get('department_id');
          $condition=$condition."  AND pm.department_id='$department_id' ";
        }
       }
      $result=$this->db->query("SELECT pm.*,pt.department_name,u.user_name,
        d.department_name as responsible_department_name,
        dr.deptrequisn_no      
        FROM pi_master pm 
        LEFT JOIN department_info pt ON(pm.department_id=pt.department_id)
        LEFT JOIN department_info d ON(pm.responsible_department=d.department_id)
        LEFT JOIN deptrequisn_master dr ON(pm.deptrequisn_id=dr.deptrequisn_id) 
        LEFT JOIN user u ON(u.id=pm.requested_by)
        WHERE pm.pi_status>=3 AND pm.pi_type=2 $condition
        ORDER BY pm.pi_id DESC LIMIT $start,$limit")->result();
      return $result;
    }
   function certify($pi_id) {
      $data=array();
      $data['pi_status']=4;
      $data['certified_date']=date('Y-m-d');
      $data['certified_by']=$this->session->userdata('user_id');
      $this->db->WHERE('pi_id',$pi_id);
      $query=$this->db->Update('pi_master',$data);
      return $query;
  }

  
}
