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
<a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" href="<?php echo base_url(); ?>common/Issued/add">
<i class="fa fa-plus"></i>
Add Issue
</a>
</div>
</div>
</div>
</div>
            <!-- /.box-header -->
        <div class="box-body">
          <form class="form-horizontal" action="<?php echo base_url();?>common/Issued/lists" method="GET" enctype="multipart/form-data">
            <div class="form-group">
              <label class="col-sm-1 control-label">Location </label>
              <div class="col-sm-2">
                <select class="form-control select2"  name="location_id" id="location_id">
                  <option value="">All Location</option>
                  <?php
                   foreach ($llist as $value) {  ?>
                    <option value="<?php echo $value->location_id; ?>"
                      <?php  echo set_select('location_id',$value->location_id); ?>>  <?php echo $value->location_name; ?></option>
                    <?php } ?>
                </select>
              </div>
              <div class="col-sm-2">
                <input type="text" name="employee_name" class="form-control" placeholder="Search 搜索 ID NO" value="<?php  echo set_value('employee_name'); ?>" autofocus>
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
              <label class="col-sm-1 control-label">Ref. No </label>
              <div class="col-sm-2">
                <input type="text" name="issue_id" class="form-control" placeholder="Ref" value="<?php  echo set_value('issue_id'); ?>" autofocus>
              </div>
              <div class="col-sm-3">
              <button type="submit" class="btn btn-success pull-left"> Search 搜索 </button>
              <a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" href="<?php echo base_url(); ?>common/Issued/lists">All</a>
            </div>
            </div>
             <!-- /.box-body -->
          </form>
        <div class="table-responsive table-bordered">
          <table id="example12" class="table table-bordered table-striped" style="width:100%;border:#000" >
            <thead>
            <tr>
              <th style="width:4%;">SN</th>
              <th style="width:8%;">For</th>
              <th style="width:8%;">Date</th>
              <th style="text-align:center;width:4%">Ref. No</th>
              <th style="width:8%;">Department</th>
              <th style="width:10%;">Emp. ID</th>
              <th style="width:6%;text-align:center">Location</th>
              <th style="text-align:center;width:10%">Req. No</th>
              <th style="width:8%;">Total Qty</th>
              <th style="width:12%;">Purpose</th>
              <th style="width:12%;">Issued By</th>
               <th style="width:8%;">Status</th>
              <th style="text-align:center;width:5%;">Actions 行动</th>
          </tr>
          </thead>
          <tbody>
          <?php
          if($list&&!empty($list)): $i=$page+1;
            foreach($list as $row):
                ?>
              <tr>
                <td style="text-align:center">
                <?php echo $i++; ?></td>
                <td><?php if($row->issue_type==1) echo "Department"; elseif($row->issue_type==2) echo "Employee"; else echo "Location"; ?></td>
                <td class="text-center">
                  <?php echo findDate($row->issue_date); ?></td>
                <td style="text-align:center;">
                <?php echo $row->issue_id; ?></td>
                <td class="text-center"><?php echo $row->department_name; ?></td>
                <td class="text-center">
                  <?php echo "$row->employee_id"; ?></td>
                <td style="text-align:center">
                <?php echo $row->location_name; ?></td>
                <td style="text-align:center">
                  <?php echo $row->requisition_no; ; ?></td>
                <td class="text-center"><?php echo $row->totalquantity; ?></td>
                <td><?php echo $row->issue_purpose;?></td>
                <td class="text-center"><?php echo $row->user_name; ?></td>
                <td class="text-center">
                <span class="btn btn-xs btn-<?php echo ($row->issue_status==1)?"danger":"success";?>">
                  <?php 
                    if($row->issue_status==1) echo "Sent";
                    elseif($row->issue_status==2) echo "Received";
                    ?>
                </span></td>
                <td style="text-align:center">
                    <!-- Single button -->
                <div class="btn-group">
                    <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-gear tiny-icon"></i><span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu pull-right" role="menu">
                    <li> <a href="<?php echo base_url()?>common/Issued/view/<?php echo $row->issue_id;?>" target="_blank">
                      <i class="fa fa-eye tiny-icon"></i>View</a></li>
                      <?php if($row->issue_status==1){ ?>
                      <li> <a href="<?php echo base_url()?>common/Issued/edit/<?php echo $row->issue_id;?>">
                        <i class="fa fa-edit tiny-icon"></i>Edit 编辑</a></li>
                        <?php if($this->session->userdata('delete')=='YES'){ ?>
                      <li><a href="#" class="delete" data-pid="<?php echo $row->issue_id;?>"><i class="fa fa-trash-o tiny-icon"></i>Delete 删除</a></li>
                    <?php } ?>
                  <?php } ?>
                      <!--  <li> <a href="<?php echo base_url()?>common/Issued/returnback/<?php echo $row->issue_id;?>">
                        <i class="fa fa-arrow-left tiny-icon"></i>Return Back</a></li> -->
                    
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
  job=confirm("Are you sure you want to delete this Information?");
   if(job==true){
  e.preventDefault();
  var rowId=$(this).data('pid');
  location.href="<?php echo base_url();?>common/Issued/delete/"+rowId;
}else{
  return false;
}
});
});//jquery ends here
</script>