<div class="row">
        <div class="col-xs-12">
   <div class="box box-primary">
<div class="box-header">
<div class="widget-block">
<div class="widget-head">
<h5><?php echo ucwords($heading); ?></h5>
<div class="widget-control pull-right">
<a class="btn btn-sm btn-primary pull-right" style="margin-right:0px;" href="<?php echo base_url(); ?>Sop/add">
<i class="fa fa-plus"></i>
Add SOP
</a>
</div>
</div>
</div>
</div>
            <!-- /.box-header -->
      <div class="box-body">
      <div class="table-responsive table-bordered">
        <table id="example1" class="table table-bordered table-striped" style="width:100%;border:#00" >
          <thead>
        <tr>
            <th style="width:5%;">SN</th>
            <th style="width:15%;">Menu Name</th>
            <th style="width:35%;">Title </th>
            <th style="text-align:center;width:8%">Download</th>
            <th style="text-align:center;width:8%">Create Date</th> 
            <th  style="text-align:center;width:5%">Action</th>
        </tr>
        </thead>
        <tbody>
        <?php
        if($list&&!empty($list)):$i=1;
          foreach($list as $row):
              ?>
            <tr>
              <td style="text-align:center">
                <?php echo $i++; ; ?></td>
              <td><?php echo $row->menu;?></td>
              <td>
                <?php echo $row->title; ?></td>
              <td><?php if (isset($row->file_1) && !empty($row->file_1)) { ?>
              <a class="btn btn-sm btn-primary" href="<?php echo base_url();?>Sop/fliedownload/<?php echo $row->file_1;?>" style="width:auto;text-decoration: none;"> 
              Download</a>
              <?php }else{ echo "None";} ?></td>
              <td style="text-align:center">
                <?php echo $row->create_date; ?></td>
              <td style="text-align:center">
                  <!-- Single button -->
              <div class="btn-group">
              <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                      <i class="fa fa-gear tiny-icon"></i><span class="caret"></span>
              </button>
              <ul class="dropdown-menu pull-right" role="menu">
              <li>  <a href="<?php echo base_url()?>Sop/edit/<?php echo $row->id;?>"><i class="fa fa-edit tiny-icon"></i>Edit</a></li>
              <?php if($this->session->userdata('delete')=='YES'){ ?>
              <li><a href="<?php echo base_url()?>Sop/delete/<?php echo $row->id;?>" class="delete"  onClick="return doconfirm();">
              <i class="fa fa-trash-o tiny-icon"></i>Delete</a></li>
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
        </div>
      </div>
      <!-- /.box-body -->
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
