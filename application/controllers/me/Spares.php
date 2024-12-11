<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Spares extends My_Controller {
    function __construct()
    {
        parent::__construct();
        $this->load->model('payment/Applications_model');
        $this->load->model('me/Spares_model');
     }
    
    function lists(){
      if($this->session->userdata('user_id')) {
      $data=array();
      if($this->input->post('perpage')!='') $perpage=$this->input->post('perpage'); else $perpage=10;
      //////////////////
        $this->load->library('pagination');
        $config['base_url']=base_url().'me/Spares/lists/';
        $config['suffix'] = '?' . http_build_query($_GET, '', "&");
        $config["uri_segment"] = 4;
        $config['total_rows'] = $this->Spares_model->get_count();
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
        $data['list']=$this->Spares_model->lists($config["per_page"],$data['page']);
        ////////////////////////////
        $data['heading']='Spares Info';
        $data['display']='me/spareslist';
        $this->load->view('admin/master',$data);
        } else {
          redirect("Logincontroller");
        }
       }
    function add(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Add New Spares Info';
        $data['clist']=$this->Look_up_model->getCategory(12);
        $data['culist']=$this->Look_up_model->clist();
        $data['mlist']=$this->Look_up_model->getMaterialType();
        $data['hlist']=$this->Applications_model->getAccountHead();
        $data['blist']=$this->Look_up_model->getBrand();
        //$data['mtlist']=$this->Look_up_model->getSparesType();
        $data['display']='me/addspares';
        $this->load->view('admin/master',$data);
        } else {
           redirect("Logincontroller");
        }
        
    }
    function edit($product_id){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Edit Spares Info';
        $data['info']=$this->Spares_model->get_info($product_id);
        $data['clist']=$this->Look_up_model->getCategory(12);
        $data['culist']=$this->Look_up_model->clist();
        $data['hlist']=$this->Applications_model->getAccountHead();
        $data['mlist']=$this->Look_up_model->getMaterialType();
        $data['blist']=$this->Look_up_model->getBrand();
        $data['display']='me/addspares';
        $this->load->view('admin/master',$data);
        } else {
           redirect("Logincontroller");
        }

    }
   
    function save($product_id=FALSE){
        $this->form_validation->set_rules('product_model','Product Model','trim|');
        $this->form_validation->set_rules('product_name','English Name','trim');
        $this->form_validation->set_rules('china_name','Chinese  Name','trim');
        $this->form_validation->set_rules('category_id','Category','trim|required');
         if($product_id==FALSE){
          $this->form_validation->set_rules('product_code','ITEM CODE','trim|is_unique[product_info.product_code]');
        }else{
          $this->form_validation->set_rules('product_code','ITEM CODE','trim|required');
        }
        $this->form_validation->set_rules('mtype_id','Material Type','trim');
        $this->form_validation->set_rules('unit_id','Product Unit','trim|required');
        $this->form_validation->set_rules('product_description','Description','trim|');
        $this->form_validation->set_rules('stock_quantity','Stock Quatity','trim|required');
        $this->form_validation->set_rules('minimum_stock','Maximum Stock Qty','trim|required');
        $this->form_validation->set_rules('safety_stock_qty','Safety Stock Qty','trim|required');
        $this->form_validation->set_rules('unit_price','Unit Price','trim|required');
        $this->form_validation->set_rules('mdiameter','Diameter','trim');
        $this->form_validation->set_rules('mthread_count','Thread Count','trim');
        $this->form_validation->set_rules('box_id','Box Name','trim');
        $this->form_validation->set_rules('mlength','Lenght','trim');
        $this->form_validation->set_rules('bd_or_cn','Country','trim');
         if ($this->form_validation->run() == TRUE) {
            $stock_quantity=$this->input->post('stock_quantity');
            if($product_id!=FALSE){
              $beforeqty=$this->db->query("SELECT stock_quantity FROM  product_info p WHERE  p.product_type=2 AND p.product_id=$product_id")->row('stock_quantity');
            $this->Look_up_model->storecrud("EDIT",$product_id,$stock_quantity,$beforeqty);
            }
            $check=$this->Spares_model->save($product_id);
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
          redirect("me/Spares/lists");
         }else{
            $data['heading']='Add New Spares Info';
            if($product_id){
              $data['heading']='Edit Spares Info';
              $data['info']=$this->Spares_model->get_info($product_id);  
            }
            $data['clist']=$this->Look_up_model->getCategory(12);
            $data['mlist']=$this->Look_up_model->getMaterialType();
            $data['culist']=$this->Look_up_model->clist();
            $data['blist']=$this->Look_up_model->getBrand();
            $data['hlist']=$this->Applications_model->getAccountHead();
            $data['display']='me/addspares';
            $this->load->view('admin/master',$data);
         }

    }
    function delete($product_id=FALSE){
      $check=$this->Spares_model->delete($product_id);
        if($check){ 
           $this->session->set_userdata('exception','Delete successfully');
         }else{
           $this->session->set_userdata('exception','Delete Failed');
        }
      redirect("me/Spares/lists");
    }

    
    //////////////////AJAX FOR DELETIN PRODUCT/////////////
    function checkSparesUse($product_id){
        $chk=$this->db->query("SELECT * FROM spares_use_detail 
             WHERE product_id=$product_id")->result();
        if(count($chk)>0){
            echo "EXISTS";
        }else{
            echo "DELETABLE";
        }
    }
    function views($product_id){
      if ($this->session->userdata('user_id')) {
        $data['heading']='Material Details Information';
        $data['info']=$this->Spares_model->get_info($product_id);
        $data['display']='me/viewMaterialInfo';
        $this->load->view('admin/master',$data);
        } else {
           redirect("Logincontroller");
        }
    }
   
 }