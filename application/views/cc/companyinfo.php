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
<div class="box box-info">
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" action="<?php echo base_url();?>cc/Company/save<?php if(isset($info)) echo "/$info->courier_name_id"; ?>" method="POST" enctype="multipart/form-data">
              <div class="box-body">
                <div class="form-group">
                  <label class="col-sm-2 control-label">Name<span style="color:red;">  *</span></label>
                  <div class="col-sm-3">
                    <input type="text" name="courier_company" class="form-control" placeholder=" Name" value="<?php if(isset($info->courier_company)) echo $info->courier_company; else echo set_value('courier_company'); ?>" autofocus>
                   <span class="error-msg"><?php echo form_error("courier_company");?></span>
                  </div>
                  <label class="col-sm-2 control-label">Address<span style="color:red;"> </span></label>
                  <div class="col-sm-3">
                    <textarea type="text" name="courier_address" class="form-control" placeholder="Address" value=""><?php if(isset($info->courier_address)) echo $info->courier_address; else echo set_value('courier_address'); ?></textarea>
                   <span class="error-msg"><?php echo form_error("courier_address");?></span>
                  </div>
                  <div class="col-sm-2">
                <button type="submit" class="btn btn-success pull-left">SAVE</button>
                </div>
                </div>

              <!-- /.box-body -->
            </form>
          </div>
            <!-- /.box-header -->
            <div class="box-body box">
              <div class="col-md-12">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th style="width:4%" class="text-center">SN</th>
                    <th style="width:20%">Name</th>
                    <th style="width:30%" class="text-center">Address</th>
                    <th  style="text-align:center;width:10%">Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php
                  if($list&&!empty($list)):
                    $i=1;
                      foreach($list as $row):
                          ?>
                      <tr>
                        <td><?php echo $i++;?></td>
                        <td><?php echo $row->courier_company;?></td>
                        <td class="text-center"><?php echo $row->courier_address;?></td>
                        <td style="text-align:center">
                          <a class="btn btn-success" href="<?php echo base_url()?>cc/Company/edit/<?php echo $row->courier_name_id;?>"><i class="fa fa-edit tiny-icon"></i></a>
                          &nbsp;&nbsp;&nbsp;&nbsp;                                        
                        <a href="#" class="btn btn-danger delete" data-pid="<?php echo $row->courier_name_id;?>"><i class="fa fa-trash-o tiny-icon"></i></a>
                        </td>
                      </tr>
                      <?php
                      endforeach;
                  endif;
                  ?>
                  </tbody>
              </table>
            </div>
          </div>
            <!-- /.box-body -->
          </div>
        </div>
 </div>
 <div class="modal modal-danger fade bs-example-modal-sm " tabindex="-1" role="dialog" id="deleteMessage" aria-labelledby="mySmallModalLabel">
  <div class="modal-dialog modal-sm">
      <div class="modal-content">

        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
          <h4 class="modal-title" id="mySmallModalLabel"><i class="fa fa-bell-o"></i> System Alert</h4>
        </div>
        <div class="modal-body">
        Sorry, this Issue To can't be deleted!!
        </div>
      </div><!-- /.modal-content -->
    </div>
  </div>

<script>
$(document).ready (function(){
  ///////////////////  CHECK BEFOR DELETING ATTACHEMNT//////////////////////
$(".delete").click(function(e){
  job=confirm("Are you sure you want to delete this information?");
   if(job==true){
  e.preventDefault();
  var rowId=$(this).data('pid');
  var url=$(this).attr("href");
  location.href="<?php echo base_url();?>cc/Company/delete/"+rowId;
  }
});
});//jquery ends here
</script>
