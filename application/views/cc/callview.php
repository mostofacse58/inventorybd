
<div  style="width:100%;float:left;font-size: 30px;text-align: center;overflow:hidden;margin:0;margin-top: 15px;">
<p style="margin:2px 0px;color: #538FD4">
<b> Ventura Leatherware Mfy (BD) Ltd.</b></p>
</div>
<div style="width:100%;overflow:hidden;font-size: 18px;color: #000;text-align:center">
 <p style="margin:0;text-align:center">
  <b>Uttara EPZ, Nilphamari.</b></p>
 </div>
 <p style="margin:0;text-align:center;font-size: 16px;">
  <b><span style="font-family: cursive;font-size: 22px;">e-</span>Courier Control </b></p>
  <table style="width: 100%">
  <tr>
    <th class="tg-s6z2"style="width: 10%">Department </th>
    <td class="tg-baqh" style="width: 40%">: <?php echo $info->department_name; ?></td>
    <th class="tg-baqh" style="width: 10%">Requisition No:: </th>
    <th class="tg-baqh" style="width: 40%">: <?php echo "$info->requisition_no" ?> </th>
  </tr>
  <tr>
    <th class="tg-s6z2">Date of Issue</th>
    <td class="tg-baqh" >: <?php echo findDate($info->issue_date); ?></td>
    <th class="tg-s6z2">Barcode </th>
    <th class="tg-s6z2">: <?php if($info->requisition_no != '' || $info->requisition_no != NULL) 
    { echo '<img src="'.base_url('dashboard/barcode/'.$info->requisition_no).'" alt="" >'; } ?> </th>
  </tr>
   <tr>
    <th class="tg-s6z2"valign="top">Issuer Name</th>
    <td class="tg-baqh" valign="top">: <?php echo "$info->issuer"; ?> </td>
    <th class="tg-s6z2">Authorised by</th>
    <td class="tg-s6z2">: <?php echo "$info->approved_by_name"; ?></td>
  </tr>
  <tr>
    <th class="tg-s6z2"valign="top">Shipper Name</th>
    <td class="tg-baqh" valign="top">: <?php echo "$info->shipper_name"; ?> </td>
    <th class="tg-s6z2">Ship to Name</th>
    <td class="tg-s6z2">: <?php echo "$info->ship_name"; ?></td>
  </tr>
  <tr>
    <th class="tg-s6z2"valign="top">Shipper Address</th>
    <td class="tg-baqh" valign="top">: <?php echo "$info->shipper_address"; ?> </td>
    <th class="tg-s6z2">Ship Address</th>
    <td class="tg-s6z2">: <?php echo "$info->ship_address"; ?></td>
  </tr>
  <tr>
    <th class="tg-s6z2"valign="top">Shipper Attention</th>
    <td class="tg-baqh" valign="top">: <?php echo "$info->shipper_attention"; ?> </td>
    <th class="tg-s6z2">Ship Attention</th>
    <td class="tg-s6z2">: <?php echo "$info->ship_attention"; ?></td>
  </tr>
  <tr>
    <th class="tg-s6z2"valign="top">Shipper Telephone</th>
    <td class="tg-baqh" valign="top">: <?php echo "$info->shipper_telephone"; ?> </td>
    <th class="tg-s6z2">Ship Telephone</th>
    <td class="tg-s6z2">: <?php echo "$info->ship_telephone"; ?></td>
  </tr>
  <tr>
    <th class="tg-s6z2"valign="top">Shipper Email</th>
    <td class="tg-baqh" valign="top">: <?php echo "$info->shipper_email"; ?> </td>
    <th class="tg-s6z2">Ship Email</th>
    <td class="tg-s6z2">: <?php echo "$info->ship_email"; ?></td>
  </tr>
  <tr>
    <?php if($info->attachment!=''){ ?>
    <th class="tg-s6z2"valign="top">
    Attachment:
    </th>
    <td class="tg-baqh" valign="top">: 
      <a href="<?php echo base_url(); ?>dashboard/gatepassExcel/<?php echo $info->attachment; ?>">Download</a>
    </td>
    <?php } ?>
    
  </tr>
  </table>
  <!-- ///////////////////// -->
