<?php
class Quotation_model extends CI_Model {
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
          $condition
          ORDER BY pm.quotation_id DESC, pm.status ASC 
          LIMIT $start,$limit")->result();
        //echo $this->db->last_query();
        //exit;
        return $result;
    }
    function get_info($quotation_id){
      $department_id=$this->session->userdata('department_id');
         $result=$this->db->query("SELECT pm.*,
          u.user_name,v.user_name as verify_id,
          a.user_name as approved_id,
          d.department_name       
          FROM  canteen_quotation_master pm 
          LEFT JOIN department_info d ON(pm.department_id=d.department_id)
          LEFT JOIN user v ON(v.id=pm.verify_id) 
          LEFT JOIN user a ON(a.id=pm.approved_id) 
          LEFT JOIN user u ON(u.id=pm.user_id)
          WHERE pm.quotation_id=$quotation_id ")->row();
        return $result;
    }
    function save($quotation_id) {
      $department_id=$this->session->userdata('department_id');
      $data=array();
      $data['quotation_date']=alterDateFormat($this->input->post('quotation_date'));
      $data['user_id']=$this->session->userdata('user_id');
      $data['department_id']=$department_id;
      $data['other_note']=$this->input->post('other_note');
      $data['q_type']=$this->input->post('q_type');
      $data['create_date']=date('Y-m-d');
      if($_FILES['attachment']['name']!=""){
        $config['upload_path'] = './quotation/';
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
      $previous_price=$this->input->post('previous_price');
      $market_price=$this->input->post('market_price');
      $operational_cost=$this->input->post('operational_cost');
      $profit=$this->input->post('profit');
      $present_price=$this->input->post('present_price');
      $pricedifference=$this->input->post('pricedifference');
      $i=0;
      if($quotation_id==FALSE){
        $counts=$this->db->query("SELECT MAX(quotation_id) as counts
             FROM canteen_quotation_master WHERE 1")->row('counts');
        $quotation_no ='VLM'.date('mY').str_pad($counts + 1, 8, '0', STR_PAD_LEFT);
        $data['quotation_no']=$quotation_no;
        $query=$this->db->insert('canteen_quotation_master',$data);
        $quotation_id=$this->db->insert_id();
      }else{
        $this->db->WHERE('quotation_id',$quotation_id);
        $query=$this->db->UPDATE('canteen_quotation_master',$data);
        $this->db->WHERE('quotation_id',$quotation_id);
        $this->db->delete('canteen_quotation_item_details');
      } 
      foreach ($product_id as $value) {
         $data1['product_id']=$value;
         $data1['quotation_id']=$quotation_id;
         $data1['previous_price']=$previous_price[$i];
         $data1['market_price']=$market_price[$i];
        // $data1['verified_market_price']=$market_price[$i];
         $data1['operational_cost']=$operational_cost[$i];
         $data1['profit']=$profit[$i];
         $data1['present_price']=$present_price[$i];
         $data1['pricedifference']=$pricedifference[$i];
         $query=$this->db->insert('canteen_quotation_item_details',$data1);
         $i++;
       }
      return $query;
    }
  
  function delete($quotation_id) {
    $this->db->WHERE('quotation_id',$quotation_id);
    $query=$this->db->delete('canteen_quotation_item_details');
    $this->db->WHERE('quotation_id',$quotation_id);
    $query=$this->db->delete('canteen_quotation_master');
    return $query;
  }

  public function getDetails($quotation_id=''){
   $result=$this->db->query("SELECT d.*,p.*,p.product_description as specification
      FROM canteen_quotation_item_details d
      INNER JOIN canteen_product_info p ON(d.product_id=p.product_id)
      INNER JOIN product_unit u ON(p.unit_id=u.unit_id)
      WHERE d.quotation_id=$quotation_id 
      ORDER BY p.product_id ASC")->result();
   return $result;
  }
 function getQuotationProduct($department_id,$term) {
      $data=date('Y-m-d');
      $result=$this->db->query("SELECT p.*,c.category_name,u.unit_name
        FROM product_info p
        INNER JOIN category_info c ON(p.category_id=c.category_id)
        INNER JOIN product_unit u ON(p.unit_id=u.unit_id)
        WHERE p.department_id=$department_id AND p.product_type=2 AND p.product_status=1
        AND (p.product_code LIKE '%$term%' or p.product_name LIKE '%$term%') 
        ORDER BY p.product_name ASC")->result();
      return $result;
  }
    
   function submit($quotation_id) {
      $data=array();
      $data['status']=2;
      $data['submited_date_time']=date('Y-m-d  h:i:s a');
      $this->db->WHERE('quotation_id',$quotation_id);
      $query=$this->db->Update('canteen_quotation_master',$data);
      return $query;
  }
  
}
