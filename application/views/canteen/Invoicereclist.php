<script src="<?php echo base_url('asset/js/plugins/datepicker/bootstrap-datepicker.js'); ?>"></script>
<script type="text/javascript">
var count = 1
$(function () {
$(document).on('click','input[type=number]',function(){ this.select(); });
  $('.date').datepicker({
      "format": "yyyy-mm-dd",
      "todayHighlight": true,
      "autoclose": true
  });
});
</script>
<div class="row">
        <div class="col-xs-12">
   <div class="box box-primary">
            <div class="box-header">
              <div class="widget-block">
             
<div class="widget-head">
<h5><?php echo ucwords($heading); ?></h5>
<div class="widget-control pull-right">

</div>
</div>
</div>
</div>
  <!-- /.box-header -->
  <div class="box-body">
    
    <form class="form-horizontal" action="<?php echo base_url();?>canteen/Invoicerec/lists" method="GET" enctype="multipart/form-data">

    <div class="form-group">
    <label class="col-sm-1 control-label">Search By </label>
        <div class="col-sm-2">
          <input class="form-control" name="product_code" id="product_code" value="<?php echo set_value('product_code'); ?>" placeholder="ITEM CODE/Name">
        <span class="error-msg"><?php echo form_error("product_code");?></span>
        </div>
        <div class="col-sm-2">
           <input class="form-control" name="requisition_no" id="requisition_no" value="<?php echo set_value('requisition_no'); ?>" placeholder="REQ NO">
          <span class="error-msg"><?php echo form_error("requisition_no");?></span>
        </div>
             <div class="col-sm-3">
          <select class="form-control select2" name="supplier_id" id="supplier_id">
            <option value="All" selected="selected">All Supplier</option>
            <?php 
            foreach($slist as $rows){  ?>
            <option value="<?php echo $rows->supplier_id; ?>" 
              <?php echo $rows->supplier_id==set_value('supplier_id')? 'selected="selected"':0; ?>>
               <?php echo $rows->supplier_name; ?></option>
            <?php }  ?>
          </select>                    
          <span class="error-msg"><?php echo form_error("supplier_id");?></span>
        </div>
        </div>
        <div class="form-group">
          <label class="col-sm-1 control-label">Search By </label>
          <div class="col-sm-2">
           <input class="form-control" name="invoice_no" id="invoice_no" value="<?php echo set_value('invoice_no'); ?>" placeholder="Invoicerec NO">
        <span class="error-msg"><?php echo form_error("invoice_no");?></span>
        </div>
          <label class="col-sm-1 control-label">Date</label>
          <div class="col-sm-2">
          <input type="text" name="from_date" readonly="" class="form-control date" placeholder="From Date" value="<?php  echo set_value('from_date'); ?>">
        </div>
        <div class="col-sm-2">
          <input type="text" name="to_date" readonly="" class="form-control date" placeholder="To Date" value="<?php  echo set_value('to_date'); ?>">
        </div>
        </div>
        <div class="form-group">
          <label class="col-sm-1 control-label"></label>
        <div class="col-sm-3">
          <button type="submit" class="btn btn-success pull-left"> Search 搜索 </button>
          <a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" href="<?php echo base_url(); ?>canteen/Invoicerec/lists">All</a>
      </div>
      </div>
    </form>

      <div class="table-responsive table-bordered">
      <table class="table table-bordered table-striped" style="width:100%;border:#00" >
        <thead>
          <tr>
            <th style="width:3%;">SN</th>
            <th style="width:8%;">Type</th>
            <th style="width:8%;">Date</th>
            <th style="width:8%;">Invoicerec No</th>
            <th style="width:8%;">Requisition. No</th>
            <th style="width:8%;">Ref No</th>
            <th style="width:20%;">Supplier</th>
            <th style="width:12%;">Total Amount</th>
            <th style="width:8%;">Status 状态</th>
            <th style="text-align:center;width:5%;">Actions 行动</th>
          </tr>
        </thead>
        <tbody>
        <?php
        if($list&&!empty($list)): $i=$page+1;
          foreach($list as $row):
              ?>
          <tr>
            <td><?php echo $i++; ?></td>
            <td>
              <?php 
              if($row->invoice_type==1) echo "BD Canteen";
              elseif($row->invoice_type==2) echo "CN Canteen";
              elseif($row->invoice_type==3) echo "Guest";
              elseif($row->invoice_type==4) echo "8Th Floor";
              ?>
            </td>
            <td class="text-center"><?php echo findDate($row->invoice_date); ?></td>
            <td class="text-center"><?php echo $row->invoice_no; ?></td>
            <td class="text-center"><?php echo $row->requisition_no; ?></td>
            <td class="text-center"><?php echo $row->ref_no; ?></td>      
            <td><?php echo "$row->supplier_name";?></td>
            <td class="text-center"><?php echo $row->total_amount; ?></td>
            <td class="text-center">
            <span class="btn btn-xs btn-<?php echo ($row->invoice_status==2||$row->invoice_status==5)?"danger":"success";?>">
              <?php 
              if($row->invoice_status==1) echo "Draft";
              elseif($row->invoice_status==2) echo "Pending";
              elseif($row->invoice_status==3) echo "Received";
              elseif($row->invoice_status==4) echo "Audited";
              elseif($row->invoice_status==8) echo "Cancel";
              ?>
            </span></td>
            <td style="text-align:center">
                <!-- Single button -->
            <div class="btn-group">
              <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
              <i class="fa fa-gear tiny-icon"></i><span class="caret"></span>
              </button>
              <ul class="dropdown-menu pull-right" role="menu">
              <li> <a href="<?php echo base_url()?>canteen/Invoicerec/view/<?php echo $row->invoice_id;?>" target="_blank"><i class="fa fa-eye tiny-icon"></i>View</a></li>
              <li> <a href="<?php echo base_url()?>canteen/Invoicerec/viewpdf/<?php echo $row->invoice_id;?>" target="_blank"><i class="fa fa-eye tiny-icon"></i>PDF</a></li>
              <?php if($row->invoice_status==2){ ?>
              <li><a href="<?php echo base_url()?>canteen/Invoicerec/checkform/<?php echo $row->invoice_id;?>">
                <i class="fa fa-arrow-circle-o-right tiny-icon"></i>Check Qty</a></li>
              <li><a href="<?php echo base_url()?>canteen/Invoicerec/received/<?php echo $row->invoice_id;?>">
                <i class="fa fa-arrow-circle-o-right tiny-icon"></i>Receive</a></li>
              <?php } ?> 
           
              </ul>
            </div>
            </td>
          </tr>
          <?php
          endforeach;
        endif;
        ?>
        </tbody>
        </table>
        <div class="box-tools">
            <?php if(isset($pagination))echo $pagination; ?>
        </div>
        </div>
      </div>
          <!-- /.box-body -->
        </div>
      </div>
 </div>


