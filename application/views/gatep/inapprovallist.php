<style type="text/css">
  .error-msg{display: none;}
</style>
<script type="text/javascript">
var url1="<?php echo base_url(); ?>gatep/Inapproval/lists";
  $(document).ready(function() {
    ////////////////////////////////
    $("#addNewTeam").click(function(){
    var reject_note = $("#reject_note").val();
    var error = 0;
   
    if(reject_note==""){
      $("#reject_note").css({"border-color":"red"});
      $("#reject_note").parent().children("span").show(200).delay(3000).hide(200,function(){
      $("#reject_note").css({"border-color":"#ccc"});
      });
      error=1;
    }
   
    if(error == 0) {
      $("#formId").submit();
      //document.location=url1;
    }

  });
    ////////////////////// CALLING AJAX FOR DELETE PRODUCT/////////
  $(".reject").click(function(e){
    e.preventDefault();
    var rowId=$(this).data('pid');
     $("#gatepass_id").val(rowId);
     $("#TeamModal").modal("show");
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
              <form class="form-horizontal" action="<?php echo base_url();?>gatep/Inapproval/lists" method="GET" enctype="multipart/form-data">
                <div class="form-group">
                  <label class="col-sm-3 control-label">Gate Pass No</label>
                  <div class="col-sm-3">
                    <input type="text" name="gatepass_no" class="form-control" placeholder="Gate Pass No" value="<?php  echo set_value('gatepass_no'); ?>" autofocus>
                  </div>
                  <div class="col-sm-1">
                  <button type="submit" class="btn btn-success pull-left"> Search </button>
                </div>
                <div class="col-sm-1">
                  <a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" href="<?php echo base_url(); ?>gatep/Inapproval/lists">All</a>
                </div>
                </div>
              </form>
            <!-- <div class="table-responsive table-bordered"> -->
              <table id="" class="table table-bordered table-striped" style="width:100%;border:#000" >
                <thead>
              <tr>
              <th style="width:5%;text-align:center">SN</th>
              <th style="text-align:center;width:10%">Department</th>
              <th style="width:8%;text-align:center">Date</th>
              <th style="width:10%;text-align:center">Gatepass No</th>
              <th style="width:10%;text-align:center">Carried Name(ID)</th>
              <th style="text-align:center;width:10%">From</th>
              <th style="text-align:center;width:6%">Status</th>
              <th  style="text-align:center;width:5%">Action</th>
          </tr>
          </thead>
          <tbody>
          <?php
          if($list&&!empty($list)): $i=1;
            foreach($list as $row):
                ?>
            <tr>
            <td style="text-align:center">
              <?php echo $i++; ; ?></td>
            <td><?php echo $row->department_name;?></td>
              <td style="text-align:center">
              <?php echo findDate($row->create_date); ; ?></td>
            <td style="text-align:center"><?php echo $row->gatepass_no;?></td>
            <td style="text-align:center">
              <?php echo "$row->carried_by ($row->employee_id)";  ?></td>
            <td style="text-align:center">
            <?php echo $row->wh_whare;  ?></td>
            <td style="text-align:center">
              <span class="btn btn-xs btn-<?php echo ($row->gatepass_status==3)?"danger":"success";?>">
                  <?php 
                  if($row->gatepass_status==1) echo "Draft";
                  elseif($row->gatepass_status==2) echo "Submit";
                  elseif($row->gatepass_status==3) echo "Pending";
                  elseif($row->gatepass_status==4) echo "Approved";
                  elseif($row->gatepass_status==5) echo "Checkout";
                  elseif($row->gatepass_status==6) echo "Checkin";
                  ?>
              </span>
              </td>
                <td style="text-align:center">
                    <!-- Single button -->
                <div class="btn-group">
                    <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-gear tiny-icon"></i><span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu pull-right" role="menu">
                      <li><a href="<?php echo base_url()?>gatep/Inapproval/view/<?php echo $row->gatepass_id;?>"><i class="fa ffa fa-eye tiny-icon"></i>View</a></li>
                       <?php if($row->gatepass_status==3){  ?>
                     <li><a href="<?php echo base_url()?>gatep/Inapproval/viewapproved/<?php echo $row->gatepass_id;?>">
                      <i class="fa fa-arrow-circle-right tiny-icon"></i>View & Approve</a></li>
                      <li>  <a href="#" data-pid="<?php echo $row->gatepass_id; ?>" class="reject"><i class="fa fa-ban tiny-icon"></i>Decline</a></li>
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

              <!-- </div> -->
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
        Sorry, this Machine can't be deleted.
        </div>
      </div><!-- /.modal-content -->
    </div>
  </div>
  <div class="modal fade " id="TeamModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title text-primary" id="myModalLabel"> Decline Note</h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" id="formId" method="POST" action="<?php echo base_url()?>gatep/Inapproval/decline">
          <div class="form-group">
            <label class="col-sm-4 control-label">Decline Note </label>
            <div class="col-sm-7">
              <textarea class="form-control" name="reject_note" rows="4" id="reject_note" placeholder="Decline Note"></textarea> 
              <span class="error-msg">Decline Note field is required</span>
            </div>
          </div>
       <input type="hidden" name="gatepass_id"  id="gatepass_id">
       </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal"> Close</button>
        <button type="button" class="btn btn-primary" id="addNewTeam"><i class="fa fa-save"></i> Save</button>
      </div>
    </div>
  </div>
</div>
 <style>
.table > caption + thead > tr:first-child > td, .table > caption + thead > tr:first-child > th, .table > colgroup + thead > tr:first-child > td, .table > colgroup + thead > tr:first-child > th, .table > thead:first-child > tr:first-child > td, .table > thead:first-child > tr:first-child > th {
  border: 1px solid #000;
}
.table-bordered > thead > tr > th, .table-bordered > tbody > tr > th, .table-bordered > tfoot > tr > th, .table-bordered > thead > tr > td, .table-bordered > tbody > tr > td, .table-bordered > tfoot > tr > td {
  border: 1px solid #000;
}
br{
  padding: 1px solid #000;
}
</style>
