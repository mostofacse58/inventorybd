<div class="row">
        <div class="col-xs-12">
   <div class="box box-primary">
   <div class="box-header">
   <div class="widget-block">
<div class="widget-head">
<h5><?php echo ucwords($heading); ?></h5>
<div class="widget-control pull-right">
<a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" href="<?php echo base_url(); ?>aformat/Deptrequisn/add">
<i class="fa fa-plus"></i>
Add New PI
</a>
</div>
</div>
</div>
</div>
<!-- /.box-header -->
<div class="box-body">
  <form class="form-horizontal" action="<?php echo base_url();?>aformat/Deptrequisn/lists" method="GET" enctype="multipart/form-data">
  <div class="box-body">
    <label class="col-sm-1 control-label">
     PI. NO <span style="color:red;">  </span></label>
      <div class="col-sm-2">
        <input class="form-control" name="pi_no" id="pi_no" value="<?php echo set_value('pi_no'); ?>" placeholder="NO">
      <span class="error-msg"><?php echo form_error("pi_no");?></span>
      </div>
      <div class="col-sm-2">
        <select class="form-control select2" required name="pi_status" id="pi_status">
          <option value="All">All Status</option>
          <option value="1"
            <?php  if(isset($info)) echo 1==$info->pi_status? 'selected="selected"':0; else echo set_select('pi_status',1);?>>
              Draft</option>
            <option value="4"
            <?php  if(isset($info)) echo 4==$info->pi_status? 'selected="selected"':0; else echo set_select('pi_status',4);?>>
              Certified</option>
            <option value="5"
            <?php  if(isset($info)) echo 5==$info->pi_status? 'selected="selected"':0; else echo set_select('pi_status',5);?>>
              Verified</option>
            <option value="6"
            <?php  if(isset($info)) echo 6==$info->pi_status? 'selected="selected"':0; else echo set_select('pi_status',6);?>>
              Received</option>
              <option value="7"
            <?php  if(isset($info)) echo 7==$info->pi_status? 'selected="selected"':0; else echo set_select('pi_status',7);?>>
              Approved</option>
            <option value="8"
            <?php  if(isset($info)) echo 8==$info->pi_status? 'selected="selected"':0; else echo set_select('pi_status',8);?>>
              Reject</option>
        </select>
       <span class="error-msg"><?php echo form_error("pi_status");?></span>
      </div>
      <div class="col-sm-3">
        <button type="submit" class="btn btn-success pull-left"> Search 搜索 </button>
        <a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" href="<?php echo base_url(); ?>aformat/Deptrequisn/lists">All</a>
    </div>
  </div>
  <!-- /.box-body -->
</form>
<div class="table-responsive table-bordered">
<table id="examplse1" class="table table-bordered table-striped" style="width:100%;border:#000" >
    <thead>
    <tr>
      <th style="width:4%;">SN</th>
      <th style="width:10%;">Department</th>
      <th style="width:8%;">REF. NO</th>
      <th style="text-align:center;width:8%;">Type</th>
      <th style="text-align:center;width:8%">PI NO</th>
      <th style="width:8%;">PI Date</th>
      <th style="text-align:center;width:8%">
        Demand Date</th>
      <th style="width:8%;">Promised Date</th>
      <th style="width:10%;">Status 状态</th>
      <th style="width:10%;">Requested by</th>
      <th style="text-align:center;width:5%;">
      Actions 行动</th>
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
      <td class="text-center"><?php echo $row->reference_no; ?></td>
      <td class="text-center"><?php 
      if($row->purchase_type_id==1||$row->purchase_type_id==2) echo "Overseas"; 
            else echo "Local"; ?></td>
      <td class="text-center"><?php echo $row->pi_no; ?></td>
      <td class="text-center"><?php echo findDate($row->pi_date); ?></td>
      <td class="text-center"><?php echo findDate($row->demand_date); ?></td>
      <td class="text-center"><?php echo findDate($row->promised_date); ?></td>
      <td class="text-center">
      <span class="btn btn-xs btn-<?php echo ($row->pi_status==1||$row->pi_status==8)?"danger":"success";?>">
      <?php 
        if($row->pi_status==1) echo "Draft";
        elseif($row->pi_status==3) echo "Submit";
        elseif($row->pi_status==4) echo "Certified";
        elseif($row->pi_status==5) echo "Verified";
        elseif($row->pi_status==6) echo "Received";
        elseif($row->pi_status==7) echo "Approved";
        elseif($row->pi_status==8) echo "Rejected";
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
        <li> <a href="<?php echo base_url()?>dashboard/viewpipdf/<?php echo $row->pi_id;?>" target="_blank"><i class="fa fa-eye tiny-icon"></i>View PDF</a></li>
        <li> <a href="<?php echo base_url()?>dashboard/downloadpiExcel/<?php echo $row->pi_id;?>" target="_blank"><i class="fa fa-eye tiny-icon"></i>View Excel</a></li>
        <li> <a href="<?php echo base_url()?>aformat/Deptrequisn/viewpihtmlonly/<?php echo $row->pi_id;?>" target="_blank"><i class="fa fa-eye tiny-icon"></i>View</a></li>
        <?php if($row->pi_status==1){ ?>
        <li> <a href="<?php echo base_url()?>aformat/Deptrequisn/submit/<?php echo $row->pi_id;?>">
          <i class="fa fa-arrow-circle-o-right tiny-icon"></i>Submit</a></li>
        <li> <a href="<?php echo base_url()?>aformat/Deptrequisn/edit/<?php echo $row->pi_id;?>"><i class="fa fa-edit tiny-icon"></i>Edit 编辑</a></li>
              <?php if($this->session->userdata('delete')=='YES'){ ?>
        <li><a href="#" class="delete" data-pid="<?php echo $row->pi_id;?>"><i class="fa fa-trash-o tiny-icon"></i>Delete 删除</a></li>
          <?php } ?>
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
  job=confirm("Are you sure you want to delete this Inaformation?");
   if(job==true){
  e.preventDefault();
  var rowId=$(this).data('pid');
  location.href="<?php echo base_url();?>aformat/Deptrequisn/delete/"+rowId;
}else{
  return false;
}
});
});//jquery ends here
</script>