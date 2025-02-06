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
        <a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" href="<?php echo base_url(); ?>canteen/Quotation/add">
        <i class="fa fa-plus"></i>
        Add Quotation
        </a>
      </div>
    </div>
  </div>
</div>
            <!-- /.box-header -->
      <div class="box-body">
         <form class="form-horizontal" action="<?php echo base_url();?>canteen/Quotation/lists" method="GET" enctype="multipart/form-data">
          <div class="box-body">
            <div class="row form-group">
            <label class="col-sm-2 control-label">To Department  <span style="color:red;">  *</span></label>
             <div class="col-sm-2">
              <select class="form-control select2" name="responsible_department" id="responsible_department">
                <option value="">All</option>
                <?php foreach ($dlist as $rows) { ?>
                  <option value="<?php echo $rows->department_id; ?>" 
                  <?php if (isset($info))
                      echo $rows->department_id == $info->responsible_department? 'selected="selected"' : 0;
                  else
                      echo $rows->department_id == set_value('responsible_department') ? 'selected="selected"' : 0;
                  ?>><?php echo $rows->department_name; ?></option>
                      <?php } ?>
                  </select>
             <span class="error-msg"><?php echo form_error("responsible_department");?></span>
           </div>
            <label class="col-sm-2 control-label">
           Req. No <span style="color:red;">  </span></label>
            <div class="col-sm-2">
              <input class="form-control" name="quotation_no" id="quotation_no" value="<?php echo set_value('quotation_no'); ?>" placeholder="NO">
            <span class="error-msg"><?php echo form_error("quotation_no");?></span>
            </div>
           </div>
          <div class="row form-group">
          <label class="col-sm-2 control-label">Demand Date</label>
          <div class="col-sm-2">
          <input type="text" name="from_date" readonly="" class="form-control date" placeholder="From Date" value="<?php  echo set_value('from_date'); ?>">
        </div>
        <div class="col-sm-2">
          <input type="text" name="to_date" readonly="" class="form-control date" placeholder="To Date" value="<?php  echo set_value('to_date'); ?>">
        </div>
            <div class="col-sm-2">
              <button type="submit" class="btn btn-success pull-left"> Search 搜索 </button>
          </div>
            <div class="col-sm-2">
                <a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" href="<?php echo base_url(); ?>canteen/Quotation/lists">All</a>
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
            <th style="width:10%;">From Department</th>
            <th style="width:10%;">To Department</th>
            <th style="width:10%;">Location</th>
            <th style="text-align:center;width:10%">Quotation NO</th>
            <th style="width:10%;">Quotation Date</th>
            <th style="text-align:center;width:10%">Demand Date</th>
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
            <td class="text-center"><?php echo $row->department_name; ?></td>
            <td class="text-center">
              <?php echo $row->responsible_department_name; ?></td>
            <td class="text-center"><?php echo $row->location_name; ?></td>
            <td class="text-center"><?php echo $row->quotation_no; ?></td>
            <td class="text-center"><?php echo findDate($row->quotation_date); ?></td>
            <td class="text-center"><?php echo findDate($row->demand_date); ?></td>
            <td class="text-center">
            <span class="btn btn-xs btn-<?php echo ($row->quotation_status==1)?"danger":"success";?>">
                  <?php 
                  if($row->quotation_status==1) echo "Draft";
                  elseif($row->quotation_status==0) echo "Reject";
                  elseif($row->quotation_status==2) echo "Submitted";
                  elseif($row->quotation_status==3) echo "Verified";
                  elseif($row->quotation_status==4) echo "Approved";
                  else echo "Received";
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
              <li> <a href="<?php echo base_url()?>canteen/Quotation/view2/<?php echo $row->quotation_id;?>" target="_blank"><i class="fa fa-eye tiny-icon"></i>View</a></li>
              <li> <a href="<?php echo base_url()?>canteen/Quotation/view/<?php echo $row->quotation_id;?>" target="_blank"><i class="fa fa-eye tiny-icon"></i>pdf</a></li>
              <li> <a href="<?php echo base_url()?>canteen/Quotation/excelload/<?php echo $row->quotation_id;?>" target="_blank"><i class="fa fa-eye tiny-icon"></i>Excel</a></li>
              <?php if($row->quotation_status==1){ ?>
              <li> <a href="<?php echo base_url()?>canteen/Quotation/submit/<?php echo $row->quotation_id;?>">
                <i class="fa fa-arrow-circle-o-right tiny-icon"></i>Submit</a></li>
              <li> <a href="<?php echo base_url()?>canteen/Quotation/edit/<?php echo $row->quotation_id;?>"><i class="fa fa-edit tiny-icon"></i>Edit 编辑</a></li>
              <?php if($this->session->userdata('delete')=='YES'){ ?>
              <li><a href="#" class="delete" data-quotationd="<?php echo $row->quotation_id;?>"><i class="fa fa-trash-o tiny-icon"></i>Delete 删除</a></li>
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
  var rowId=$(this).data('quotationd');
  location.href="<?php echo base_url();?>canteen/Quotation/delete/"+rowId;
}else{
  return false;
}
});
});//jquery ends here
</script>