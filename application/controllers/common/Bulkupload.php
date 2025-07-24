<?php if ( ! defined('BASEPATH')) exme('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\IOFactory;
class Bulkupload extends My_Controller {
function __construct(){
    parent::__construct();
    $this->load->library('Excel'); //load PHPExcel library 
    $this->load->model('common/Bulkupload_model');
    date_default_timezone_set('Atlantic/Azores');
 }
function addExcel(){
    if ($this->session->userdata('user_id')) {
    $data['heading']='Upload Serial No';
    $data['dlist']=$this->Look_up_model->departmentList();
    $data['slist']=$this->Look_up_model->getSupplier();
    $data['display']='common/bulkupload';
    $this->load->view('admin/master',$data);
    } else {
       redirect("Logincontroller");
    }
}
function save(){
   if ($_FILES['data_file']['name'] != "") {
    $configUpload['upload_path'] = FCPATH . 'asset/excel/';
    $configUpload['allowed_types'] = 'xls|xlsx|csv';
    $configUpload['max_size'] = '500000';
    $this->load->library('upload', $configUpload);
    if($this->upload->do_upload('data_file')) {
    $upload_data = $this->upload->data(); 
    $file_name = $upload_data['file_name'];
    $extension = $upload_data['file_ext']; 

    // $objReader = PHPExcel_IOFactory::createReader('Excel2007'); 
    // $objReader->setReadDataOnly(true);
    // $objPHPExcel = $objReader->load(FCPATH . 'asset/excel/' . $file_name);
    // $totalrows = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();       
    // $objWorksheet = $objPHPExcel->setActiveSheetIndex(0);

    $filePath = './asset/excel/'.  $file_name; // your uploaded file
    $spreadsheet = IOFactory::load($filePath);
    $worksheet = $spreadsheet->getActiveSheet();
    $highestRow = $worksheet->getHighestRow(); 

   // $spreadsheet = IOFactory::load($filePath);
   // $sheet = $spreadsheet->getActiveSheet();
    //$data = $sheet->toArray();

    //print_r($highestRow);   exit;




    $department_id=$this->input->post('department_id');
    if($highestRow>2){
        for ($i = 3; $i <= $highestRow; $i++) {
          $product_name  = $worksheet->getCellByColumnAndRow(1, $i)->getValue();
          $category_name  = $worksheet->getCellByColumnAndRow(3, $i)->getValue();
          $product_code  = $worksheet->getCellByColumnAndRow(4, $i)->getValue();
          $unit_price  = $worksheet->getCellByColumnAndRow(5, $i)->getValue();
          ////////////////Start/////////////
          if($product_name==''&&$category_name==''){
            $this->session->set_userdata('exception_err', "Please fill up all data currectly.");
            redirect("common/Bulkupload/addExcel");
          }
        }



      for ($i = 3; $i <= $highestRow; $i++) {
          $product_name   = $worksheet->getCellByColumnAndRow(2, $i)->getValue(); // B
          $china_name     = $worksheet->getCellByColumnAndRow(3, $i)->getValue(); // C
          $category_name  = $worksheet->getCellByColumnAndRow(4, $i)->getValue(); // D
          $product_code   = $worksheet->getCellByColumnAndRow(5, $i)->getValue(); // E
          $unit_price     = $worksheet->getCellByColumnAndRow(6, $i)->getValue(); // F
          $unit_name      = $worksheet->getCellByColumnAndRow(7, $i)->getValue(); // G
          $stock          = $worksheet->getCellByColumnAndRow(8, $i)->getValue(); // H
          $minstock       = $worksheet->getCellByColumnAndRow(9, $i)->getValue(); // I
          $box_name       = $worksheet->getCellByColumnAndRow(10, $i)->getValue(); // J
          $description    = $worksheet->getCellByColumnAndRow(11, $i)->getValue(); // K

          $category_name = mb_convert_encoding($category_name, 'UTF-8', 'UTF-16LE'); 
          $category_name = mb_convert_encoding($category_name, 'UTF-8', 'UTF-16LE'); 

          // Check product
          $productinfo = $this->Bulkupload_model->checkproduct($product_name, $category_name);
          if ($productinfo != 0) {
              $product_id = $productinfo;
          } else {
              $pdata = array();
              $pdata['product_name']      = $product_name;
              $pdata['china_name']        = $china_name;
              $pdata['category_id']       = $this->Bulkupload_model->checkcat($category_name);
              $pdata['department_id']     = $department_id;
              $pdata['unit_id']           = $this->Bulkupload_model->checkUnit($unit_name);
              $pdata['box_id']            = $this->Bulkupload_model->checklocation($box_name);

              // Generate product code if empty
              if ($product_code == '') {
                  $product_code_count = $this->db->query("
                      SELECT MAX(product_code_count) AS counts 
                      FROM product_info 
                      WHERE department_id = $department_id AND product_type = 2
                  ")->row('counts');

                  $random = strtoupper(substr(md5('ABCDSTSHJUHUHUHUIHUIHIU5454L' . mt_rand(0, 1005)), 0, 3));
                  $pdata['product_code'] = 'CD' . $random . str_pad($product_code_count + 1, 8, '0', STR_PAD_LEFT);
                  $pdata['product_code_count'] = $product_code_count + 1;
              } else {
                  $pdata['product_code'] = $product_code;
              }

              $pdata['product_model']      = $pdata['product_code'];
              $pdata['stock_quantity']     = $stock;
              $pdata['main_stock']         = $stock;
              $pdata['minimum_stock']      = $minstock;
              $pdata['product_type']       = 2;
              $pdata['product_description']= $description;
              $pdata['machine_other']      = 2;

              //print_r($pdata); exit();

              $product_id = $this->Bulkupload_model->insertproduct($pdata);
          }
      }

      unlink('./asset/excel/' . $file_name); 
      $this->session->set_userdata('exception', 'Upload successfully!');
      redirect("common/Bulkupload/addExcel");
    }else{
      $this->session->set_userdata('exception_err', "No data found.");
      redirect("common/Bulkupload/addExcel");
    }
    }else{
      $this->session->set_userdata('exception_err', 'File is required');
      redirect("common/Bulkupload/addExcel");
    }
}

}


}