
<style type="text/css">
  @media print{
    .print{ display:none;}
    .approval_panel{ display:none;}
     .margin_top{ display:none;}
    .rowcolor{ background-color:#CCCCCC !important;}
    body {padding: 3px; font-size:14px}
}
.tg  {border-collapse:collapse;border-spacing:0;width:100%}
.tg td{font-family:Arial, sans-serif;font-size:14px;padding:3px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
.tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:3px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
.tg .tg-s6z2{text-align:center}
.tg .tg-baqh{text-align:center;vertical-align:top}

</style>
<script type="text/javascript">
    function calculateRow(id){
        var unit_price=$("#unit_price_"+id).val();
        var auditquantity=$("#auditquantity_"+id).val();
        if($.trim(auditquantity)==""|| $.isNumeric(auditquantity)==false){
            auditquantity=0;
        }
        if($.trim(unit_price)==""|| $.isNumeric(unit_price)==false){
            unit_price=0;
        }
        var quantityAndPrice=parseFloat($.trim(unit_price))*parseFloat($.trim(auditquantity));
        $("#auditamount_"+id).val(quantityAndPrice.toFixed(2));
    }

</script>
<div class="row">
  <div class="col-xs-12">
   <div class="box box-primary">
      <div class="box-header">
        <div class="widget-block">
       
<div class="widget-head">
<h5><?php echo ucwords($heading); ?></h5>

</div>
</div>
</div>
  <!-- /.box-header -->
  <form class="form-horizontal" action="<?php echo base_url(); ?>canteen/Invoiceaudit/updated<?php if (isset($info)) echo "/$info->invoice_id"; ?>" method="POST" enctype="multipart/form-data" onsubmit="return formsubmit();">
    <div class="box-body">
    <div style="width:100%;overflow:hidden;text-align:center;margin-top: 12px;">
    <p style="line-height: 27px;padding:5px;margin-bottom: 0px;padding-bottom: 0px;font-size: 15px" >
      <b><i> Material Receive Form
      </i></b></p>
    </div>
    <table style="width: 100%" class="tg">
      <tr>
        <th style="text-align: left;width: 20%">Supplier</th>
        <th style="text-align: left;width: 30%"> <?php  echo "$info->supplier_name"; ?></th>
        <th style="text-align: left;width: 20%">INVOICE NO</th>
        <th style="text-align: left;width: 30%"> <?php if(isset($info)) echo $info->invoice_no; ?>
        </th>
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
        <th style="width:6%;text-align:center;">Required Qty</th>
        <th style="width:6%;text-align:center;">Invoice Qty</th>
        <th style="width:8%;text-align:center;">Unit</th>
        <th style="width:8%;text-align:center;">Unit Price</th>
        <th style="width:8%;text-align:center;">Amount</th>
        <th style="width:8%;text-align:center;">Actual Qty</th>
        <th style="width:8%;text-align:center;">Actual Amount</th>
        <th style="width:10%;text-align:center;">Audit Qty</th>
        <th style="width:10%;text-align:center;">Audit Amount</th>
        <th style="width:10%;text-align:center;">Remarks</th>
      </tr>
      <?php
      if(isset($detail)){
         $i=1; 
         $m=0; 
        foreach($detail as $value){ 
       ?>
      <tr>
        <td class="tg-s6z2"><?php echo $i++; ?></td>
        <td class="tg-s6z2"><?php echo $value->product_code;  ?></td>
        <td class=""><?php echo $value->product_name; ?></td>
        <td class="tg-s6z2"><?php echo "$value->required_qty"; ?></td>
        <td class="tg-s6z2"><?php echo "$value->quantity"; ?></td>
        <td class="tg-s6z2"><?php echo "$value->unit_name"; ?></td>
        <td class="tg-s6z2"><?php echo "$value->unit_price"; ?></td>
        <td class="tg-s6z2"><?php echo "$value->amount"; ?></td>
        <td class="tg-s6z2"><?php echo $value->actualquantity; ?></td>
        <td class="tg-s6z2"><?php echo "$value->actualamount"; ?></td>
        <td class="tg-s6z2">
          <input type="hidden" name="item_detail_id[]" value="<?php echo $value->item_detail_id; ?>"  id="item_detail_id_<?php echo $m; ?>">
          <input type="hidden" name="product_id[]" value="<?php echo $value->product_id; ?>"  id="product_id_<?php echo $m; ?>">
          <input type="hidden" name="unit_price[]" value="<?php echo $value->unit_price; ?>"  id="unit_price_<?php echo $m; ?>">
          <input type="text" name="auditquantity[]" onfocus="this.select();" value="<?php echo $value->auditquantity; ?>" onblur="return calculateRow(<?php echo $m; ?>);" onkeyup="return calculateRow(<?php echo $m; ?>);" class="form-control" required  placeholder="auditquantity" style="width:100%;float:left;text-align:center"  id="auditquantity_<?php echo $m; ?>"> 
        </td>
        <td class="tg-s6z2">
          <input type="text" name="auditamount[]" required value="<?php echo $value->auditamount; ?>" readonly class="form-control"  placeholder="auditamount" style="width:100%;float:left;text-align:center"  id="auditamount_<?php echo $m; ?>"> 
        </td>
        <td class="tg-s6z2"><?php echo "$value->remarks"; ?></td>
      </tr>
       <?php $m++;
        }} ?>
       <tr>
        <td style="text-align: right;" colspan="3">Total Quantity:</td>
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
      <td style="width:33%;text-align:center">
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
     </div>
<!-- /.box-body -->
 <div class="box-footer">
      <div class="col-sm-4">
        <a href="<?php echo base_url()?>canteen/<?php echo $controller; ?>/lists" class="btn btn-info">
        <i class="fa fa-arrow-circle-o-left" aria-hidden="true"></i> 
        Back</a></div>
      <div class="col-sm-4">
          <button type="submit" class="btn btn-info pull-right">SAVE 保存</button>
      </div>
  </div>
</div>
</form>
      

</div>
</div>
