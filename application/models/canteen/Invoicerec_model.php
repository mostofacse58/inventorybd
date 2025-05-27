<?php
class Invoicerec_model extends CI_Model {
  public function get_count(){
    $condition=' ';
    if($_GET){
    
      if($this->input->get('product_code')!=''){
        $product_code=$this->input->get('product_code');
        $condition=$condition."  AND (pmd.product_code LIKE '%$product_code%' ) ";
      }
      if($this->input->get('requisition_no')!=''){
        $requisition_no=$this->input->get('requisition_no');
        $condition=$condition."  AND pm.requisition_no='$requisition_no' ";
      }
 
      if($this->input->get('requisition_no')!=''){
        $requisition_no=$this->input->get('requisition_no');
        $condition=$condition."  AND pmd.requisition_no='$requisition_no' ";
      }
       if($this->input->get('invoice_type')!='All'){
        $invoice_type=$this->input->get('invoice_type');
        $condition=$condition."  AND pm.invoice_type='$invoice_type' ";
      }
      if($this->input->get('supplier_id')!='All'){
        $supplier_id=$this->input->get('supplier_id');
        $condition=$condition."  AND pm.supplier_id=$supplier_id ";
      }
      if($this->input->get('from_date')!=''&&$this->input->get('to_date') !=' '){
        $from_date=$this->input->get('from_date');
        $to_date=$this->input->get('to_date');
        $condition.=" AND pm.invoice_date BETWEEN '$from_date' AND '$to_date'";
      }
    }
    if($this->input->get('product_code')!=''||$this->input->get('requisition_no')!=''){
        $query=$this->db->query("SELECT pm.*,u.user_name,s.supplier_name      
          FROM  canteen_invoice_master pm 
          INNER JOIN canteen_invoice_item_details pmd ON(pm.invoice_id=pmd.invoice_id)
          LEFT JOIN supplier_info s ON(pm.supplier_id=s.supplier_id)
          LEFT JOIN user u ON(u.id=pm.user_id) 
          WHERE  pm.invoice_status!=5 
          AND pm.invoice_status>=2
          $condition
          GROUP BY pm.invoice_id")->result();
    }else{
        $query=$this->db->query("SELECT pm.*,u.user_name,s.supplier_name      
          FROM  canteen_invoice_master pm 
          LEFT JOIN supplier_info s ON(pm.supplier_id=s.supplier_id)
          LEFT JOIN user u ON(u.id=pm.user_id) 
          WHERE pm.invoice_status!=5 
          AND pm.invoice_status>=2 
          $condition")->result();
         }
    $data = count($query);
    return $data;
  }
  function lists($limit,$start) {
    $condition=' ';
    if($_GET){
        if($this->input->get('requisition_no')!=''){
        $requisition_no=$this->input->get('requisition_no');
        $condition=$condition."  AND pm.requisition_no='$requisition_no' ";
      }
      if($this->input->get('invoice_type')!='All'){
        $invoice_type=$this->input->get('invoice_type');
        $condition=$condition."  AND pm.invoice_type='$invoice_type' ";
      }
      if($this->input->get('product_code')!=''){
        $product_code=$this->input->get('product_code');
        $condition=$condition."  AND (pmd.product_code LIKE '%$product_code%') ";
      }
      if($this->input->get('requisition_no')!=''){
        $requisition_no=$this->input->get('requisition_no');
        $condition=$condition."  AND pmd.requisition_no='$requisition_no' ";
      }

      if($this->input->get('supplier_id')!='All'){
        $supplier_id=$this->input->get('supplier_id');
        $condition=$condition."  AND pm.supplier_id=$supplier_id ";
      }
      if($this->input->get('from_date')!=''&&$this->input->get('to_date') !=' '){
        $from_date=$this->input->get('from_date');
        $to_date=$this->input->get('to_date');
        $condition.=" AND pm.invoice_date BETWEEN '$from_date' AND '$to_date'";
      }
     }
    $department_id=$this->session->userdata('');
    if($this->input->get('product_code')!=''||$this->input->get('requisition_no')!=''){
      $result=$this->db->query("SELECT pm.*,u.user_name,
          s.supplier_name      
          FROM  canteen_invoice_master pm 
          INNER JOIN canteen_invoice_item_details pmd ON(pm.invoice_id=pmd.invoice_id)
          LEFT JOIN supplier_info s ON(pm.supplier_id=s.supplier_id)
          LEFT JOIN user u ON(u.id=pm.user_id) 
          WHERE  pm.invoice_status!=5
          AND pm.invoice_status>=2
          $condition
        GROUP BY pm.invoice_id
        ORDER BY pm.invoice_id DESC 
        LIMIT $start,$limit")->result();
     }else{
      $result=$this->db->query("SELECT pm.*,u.user_name,
        s.supplier_name,s.company_name      
          FROM  canteen_invoice_master pm 
          LEFT JOIN supplier_info s ON(pm.supplier_id=s.supplier_id)
          LEFT JOIN user u ON(u.id=pm.user_id) 
          WHERE pm.invoice_status!=5
          AND pm.invoice_status>=2 
          $condition
        ORDER BY pm.invoice_id DESC 
        LIMIT $start,$limit")->result();
       }
      return $result;
    }
    
    
	function received($invoice_id) {
		$this->db->WHERE('invoice_id',$invoice_id);
		$query=$this->db->Update('canteen_invoice_master',array('invoice_status'=>3,
			'received_by'=>$this->session->userdata('user_name'),
			'received_date'=>date('Y-m-d H:i:s')));
		$this->db->WHERE('invoice_id',$invoice_id);
		$query=$this->db->update('canteen_invoice_item_details',array('invoice_status'=>3));
		return $query;
	}

	function updated($invoice_id) {
		$data['received_id']=$this->session->userdata('user_id');
		$this->db->WHERE('invoice_id',$invoice_id);
		$query=$this->db->Update('canteen_invoice_master',$data);
		//////////////////////////////////////
		$item_detail_id=$this->input->post('item_detail_id');
		$actualquantity=$this->input->post('actualquantity');
		$actualamount=$this->input->post('actualamount');
		$product_id=$this->input->post('product_id');
		$i=0;
		foreach ($item_detail_id as $value) {
			$data1=array();
			$data1['actualquantity']=$actualquantity[$i];
			$data1['actualamount']=$actualamount[$i];
			$data1['actualDateTime']=date('Y-m-d H:i:s');
			$this->db->WHERE('invoice_id',$invoice_id);
			$this->db->WHERE('product_id',$product_id[$i]);
			$this->db->WHERE('item_detail_id',$value);
			$query=$this->db->UPDATE('canteen_invoice_item_details',$data1);
			$i++;
		}
		return $query;
	}
 
    
  
}
