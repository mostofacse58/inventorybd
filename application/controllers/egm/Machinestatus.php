<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Machinestatus extends My_Controller {
    function __construct()
    {
        parent::__construct();
        
        $this->load->model('me/Machinestatus_model');
     }
      
    function lists(){
      
      $data=array();
      if($this->session->userdata('user_id')){
      //////////////////
      $data=array();
      if($this->input->post('perpage')!='') $perpage=$this->input->post('perpage'); else $perpage=20;
        $this->load->library('pagination');
        $config['base_url']=base_url().'me/Machinestatus/lists/';
        $config["uri_segment"] = 4;
        $config['total_rows'] = $this->Machinestatus_model->get_count();
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
        $data['list']=$this->Machinestatus_model->lists($config["per_page"],$data['page']);
        $this->form_validation->set_rules('line_id','Location','trim');
        $this->form_validation->set_rules('tpm_serial_code','TPM','trim');
        ////////////////////////////
        $data['heading']='Used Machine Status Info';
        $data['display']='me/machinestatuslist';
        $data['flist']=$this->Machinestatus_model->getFloorLine();
        $this->load->view('admin/master',$data);
        } else {
          redirect("Logincontroller");
        }
       }
    function add(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Add Machine Assign';
        $data['mlist']=$this->Machinestatus_model->getUNUSEDMachine();
        $data['flist']=$this->Machinestatus_model->getFloorLine();
        $data['display']='me/addmachinestatus';
        $this->load->view('admin/master',$data);
        } else {
           redirect("Logincontroller");
        }
    }
    function add2(){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Add Machine Assign';
        //$data['mlist']=$this->Machinestatus_model->getUNUSEDMachine();
        $data['flist']=$this->Machinestatus_model->getFloorLine();
        $data['display']='me/addmulti_status';
        $this->load->view('admin/master',$data);
        } else {
           redirect("Logincontroller");
        }
    }
    function edit($product_status_id){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Edit Machine Assign';
        $data['info']=$this->Machinestatus_model->get_info($product_status_id);
        $data['mlist']=$this->Machinestatus_model->getUNUSEDMachine($product_status_id);
        $data['flist']=$this->Machinestatus_model->getFloorLine();
        $data['display']='me/addmachinestatus';
        $this->load->view('admin/master',$data);
        } else {
          redirect("Logincontroller");
        }

    }
   
    function save($product_status_id=FALSE){
        $this->form_validation->set_rules('product_detail_id','Product Name','trim|required');
        $this->form_validation->set_rules('line_id','Location','trim|required');
        $this->form_validation->set_rules('assign_date','Assign Date','trim|required');
        $this->form_validation->set_rules('note','Note','trim');
        $this->form_validation->set_rules('machine_status','Status','trim|required');
         if ($this->form_validation->run() == TRUE) {
            $check=$this->Machinestatus_model->save($product_status_id);
            if($check && !$product_status_id){
               $this->session->set_userdata('exception','Saved successfully');
               }elseif($check&& $product_status_id){
                   $this->session->set_userdata('exception','Update successfully');
               }else{
                 $this->session->set_userdata('exception','Submission Failed');
               }
          redirect("me/Machinestatus/lists");
         }else{
            $data['heading']='Add New Machine Assign';
            if($product_status_id){
              $data['heading']='Edit Machine Assign';
              $data['info']=$this->Machinestatus_model->get_info($product_status_id);  
            }
            $data['mlist']=$this->Machinestatus_model->getUNUSEDMachine($product_status_id);
            $data['flist']=$this->Machinestatus_model->getFloorLine();
            $data['display']='me/addmachinestatus';
            $this->load->view('admin/master',$data);
         }

    }
     function save2(){
          $check=$this->Machinestatus_model->save2();
          $this->session->set_userdata('exception','Saved successfully');
          redirect("me/Machinestatus/lists");
      }
    function delete($product_status_id=FALSE){
      $check=$this->Machinestatus_model->delete($product_status_id);
        if($check){ 
           $this->session->set_userdata('exception','Delete successfully');
         }else{
           $this->session->set_userdata('exception','Delete Failed');
        }
      redirect("me/Machinestatus/lists");
    }

    
    function takeoverForm($product_status_id){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Machine Take Over Form';
        $data['info']=$this->Machinestatus_model->get_info($product_status_id);
        $data['display']='me/takeoverForm';
        $this->load->view('admin/master',$data);
        } else {
          redirect("Logincontroller");
        }
    }
    
    function saveTakeover($product_status_id){
      $data['take_over_status']=2;
      $data['takeover_date']=alterDateFormat($this->input->post('takeover_date'));;
      $data['takeover_man']=$this->session->userdata('user_id');
      $this->db->where('product_status_id', $product_status_id);
      $this->db->update('product_status_info',$data);
      $this->session->set_userdata('exception','Take Over successfully');
      redirect("me/Machinestatus/lists");
    }
    function idle($product_status_id){
        if ($this->session->userdata('user_id')) {
        $check=$this->Machinestatus_model->idle($product_status_id);
        $this->session->set_userdata('exception','This machine idle successfully');
        redirect("me/Machinestatus/lists");
        } else {
          redirect("Logincontroller");
        }
    }
     function underservice(){
        if ($this->session->userdata('user_id')) {
        $check=$this->Machinestatus_model->underservice();
        $this->session->set_userdata('exception','This machine on under service successfully');
        redirect("me/Machinestatus/lists");
        } else {
          redirect("Logincontroller");
        }
    }

   //////////////////AJAX FOR DELETIN PRODUCT/////////////
    function checkDelete($product_status_id){
        $chk=$this->db->query("SELECT * FROM machine_downtime_info 
          WHERE product_status_id=$product_status_id")->result();
        if(count($chk)>0){
            echo "EXISTS";
        }else{
            echo "DELETABLE";
        }
    }

    public function suggestions(){
        $term = $this->input->get('term', true);
        if (strlen($term) < 1 || !$term) {
            die("<script type='text/javascript'>setTimeout(function(){ window.top.location.href = '" . base_url('dashboard') . "'; }, 10);</script>");
        }
        $rows = $this->Machinestatus_model->getUNUSEDMachineList($term);
        if ($rows){
            $c = str_replace(".", "", microtime(true));
            $r = 0;
            foreach ($rows as $row) {
       
                $pr[] = array('id' => ($c + $r), 'product_detail_id' => $row->product_detail_id, 'label' => $row->product_name . " (" . $row->tpm_serial_code . ")", 'tpm_serial_code' => $row->tpm_serial_code ,'product_name' => $row->product_name,'ventura_code' => $row->ventura_code);
                $r++;
            }
            header('Content-Type: application/json');
            die(json_encode($pr));
            exit;
        }else{
            $dsad='';
            header('Content-Type: application/json');
            die(json_encode($dsad));
            exit;
        }
    }
 }