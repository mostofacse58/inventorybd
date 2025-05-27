<?php
class Invoice_model extends CI_Model {
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
          $condition
          GROUP BY pm.invoice_id")->result();
    }else{
        $query=$this->db->query("SELECT pm.*,u.user_name,s.supplier_name      
          FROM  canteen_invoice_master pm 
          LEFT JOIN supplier_info s ON(pm.supplier_id=s.supplier_id)
          LEFT JOIN user u ON(u.id=pm.user_id) 
          WHERE pm.invoice_status!=5 
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
          $condition
        ORDER BY pm.invoice_id DESC 
        LIMIT $start,$limit")->result();
       }
      return $result;
    }
    
    function save($invoice_id) {
        $department_id=$this->session->userdata('department_id');
        $data=array();
        $data['supplier_id']=$this->input->post('supplier_id');
        $data['invoice_date']=alterDateFormat($this->input->post('invoice_date'));
        $data['user_id']=$this->session->userdata('user_id');
        $requisition_no=$this->input->post('requisition_no');
        $requisition_no=str_replace(" ","",$requisition_no);
        $data['requisition_no']=$requisition_no;
        $data['requisition_id']=$this->input->post('requisition_id');
        $data['note']=$this->input->post('note');
        $data['ref_no']=$this->input->post('ref_no');
        if($invoice_id==FALSE){
          $counts=$this->db->query("SELECT MAX(invoice_id) as counts
             FROM canteen_invoice_master WHERE 1")->row('counts');
          $invoice_no ='V'.date('mY').str_pad($counts + 1, 4, '0', STR_PAD_LEFT);
          $data['invoice_no']=$invoice_no;
          $data['created_by']=$this->session->userdata('user_name');
          $query=$this->db->insert('canteen_invoice_master',$data);
          $invoice_id=$this->db->insert_id();
        }else{
          $data['updated_at']=date('Y-m-d H:i:s');
          $this->db->WHERE('invoice_id',$invoice_id);
          $this->db->UPDATE('canteen_invoice_master',$data);
        }
        ////////////////////////////////////////
        $product_id=$this->input->post('product_id');
        $quantity=$this->input->post('quantity');
        $unit_price=$this->input->post('unit_price');
        $amount=$this->input->post('amount');
        $product_code=$this->input->post('product_code');
        $requisition_no=$this->input->post('requisition_no');
        $required_qty=$this->input->post('required_qty');
        $product_name=$this->input->post('product_name');
        $specification=$this->input->post('specification');
        $i=0;
        $total_amount=0;
        /////////////////
        foreach ($product_id as $value) {
           $data1['invoice_id']=$invoice_id;
           $data1['product_id']=$value;
           $data1['requisition_no']=trim($requisition_no[$i]);
           $data1['required_qty']=$required_qty[$i];
           $data1['quantity']=$quantity[$i];
           $data1['amount']=$amount[$i];
           $data1['unit_price']=$unit_price[$i];
           $data1['actualquantity']=$quantity[$i];
           $data1['actualamount']=$quantity[$i]*$unit_price[$i];
           $data1['auditquantity']=$quantity[$i];
           $data1['auditamount']=$quantity[$i]*$unit_price[$i];
           $data1['product_code']=$product_code[$i];
           $data1['specification']=$specification[$i];
           $data1['product_name']=$product_name[$i];
           $total_amount=$total_amount+$amount[$i];
           $data1['amount']=$amount[$i];
           $query=$this->db->insert('canteen_invoice_item_details',$data1);
           //////////////////////////
            $data2['unit_price']=$unit_price[$i];
            $this->db->WHERE('product_id',$value);
            $this->db->UPDATE('canteen_product_info',$data2);
            $i++;
           }
          $data4['total_amount']=$total_amount;
          $this->db->WHERE('invoice_id',$invoice_id);
          $this->db->UPDATE('canteen_invoice_master',$data4);
        return $query;
    }
  
  function delete($invoice_id) {
    $this->db->WHERE('invoice_id',$invoice_id);
    $query=$this->db->update('canteen_invoice_item_details',array('invoice_status'=>5));
    $this->db->WHERE('invoice_id',$invoice_id);
    $query=$this->db->update('canteen_invoice_master',array('invoice_status'=>5));
    return $query;
  }
  function get_info($invoice_id){
     $result=$this->db->query("SELECT pm.*,s.supplier_name,
      u.user_name,u1.user_name as received_by_name
      FROM  canteen_invoice_master pm 
      LEFT JOIN supplier_info s ON(pm.supplier_id=s.supplier_id)
      LEFT JOIN user u ON(u.id=pm.user_id) 
      LEFT JOIN user u1 ON(u1.id=pm.received_by) 
      WHERE pm.invoice_id=$invoice_id")->row();
    return $result;
  }
  public function getDetails($invoice_id=''){
   $result=$this->db->query("SELECT p.*,pud.*,c.category_name,u.unit_name
        FROM canteen_invoice_item_details pud
        INNER JOIN canteen_product_info p ON(pud.product_id=p.product_id)
        INNER JOIN category_info c ON(p.category_id=c.category_id)
        INNER JOIN product_unit u ON(p.unit_id=u.unit_id)
        WHERE pud.invoice_id=$invoice_id AND pud.invoice_status!=5
        ORDER BY p.product_name ASC")->result();
   return $result;
  }
  public function getItemSearch($invoice_id=''){
   $result=$this->db->query("SELECT p.*,pud.*,c.category_name,u.unit_name
        FROM canteen_invoice_item_details pud
        INNER JOIN canteen_product_info p ON(pud.product_id=p.product_id)
        INNER JOIN category_info c ON(p.category_id=c.category_id)
        INNER JOIN product_unit u ON(p.unit_id=u.unit_id)
        WHERE pud.invoice_id=$invoice_id AND pud.invoice_status!=5
        ORDER BY p.product_name ASC")->result();
   return $result;
  }
  function submit($invoice_id) {
    $this->db->WHERE('invoice_id',$invoice_id);
    $query=$this->db->Update('canteen_invoice_master',array('invoice_status'=>2));
     $this->db->WHERE('invoice_id',$invoice_id);
    $query=$this->db->update('canteen_invoice_item_details',array('invoice_status'=>2));
    return $query;
 }
 
    
  
}
