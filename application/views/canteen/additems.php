  <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>asset/datepickerbootstrap/css/datepicker.css">
<script type="text/javascript" src="<?php echo base_url();?>asset/datepickerbootstrap/js/bootstrap-datepicker.js"></script>

<script>
 $(document).ready(function(){
  //////////////////date picker//////////////////////
      $('.date').datepicker({
        "format":"dd/mm/yyyy",
        "todayHighlight": true,
        "autoclose":true
      });
  });
</script>

<div class="row">
  <div class="col-md-12">
    <div class="panel panel-success">
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
        <!-- form start -->
    <form class="form-horizontal" action="<?php echo base_url();?>canteen/items/save<?php if(isset($info)) echo "/$info->product_id"; ?>" method="POST" enctype="multipart/form-data">
      <div class="box-body">
        <div class="form-group">
          <label class="col-sm-2 control-label">English Name 英文名称<span style="color:red;">  *</span></label>
          <div class="col-sm-6">
            <input type="text" name="product_name" required class="form-control" placeholder="English Name英文名称" value="<?php if(isset($info->product_name)) echo $info->product_name; else echo set_value('product_name'); ?>">
           <span class="error-msg"><?php echo form_error("product_name");?></span>
          </div>
                           
        </div>
         <div class="form-group">
          <label class="col-sm-2 control-label">Category Name分类名称<span style="color:red;">  *</span></label>
          <div class="col-sm-4">
            <select class="form-control select2" required name="category_id" id="category_id">
              <option value="">Select Category 选择类别</option>
              <?php foreach ($clist as $value) {  ?>
                <option value="<?php echo $value->category_id; ?>"
                  <?php  if(isset($info)) echo $value->category_id==$info->category_id? 'selected="selected"':0; else echo set_select('category_id',$value->category_id);?>>
                  <?php echo $value->category_name; ?></option>
                <?php } ?>
            </select>
           <span class="error-msg"><?php echo form_error("category_id");?></span>
          </div>
          <label class="col-sm-2 control-label">
            Iteam Code物料编码 <span style="color:red;">  </span></label>
          <div class="col-sm-4">
            <input type="text" name="product_code" <?php if(isset($info)) echo ""; ?> placeholder="Iteam Code物料编码" class="form-control" value="<?php if(isset($info)) echo $info->product_code; else echo set_value('product_code'); ?>"> 
            <span class="error-msg"><?php echo form_error("product_code"); ?></span>
          </div>
         
        </div>
        <div class="form-group">
          
          <label class="col-sm-2 control-label">Unit Price单价<span style="color:red;">  *</span></label>
        <div class="col-sm-2">
          <input type="text" name="unit_price" <?php if(isset($info)) echo ""; ?>  class="form-control integerchk" value="<?php if(isset($info)) echo $info->unit_price; else echo set_value('unit_price');  ?>"> 
          <span class="error-msg"><?php echo form_error("unit_price"); ?></span>
        </div>
       <label class="col-sm-2 control-label">Unit单价</label>
           <div class="col-sm-2">
            <select class="form-control select2" name="unit_id" id="unit_id">
              <option value="">Select 选择</option>
              <?php 
              $ulist=$this->db->query("SELECT * FROM product_unit")->result();
              foreach ($ulist as $value) {  ?>
                <option value="<?php echo $value->unit_id; ?>"
                  <?php  if(isset($info)) echo $value->unit_id==$info->unit_id? 'selected="selected"':0; else echo set_select('unit_id',$value->unit_id);?>>
                  <?php echo $value->unit_name; ?></option>
                <?php } ?>
            </select>
           <span class="error-msg"><?php echo form_error("unit_id");?></span>
         </div>
          <label class="col-sm-2 control-label">Currency 货币 </label>
          <div class="col-sm-2">
          <select class="form-control select2" name="currency" id="currency" required="">
              <option value="">Select </option>
              <?php foreach ($culist as $value) {  ?>
                <option value="<?php echo $value->currency; ?>"
                  <?php  if(isset($info)) echo $value->currency==$info->currency? 'selected="selected"':0; else echo set_select('currency',$value->currency);?>>
                  <?php echo $value->currency; ?></option>
                <?php } ?>
            </select>
           <span class="error-msg"><?php echo form_error("currency");?></span>
          </div>
         
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">Picture图片</label>
              <div class="col-sm-3">
                  <input type="file" class="form-control"  name="product_image" accept="image/*" >
                <?php if (isset($info->product_image) &&!empty($info->product_image)) { ?>
                  <div style="margin-top:20px;">
                  <img src="<?php echo base_url(); ?>product/<?php echo $info->product_image ?>" class="img-thumbnail" style="width:100px;height:auto;"/>
                  </div>
                <?php } ?>
                <span>Allow: Max size: 500Kb</span>
              </div>
              <label class="col-sm-3 control-label">Specification</label>
                <div class="col-sm-4">
                  <textarea  name="product_description" class="form-control" rows="2"><?php if(isset($info)) echo $info->product_description; else echo set_value('product_description'); ?> </textarea>
                   <span class="error-msg"><?php echo form_error("product_description");?></span>
                </div>
              </div><!-- ///////////////////// -->
            </div>
        <!-- /.box-body -->
        <div class="box-footer">
           <div class="col-sm-4"><a href="<?php echo base_url(); ?>canteen/items/lists" class="btn btn-info"><i class="fa fa-arrow-circle-o-left" aria-hidden="true"></i> Back</a></div>
           <div class="col-sm-4">
          <button type="submit" class="btn btn-info pull-right">SAVE 保存</button>
          </div>
        </div>
        <!-- /.box-footer -->
      </form>
    </div>
  </div>
   
   </div>
 </div>
 
