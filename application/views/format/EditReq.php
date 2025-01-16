<style type="text/css">
.tg  {border-collapse:collapse;border-spacing:0;width:100%}
.tg td{
  font-family: 'Hiragino Kaku Gothic Pro', 'WenQuanYi Zen Hei', '微軟正黑體', '蘋果儷中黑', Helvetica, Arial, sans-serif;
  font-size:12px;padding:2px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
.tg th{
  font-family: 'Hiragino Kaku Gothic Pro', 'WenQuanYi Zen Hei', '微軟正黑體', '蘋果儷中黑', Helvetica, Arial, sans-serif;
  font-size:12px;font-weight:normal;padding:3px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
.tg .tg-s6z2{text-align:center}
.tg .tg-baqh{text-align:center;vertical-align:top}
hr{margin: 5px}
.tg1  {border-collapse:collapse;border-spacing:0;width:100%}
.tg1 td{
  font-family: 'Hiragino Kaku Gothic Pro', 'WenQuanYi Zen Hei', '微軟正黑體', '蘋果儷中黑', Helvetica, Arial, sans-serif;
  font-size:12px;padding:2px;overflow:hidden;word-break:normal;line-height: 18px;overflow: hidden;}
  .error-msg{display: none;}
  .primary_area1{
  background-color: #fff;
  border-top: 5px dotted #000;
  border-bottom: 5px dotted #000;
  box-shadow: inset 0 -2px 0 0 #000, inset 0 2px 0 0 #000, 0 2px 0 0 #000, 0 -2px 0 0 #000;
  margin-bottom: 1px;
  padding: 10px;
  border-left: 5px;
  border-right: 5px;
  border-left-style:double ;
  border-right-style:double;
  padding-top:0px;
}
 
</style>

<div class="row">
  <div class="col-md-12">
  <form class="form-horizontal" action="<?php echo base_url(); ?>format/Requisitionprice/save<?php if (isset($info)) echo "/$info->requisition_id"; ?>" method="POST" enctype="multipart/form-data" onsubmit="return formsubmit();">

    <div class="box box-info" style="padding: 10px">
      <div class="primary_area1">

     <div class="table-responsive table-bordered"> 
    <div  style="width:100%;float:left;font-size: 30px;text-align: center;overflow:hidden;margin:0;margin-top: 0px;">
      <p style="margin:2px 0px;color: #538FD4">
      <b> <?php echo  $this->session->userdata('company_name'); ?></b></p>
      </div>

 <div style="width:100%;overflow:hidden;text-align:center;margin-top: 0px;">
<p style="line-height: 20px;padding: 3px 5px;font-size: 18px" >
  <b><u> MATERIAL REQUISITION SLIP</u></b></p>
</div>

<hr style="margin-top: 0px;">
<table style="width: 100%">
  <tr>
    <th style="width:50%;text-align: left" > 
      Name : <?php if(isset($info)) echo "$info->employee_name $info->employee_id"; ?></th>
    <th style="width:25%;text-align: left" > 
      SL. No: <?php if(isset($info)) echo $info->requisition_no; ?> </th>
    </tr>
    <tr>
    <th style="text-align: left" > 
      Department: <?php if(isset($info)) echo $info->department_name; ?> </th>
    <th style="text-align: left" > 
     Date日期 : <?php if(isset($info)) echo findDate($info->requisition_date); ?></th>
    </tr>
    <tr>
    <th style="text-align: left" > 
      Demand Date: <?php if(isset($info)) echo  findDate($info->demand_date); ?> 
    </th>
    <th style="text-align: left" > 
     Note : <?php if(isset($info)) echo $info->other_note; ?></th>
  </tr>
  <tr>
    <th style="text-align: left" > 
      Location: <?php if(isset($info)) echo  $info->location_name; ?> 
    </th>
    <th style="text-align: left" > 
      File No: <?php if(isset($info)) echo  $info->file_no; ?> 
    </th>
  </tr>
  <tr>
    <th style="text-align: left" > 
      IE Verify: <?php  echo  $info->ie_verify; ?> 
    </th>
    <?php if($info->attachment!=''){ ?>
    <th class="tg-s6z2" style="" valign="top">
    Attachment:
      <a href="<?php echo base_url(); ?>Dashboard/ReqAttach/<?php echo $info->attachment; ?>">Download</a>
    </th>
    <?php } ?>
  </tr>
   <tr>
    <th style="text-align: left" > 
      ASSET CODE: <?php if(isset($info)) echo  $info->asset_encoding; ?> 
    </th>
    <th style="text-align: left" > 
    </th>
  </tr>
</table>

<br>
<table class="tg">
  <tr>
    <th style="width:3%;text-align:center">SN</th>
    <th style="width:8%;text-align:center">Item code</th>
    <th style="width:15%;text-align:center">Materials Description</th>
    <th style="width:8%;text-align:center">Spacification</th>
    <th style="width:7%;text-align:center;">Unit</th>
    <th style="width:7%;text-align:center;">Colour</th>
    <th style="width:7%;text-align:center;">Req. Qty</th>
    <th style="width:7%;text-align:center;">Unit Price</th>
    <th style="width:7%;text-align:center;">Amount</th>
    <th style="width:7%;text-align:center;">Issued Qty</th>
    <th style="width:12%;text-align:center;">Remarks</th>
  </tr>
  <?php
  if(isset($detail)){
     $i=1; 
     $id=0;
    foreach($detail as $value){ 
    ?>
  <tr>
    <td class="tg-s6z2"><?php echo $i++; ?></td>
    <td class="tg-s6z2"><?php echo $value->product_code;  ?></td>
    <td class=""><?php echo $value->product_name; ?></td>
    <td class="tg-s6z2"><?php echo "$value->specification"; ?></td>
    
    <td class="tg-s6z2"></td>
    <td class="tg-s6z2"><?php echo "$value->required_qty"; ?>
    <input type="hidden" name="requisition_detail_id[]" id="requisition_detail_id<?php echo $id; ?>" value="<?php echo $value->requisition_detail_id; ?>">
    <input type="hidden" name="product_id[]" id="product_id<?php echo $id; ?>" value="<?php echo $value->product_id; ?>">
      <input type="hidden" name="required_qty[]" id="required_qty_<?php echo $id; ?>" value="<?php echo $value->required_qty; ?>">
    </td>
    <td class="tg-s6z2"><?php echo "$value->unit_name"; ?></td>
    <td><input type="text" name="unit_price[]" value="<?php echo $value->unit_price; ?>" onblur="return checkQuantity(<?php echo $id; ?>);" onkeyup="return checkQuantity(<?php echo $id; ?>);" class="form-control integerchk"  placeholder="unit_price" style="width:100%;float:left;text-align:center"  id="unit_price_<?php echo $id; ?>"></td>
    <td><input type="text" name="amount[]" value="<?php echo $value->amount; ?>" readonly onblur="return checkQuantity(<?php echo $id; ?>);" onkeyup="return checkQuantity(<?php echo $id; ?>);" class="form-control"  placeholder="amount" style="width:100%;float:left;text-align:center"  id="amount_<?php echo $id; ?>"></td>
    <td class="tg-s6z2"><?php echo "$value->issued_qty"; ?></td>
    <td class="tg-s6z2"><?php echo "$value->remarks"; ?></td>
  </tr>
   <?php }
 } ?>
</table>
<br><br>
<br><br>
<table style="width:100%">
  <tr>
  <td style="width:20%;text-align:left;"><?php if(isset($info)) echo "$info->requested_by"; ?></td>
  <td style="width:20%;text-align:center"><?php if($info->requisition_status>2) echo "$info->verify_name"; ?></td>
  <td style="width:20%;text-align:center"><?php if($info->requisition_status>3) echo "$info->dept_head"; ?></td>
  <td style="width:20%;text-align:center"><?php if($info->requisition_status>4) echo "$info->approved_by"; ?></td>
  <td style="width:20%;text-align:right"> <?php if($info->requisition_status>4) echo "$info->approved_by"; ?></td>
  </tr>
  <tr>
  <td style="text-align:left;">
    <?php if(isset($info)) echo $info->submited_date_time; ?></td>
  <td style="text-align:center"><?php if($info->requisition_status>2) echo "$info->verify_date"; ?></td>
  <td style="text-align:center"><?php if($info->requisition_status>3) echo "$info->aproved_date_time"; ?></td>

  <td style="text-align:center"><?php if($info->requisition_status>4) echo $info->delivery_date; ?></td>
  <td style="text-align:right"><?php if($info->requisition_status>4) echo $info->delivery_date; ?></td>
  </tr>
  <tr>
  <td style="text-align:left;font-size: 15px;line-height: 5px">-------------</td>
  <td style="text-align:center;font-size: 15px;line-height: 5px">-------------</td>
  <td style="text-align:center;font-size: 15px;line-height: 5px">-------------</td>
  <td style="text-align:center;font-size: 15px;line-height: 5px">--------------</td>
  <td style="text-align:right;font-size: 15px;line-height: 5px">--------------</td>
  </tr>
  <tr>
  <td style="text-align:left;">PREPARED BY</td>
  <td style="text-align:center">VERIFY</td>
  <td style="text-align:center">HEAD OF DEPARTMENT</td>
  <td style="text-align:center">RECEIVED BY</td>
  <td style="text-align:right">DELIVERED BY</td>
  </tr>

</table>

</div>
</div>
<button type="submit" class="btn btn-info pull-right"> <i class="fa fa-save"></i> SAVE 保存</button>
</div>
<!-- end box-info   -->
</form>
</div>
</div>
<script type="text/javascript">
  function checkQuantity(ids){
     var required_qty=parseFloat($("#required_qty_"+ids).val());
     var unit_price=parseFloat($("#unit_price_"+ids).val());
     if($.trim(unit_price)==""|| $.isNumeric(unit_price)==false){
      $("#unit_price_"+ids).val(0);
     }
     var amount=required_qty*unit_price;
     $("#amount_"+ids).val(amount);
  }
</script>


