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
</div>
</div>
</div>
</div>
<!-- /.box-header -->
<div class="box-body">
  <form class="form-horizontal" action="<?php echo base_url();?>payment/Bareceived/lists" method="GET" enctype="multipart/form-data">
  <div class="box-body">
    <div class="form-group">
    <label class="col-sm-2 control-label">Budget. NO </label>
      <div class="col-sm-2">
        <input class="form-control" name="budget_no" id="budget_no" value="<?php echo set_value('budget_no'); ?>" placeholder="NO">
      <span class="error-msg"><?php echo form_error("budget_no");?></span>
      </div>
      <div class="form-group">
      <label class="col-sm-1 control-label">Date</label>
        <div class="col-sm-2">
        <input type="text" name="from_date" readonly="" class="form-control date" placeholder="From Date" value="<?php  echo set_value('from_date'); ?>">
      </div>
      <div class="col-sm-2">
        <input type="text" name="to_date" readonly="" class="form-control date" placeholder="To Date" value="<?php  echo set_value('to_date'); ?>">
      </div>
      <div class="col-sm-2">
        <button type="submit" class="btn btn-success pull-left"> Search 搜索 </button>
        <a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" href="<?php echo base_url(); ?>payment/Bareceived/lists">All</a>
    </div>
  </div>
  </div>
  <!-- /.box-body -->
</form>
<div class="table-responsive table-bordered">
<table id="examplse1" class="table table-bordered table-striped" style="width:100%;border:#000" >
    <thead>
    <tr>
      <th style="width:4%;">SN</th>
      <th style="width:7%;">Budget NO</th>  
      <th style="width:7%;">Month</th>      
      <th style="text-align:center;width:8%">For Department</th>
      <th style="text-align:center;width:8%">Received Date</th>
      <th style="text-align:center;width:8%">
        Total Amount</th>
      <th style="width:8%;">Status 状态</th>
      <th style="width:10%;">Prep.By</th>
      <th style="text-align:center;width:7%;">
      Actions 行动</th>
  </tr>
  </thead>
  <tbody>
  <?php
  if($lists&&!empty($lists)): $i=1;
    foreach($lists as $row):
    ?>
    <tr>
      <td class="text-center"><?php echo $i++; ?></td>
      <td class="text-center"><?php echo $row->budget_no;?></td>
      <td class="text-center"><?php echo $row->for_month; ?></td>
      <td class="text-center"><?php echo $row->department_name; ?></td>
      <td class="text-center"><?php echo findDate($row->received_date); ?></td>
      <td class="text-center"><?php echo $row->total_amount; ?></td>
      <td class="text-center">
      <span class="btn btn-xs btn-<?php echo ($row->status==1||$row->status==3||$row->status==8)?"danger":"success";?>">
        <?php 
        if($row->status==1) echo "Draft";
        elseif($row->status==2) echo "Pending";
        elseif($row->status==3) echo "Pending";
        elseif($row->status==4) echo "Received";
        elseif($row->status==8) echo "Rejected";
        ?>
      </span></td>
      <td class="text-center"><?php echo getUserName($row->user_id); ?></td>
      <td style="text-align:center">
      <!-- Single button -->
      <div class="btn-group">
        <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
        <i class="fa fa-gear tiny-icon"></i><span class="caret"></span>
        </button>
        <ul class="dropdown-menu pull-right" role="menu">
          <li><a href="<?php echo base_url()?>payment/Bareceived/view/<?php echo $row->master_id;?>">
          <i class="fa fa-eye tiny-icon"></i>View  </a></li>
           <li> <a href="<?php echo base_url()?>payment/Budgeta/loadExcel/<?php echo $row->master_id;?>" target="_blank">
          <i class="fa fa-eye tiny-icon"></i>Excel</a></li>
         <?php if($row->status==3){ ?>
          <li><a href="<?php echo base_url()?>payment/Bareceived/view/<?php echo $row->master_id;?>">
          <i class="fa fa-eye tiny-icon"></i>View & Receive </a></li>
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

