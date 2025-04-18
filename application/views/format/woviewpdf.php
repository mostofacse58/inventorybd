<html>
<header>
<style type="text/css">
body {
   padding: 3px;
   font-size:12px;
   font-family: 'Hiragino Kaku Gothic Pro', 'WenQuanYi Zen Hei', '微軟正黑體', '蘋果儷中黑', Helvetica, Arial, sans-serif;
    }
.tg  {border-collapse:collapse;border-spacing:0;width:100%}
.tg td{
  font-family: 'Hiragino Kaku Gothic Pro', 'WenQuanYi Zen Hei', '微軟正黑體', '蘋果儷中黑', Helvetica, Arial, sans-serif;
  font-size:10px;padding:2px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
.tg th{
  font-family: 'Hiragino Kaku Gothic Pro', 'WenQuanYi Zen Hei', '微軟正黑體', '蘋果儷中黑', Helvetica, Arial, sans-serif;
  font-size:10px;font-weight:normal;padding:2px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
.tg .tg-s6z2{text-align:center}
.tg .tg-baqh{text-align:center;vertical-align:top}
hr{margin: 5px}
.tg1  {border-collapse:collapse;border-spacing:0;width:100%}
.tg1 td{
  font-family: 'Hiragino Kaku Gothic Pro', 'WenQuanYi Zen Hei', '微軟正黑體', '蘋果儷中黑', Helvetica, Arial, sans-serif;
  font-size:10px;padding:2px;overflow:hidden;word-break:normal;line-height: 18px;overflow: hidden;
}
</style>
</header>
<body>

<div  style="width:100%;float:left;font-size: 30px;text-align: center;overflow:hidden;margin:0;margin-top: 0px;">
<p style="margin:0px 0px;color: #538FD4;line-height: 40px">
<b><?php echo $info->company_name; ?>
</b></p>
</div>
 

<hr style="margin-top: 0px">
<div style="width:100%;overflow:hidden;text-align:center;margin-top: 0px;">
<p style="line-height: 20px;padding: 0px 5px;font-size: 18px;margin:3px 0px;" >
  <b>
    <?php if($info->product_type=='PRODUCT'){ ?>
    <?php if($info->po_type=='BD WO') echo "Workorder 采购单";
       else echo "(Bangladesh Fty)"; ?> 
  <?php }else{ ?>
    Service Order <br>服務訂單
  <?php } ?>
  </b>
</p>
</div>

<table style="width: 100%">
  <?php if($info->po_type=='BD WO'){ ?>

  <tr>
    <td style="width:10%;text-align: left"> 
      To, 
    </td>
    <td style="width:40%;text-align: right;" > 
    </td>
    <td style="width:10%;text-align: left"> 
      WO NO  采购单号:
    </td>
    <td style="width:40%;text-align: right;" > 
       <?php if(isset($info)) echo $info->po_number; ?> 
    </td>
  </tr>

  <tr>
    <td style="text-align: left" colspan="2"> 
       <?php if(isset($info)) echo $info->supplier_name; ?> 
     </td>
     <td>Date日期:</td>
    <td style="text-align: right;" > 
       <?php if(isset($info)) echo findDate($info->po_date); ?> 
    </td>
  </tr>
  <tr>
    <td style="text-align: left"> 
       <?php if(isset($info)) echo $info->company_address; ?> </td>
    <td style="text-align: left" > 
    </td>
  </tr>
  <tr>
    <td style="text-align: left"> 
    Phone:<?php if(isset($info)) echo $info->phone_no; ?> </td>
    <td style="text-align: right;" >
    Product Type 產品類型: <?php if(isset($info)) echo $info->product_type; ?> 
       </td>
  </tr>
<?php }else{ ?>
  <tr>
   <td style="width:12%;text-align: left" valign="top"> 
       Issue Date: 
     </td>
    <td style="width:38%;text-align: left" valign="top"> 
      <?php if(isset($info)) echo $info->po_date; ?> </td>
    <td style="width:12%;text-align: left;"  valign="top"> 
      Issuer: 
      </td>
    <td style="width:38%;text-align: left;" valign="top">
      <?php if(isset($info)) echo "Ventura (HK) Trading Limited"; ?> </td>
  </tr>
  <tr>
   <td style="text-align: left" valign="top"> 
       Page: 
    </td>
    <td style="text-align: left" valign="top"> 
    </td>
    <td style="text-align: left" valign="top"> 
      Attention: 
      </td>
    <td style="text-align: left" valign="top">
      <?php if(isset($info)) echo "Md. Shakhawat Hossen BITON"; ?> Tel-<?php echo "01787670281"; ?> </td>
  </tr>

  <tr>
    <td style="text-align: left" valign="top"> 
       Supplier:
    </td>
    <td style="text-align: left" valign="top"> 
     <?php if(isset($info)) echo "$info->supplier_name <br>$info->company_address"; ?> 
   </td>
    <td style="text-align: left" valign="top"> 
       Ship To:
    </td>
    <td style="text-align: left" valign="top"> 
      <?php echo $info->ship_to; ?> 
    </td>
  </tr>
  <tr>
    <td style="text-align: left" valign="top"> 
     Attention:
     </td>
    <td style="text-align: left" valign="top">
     <?php if(isset($info)) echo $info->dear_name; ?> </td>
    <td style="text-align: left" valign="top"> 
      Tel: 
      </td>
    <td style="text-align: left" valign="top"> 
      <?php if(isset($info)) echo "01787670282"; ?> 
    </td>
  </tr>
  <tr>
    <td style="text-align: left" valign="top"> 
     E-mail:
    </td>
    <td style="text-align: left" valign="top"> 
      <?php if(isset($info)) echo $info->email_address; ?> </td>
    <td style="text-align: left" valign="top"> 
      Bill To:
    </td>
    <td style="text-align: left" valign="top"> 
      <?php if(isset($info)) echo "The Well Leatherware Mfy Ltd"; ?> </td>
  </tr>
<?php } ?>
  
</table>
<br>
<?php if($info->po_type=='BD WO'){ ?>
<p style="width: 100%;margin:3px 0px;text-align: center;"> 
  <strong>Subject  主题:<?php if(isset($info)) echo $info->subject; ?></strong> 
</p>
<p style="width: 100%;margin:3px 0px;"> Dear <?php if(isset($info)) echo $info->dear_name; ?> 
<br>
  <?php if(isset($info)) echo $info->body_content; ?>
</p>
<?php }else{ ?>
  <p style="width: 100%;margin:3px 0px;text-align: center;font-size: 18px;"> 
  <strong>PURCHASE ORDER NO:<?php echo $info->po_number; ?></strong> 
</p>
<?php } ?>
<br>
<table class="tg"  style="overflow: hidden;">
  <thead>
  <tr>
    <th style="width:6%;text-align:center">SN(序号)</th>
    <th style="width:8%;text-align:center">Material Code<br>(物料编码)</th>
    <th style="width:25%;text-align:center">Material Name<br>(物料名称)</th>
    <th style="width:8%;text-align:center">Specification<br>(规格)</th>
    <th style="width:8%;text-align:center">Material Picture<br>(物料图片)</th>
    <th style="width:8%;text-align:center">Qty<br>(数量)</th>
    <th style="width:5%;text-align:center;">Unit(单位)</th>
    <th style="width:7%;text-align:center;">Unit price<br> (单价) <br> <?php if(isset($info)) echo $info->currency; ?></th>
    <th style="width:7%;text-align:center;">Sub Total <br>(总金额) <br><?php if(isset($info)) echo $info->currency; ?></th>
    <th style="width:4%;text-align:center;">PI NO <br>(申请单号)</th>
    <?php if($info->for_department_id==17){ ?>
    <th style="width:8%;text-align:center;">FILE NO</th>
    <th style="width:8%;text-align:center;">Customer<br>(客户)</th>
    <th style="width:8%;text-align:center;">Season<br>(季节)</th>
    <?php } ?>


  </tr>
</thead>
<tbody>
  <?php
  if(isset($detail)){
	   $i=1; 
     $totalqty=0;
	  foreach($detail as $value){ 
     $totalqty=$totalqty+$value->quantity;
	  ?>
  <tr>
    <td class="tg-s6z2"><?php echo $i++; ?></td>
    <td class=""><?php if($value->erp_item_code!='') echo $value->erp_item_code; else echo $value->product_code;  ?></td>
    <td class=""><?php echo $value->product_name; if($value->china_name!='') echo "($value->china_name)";  ?></td>
    <td class=""><?php echo $value->specification;  ?></td>
    <td class="textcenter">
    <?php if (isset($value->product_image)&&!empty($value->product_image)) { ?>
      <a href="<?php echo base_url();?>product/<?php echo $value->product_image; ?>" data-toggle="lightbox" data-title="<?php echo $value->product_name;  ?>" data-gallery="gallery">
    <img src="<?php echo base_url();?>product/<?php echo $value->product_image; ?>" class="img-thumbnail" style="width:70px;height:auto;">
  </a>
    <?php }else{ echo "No Picture";} ?>
  </td>
    <td class="tg-s6z2"><?php echo "$value->quantity"; ?></td>
    <td class="tg-s6z2"><?php echo "$value->unit_name"; ?></td>
    <td class="tg-s6z2"><?php echo $value->unit_price; ?></td>
    <td class="tg-s6z2"><?php echo number_format($value->sub_total_amount,2); ?></td>
    <td class="tg-s6z2"><?php echo "$value->pi_no"; ?></td>
    <?php if($info->for_department_id==17){ ?>
    <td class="tg-s6z2"><?php echo "$value->file_no"; ?></td>
    <td class="tg-s6z2"><?php echo "$info->customer"; ?></td>
    <td class="tg-s6z2"><?php echo "$info->season"; ?></td>
    <?php } ?>
  </tr>
   <?php }
    } ?>
  <tr>
    <th sty colspan="5" style="text-align: right;" >Total</th>
    <th class="tg-s6z2"><?php echo $totalqty; ?></th>
    <th class="tg-s6z2"></th>
    <th class="tg-s6z2"></th>
    <th class="tg-s6z2"><?php echo "$info->subtotal"; ?></th>
    <th class="tg-s6z2"></th>
    <?php if($info->for_department_id==17){ ?>
      <th class="tg-s6z2" colspan="3"></th>
    <?php } ?>

  </tr>
  <tr>
    <th sty colspan="8" style="text-align: right;" >Discount Amount</th>
    <th class="tg-s6z2"><?php echo "$info->discount_amount"; ?></th>
    <th class="tg-s6z2"></th>
    <?php if($info->for_department_id==17){ ?>
      <th class="tg-s6z2" colspan="3"></th>
    <?php } ?>

  </tr>
  <tr>
    <th sty colspan="8" style="text-align: right;" >Grand Total Amount</th>
    <th class="tg-s6z2"><?php echo "$info->total_amount"; ?></th>
    <th class="tg-s6z2"></th>
    <?php if($info->for_department_id==17){ ?>
      <th class="tg-s6z2" colspan="3"></th>
    <?php } ?>
    
  </tr>
</tbody>
</table>
<p style="width: 100%;margin:3px 0px;text-align: left;"> 
  <strong>In Word:<?php if(isset($info)) echo number_to_word($info->total_amount); echo " $info->currency only."; ?></strong> 
</p>
<br>
<p style="width: 100%;margin:5px 0px;text-align: left;line-height: 17px">
<u>Terms & Condition 条款与协议:</u>
</p>
<table class="tg1" style="overflow: hidden;">
  <tr>
  <td style="width: 16%">Delivery Date: </td>
  <td style="width: 84%"><?php if(isset($info)) echo findDate($info->delivery_date); ?></td>
</tr>
<?php if($info->delivery_date2!=''){ ?>
<tr>
  <td style="width: 16%">2nd Delivery Date: </td>
  <td style="width: 84%"><?php if(isset($info)) echo findDate($info->delivery_date2); ?></td>
</tr>
<?php } ?>
<?php if($info->delivery_date3!=''){ ?>
<tr>
  <td style="width: 16%">3rd Delivery Date: </td>
  <td style="width: 84%"><?php if(isset($info)) echo findDate($info->delivery_date3); ?></td>
</tr>
<?php } ?>
<?php if($info->po_type=='BD PO'){ ?>
 <tr>
  <td>Shipping Mode:  </td>
  <td><?php if(isset($info)) echo $info->mode_of_shipment; ?></td>
</tr>
<?php } ?>

 <tr>
  <td>Payment Terms: </td>
  <td><?php if(isset($info)) echo $info->pay_term; ?></td>
</tr>
<tr>
  <td>Payment Disburse: </td>
  <td><?php if(isset($info)) echo $info->credit_days; ?> days credit</td>
</tr>
 <tr>
  <td valign="top">Remarks: </td>
  <td><?php if(isset($info)) echo $info->term_condition; ?></td>
</tr>
</table>

<br>
<br>

<?php if($info->po_type=='BD WO'){   ?>
  <table class="tg1" style="overflow: hidden;">
  <tr>
  <td>&nbsp;</td>
  <td></td>
  <td></td>
</tr>
  <tr>
  <td style="width:33%;text-align:left;">  <?php if($info->po_status>=1) echo "$info->user_name"; ?></td>
  <td style="width:33%;text-align:center;"> <?php if($info->po_status>=4) echo "$info->approved_by"; ?></td>
  <td style="width:34%;text-align:right;"> </td>
  </tr>
 <tr>
  <td style="text-align:left;"> <?php if($info->po_status>=1) echo findDate($info->create_date); ?></td>
  <td style="text-align:center;"> <?php if($info->po_status>=4) echo findDate($info->approved_date); ?></td>
  <td style="text-align:right;"> <?php echo findDate($info->acknow_date); ?></td>
  </tr> 
  <tr>
  <td style="text-align:left;font-size: 15px;line-height: 5px">---------------</td>
  <td style="text-align:center;font-size: 15px;line-height: 5px">----------------</td>
  <td style="text-align:right;font-size: 15px;line-height: 5px">----------------</td>
  </tr>
  <tr>
  <td style="text-align:left;">Prepared by(部门申请人)</td>
  <td style="text-align:center;">Approved by(部门审批人)</td>
  <td style="text-align:right;">Received by(收到的)</td>
  </tr>
</table>

<?php }else{ ?>
  <table class="tg1" style="overflow: hidden;">
  <tr>
  <td>&nbsp;</td>
  <td></td>
  <td></td>
  <td></td>
</tr>
  <tr>
  <td style="width:25%;text-align:left;">  <?php if($info->po_status>=1) echo "$info->user_name"; ?></td>
  <td style="width:25%;text-align:center;">  <?php if($info->po_status>=3) echo "$info->checked_by"; ?></td>
  <td style="width:25%;text-align:center;"> <?php if($info->po_status>=4) echo "$info->approved_by"; ?></td>
  <td style="width:25%;text-align:right;"> </td>
  </tr>
 <tr>
  <td style="text-align:left;"> <?php if($info->po_status>=1) echo findDate($info->create_date); ?></td>
  <td style="text-align:center;"> <?php if($info->po_status>=3) echo findDate($info->checked_datetime); ?></td>
  <td style="text-align:center;"> <?php if($info->po_status>=4) echo findDate($info->approved_date); ?></td>
  <td style="text-align:right;"> <?php echo findDate($info->acknow_date); ?></td>
  </tr> 
  <tr>
  <td style="text-align:left;font-size: 15px;line-height: 5px">---------------</td>
  <td style="text-align:center;font-size: 15px;line-height: 5px">----------------</td>
  <td style="text-align:center;font-size: 15px;line-height: 5px">----------------</td>
  <td style="text-align:right;font-size: 15px;line-height: 5px">----------------</td>
  </tr>
  <tr>
  <td style="text-align:left;">Prepared by(部门申请人)</td>
  <td style="text-align:center;">Checked by(已审核)</td>
  <td style="text-align:center;">Approved by(部门审批人)</td>
  <td style="text-align:right;">Received by(收到的)</td>
  </tr>
</table>

<?php } ?>

</body>
<html>