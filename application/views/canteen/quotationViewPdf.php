<html>
<style type="text/css">
  @media print{
            .print{ display:none;}
            .approval_panel{ display:none;}
             .margin_top{ display:none;}
            .rowcolor{ background-color:#CCCCCC !important;}
            body {padding: 3px; font-size:12px}
        }
.tg  {border-collapse:collapse;border-spacing:0;width:100%}
.tg td{font-family:Arial, sans-serif;font-size:12px;padding:3px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
.tg th{font-family:Arial, sans-serif;font-size:12px;font-weight:normal;padding:3px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
.tg .tg-s6z2{text-align:center}
.tg .tg-baqh{text-align:center;vertical-align:top}

</style>
<br>
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
    <th style="width:3%;text-align:center">SN</th>
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

<html>