<?php
class Items_model extends CI_Model {
  public function get_count(){
    $condition=' ';
    if($_POST){
        $category_id=$this->input->post('category_id');
        if($category_id!='All'){
          $condition.=" AND p.category_id=$category_id ";
        }
        if($this->input->post('product_code')!=''){
          $product_code=$this->input->post('product_code');
          $condition=$condition."  AND (p.product_code LIKE '%$product_code%' OR p.product_name LIKE '%$product_code%') ";
        }
        
      }
    $department_id=$this->session->userdata('department_id');
    $department_id=3;
      $query=$this->db->query("SELECT * FROM canteen_product_info p
        WHERE p.department_id=$department_id   $condition");
      $data = count($query->result());
      return $data;
    }

    function lists($limit,$start) {
      $department_id=$this->session->userdata('department_id');
      $department_id=3;
      $condition=' ';
      if($_POST){
        $category_id=$this->input->post('category_id');
        if($category_id!='All'){
          $condition.=" AND p.category_id=$category_id ";
        }
        if($this->input->post('product_code')!=''){
          $product_code=$this->input->post('product_code');
          $condition=$condition."  AND (p.product_code LIKE '%$product_code%' OR p.product_name LIKE '%$product_code%') ";
        }
      }
    $result=$this->db->query("SELECT p.*,c.category_name
      FROM  canteen_product_info p
      INNER JOIN category_info c ON(p.category_id=c.category_id)
      LEFT JOIN user u ON(u.id=p.user_id) 
      WHERE p.department_id=$department_id 
       $condition
      ORDER BY p.product_id DESC LIMIT $start,$limit")->result();
    return $result;
  }

    function get_info($product_id){
      $department_id=$this->session->userdata('department_id');
        $result=$this->db->query("SELECT p.*,c.category_name
          FROM  canteen_product_info p
          INNER JOIN category_info c ON(p.category_id=c.category_id)
          LEFT JOIN user u ON(u.id=p.user_id) 
          WHERE p.department_id=$department_id AND
           p.product_id=$product_id")->row();
        return $result;
    }
   
    function save($product_id) {
        $hkdrate=getHKDRate($this->input->post('currency'));
        $department_id=$this->session->userdata('department_id');
        $data=array();
        if($_FILES['product_image']['name']!=""){
        $config1['upload_path'] = './canteen/';
        $config1['allowed_types'] = 'gif|jpg|jpeg|png|PNG|JPEG|JPG';
        $config1['max_size'] = '1500';
        $this->load->library('upload', $config1);
        if ($this->upload->do_upload("product_image")){
          $upload_info1 = $this->upload->data();
          $data['product_image']=$upload_info1['file_name'];
        } }
        $data['product_name']=$this->input->post('product_name');
        $data['category_id']=$this->input->post('category_id');
        $data['product_code']=$this->input->post('product_code');
        $data['unit_id']=$this->input->post('unit_id');
        $data['unit_price']=$this->input->post('unit_price');
        $data['currency']=$this->input->post('currency');
        $data['department_id']=$department_id;
        $data['entry_date']=date('Y-m-d');
        $data['product_description']=$this->input->post('product_description');
        $data['user_id']=$this->session->userdata('user_id');
        if($product_id==FALSE){
          if($data['product_code']==''){
            $product_code_count=$this->db->query("SELECT max(product_code_count) as counts 
              FROM canteen_product_info 
          WHERE department_id=$department_id ")->row('counts');
        $random=strtoupper(substr(md5('ABCDSTSHJUHUHUHUIHUIHIU5454L'.mt_rand(0,1005)),0,4));
        $data['product_code']='BD'.$random.str_pad($product_code_count + 1, 10, '0', STR_PAD_LEFT);
        $data['product_code_count']=$product_code_count + 1;
        }
        $query=$this->db->insert('canteen_product_info',$data);
          $product_id=$this->db->insert_id();
        }else{
          $this->db->WHERE('product_id',$product_id);
          $query=$this->db->update('canteen_product_info',$data);
        }
      return $product_id;
    }


  
    function delete($product_id) {
        // $this->db->WHERE('product_id',$product_id);
        // $query=$this->db->delete('canteen_product_info');
        // $this->db->WHERE('product_id',$product_id);
        // $query=$this->db->delete('stock_master_detail');
        //return $query;
      return true;
    }
    function deactivated($product_id) {
        $data['product_status']=2;
        $this->db->WHERE('product_id',$product_id);
        $query=$this->db->Update('canteen_product_info',$data);
        return $query;
    }
    function activated($product_id) {
        $data['product_status']=1;
        $this->db->WHERE('product_id',$product_id);
        $query=$this->db->Update('canteen_product_info',$data);
        return $query;
    }


  
}
