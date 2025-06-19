<?php
class Requisitionrec_model extends CI_Model {
	public function get_count(){
    $condition=' ';
    if(isset($_GET)){
      if($this->input->get('requisition_no')!=''){
        $requisition_no=$this->input->get('requisition_no');
        $condition=$condition."  AND pm.requisition_no='$requisition_no' ";
      }
      if($this->input->get('responsible_department')!=''){
        $responsible_department=$this->input->get('responsible_department');
        $condition=$condition."  AND pm.responsible_department='$responsible_department' ";
      }
      if($this->input->get('from_date')!=''&&$this->input->get('to_date') !=' '){
        $from_date=$this->input->get('from_date');
        $to_date=$this->input->get('to_date');
        $condition.=" AND pm.demand_date BETWEEN '$from_date' AND '$to_date'";
      }
     }
    $department_id=$this->session->userdata('department_id');
      $data=$this->db->query("SELECT count(*) as counts  
        FROM  canteen_requisition_master pm 
          WHERE 1
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
          if($this->input->get('responsible_department')!=''){
            $responsible_department=$this->input->get('responsible_department');
            $condition=$condition."  AND pm.responsible_department='$responsible_department' ";
          }
          if($this->input->get('from_date')!=''&&$this->input->get('to_date') !=' '){
            $from_date=$this->input->get('from_date');
            $to_date=$this->input->get('to_date');
            $condition.=" AND pm.demand_date BETWEEN '$from_date' AND '$to_date'";
          }
         }
        $result=$this->db->query("SELECT pm.*,pt.department_name,u.user_name,s.supplier_name
          FROM  canteen_requisition_master pm 
          LEFT JOIN department_info pt ON(pm.department_id=pt.department_id)
          LEFT JOIN user u ON(u.id=pm.requested_by) 
          LEFT JOIN supplier_info s ON(pm.supplier_id=s.supplier_id) 
          WHERE 1
          $condition
          ORDER BY pm.requisition_id DESC, pm.requisition_status ASC 
          LIMIT $start,$limit")->result();
        return $result;
    }
    function get_info($requisition_id){
      $department_id=$this->session->userdata('department_id');
        $result=$this->db->query("SELECT pm.*,pt.department_name,
          u.user_name as requested_by,s.supplier_name,
          a.user_name as approved_by
          FROM  canteen_requisition_master pm 
          LEFT JOIN department_info pt ON(pm.department_id=pt.department_id)
          LEFT JOIN supplier_info s ON(pm.supplier_id=s.supplier_id) 
          LEFT JOIN user a ON(a.id=pm.approved_by) 
          LEFT JOIN user u ON(u.id=pm.requested_by)
          WHERE pm.requisition_id=$requisition_id ")->row();
        return $result;
    }
    function save($requisition_id) {
      $department_id=$this->session->userdata('department_id');
      $data=array();
      $data['requisition_date']=alterDateFormat($this->input->post('requisition_date'));
      $data['demand_date']=alterDateFormat($this->input->post('demand_date'));
      $data['user_id']=$this->session->userdata('user_id');
      $data['requested_by']=$this->session->userdata('user_id');
      $data['department_id']=$department_id;
      $data['other_note']=$this->input->post('other_note');
      $data['for_canteen']=$this->input->post('for_canteen');
      $data['supplier_id']=$this->input->post('supplier_id');
      $data['create_date']=date('Y-m-d');
      if($_FILES['attachment']['name']!=""){
        $config['upload_path'] = './requisition/';
        $config['allowed_types'] = '*';
        $config['max_size'] = '300000';
        $config['encrypt_name'] = TRUE;
        $config['detect_mime'] = TRUE;
        $this->load->library('upload', $config);
        if ($this->upload->do_upload("attachment")){
          $upload_info = $this->upload->data();
          $data['attachment']=$upload_info['file_name'];
        }
      }
      //////////////////////////////
      $product_id=$this->input->post('product_id');
      $specification=$this->input->post('specification');
      $product_code=$this->input->post('product_code');
      $product_name=$this->input->post('product_name');
      $required_qty=$this->input->post('required_qty');
      $remarks=$this->input->post('remarks');
      $i=0;
      if($requisition_id==FALSE){
        $counts=$this->db->query("SELECT MAX(requisition_id) as counts
             FROM canteen_requisition_master WHERE 1")->row('counts');
        $requisition_no ='VLM'.date('mY').str_pad($counts + 1, 8, '0', STR_PAD_LEFT);
        $data['requisition_no']=$requisition_no;
        $query=$this->db->insert('canteen_requisition_master',$data);
        $requisition_id=$this->db->insert_id();
      }else{
        $this->db->WHERE('requisition_id',$requisition_id);
        $query=$this->db->UPDATE('canteen_requisition_master',$data);
        $this->db->WHERE('requisition_id',$requisition_id);
        $this->db->delete('canteen_requisition_item_details');
      } 
      foreach ($product_id as $value) {
         $data1['product_id']=$value;
         $data1['requisition_id']=$requisition_id;
         $data1['product_code']=$product_code[$i];
         $data1['product_name']=$product_name[$i];
         $data1['specification']=$specification[$i];
         $data1['required_qty']=$required_qty[$i];
         $data1['remarks']=$remarks[$i];
         $query=$this->db->insert('canteen_requisition_item_details',$data1);
         $i++;
       }
      return $query;
    }
  
    function delete($requisition_id) {
        $this->db->WHERE('requisition_id',$requisition_id);
        $query=$this->db->delete('canteen_requisition_item_details');
        $this->db->WHERE('requisition_id',$requisition_id);
        $query=$this->db->delete('canteen_requisition_master');
        return $query;
     }
  public function getDetails($requisition_id=''){
   $result=$this->db->query("SELECT pud.*,p.*,c.category_name,
        u.unit_name,pud.unit_price,pud.amount
        FROM canteen_requisition_item_details pud
        INNER JOIN canteen_product_info p ON(pud.product_id=p.product_id)
        INNER JOIN category_info c ON(p.category_id=c.category_id)
        INNER JOIN product_unit u ON(p.unit_id=u.unit_id)
        WHERE pud.requisition_id=$requisition_id 
        ORDER BY p.product_name ASC")->result();
   return $result;
  }
 
    
   function received($requisition_id) {
      $data=array();
      $data['received_by']=$this->session->userdata('user_name');
      $data['requisition_status']=3;
      $data['received_date']=date('Y-m-d  h:i:s a');
      $this->db->WHERE('requisition_id',$requisition_id);
      $query=$this->db->Update('canteen_requisition_master',$data);
      


      return $query;
  }
  
}
