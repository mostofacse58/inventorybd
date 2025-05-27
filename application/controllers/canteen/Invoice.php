<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Invoice extends My_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('shipping/Import_model');
        $this->load->model('canteen/Invoice_model');
        
     }
    function lists(){
        $data=array();
        if($this->input->post('perpage')!='') 
        $perpage=$this->input->post('perpage'); else $perpage=20;
        $this->load->library('pagination');
        $config['base_url']=base_url().'canteen/Invoice/lists/';
        $config['suffix'] = '?' . http_build_query($_GET, '', "&");
        $config["uri_segment"] = 4;
        $config['total_rows'] = $this->Invoice_model->get_count();
        $total_rows=$config['total_rows'];
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
        $pagination = $this->pagination->create_links();
        $data['pagination']='<p>We have ' . $total_rows . ' records in ' . $choice . ' pages ' . $pagination . '</p>';
        $data['list']=$this->Invoice_model->lists($config["per_page"],$data['page']);
        $this->form_validation->set_rules('location','Location','trim');
        $this->form_validation->set_rules('employee_name','Name','trim');
        $data['dlist']=$this->Look_up_model->departmentList();
        $data['slist']=$this->Look_up_model->getSupplier();
        ////////////////////////////
        $data['heading']='Invoice List';
        $data['display']='canteen/Invoicelist';
        $this->load->view('admin/master',$data);
      }
    function adInvoice($invoice_id){
      $data['heading']='Edit Receive';
      $data['info']=$this->Invoice_model->get_info($invoice_id);
      $data['dlist']=$this->Look_up_model->departmentList();
      $data['detail']=$this->Invoice_model->getDetails($invoice_id);
      $data['display']='canteen/addiInvoice';
      $this->load->view('admin/master',$data);
    }


    function add(){
      if($this->session->userdata('user_id')) {
        $data['heading']='Add Receive';
        $data['collapse']='YES';
        $data['slist']=$this->Look_up_model->getSupplier();
        $data['clist']=$this->Look_up_model->clist();
        $data['display']='canteen/addiInvoice';
        $this->load->view('admin/master',$data);
      }else{
        redirect("Logincontroller");
      }
    }
    
    function edit($invoice_id){
        if ($this->session->userdata('user_id')) {
        $data['heading']='Edit Receive';
        $data['info']=$this->Invoice_model->get_info($invoice_id);
        $data['slist']=$this->Look_up_model->getSupplier();
        $data['dlist']=$this->Look_up_model->departmentList();
        $data['clist']=$this->Look_up_model->clist();
        $data['blist']=$this->Look_up_model->get_box();
        $data['detail']=$this->Invoice_model->getDetails($invoice_id);
        $data['flist']=$this->Import_model->getdata('shipping_file_style_info');
        $data['display']='canteen/addiInvoice';
        $this->load->view('admin/master',$data);
        } else {
          redirect("Logincontroller");
        }
    }
   function save($invoice_id=FALSE){
      $check=$this->Invoice_model->save($invoice_id);
      if($check && !$invoice_id){
       $this->session->set_userdata('exception','Saved successfully');
       }elseif($check&& $invoice_id){
           $this->session->set_userdata('exception','Update successfully');
       }else{
         $this->session->set_userdata('exception','Submission Failed');
       }
      redirect("canteen/Invoice/lists");
    }
    function delete($invoice_id=FALSE){
      $check=$this->Invoice_model->delete($invoice_id);
        if($check){ 
           $this->session->set_userdata('exception','Delete successfully');
         }else{
           $this->session->set_userdata('exception','Delete Failed');
        }
      redirect("canteen/Invoice/lists");
    }
  ////////////////////////
  public function suggestions(){
        $term = $this->input->get('term', true);
        if (strlen($term) < 1 || !$term) {
            die("<script type='text/javascript'>setTimeout(function(){ window.top.location.href = '" . base_url('dashboard') . "'; }, 10);</script>");
        }
        
        $rows = $this->Invoice_model->getItemSearch($term);
        if ($rows){
          $c = str_replace(".", "", microtime(true));
          $r = 0;
          foreach ($rows as $row) {
            $stock=$row->main_stock;
            $description="Category: $row->category_name";
            $pr[] = array('id' => ($c + $r), 'product_id' =>$row->product_id, 'label' => $row->product_name . " (" . $row->product_code . ")",'category_name' => $row->category_name ,'unit_name' => $row->unit_name,'description' => $description, 'product_name' => $row->product_name,'product_code' => $row->product_code, 'unit_price' => $row->unit_price, 'stock' =>$stock);
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
    function view($invoice_id=FALSE){
        $data['show']=1;
        $data['controller']=$this->router->fetch_class();
        $data['heading']='Invoice Details';
        $data['info']=$this->Invoice_model->get_info($invoice_id);
        $data['detail']=$this->Invoice_model->getDetails($invoice_id);
        $data['display']='canteen/invoiceview';
        $this->load->view('admin/master',$data);
      }
  function viewpdf($invoice_id=FALSE){
    if ($this->session->userdata('user_id')) {
    $data['heading']='Receive Items ';
        $data['info']=$this->Invoice_model->get_info($invoice_id);
        $data['detail']=$this->Invoice_model->getDetails($invoice_id);
        $pdfFilePath='ItemReceiveInvoice'.date('Y-m-d H:i').'.pdf';
        require 'vendor/autoload.php';
        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4', 'margin_left' => 10, 'margin_right' => 10, 'margin_top' => 15, 'margin_bottom' => 10,]);
        $mpdf->useAdobeCJK = true;
        
        $mpdf->autoScriptToLang = true;
        $mpdf->autoLangToFont = true;
        $header = $this->load->view('header', $data, true);
        $html=$this->load->view('canteen/invoiceviewpdf', $data, true);
        $mpdf->setHtmlHeader($header);
        $mpdf->pagenumPrefix = '  Page ';
        $mpdf->pagenumSuffix = ' - ';
        $mpdf->nbpgPrefix = ' out of ';
        $mpdf->nbpgSuffix = '';
        $mpdf->setFooter('{DATE H:i:s j/m/Y}{PAGENO}{nbpg}');
        $mpdf->WriteHTML($html);
        $mpdf->Output($pdfFilePath,'D');
    } else {
       redirect("Logincontroller");
    }
  }
  public function getReqInfo(){
    $requisition_no = $this->input->post('requisition_no');
    $requisition_no=str_replace(" ","",$requisition_no);
    $info=$this->db->query("SELECT pm.*  
        FROM  canteen_requisition_master pm 
        WHERE pm.requisition_no='$requisition_no' 
        AND pm.requisition_status!=5 
        AND pm.requisition_status=3")->row();

    if(count($info)>0){
      $data=array('check'=>'YES',
        'requisition_id'=>$info->requisition_id,
        'for_canteen'=>$info->for_canteen);
    }else{
      $data=array('check'=>'NO');
    }
    echo  json_encode($data);
  }
  public function getReqwiseitem(){
      $requisition_no = $this->input->post('requisition_no');
      $requisition_no=str_replace(" ","",$requisition_no);
      $detail=$this->db->query("SELECT pm.*,prd.*,prd.required_qty   
        FROM canteen_requisition_item_details prd,
        canteen_requisition_master pm
        WHERE pm.requisition_id=prd.requisition_id 
        AND pm.requisition_status=3
        AND pm.requisition_no='$requisition_no' 
        ORDER BY prd.product_code ASC ")->result();
      //print_r($detail); exit;
      $i=0;
      $id=0;
      ///////////////
      if(isset($detail)):
        foreach ($detail as  $value) {
          $product_id=$value->product_id;
          $requisition_no=$value->requisition_no;
          $inquantity=$this->db->query("SELECT IFNULL(SUM(pud.quantity),0) as inquantity
         FROM canteen_invoice_item_details pud, canteen_invoice_master pum 
         WHERE pum.invoice_id=pud.invoice_id 
         AND pum.requisition_no='$requisition_no' 
         AND pud.product_id=$product_id  
         AND pum.invoice_status!=5 
         AND pum.requisition_no='$requisition_no' ")->row('inquantity');

         $quantity=$value->required_qty-$inquantity;
          if($quantity>0){
          $str='<tr id="row_' . $id . '"><td style="text-align:center"><input type="hidden" value="'.$value->product_id.'" name="product_id[]"  id="product_id_' . $id . '"/><b>' . ($id +1).'</b></td> <td> <input type="text" name="product_name[]" readonly class="form-control" placeholder="'.$value->product_name.'" value="'.$value->product_name.'"  style="margin-bottom:5px;width:98%" id="product_item_'  .$id. '"> </td>';
          $str.='<td><input type="text" name="product_code[]" readonly class="form-control" placeholder="Item Code" value="'.$value->product_code.'"  style="margin-bottom:5px;width:98%" id="product_code_'.$id. '"> </td>';
          $str.='<td><input type="text" name="specification[]" class="form-control" value="'.$value->specification.'"  style="margin-bottom:5px;width:98%" id="specification_'.$id. '"> </td>';

          $str.='<td><input type="text" name="required_qty[]" readonly class="form-control" value="'.$value->required_qty.'"  style="margin-bottom:5px;width:98%" id="required_qty_'.$id. '"/> </td>';
          $str.='<td><input type="text" name="quantity[]" value="'.$quantity.'" onblur="return checkQuantity(' .$id.');" onkeyup="return checkQuantity(' .$id.');" class="form-control"  placeholder="Quantity" style="width:60%;float:left;text-align:center"  id="quantity_' .$id. '"> </td>';
          $str.='<td> <input type="text" name="unit_price[]" readonly class="form-control" placeholder="Unit Price" value="'.$value->unit_price.'" onblur="return calculateRow(' .$id.');" onkeyup="return calculateRow(' .$id.');"  style="margin-bottom:5px;width:98%;text-align:center" id="unit_price_'.$id.'"/> </td>';
          $str.='<td> <input type="text" name="amount[]" readonly class="form-control" placeholder="Amount" value="'.$value->unit_price*$quantity.'"   style="margin-bottom:5px;width:98%;text-align:center" id="amount_'.$id.'"> </td>';

          $str.='<td> <a class="btn btn-danger btn-xs" onclick="return deleter('. $id .');" style="margin-top:5px;"><i class="fa fa-trash-o"></i></a></td></tr>';
             echo $str;
        $id++;
        }
       }
      endif;
    }
    function submit($invoice_id=FALSE){
      $check=$this->Invoice_model->submit($invoice_id);
      if($check){ 
        $this->session->set_userdata('exception','Send successfully');
       }else{
        $this->session->set_userdata('exception','Send Failed');
      }
      redirect("canteen/Invoice/lists");
    }

    //////////////////AJAX FOR DELETIN PRODUCT/////////////
    function checkItemsUse($invoice_id){
      $chk=$this->db->query("SELECT pd.* FROM canteen_invoice_item_details pd
           WHERE pd.invoice_id=$invoice_id 
           AND pd.FIFO_CODE IN (SELECT u.FIFO_CODE FROM spares_use_detail u 
           WHERE pd.product_id=u.product_id) ")->result();

      $chk2=$this->db->query("SELECT pd.* FROM canteen_invoice_item_details pd
           WHERE  pd.invoice_id=$invoice_id 
           AND pd.FIFO_CODE IN (SELECT u.FIFO_CODE FROM item_issue_detail u 
           WHERE pd.product_id=u.product_id) ")->result();

      if((count($chk)+count($chk2))>0){
          echo "EXISTS";
      }else{
          echo "DELETABLE";
      }
    }

        
 }