<br>
  <table class="tg" style="width: 100%">
  <tr>
  <th style="width:3%;text-align:center">SN</th>
  <th style="width:20%;text-align:center">Particulars</th>
  <th style="width:5%;text-align:center;">Qty</th>
  <th style="width:5%;text-align:center;">Unit </th>
  <th style="width:10%;text-align:center;">Unit Price (USD)</th>
  <th style="width:10%;text-align:center;">Amount(USD)</th>
  <th style="width:10%;text-align:center;">Weight(Kg)</th>
  <th style="width:10%;text-align:center;">Volumetric Weight (Kg)</th>
  </tr>
  <?php
   if(isset($detail)){
  $i=1; $totalqty=0;
  $totalweight=0;
  $totalvolweight=0;
  $totalamount=0;
  foreach($detail as $row){
  $totalqty=$totalqty+ $row->quantity; 
  $totalweight=$totalweight+ $row->weight; 
  $totalvolweight=$totalvolweight+ $row->vol_weight; 
  $totalamount=$totalamount+ $row->amount; 
  ?>
  <tr>
    <td class="tg-baqh" style="text-align:center">
      <?php echo $i++;; ?></td>
    <td class="tg-baqh" ><?php echo $row->particulars; ?></td>
    <td style="text-align:center"><?php echo $row->quantity; ?></td>
    <td class="tg-baqh" style="text-align:center">
      <?php echo $row->unit_name; ?></td>
    <td class="tg-baqh" style="text-align:center">
      <?php echo $row->unit_price; ?></td>
    <td class="tg-baqh" style="text-align:center">
      <?php echo $row->amount; ?></td>
    <td class="tg-baqh" style="text-align:center">
      <?php echo $row->weight; ?></td>
    <td class="tg-baqh" style="text-align:center">
      <?php echo $row->vol_weight; ?></td>
    </tr>
    <?php }
  } ?>
    <tr>
     <td style="text-align: center;" colspan="2">Total</td>
     <td style="text-align: center;"><?php echo $totalqty; ?></td>
     <td></td>
     <td></td>
     <td style="text-align: center;"><?php echo $totalamount; ?></td>
     <td style="text-align: center;"><?php echo $totalweight; ?></td>
     <td style="text-align: center;"><?php echo $totalvolweight; ?></td>
    </tr>
  </table>

  <br>
  <table style="width: 100%">
  <tr>
    <th class="tg-s6z2"style="width: 10%">Demand ETA </th>
    <th class="tg-baqh" style="width: 40%">: <?php echo findDate($info->demand_eta); ?></th>
    <th class="tg-baqh" style="width: 10%">BD ETD </th>
    <th class="tg-baqh" style="width: 40%">: <?php echo findDate($info->bd_eta); ?> </th>
  </tr>
  <tr>
    <th class="tg-s6z2"style="width: 10%">Shipping mode </th>
    <th class="tg-baqh" style="width: 40%">: <?php echo $info->shipping_mode; ?></th>
    <th class="tg-baqh" style="width: 10%">BD Des </th>
    <th class="tg-baqh" style="width: 40%">: <?php echo "$info->bd_des"; ?> </th>
  </tr>
  <tr>
    <th class="tg-s6z2"style="width: 10%">Payment Mode </th>
    <th class="tg-baqh" style="width: 40%">: <?php echo $info->payment_method; ?></th>
    <th class="tg-baqh" style="width: 10%">AWB No </th>
    <th class="tg-baqh" style="width: 40%">: <?php echo "$info->aws_no" ?> </th>
  </tr>
  <tr>
    <th class="tg-s6z2"style="width: 10%">Charges Back to </th>
    <th class="tg-baqh" style="width: 40%">: <?php echo $info->chargeback_name; ?></th>
    <th class="tg-baqh" style="width: 10%">Courier Company </th>
    <th class="tg-baqh" style="width: 40%">: <?php echo $info->courier_company; ?> </th>
  </tr>
  <tr>
    <th class="tg-s6z2"style="width: 10%">Bill Amount </th>
    <th class="tg-baqh" style="width: 40%">: <?php echo $info->bill_amount; ?></th>
    <th class="tg-baqh" style="width: 10%">Payment Status </th>
    <th class="tg-baqh" style="width: 40%">: <?php echo $info->payment_status ?> </th>
  </tr>
  <tr>
    <th class="tg-s6z2"style="width: 10%">Additional Charge </th>
    <th class="tg-baqh" style="width: 40%">: <?php echo $info->additional_charge; ?></th>
    <th class="tg-s6z2"style="width: 10%">Charge Back Status </th>
    <th class="tg-baqh" style="width: 40%">: <?php echo $info->charges_status; ?></th>
    
  </tr>
  <?php if($info->chargeback_id==1){  ?>
  <tr>
    <th class="tg-s6z2"style="width: 10%">Account Name </th>
    <th class="tg-baqh" style="width: 40%">: <?php echo $info->account_name; ?></th>
    <th class="tg-s6z2"style="width: 10%">Account No </th>
    <th class="tg-baqh" style="width: 40%">: <?php echo $info->account_no_vlmbd; ?></th>    
  </tr>
<?php } ?>
</table>
<br><br><br>

  <table style="width:100%">
  <tr>
    <td style="text-align:left;width: 33%">
      <?php if($info->courier_status>=2){ echo $info->user_name; 
        echo "<br>"; echo findDate($info->issue_date); }
      ?></td>
     <td style="text-align:center;width: 33%">
      <?php if($info->courier_status>=4) {
        echo $info->received_by_name; 
          echo "<br>";
          echo findDate($info->received_date);
        }
        ?>
    </td>
     <td style="text-align:right;">
      <?php if($info->courier_status>=3) {
        echo $info->approved_by_name; 
          echo "<br>";
          echo findDate($info->approved_date);
        }
        ?>
      </td>
  </tr>
  <tr>
     <td style="text-align:left;font-size:15px;line-height:5px">
     ---------------------------------</td>
     <td style="text-align:center;font-size:15px;line-height:5px">
     --------------------------------</td>
     <td style="text-align:right;font-size:15px;line-height:5px">
     --------------------------------</td>
  </tr>
  <tr>
  <td style="text-align:left">PREPARED BY</td>
  <td style="text-align:center;">RECEIVED BY</td>
  <td style="text-align:right">APPROVED BY</td>
  </tr>
</table>
<br>
<p style="margin:0;text-align:center">
<?php echo $this->session->userdata('caddress'); ?>                   
</p>
  <!-- ///////////////////// -->
