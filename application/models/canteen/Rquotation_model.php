<?php
class Rquotation_model extends CI_Model {
	public function get_count(){
    $condition=' ';
    if(isset($_GET)){
      if($this->input->get('quotation_no')!=''){
        $quotation_no=$this->input->get('quotation_no');
        $condition=$condition."  AND pm.quotation_no='$quotation_no' ";
      }
 
      if($this->input->get('from_date')!=''&&$this->input->get('to_date') !=' '){
        $from_date=$this->input->get('from_date');
        $to_date=$this->input->get('to_date');
        $condition.=" AND pm.quotation_date BETWEEN '$from_date' AND '$to_date'";
      }
     }
    $department_id=$this->session->userdata('department_id');
      $data=$this->db->query("SELECT count(*) as counts  
        FROM  canteen_quotation_master pm 
          WHERE pm.department_id=$department_id 
          AND pm.status>2
          $condition")->row('counts');
      return $data;
    }
    
    function lists($limit,$start) {
        $department_id=$this->session->userdata('department_id');
        $condition=' ';
        if(isset($_GET)){
          if($this->input->get('quotation_no')!=''){
            $quotation_no=$this->input->get('quotation_no');
            $condition=$condition."  AND pm.quotation_no='$quotation_no' ";
          }
         
          if($this->input->get('from_date')!=''&&$this->input->get('to_date') !=' '){
            $from_date=$this->input->get('from_date');
            $to_date=$this->input->get('to_date');
            $condition.=" AND pm.quotation_date BETWEEN '$from_date' AND '$to_date'";
          }
         }
        $result=$this->db->query("SELECT pm.*,d.department_name,u.user_name
          FROM  canteen_quotation_master pm 
          LEFT JOIN department_info d ON(pm.department_id=d.department_id) 
          LEFT JOIN user u ON(u.id=pm.user_id) 
          WHERE pm.department_id=$department_id 
          AND pm.status>2
          $condition
          ORDER BY pm.quotation_id DESC, pm.status ASC 
          LIMIT $start,$limit")->result();
        //echo $this->db->last_query();
        //exit;
        return $result;
    }
  
 
    
   function approved($quotation_id) {
      $data=array();
      $data['status']=4;
      $data['approved_id']=$this->session->userdata('user_id');
      $data['approved_date_time']=date('Y-m-d  h:i:s a');
      $this->db->WHERE('quotation_id',$quotation_id);
      $query=$this->db->Update('canteen_quotation_master',$data);
      return $query;
  }


  
}
