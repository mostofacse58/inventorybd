<style type="text/css">
  table td{
  padding: 5px 3px;
}
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
</style>
<div class="row">
  <div class="col-md-12">
   <div class="content-holder">
   <div class="box box-info" style="padding: 10px">
   <div class="table-responsive table-bordered">
<div  style="width:100%;float:left;font-size: 30px;text-align: center;overflow:hidden;margin:0;margin-top: 0px;">
<p style="margin:0px 0px;color: #538FD4">
<b><?php  echo $this->session->userdata('company_name'); ?></b></p>
</div>
 <div style="width:100%;overflow:hidden;text-align:center;margin-top: 12px;">
<p style="line-height: 27px;padding:5px;margin-bottom: 0px;padding-bottom: 0px;font-size: 15px" >
  <b><i>  <?php if($info->q_type==1) echo "BD Canteen Price Quotation"; else echo "Chinese Canteen Price Quotation"; ?>
  </i></b></p>
</div>
<table style="width: 100%">
   <tr>
    <th style="text-align: left;width: 15%" >QUOTATION NO:</th>
    <th style="text-align: left;width: 20%" ><?php if(isset($info)) echo $info->quotation_no; ?></th>
      <th style="text-align: left" >QUOTATION DATE: </th>
      <th style="text-align: left" ><?php if(isset($info)) echo findDate($info->quotation_date); ?></th>
  </tr>
  
</table>
<br>
<table class="tg">
  <tr>
    <th style="width:2%;text-align:center">SN</th>
    <th style="width:15%;text-align:center">Items Name 物料名称</th>
    <th style="width:12%;text-align:center">Specification 规格</th>
    <th style="width:5%;text-align:center;">Unit 單元</th>
    <th style="width:12%;text-align:center;">Previous Rate 以前的价格 </th>
    <th style="width:12%;text-align:center;">Verified market price 经核实的市场价格 </th>
    <th style="width:12%;text-align:center;">Market Price 市价 </th>
    <th style="width:12%;text-align:center;">Operational Cost+AIT 运营成本</th>
    <th style="width:12%;text-align:center;">Profit 利润</th>
    <th style="width:12%;text-align:center;">Present Rate现价 </th>
    <th style="width:12%;text-align:center;">Increase/Decrease 增加/减少</th>
  </tr>
 
  <?php
  if(isset($detail)){
     $i=1;
    foreach($detail as $value){ 
  
    ?>
  <tr>
    <td class="tg-s6z2"><?php echo $i++; ?></td>
    <td class=""><?php echo $value->product_name; ?></td>
    <td class=""><?php echo $value->Specification; ?></td>
    <td class=""><?php echo $value->unit_name; ?></td>
    <td class=""><?php echo $value->previous_price; ?></td>
    <td class=""><?php echo $value->verified_market_price; ?></td>
    <td class=""><?php echo $value->market_price; ?></td>
    <td class=""><?php echo $value->operational_cost; ?></td>
    <td class=""><?php echo $value->profit; ?></td>
    <td class=""><?php echo $value->present_price; ?></td>
    <td class=""><?php echo $value->pricedifference; ?></td>
  </tr>
   <?php }} ?>
 
</table>
<br><br><br>
<table style="width:100%">
  <tr>
  <td style="width:33%;text-align:left">
    <?php echo "$info->user_name<br>";  echo $info->create_date;  ?></td>
  <td style="width:33%;text-align:center;">
    <?php if(isset($info)) {
        echo "$info->verify_id<br>";
        echo $info->verify_date_time;
      } 
    ?>
  </td>
  <td style="width:34%;text-align:right">
    <?php if(isset($info)) {
        echo "$info->approved_id<br>";
        echo $info->approved_date_time;
      } 
    ?>
  </td>
  </tr>
  <tr>
  <td style="text-align:left;font-size: 15px;line-height: 5px">
  -----------------
  </td>
  <td style="text-align:center;font-size: 15px;line-height: 5px">
  -----------------
  </td>
  <td style="text-align:right;font-size: 15px;line-height: 5px">
  ----------------
  </td>
  </tr>
  <tr>
  <td style="text-align:left">Prepared By</td>
  <td style="text-align:center;">Verify By</td>
  <td style="text-align:right">Approved By</td>
  </tr>

</table>
  <div class="box-footer">
    <div class="col-sm-12" style="text-align: center;">
      <a class="btn btn-info" href="<?php echo base_url()?>canteen/<?php echo $controller; ?>/lists">
        <i class="fa fa-arrow-circle-o-left tiny-icon"></i> Back</a>
      <?php if($info->status==2&&$controller=='Vquotation'){ ?>
        <a class="btn btn-info" href="<?php echo base_url()?>canteen/<?php echo $controller; ?>/approved/<?php echo $info->quotation_id;?>">
        <i class="fa fa-check-circle-o  tiny-icon"> </i> Verify done </a>

        <a class="btn btn-danger" href="<?php echo base_url()?>canteen/<?php echo $controller; ?>/returns/<?php echo $info->quotation_id;?>">
          <i class="fa fa-arrow-circle-o-left tiny-icon"></i> Return</a>
      <?php } ?>
      <?php if($info->status==3&&$controller=='Rquotation'){ ?>
        <a class="btn btn-info" href="<?php echo base_url()?>canteen/<?php echo $controller; ?>/approved/<?php echo $info->quotation_id;?>">
        <i class="fa fa-check-circle-o  tiny-icon"> </i> Approved </a>
        <a class="btn btn-danger" href="<?php echo base_url()?>canteen/<?php echo $controller; ?>/returns/<?php echo $info->quotation_id;?>">
          <i class="fa fa-arrow-circle-o-left tiny-icon"></i> Return</a>
      <?php } ?>

      <?php if($info->status==1&&$controller=='Quotation'){ ?>
        <a class="btn btn-info" href="<?php echo base_url()?>canteen/<?php echo $controller; ?>/submit/<?php echo $info->quotation_id;?>">
        <i class="fa fa-check-circle-o  tiny-icon"> </i>Submit</a>
      <?php  } ?>
  </div>



  </div>
 </div>

</div>
</div>
</div>
</div>

<script>
$(document).ready (function(){
  ///////////////////  CHECK BEFOR DELETING ATTACHEMNT//////////////////////
$(".received").click(function(e){
  job=confirm("Are you sure you want to received this Information?");
   if(job==true){
  e.preventDefault();
  var rowId=$(this).data('pid');
  location.href="<?php echo base_url();?>canteen/<?php echo $controller; ?>/received/"+rowId;
}else{
  return false;
}
});
});//jquery ends here
</script>