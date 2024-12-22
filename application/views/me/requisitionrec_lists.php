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
        <form class="form-horizontal" action="<?php echo base_url();?>me/Requisitionrec/lists" method="GET" enctype="multipart/form-data">
          <div class="box-body">
            <label class="col-sm-1 control-label">
             Req. NO <span style="color:red;">  </span></label>
              <div class="col-sm-2">
                <input class="form-control" name="requisition_no" id="requisition_no" value="<?php echo set_value('requisition_no'); ?>" placeholder="NO">
              <span class="error-msg"><?php echo form_error("requisition_no");?></span>
              </div>
              <label class="col-sm-1 control-label">
               ITEM CODE <span style="color:red;">  </span></label>
                <div class="col-sm-2">
                  <input class="form-control" name="product_code" id="product_code" value="<?php echo set_value('product_code'); ?>" placeholder="CODE">
                <span class="error-msg"><?php echo form_error("product_code");?></span>
                </div>
                <label class="col-sm-2 control-label">From Department</label>
                <div class="col-sm-2">
                  <select class="form-control select2" name="department_id" id="department_id" onchange='this.form.submit()'>
                  <option value="All" <?php echo 'All'==set_value('department_id')? 'selected="selected"':0; ?>>All</option>
                  <?php 
                  foreach($dlist as $rows){  ?>
                  <option value="<?php echo $rows->department_id; ?>" 
                    <?php echo $rows->department_id==set_value('department_id')? 'selected="selected"':0; ?>>
                     <?php echo $rows->department_name; ?></option>
                  <?php }  ?>
                </select>                    
                <span class="error-msg"><?php echo form_error("department_id");?></span>
                </div>
              <div class="col-sm-2">
                <button type="submit" class="btn btn-success pull-left"> Search 搜索 </button>
                <a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" href="<?php echo base_url(); ?>me/Requisitionrec/lists">All</a>
            </div>
          </div>
          <!-- /.box-body -->
        </form>
      <div class="table-responsive table-bordered">
      <table id="" class="table table-bordered table-striped" style="width:100%;border:#000">
          <thead>
          <tr>
            <th style="width:4%;">SN</th>
            <th style="width:10%;">From Department</th>
            <th style="width:10%;">To Department</th>
            <th style="text-align:center;width:10%">Requisition NO</th>
            <th style="width:10%;">Requisition Date</th>
            <th style="text-align:center;width:10%">Demand Date</th>
            <th style="text-align:center;width:10%">TPM Code</th>
            <th style="width:8%;">Status</th>
            <th style="width:10%;">Prepared by</th>
            <th style="text-align:center;width:5%;">Actions 行动</th>
        </tr>
        </thead>
        <tbody>
        <?php
        if($list&&!empty($list)): $i=1;
          foreach($list as $row):
              ?>
          <tr>
            <td class="text-center"><?php echo $i++; ?></td>
            <td class="text-center"><?php echo $row->department_name; ?></td>
            <td class="text-center">
              <?php echo $row->responsible_department_name; ?></td>
            <td class="text-center"><?php echo $row->requisition_no; ?></td>
            <td class="text-center"><?php echo findDate($row->requisition_date); ?></td>
            <td class="text-center"><?php echo findDate($row->demand_date); ?></td>
            <td class="text-center"><?php echo $row->asset_encoding; ?></td>
            <td class="text-center">
            <span class="btn btn-xs btn-<?php echo ($row->requisition_status==3)?"danger":"success";?>">
              <?php 
             if($row->requisition_status==3) echo "Pending";
             else if($row->requisition_status==4) echo "Received";
            else if($row->requisition_status==5)  echo "Approved";
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
              <li> <a href="<?php echo base_url()?>me/Requisition/view/<?php echo $row->requisition_id;?>" target="_blank">
                <i class="fa fa-eye tiny-icon"></i>View</a></li>
               <li> <a href="<?php echo base_url()?>me/Requisition/viewhtml/<?php echo $row->requisition_id;?>">
                <i class="fa fa-eye tiny-icon"></i>PDF</a></li>
              <?php if($row->requisition_status==3){ ?>
              <li><a href="<?php echo base_url()?>me/Requisitionrec/received/<?php echo $row->requisition_id;?>">
                <i class="fa fa-arrow-circle-o-right tiny-icon"></i>
              Receive</a></li>
              <li><a href="<?php echo base_url()?>me/Requisitionrec/rejected/<?php echo $row->requisition_id;?>">
                <i class="fa fa-arrow-circle-o-right tiny-icon"></i>
              Reject</a></li>
              <li><a href="<?php echo base_url()?>me/Requisitionrec/returns/<?php echo $row->requisition_id;?>">
                <i class="fa fa-arrow-circle-o-right tiny-icon"></i>
              Return</a></li>
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


<script>
$(document).ready (function(){
  ///////////////////  CHECK BEFOR DELETING ATTACHEMNT//////////////////////
$(".delete").click(function(e){
  job=confirm("Are you sure you want to delete this Inmeion?");
   if(job==true){
  e.preventDefault();
  var rowId=$(this).data('requisitiond');
  location.href="<?php echo base_url();?>me/Requisition/delete/"+rowId;
}else{
  return false;
}
});
});//jquery ends here
</script>