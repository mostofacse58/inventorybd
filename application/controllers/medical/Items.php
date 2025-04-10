<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Items extends My_Controller {
    function __construct()
    {
        parent::__construct();
        $this->load->model('payment/Applications_model');
        $this->load->model('medical/Items_model');
     }
    
    function lists(){
      if($this->session->userdata('user_id')) {
      $data=array();
      if($this->input->post('perpage')!='') $perpage=$this->input->post('perpage'); else $perpage=10;
      //////////////////
        $this->load->library('pagination');
        $config['base_url']=base_url().'medical/Items/lists/';
        $config["uri_segment"] = 4;
        $config['total_rows'] = $this->Items_model->get_count();
        $config['per_page'] = $perpage;
        $choice = $config["total_rows"] / $config["per_page"];
        $config["num_links"] = 2;
        $config['full_tag_open'] = '<ul class="pagination pagination-sm pull-right">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = 'First';
        $config['last_link'] = 'Last';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = '<span aria-hidden="true">&laquo Prev</span>';
        $config['prev_tag_open'] = '<li class="prev">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '<span aria-hidden="true">Next »</span>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = "</a></li>";
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        //////////////////////////////////////////
        $this->pagination->initialize($config); 
        $data['page'] = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $data['pagination'] = $this->pagination->create_links();
        $data['list']=$this->Items_model->lists($config["per_page"],$data['page'] );
        ////////////////////////////
        $data['heading']='Medicine Info';
        $data['display']='medical/itemslist';
        $this->load->view('admin/master',$data);
        } else {
          redirect("Logincontroller");
        }
       }
       function lists2(){
       $data=array();
       $list=$this->Items_model->lists2();

       foreach ($list as $value) {        
        $data['product_model']=$value->product_model;
        $data['product_name']=$value->product_name;
        $data['china_name']=$value->china_name;
        $data['category_id']=$value->category_id+22;
        $data['product_code']=$value->product_code;
        $data['stock_quantity']=$value->stock_quantity;
        $data['minimum_stock']=$value->minimum_stock;
        $data['unit_id']=$value->product_model;
        $data['unit_price']=$value->unit_price;
        $data['department_id']=26;
        $data['product_type']=2;
        $data['entry_date']=date('Y-m-d');
        $data['product_description']=$value->product_description;
        $data['box_id']=$value->box_id+5;
        $data['brand_id']=$value->brand_id;
        $data['user_id']=23;
        $data['product_code_count']=$value->product_code_count;
        //print_r($data); exit();
        $query=$this->db->insert('product_info',$data);
        }
       }
    function add(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Add New Medicine Info';
        $data['clist']=$this->Look_up_model->getCategory(3);
        $data['brlist']=$this->Look_up_model->getBrand();
        $data['hlist']=$this->Applications_model->getAccountHead();
        $data['display']='medical/additems';
        $this->load->view('admin/master',$data);
        } else {
           redirect("Logincontroller");
        }
        
    }
    function edit($product_id){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Edit Medicine Info';
        $data['info']=$this->Items_model->get_info($product_id);
        $data['clist']=$this->Look_up_model->getCategory(12);
        $data['hlist']=$this->Applications_model->getAccountHead();
        $data['brlist']=$this->Look_up_model->getBrand();
        $data['display']='medical/additems';
        $this->load->view('admin/master',$data);
        } else {
           redirect("Logincontroller");
        }

    }
   
    function save($product_id=FALSE){
       if($product_id==FALSE){
          $this->form_validation->set_rules('product_model','Model','trim|is_unique[product_info.product_model]');
        }else{
          $this->form_validation->set_rules('product_model','Model','trim');
        }        $this->form_validation->set_rules('product_name','English Name','trim|required');
        $this->form_validation->set_rules('china_name','Chinese  Name','trim');
        $this->form_validation->set_rules('category_id','Category','trim|required');
         if($product_id==FALSE){
          $this->form_validation->set_rules('product_code','ITEM CODE','trim|is_unique[product_info.product_code]');
        }else{
          $this->form_validation->set_rules('product_code','ITEM CODE','trim');
        }
        $this->form_validation->set_rules('unit_id','Product Unit','trim|required');
        $this->form_validation->set_rules('product_description','Description','trim');
        $this->form_validation->set_rules('stock_quantity','Stock Quatity','trim|required');
        $this->form_validation->set_rules('minimum_stock','minimum Stock Qty','trim|required');
        $this->form_validation->set_rules('unit_price','Unit Price','trim|required');
        $this->form_validation->set_rules('box_id','Box Name','trim');
        $this->form_validation->set_rules('brand_id','Brand','trim');
         if ($this->form_validation->run() == TRUE) {
            $stock_quantity=$this->input->post('stock_quantity');
            if($product_id!=FALSE){
              $beforeqty=$this->db->query("SELECT stock_quantity FROM  product_info p WHERE  p.product_type=2 AND p.product_id=$product_id")->row('stock_quantity');
            $this->Look_up_model->storecrud("EDIT",$product_id,$stock_quantity,$beforeqty);
            }
            $check=$this->Items_model->save($product_id);
            if($product_id==FALSE){
              $this->Look_up_model->storecrud("ADD",$check,$stock_quantity);
            }
            if($check &&!$product_id){
               $this->session->set_userdata('exception','Saved successfully');
               }elseif($check&&$product_id){
                   $this->session->set_userdata('exception','Update successfully');
               }else{
                 $this->session->set_userdata('exception','Submission Failed');
               }
          redirect("medical/Items/lists");
         }else{
            $data['heading']='Add New Medicine Info';
            if($product_id){
              $data['heading']='Edit Medicine Info';
              $data['info']=$this->Items_model->get_info($product_id);  
            }
            $data['clist']=$this->Look_up_model->getCategory(3);
            $data['brlist']=$this->Look_up_model->getBrand();
            $data['hlist']=$this->Applications_model->getAccountHead();
            $data['display']='medical/additems';
            $this->load->view('admin/master',$data);
         }

    }
    function delete($product_id=FALSE){
      $check=$this->Items_model->delete($product_id);
        if($check){ 
           $this->session->set_userdata('exception','Delete successfully');
         }else{
           $this->session->set_userdata('exception','Delete Failed');
        }
      redirect("medical/Items/lists");
    }

    
    //////////////////AJAX FOR DELETIN PRODUCT/////////////
    function checkMedicineUse($product_id){
        $chk=$this->db->query("SELECT * FROM item_issue_detail 
             WHERE product_id=$product_id")->result();
        if(count($chk)>0){
            echo "EXISTS";
        }else{
            echo "DELETABLE";
        }
    }
    function views($product_id){
      if ($this->session->userdata('user_id')) {
        $data['heading']='Item Details Information';
        $data['info']=$this->Items_model->get_info($product_id);
        $data['display']='common/itemview';
        $this->load->view('admin/master',$data);
        } else {
           redirect("Logincontroller");
        }
    }
   
 }