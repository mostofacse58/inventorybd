<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Quotation extends My_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('canteen/Quotation_model');
     }
    
    function lists(){
      if($this->session->userdata('user_id')) {
      $data=array();
      if($this->input->post('perpage')!='') $perpage=$this->input->post('perpage'); else $perpage=10;
      ////////////////////////////////////
      $this->load->library('pagination');
      $config['base_url']=base_url().'canteen/Quotation/lists/';
      $config['suffix'] = '?' . http_build_query($_GET, '', "&");
      $config["uri_segment"] = 4;
      $config['total_rows'] = $this->Quotation_model->get_count();
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
      ////////////////////////////////////////
      $this->pagination->initialize($config); 
      $data['page'] = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
      $total_rows=$config['total_rows'];
      $pagination = $this->pagination->create_links();
      $data['pagination']='<p>We have ' . $total_rows . ' records in ' . $choice . ' pages ' . $pagination . '</p>';
      $data['list']=$this->Quotation_model->lists($config["per_page"],$data['page'] );
      ////////////////////////////////////////
      $data['heading']='Quotation Lists';
      $data['display']='canteen/quotation_lists';
      $this->load->view('admin/master',$data);
      } else {
        redirect("Logincontroller");
      }
  }
  function add(){
    if($this->session->userdata('user_id')) {
      $data['heading']='Add Quotation';
      $data['display']='canteen/addquotation';
      $this->load->view('admin/master',$data);
    }else{
      redirect("Logincontroller");
    }
  }
  function edit($quotation_id){
    if ($this->session->userdata('user_id')) {
    $data['heading']='Edit Quotation';
    $data['info']=$this->Quotation_model->get_info($quotation_id);
    $data['detail']=$this->Quotation_model->getDetails($quotation_id);
    $data['display']='canteen/addquotation';
    $this->load->view('admin/master',$data);
    } else {
       redirect("Logincontroller");
    }
  }
   function save($quotation_id=FALSE){
      $check=$this->Quotation_model->save($quotation_id);
      if($check && !$quotation_id){
       $this->session->set_userdata('exception','Saved successfully');
       }elseif($check&& $quotation_id){
           $this->session->set_userdata('exception','Update successfully');
       }else{
         $this->session->set_userdata('exception','Submission Failed');
       }
      redirect("canteen/Quotation/lists");
    }
    function delete($quotation_id=FALSE){
      $check=$this->Quotation_model->delete($quotation_id);
        if($check){ 
           $this->session->set_userdata('exception','Delete successfully');
         }else{
           $this->session->set_userdata('exception','Delete Failed');
        }
      redirect("canteen/Quotation/lists");
    }
    
    public function getAllItems(){
      $q_type = $this->input->post('q_type');
      $data=date('Y-m-d');
      if($q_type==1){
        $detail=$this->db->query("SELECT a.*, product_description as specification,
          unit_price as previous_price,
          unit_price as market_price, 0 as operational_cost,0 as pricedifference,u.unit_name
          FROM canteen_product_info a 
          INNER JOIN product_unit u ON(a.unit_id=u.unit_id)
          WHERE category_id=167  
          ORDER BY product_id ASC")->result();
        }else{
        $detail=$this->db->query("SELECT a.*,product_description as specification,
          unit_price as previous_price,
          unit_price as market_price, 0 as operational_cost,0 as pricedifference,u.unit_name
          FROM canteen_product_info a 
          INNER JOIN product_unit u ON(a.unit_id=u.unit_id)
          WHERE  category_id=207  
          ORDER BY product_id ASC")->result();
      }
      print_r($detail);
      
       $i=0;
       $id=0;
        if(isset($detail)):
          foreach ($detail as  $value) {
             $str='<tr id="row_' . $id . '"><td style="text-align:center">
             <input type="hidden" value="'.$value->product_id.'" name="product_id[]"  id="product_id_' . $id . '"/><b>' . ($id +1).'</b></td> <td> '.$value->product_name.' </td>';
            $str.= '<td>'.$value->specification.'</td>';

            $str.= '<td> <label  style="width:98%;float:left">'.$value->unit_name.'</label></td>';

            $str.= '<td> <input type="text" name="previous_price[]" value="'.$value->unit_price.'" readonly class="form-control"  placeholder="previous_price" style="width:60%;float:left;text-align:center"  id="previous_price_' .$id. '"> </td>';

            $str.= '<td><input type="text"  onfocus="this.select();" name="market_price[]"  class="form-control" placeholder="market_price" 
            value="'.$value->market_price.'" onblur="return calculateRow(' .$id.');" onkeyup="return calculateRow(' .$id.');" style="margin-bottom:5px;width:98%;text-align:center" id="market_price_'.$id.'"> </td>';

            $str.= '<td><input type="text"  onfocus="this.select();" name="operational_cost[]"  class="form-control" placeholder="operational_cost" 
            value="'.$value->operational_cost.'" onblur="return calculateRow(' .$id.');" onkeyup="return calculateRow(' .$id.');" style="margin-bottom:5px;width:98%;text-align:center" id="operational_cost_'.$id.'"> </td>';

            $str.= '<td> <input type="text"  onfocus="this.select();" onselect name="profit[]"  class="form-control" placeholder="profit" 
            value="0" onblur="return calculateRow(' .$id.');" onkeyup="return calculateRow(' .$id.');" style="margin-bottom:5px;width:98%;text-align:center" id="profit_'.$id.'"> </td>';

            $str.= '<td><input type="text" readonly name="present_price[]"  class="form-control" placeholder="present_price" 
            value="'.$value->unit_price.'" onblur="return calculateRow(' .$id.');" onkeyup="return calculateRow(' .$id.');" style="margin-bottom:5px;width:98%;text-align:center" id="present_price_'.$id.'"> </td>';

            $str.='<td><input type="text" name="pricedifference[]" readonly class="form-control" placeholder="Rate" 
                value="'.$value->pricedifference.'" style="margin-bottom:5px;width:98%;text-align:center" id="pricedifference_'.$id.'"></td> ';
            $str.= '<td style"text-align:center"><button class="btn btn-danger btn-xs" onclick="return deleter('. $id .');" style="margin-top:5px;"><i class="fa fa-trash-o"></i></button></td></tr>';
            echo $str;
          $id++;
        }
        endif;
    }


    function view($quotation_id=FALSE){
      $data['heading']='Quotation';
      $data['controller']=$this->router->fetch_class();
      $data['info']=$this->Quotation_model->get_info($quotation_id);
      $data['detail']=$this->Quotation_model->getDetails($quotation_id);
      $data['display']='canteen/quotationView';
      $this->load->view('admin/master',$data);
    }

  function viewpdf($quotation_id=FALSE){
    if ($this->session->userdata('user_id')) {
        $data['heading']='Quotation Form';
            $data['info']=$this->Quotation_model->get_info($quotation_id);
            $data['detail']=$this->Quotation_model->getDetails($quotation_id);
            $pdfFilePath='Quotation'.date('Y-m-d H:i').'.pdf';
            require 'vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4', 'margin_left' => 10, 'margin_right' => 10, 'margin_top' => 10, 'margin_bottom' => 15,]);
            $mpdf->useAdobeCJK = true;
            
            $mpdf->autoScriptToLang = true;
            $mpdf->autoLangToFont = true;
            $mpdf->AddPage('L');
            $header = $this->load->view('header', $data, true);
            $footer = $this->load->view('footer', $data, true);
            $html=$this->load->view('canteen/quotationViewPdf', $data, true);
            $mpdf->setHtmlFooter($footer);
            $mpdf->WriteHTML($html);
            $mpdf->Output();
        } else {
           redirect("Logincontroller");
        }
      }
    function excelload($quotation_id=FALSE){
      $data['heading']='Quotation Form';
      $data['info']=$this->Quotation_model->get_info($quotation_id);
      $data['detail']=$this->Quotation_model->getDetails($quotation_id);
      $this->load->view('canteen/quotationExcel', $data);
    }
    function submit($quotation_id=FALSE){
      $check=$this->Quotation_model->submit($quotation_id);
        if($check){ 
           $this->session->set_userdata('exception','Send successfully');
         }else{
           $this->session->set_userdata('exception','Send Failed');
        }
      redirect("canteen/Quotation/lists");
    }

   
 }