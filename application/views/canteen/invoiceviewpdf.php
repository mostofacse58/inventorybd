<html>
<header>
<style type="text/css">
body {
  padding: 3px;
   font-size:10px;
   font-family: 'Hiragino Kaku Gothic Pro', 'WenQuanYi Zen Hei', '微軟正黑體', '蘋果儷中黑', Helvetica, Arial, sans-serif;
    }
.tg  {border-collapse:collapse;border-spacing:0;width:150%}
.tg td{
  font-family: 'Hiragino Kaku Gothic Pro', 'WenQuanYi Zen Hei', '微軟正黑體', '蘋果儷中黑', Helvetica, Arial, sans-serif;
  font-size:12px;padding:2px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
.tg th{
  font-family: 'Hiragino Kaku Gothic Pro', 'WenQuanYi Zen Hei', '微軟正黑體', '蘋果儷中黑', Helvetica, Arial, sans-serif;
  font-size:12px;
  font-weight:normal;
  padding:4px 2px;
  border-style:solid;
  border-width:1px;
  overflow:hidden;
  word-break:normal;
}
.tg .tg-s6z2{
  text-align:center;
}
.tg .tg-baqh{
  text-align:center;
  vertical-align:top
}
</style>
</header>
<body>
 <div style="width:100%;overflow:hidden;text-align:center;margin-top: 12px;">
  <p style="line-height: 27px;padding:5px;margin-bottom: 0px;padding-bottom: 0px;font-size: 13px" >
    <b><i> Invoice
    </i></b>
  </p>
</div>
 
<table class="tg">
  <tr>
    <th style="text-align: left;width: 20%;font-size: 15px">Name</th>
    <th style="text-align: left;width: 30%;font-size: 15px"> <?php  echo $this->session->userdata('company_name'); ?></th>
    <th style="text-align: left;width: 20%">Invoice NO</th>
    <th style="text-align: left;width: 30%"> <?php if(isset($info)) echo $info->invoice_no; ?></th>
  </tr>
   <tr>
    <th style="text-align: left">Invoice Date </th>
    <th style="text-align: left"><?php if(isset($info)) echo findDate($info->invoice_date); ?></th>
    <th style="text-align: left">Ref. No </th>
    <th style="text-align: left"><?php if(isset($info)) echo $info->ref_no; ?></th>
  </tr>
  <tr>
    <th style="text-align: left">Type </th> 
    <th style="text-align: left"> <?php 
      if($info->invoice_type==1) echo "BD Canteen";
      elseif($info->invoice_type==2) echo "CN Canteen";
      elseif($info->invoice_type==3) echo "Guest";
      elseif($info->invoice_type==4) echo "8th Floor";
      ?></th>
    <th style="text-align: left">Requisition NO </th>
    <th style="text-align: left"><?php if(isset($info)) echo $info->requisition_no; ?></th>
  </tr>
</table>
<br>
<table class="tg">
  <tr>
    <th style="width:3%;text-align:center">SL</th>
    <th style="width:13%;text-align:center">Item Code</th>
    <th style="width:15%;text-align:center">Item Name 项目名</th>
    <th style="width:10%;text-align:center">Specification</th>
    <th style="width:6%;text-align:center;">Required Qty</th>
    <th style="width:6%;text-align:center;">Invoice Qty</th>
    <th style="width:8%;text-align:center;">Unit</th>
    <th style="width:8%;text-align:center;">Unit Price</th>
    <th style="width:8%;text-align:center;">Amount</th>
    <th style="width:8%;text-align:center;">Actual Qty</th>
    <th style="width:8%;text-align:center;">Actual Amount</th>
    <th style="width:8%;text-align:center;">Audit Qty</th>
    <th style="width:8%;text-align:center;">Audit Amount</th>
    <th style="width:10%;text-align:center;">Remarks</th>
  </tr>
  <?php
  if(isset($detail)){
	   $i=1; 
	  foreach($detail as $value){ 
	 ?>
  <tr>
    <td class="tg-s6z2"><?php echo $i++; ?></td>
    <td class="tg-s6z2"><?php echo $value->product_code;  ?></td>
    <td class=""><?php echo $value->product_name; ?></td>
    <td class="textcenter"><?php echo $value->specification; ?></td>
    <td class="tg-s6z2"><?php echo "$value->required_qty"; ?></td>
    <td class="tg-s6z2"><?php echo "$value->quantity"; ?></td>
    <td class="tg-s6z2"><?php echo "$value->unit_name"; ?></td>
    <td class="tg-s6z2"><?php echo "$value->unit_price"; ?></td>
    <td class="tg-s6z2"><?php echo "$value->amount"; ?></td>
    <td class="tg-s6z2"><?php echo "$value->actualquantity"; ?></td>
    <td class="tg-s6z2"><?php echo $value->actualamount; ?></td>
    <td class="tg-s6z2"><?php echo "$value->auditquantity"; ?></td>
    <td class="tg-s6z2"><?php echo $value->auditamount; ?></td>
    <td class="tg-s6z2"><?php echo "$value->remarks"; ?></td>
  </tr>
   <?php }} ?>
   <tr>
    <td style="text-align: right;" colspan="4">Total Quantity:</td>
    <td style="text-align: center;"><?php echo array_sum(array_column($detail,'required_qty'));; ?></td>
    <td style="text-align: center;"><?php echo array_sum(array_column($detail,'quantity'));; ?></td>
    <td></td>
    <td></td>
    <td style="text-align: center;"><?php echo array_sum(array_column($detail,'amount'));; ?></td>
    <td style="text-align: center;"><?php echo array_sum(array_column($detail,'actualquantity'));; ?></td>
    <td style="text-align: center;"><?php echo array_sum(array_column($detail,'actualamount'));; ?></td>
    <td style="text-align: center;"><?php echo array_sum(array_column($detail,'auditquantity'));; ?></td>
    <td style="text-align: center;"><?php echo array_sum(array_column($detail,'auditamount'));; ?></td>
    <td></td>
  </tr>
</table>
<br><br>
<p>Note:<?php if(isset($info)) echo $info->note; ?></p>
<br>
<table style="width:100%">
  <tr>
  <td style="width:33%;text-align:left">
    <?php if(isset($info)) echo "$info->user_name <br>";
    echo $info->created_at;  ?>
  </td>
  <td style="width:33%;text-align:center">
    <?php if(isset($info)) {
      echo "$info->received_by<br>";
      echo $info->received_date;
      } 
    ?>
  </td>
  <td style="width:33%;text-align:right">
    <?php if(isset($info)) {
      echo "$info->audit_by<br>";
      echo $info->audit_date;
    } 
    ?>
    </td>
  </tr>
  <tr>
  <td style="text-align:left;font-size: 15px;line-height: 5px">-----------------</td>
  <td style="text-align:center;font-size: 15px;line-height: 5px">---------------</td>
  <td style="text-align:right;font-size: 15px;line-height: 5px">----------------</td>
  </tr>
  <tr>
  <td style="text-align:left">Submitted By</td>
  <td style="text-align:center">Received By</td>
  <td style="text-align:right">Audited By</td>
  </tr>

</table>

</body>
<html>