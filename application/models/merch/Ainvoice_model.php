<?php
class Ainvoice_model extends CI_Model {
  function __construct(){
    parent::__construct();
 }
  public function get_count(){
    $condition=' ';
    if(isset($_GET)){
      if($this->input->get('invoice_no')!=''){
        $invoice_no=$this->input->get('invoice_no');
        $condition=$condition."  AND g.invoice_no LIKE '%$invoice_no%' ";
      }
      if($this->input->get('employee_idno')!=''){
        $invoice_no=$this->input->get('employee_idno');
        $condition=$condition."  AND g.employee_idno LIKE '%$employee_idno%' ";
      }
     }
    $department_id=$this->session->userdata('department_id');
    $query=$this->db->query("SELECT * FROM invoice_master g
        WHERE g.status>=2 AND 
        g.department_id=$department_id $condition");
    $data = count($query->result());
    return $data;
  }

  public  function lists($limit,$start){
    $condition=' ';
    if(isset($_GET)){
      if($this->input->get('invoice_no')!=''){
        $invoice_no=$this->input->get('invoice_no');
        $condition=$condition."  AND g.invoice_no LIKE '%$invoice_no%' ";
      }
      if($this->input->get('employee_idno')!=''){
        $invoice_no=$this->input->get('employee_idno');
        $condition=$condition."  AND g.employee_idno LIKE '%$employee_idno%' ";
      }
    }
    $department_id=$this->session->userdata('department_id');
    $result=$this->db->query("SELECT g.*,u.user_name as created_by,
      u1.user_name as approved_by_name,d.department_name
      FROM  invoice_master g 
      INNER JOIN department_info d ON(g.department_id=d.department_id)
      LEFT JOIN user u ON(u.id=g.user_id)
      LEFT JOIN user u1 ON(u1.id=g.approved_by) 
      WHERE g.status>=2 
      AND g.department_id=$department_id 
      $condition
      ORDER BY g.invoice_id DESC 
      LIMIT $start,$limit")->result();
    return $result;
  }
  function get_detail($invoice_id){
    $result=$this->db->query("SELECT gd.*
      FROM  invoice_details gd 
      WHERE gd.invoice_id=$invoice_id")->result();
    return $result;
  }
  function get_info($invoice_id){
    $department_id=$this->session->userdata('department_id');
      $result=$this->db->query("SELECT g.*,u.user_name,
      u1.user_name as approved_by_name,
      d.department_name
      FROM  invoice_master g 
      INNER JOIN department_info d ON(g.department_id=d.department_id)
      LEFT JOIN user u ON(u.id=g.user_id)
      LEFT JOIN user u1 ON(u1.id=g.approved_by) 
      WHERE g.invoice_id=$invoice_id")->row();
      return $result;
    }
    function save($invoice_id) {
        $data=array();
        $department_id=$this->session->userdata('department_id');
        $data['employee_idno']=$this->input->post('employee_idno');
        $data['employee_name']=$this->input->post('employee_name');
        $data['create_date']=alterDateFormat($this->input->post('create_date'));
        $data['user_id']=$this->session->userdata('user_id');
        $data['department_id']=$this->session->userdata('department_id');
        ///////////////
        if($invoice_id==FALSE){
          $no_count=$this->db->query("SELECT max(invoice_id) as counts 
            FROM invoice_master 
          WHERE 1")->row('counts');

          $data['invoice_no']='IN'.str_pad($no_count + 1, 6, '0', STR_PAD_LEFT);
          $query=$this->db->insert('invoice_master',$data);
          $invoice_id=$this->db->insert_id();
        }else{
          $this->db->WHERE('invoice_id',$invoice_id);
          $query=$this->db->update('invoice_master',$data);
          
        }
        $this->db->WHERE('invoice_id',$invoice_id);
        $this->db->delete('invoice_details');
        $product_name=$this->input->post('product_name');
        $unit_price=$this->input->post('unit_price');
        $quantity=$this->input->post('quantity');
        $unit_name=$this->input->post('unit_name');
        $amount=$this->input->post('amount');
        $i=0;
        $data2['invoice_id']=$invoice_id;
        $data2['department_id']=$department_id;
        foreach ($product_name as $value) {
          $data2['product_name']=$value;
          $data2['unit_price']=$unit_price[$i];
          $data2['quantity']=$quantity[$i];
          $data2['unit_name']=$unit_name[$i];
          $data2['amount']=$amount[$i];
          $query=$this->db->insert('invoice_details',$data2);
          $i++;
        }
       return $query;
    }
  
    function delete($invoice_id) {
      $this->db->WHERE('invoice_id',$invoice_id);
      $query=$this->db->delete('invoice_master');
      $this->db->WHERE('invoice_id',$invoice_id);
      $query=$this->db->delete('invoice_details');
      return $query;
  }

  function Userlists(){
     $result=$this->db->query("SELECT u.* FROM user u,post p
      WHERE p.post_id=u.post_id AND p.post_lavel='Director' AND u.status='ACTIVE'
      ORDER BY u.user_name ASC")->result();
      return $result;
  }
  function ShipTolists(){
     $result=$this->db->query("SELECT * FROM ship_to_info
      ORDER BY ship_name ASC")->result();
      return $result;
  }
 


  
}
 
