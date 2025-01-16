<?php
class Requisitionprice_model extends CI_Model {
	public function get_count(){
    $condition=' ';
    if(isset($_GET)){
      if($this->input->get('requisition_no')!=''){
        $requisition_no=$this->input->get('requisition_no');
        $condition=$condition."  AND pm.requisition_no='$requisition_no' ";
      }
     }
    $department_id=$this->session->userdata('department_id');
      $data=$this->db->query("SELECT count(*) as counts  
        FROM  requisition_master pm 
          WHERE pm.pr_type=1 
          AND pm.requisition_status>=2 
          AND pm.general_or_tpm=1 
          AND pm.ie_verify='YES' 
          $condition")->row('counts');
      return $data;
    }
    
    function lists($limit,$start) {
        $department_id=$this->session->userdata('department_id');
        $condition=' ';
        if(isset($_GET)){
          if($this->input->get('requisition_no')!=''){
            $requisition_no=$this->input->get('requisition_no');
            $condition=$condition."  AND pm.requisition_no='$requisition_no' ";
          }
         }
        $result=$this->db->query("SELECT pm.*,pt.department_name,u.user_name,l.location_name,
          d.department_name as responsible_department_name       
          FROM  requisition_master pm 
          LEFT JOIN department_info pt ON(pm.department_id=pt.department_id)
          LEFT JOIN department_info d ON(pm.responsible_department=d.department_id) 
          LEFT JOIN location_info l ON(l.location_id=pm.location_id)
          LEFT JOIN user u ON(u.id=pm.requested_by) 
          WHERE pm.pr_type=1 
          AND pm.requisition_status>=2 
          AND pm.general_or_tpm=1 
          AND pm.ie_verify='YES'  
          $condition
          ORDER BY pm.requisition_id DESC, pm.requisition_status ASC LIMIT $start,$limit")->result();
        return $result;
    }
    function get_info($requisition_id){
      $department_id=$this->session->userdata('department_id');
         $result=$this->db->query("SELECT pm.*,pt.department_name,
          u.user_name as requested_by,h.user_name as dept_head,
          a.user_name as approved_by,e.employee_name,l.location_name,
          d.department_name as responsible_department_name       
          FROM  requisition_master pm 
          LEFT JOIN department_info pt ON(pm.department_id=pt.department_id)
          LEFT JOIN department_info d ON(pm.responsible_department=d.department_id)
          LEFT JOIN location_info l ON(l.location_id=pm.location_id)
          LEFT JOIN user h ON(h.id=pm.dept_head) 
          LEFT JOIN user a ON(a.id=pm.approved_by) 
          LEFT JOIN user u ON(u.id=pm.requested_by)
          LEFT JOIN employee_idcard_info e ON(e.employee_cardno=pm.employee_id) 
          WHERE pm.requisition_id=$requisition_id  AND pm.general_or_tpm=1")->row();
        return $result;
    }
    function save($requisition_id) {
      $data=array();
      $product_id=$this->input->post('product_id');
      $requisition_detail_id=$this->input->post('requisition_detail_id');
      $unit_price=$this->input->post('unit_price');
      $amount=$this->input->post('amount');
      $i=0;
      foreach ($requisition_detail_id as $value) {
         $data1['unit_price']=$unit_price[$i];
         $data1['amount']=$amount[$i];
         $this->db->WHERE('requisition_id',$requisition_id);
         $this->db->WHERE('requisition_detail_id',$value);
         $this->db->WHERE('product_id',$product_id[$i]);
         $query=$this->db->UPDATE('requisition_item_details',$data1);
         $i++;
       }
      return $query;
    }
  
    public function getDetails($requisition_id=''){
     $result=$this->db->query("SELECT pud.*,p.*,c.category_name,u.unit_name
          FROM requisition_item_details pud
          INNER JOIN product_info p ON(pud.product_id=p.product_id)
          INNER JOIN category_info c ON(p.category_id=c.category_id)
          INNER JOIN product_unit u ON(p.unit_id=u.unit_id)
          WHERE pud.requisition_id=$requisition_id 
          ORDER BY p.product_name ASC")->result();
     return $result;
    }

    
   function submit($requisition_id) {
      $data=array();
      $data['tpm_status']=2;
      $data['tpm_updated_by']=$this->session->userdata('user_name');
      $data['tpm_updated_date']=date('Y-m-d h:i:sa');
      $this->db->WHERE('requisition_id',$requisition_id);
      $query=$this->db->Update('requisition_master',$data);
      return $query;
  }
  
}
