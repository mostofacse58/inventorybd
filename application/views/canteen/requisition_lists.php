<script src="<?php echo base_url('asset/js/plugins/datepicker/bootstrap-datepicker.js'); ?>"></script>
<script>
  $(function () {
  $(document).on('click','input[type=number]',function(){ 
    this.select(); 
    });
    $('.date').datepicker({
      "format": "dd/mm/yyyy",
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
        <a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" href="<?php echo base_url(); ?>canteen/Requisition/add">
        <i class="fa fa-plus"></i>
        Add Requisition
        </a>
      </div>
    </div>
  </div>
</div>
            <!-- /.box-header -->
      <div class="box-body">
         <form class="form-horizontal" action="<?php echo base_url();?>canteen/Requisition/lists" method="GET" enctype="multipart/form-data">
          <div class="box-body">
            <div class="row form-group">
              <label class="col-sm-2 control-label">Supplier  <span style="color:red;">  *</span></label>
              <div class="col-sm-2">
            <select class="form-control select2" name="supplier_id" id="supplier_id" required="">
              <option value="All" selected="selected">All</option>
              <?php foreach ($slist as $rows) { ?>
                <option value="<?php echo $rows->supplier_id; ?>" 
                <?php if (isset($supplier_id))
                    echo $rows->supplier_id == $supplier_id? 'selected="selected"' : 0;
                else
                    echo $rows->supplier_id == set_value('supplier_id') ? 'selected="selected"' : 0;
                ?>><?php echo $rows->supplier_name; ?></option>
                    <?php } ?>
                </select>
           <span class="error-msg"><?php echo form_error("supplier_id");?></span>
         </div>
            <label class="col-sm-2 control-label">Req. No <span style="color:red;">  </span></label>
            <div class="col-sm-2">
              <input class="form-control" name="requisition_no" id="requisition_no" value="<?php echo set_value('requisition_no'); ?>" placeholder="NO">
            <span class="error-msg"><?php echo form_error("requisition_no");?></span>
            </div>
            <label class="col-sm-2 control-label">Type   <span style="color:red;">  *</span></label>
           <div class="col-sm-2">
            <select class="form-control" name="for_canteen" id="for_canteen" required="">
              <option value="" selected="selected">Select</option>
              <option value="1"
                <?php if(isset($for_canteen)) echo '1'==$for_canteen? 'selected="selected"':0; else echo set_select('for_canteen','1');?>> For BD Canteen</option>
              <option value="2"
                <?php if(isset($for_canteen)) echo '2'==$for_canteen? 'selected="selected"':0; else echo set_select('for_canteen','2');?>> For CN Canteen</option>
                <option value="3"
                <?php if(isset($for_canteen)) echo '3'==$for_canteen? 'selected="selected"':0; else echo set_select('for_canteen','3');?>>For Guest</option>
              <option value="4"
                <?php if(isset($for_canteen)) echo '4'==$for_canteen? 'selected="selected"':0; else echo set_select('for_canteen','4');?>>For 8th Floor</option>
            </select>
           <span class="error-msg"><?php echo form_error("for_canteen");?></span>
         </div>
           </div>
          <div class="row form-group">
          <label class="col-sm-2 control-label">Demand Date</label>
          <div class="col-sm-2">
          <input type="text" name="from_date" readonly="" class="form-control date" placeholder="From Date" value="<?php  echo  $from_date; ?>">
        </div>
        <div class="col-sm-2">
          <input type="text" name="to_date" readonly="" class="form-control date" placeholder="To Date" value="<?php  echo $to_date; ?>">
        </div>
            <div class="col-sm-2">
              <button type="submit" class="btn btn-success pull-left"> Search 搜索 </button>
          </div>
            <div class="col-sm-2">
                <a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" href="<?php echo base_url(); ?>canteen/Requisition/lists">All</a>
            </div>
          </div>
          </div>
          <!-- /.box-body -->
        </form>
      <div class="table-responsive table-bordered">
      <table id="" class="table table-bordered table-striped" style="width:100%;border:#000">
          <thead>
          <tr>
            <th style="width:4%;">SN</th>
            <th style="width:10%;">For</th>
            <th style="text-align:center;width:10%">Requisition NO</th>
            <th style="width:10%;">Requisition Date</th>
            <th style="text-align:center;width:10%">Demand Date</th>
            <th style="width:10%;">Supplier</th>
            <th style="width:8%;">Status</th>
            <th style="width:10%;">Prepared by</th>
            <th style="text-align:center;width:5%;">Actions 行动</th>
            <th style="width:8%;">Attachment</th>
        </tr>
        </thead>
        <tbody>
        <?php
        if($list&&!empty($list)): $i=1;
          foreach($list as $row):
              ?>
          <tr>
            <td class="text-center"><?php echo $i++; ?></td>
            <td class="text-center">
              <?php 
              if($row->for_canteen==1) echo "BD Canteen";
              elseif($row->for_canteen==2) echo "CN Canteen";
              elseif($row->for_canteen==3) echo "Guest";
              elseif($row->for_canteen==4) echo "8Th Floor";
              ?>
            </td>
            <td class="text-center"><?php echo $row->requisition_no; ?></td>
            <td class="text-center"><?php echo findDate($row->requisition_date); ?></td>
            <td class="text-center"><?php echo findDate($row->demand_date); ?></td>
            <td class="text-center"><?php echo $row->supplier_name; ?></td>
            <td class="text-center">
            <span class="btn btn-xs btn-<?php echo ($row->requisition_status==1)?"danger":"success";?>">
                  <?php 
                  if($row->requisition_status==1) echo "Draft";
                  elseif($row->requisition_status==2) echo "Submitted";
                  elseif($row->requisition_status==3) echo "Received";
                  ?>
              </span></td>
            <td class="text-center"><?php echo $row->user_name; ?></td>
            <td style="text-align:center">
                <!-- Single button -->
            <div class="btn-group">
              <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
              <i class="fa fa-gear tiny-icon"></i><span class="caret"></span>
              </button>
              <ul class="dropdown-menu pull-right" role="menu">
              <li> <a href="<?php echo base_url()?>canteen/Requisition/view2/<?php echo $row->requisition_id;?>" target="_blank"><i class="fa fa-eye tiny-icon"></i>View</a></li>
              <li> <a href="<?php echo base_url()?>canteen/Requisition/view/<?php echo $row->requisition_id;?>" target="_blank"><i class="fa fa-eye tiny-icon"></i>pdf</a></li>
              <?php if($row->requisition_status==1){ ?>
              <li> <a href="<?php echo base_url()?>canteen/Requisition/submit/<?php echo $row->requisition_id;?>">
                <i class="fa fa-arrow-circle-o-right tiny-icon"></i>Submit</a></li>
              <li> <a href="<?php echo base_url()?>canteen/Requisition/edit/<?php echo $row->requisition_id;?>"><i class="fa fa-edit tiny-icon"></i>Edit 编辑</a></li>
              <?php if($this->session->userdata('delete')=='YES'){ ?>
              <li><a href="#" class="delete" data-requisitiond="<?php echo $row->requisition_id;?>"><i class="fa fa-trash-o tiny-icon"></i>Delete 删除</a></li>
              <?php } ?>
              <?php } ?>
              </ul>
            </div>
            </td>
            <td class="text-center">
              <?php if(isset($row) &&!empty($row->attachment)) { ?>
              <a href="<?php echo base_url(); ?>Dashboard/ReqAttach/<?php echo $row->attachment; ?>">Download</a>
            <?php } ?>
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


<script>
$(document).ready (function(){
  ///////////////////  CHECK BEFOR DELETING ATTACHEMNT//////////////////////
$(".delete").click(function(e){
  job=confirm("Are you sure you want to delete this Information?");
   if(job==true){
  e.preventDefault();
  var rowId=$(this).data('requisitiond');
  location.href="<?php echo base_url();?>canteen/Requisition/delete/"+rowId;
}else{
  return false;
}
});
});//jquery ends here
</script>