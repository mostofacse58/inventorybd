<?php
class Vquotation_model extends CI_Model {
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
          AND pm.status>1
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
          AND pm.status>1
          $condition
          ORDER BY pm.quotation_id DESC, pm.status ASC 
          LIMIT $start,$limit")->result();
        //echo $this->db->last_query();
        //exit;
        return $result;
    }
  
 
    
   function approved($quotation_id) {
      $data=array();
      $data['status']=3;
      $data['verify_id']=$this->session->userdata('user_id');
      $data['verify_date_time']=date('Y-m-d  h:i:s a');
      $this->db->WHERE('quotation_id',$quotation_id);
      $query=$this->db->Update('canteen_quotation_master',$data);
      return $query;
  }

  function save($quotation_id) {
      $quotation_detail_id=$this->input->post('quotation_detail_id');
      $product_id=$this->input->post('product_id');
      $verified_market_price=$this->input->post('verified_market_price');
      $i=0;
        foreach ($product_id as $value) {
         $data1['verified_market_price']=$verified_market_price[$i];
         $this->db->WHERE('product_id',$value);
         $this->db->WHERE('quotation_detail_id',$quotation_detail_id[$i]);
         $this->db->WHERE('quotation_id',$quotation_id);
         $query=$this->db->UPDATE('canteen_quotation_item_details',$data1);
         $i++;
       }
      return $query;
    }
  
}
