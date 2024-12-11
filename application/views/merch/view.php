  <script src="<?php echo base_url(); ?>asset/js/print.js"></script>

   <script type="text/javascript">
      // When the document is ready, initialize the link so
      // that when it is clicked, the printable area of the
      // page will print.
      $(function(){
        // Hook up the print link.
        $(".prints").attr( "href", "javascript:void(0)");

        $(".prints").click(function(){
            // Print the DIV.
            $(".primary_area" ).print();
            // Cancel click event.
            return( false );
          });
      });
    </script>
  <style>
        
    @media print{
    .print{ display:none;}
    .approval_panel{ display:none;}
     .margin_top{ display:none;}
    .rowcolor{ background-color:#CCCCCC !important;}
    body {
      font-size:14px;
      padding: 3px;
     }
    }
  .tg  {border-collapse:collapse;border-spacing:0;width: 100%}
.tg td{font-size:14px;font-weight: normal;padding:3px 5px;border-style:solid;border:1px solid #000;overflow:hidden;word-break:normal;}
.tg th{text-align: left;font-size:14px;font-weight:bold;padding:3px 5px;border-style:solid;border:1px solid #000;overflow:hidden;word-break:normal;}
.tg .tg-s6z2{text-align:left}
.tg-s6z25{text-align:right;}
tbody{margin: 0;
  padding: 0}
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
   <div class="box box-info">
         <div class="box-header">
  <div class="widget-block">
    <div class="widget-head">
    <h5><i class="fa fa-eye"></i> 
      <?php echo ucwords($heading); ?>
    </h5>
    <div class="widget-control pull-right">

    </div>
    </div>
    </div>
</div>  
<div class="box-body">
  <div class="primary_area">
<div class="primary_area1">
<div  style="width:100%;float:left;font-size: 30px;text-align: center;overflow:hidden;margin:0;margin-top: 15px;">
<p style="margin:2px 0px;color: #538FD4">
<b> Ventura Leatherware Mfy (BD) Ltd.</b></p>
</div>
<div style="width:100%;overflow:hidden;font-size: 18px;color: #000;text-align:center">
 <p style="margin:0;text-align:center">
  <b>Uttara EPZ, Nilphamari.</b></p>
 </div>
 <p style="margin:0;text-align:center;font-size: 16px;">
  <b><span style="font-family: cursive;font-size: 22px;">e-</span>Invoice </b></p>
  <table style="width: 100%">
    <tr>
      <th class="tg-s6z2"style="width: 20%">Date </th>
      <td class="tg-baqh" style="width: 30%">: <?php echo $info->create_date; ?></td>
      <th class="tg-baqh" style="width: 20%">Invoice No </th>
      <th class="tg-baqh" style="width: 30%">: <?php echo "$info->invoice_no" ?> </th>
    </tr>
    <tr>
      <th class="tg-s6z2" valign="top">Employee ID</th>
      <td class="tg-baqh" valign="top">: <?php echo "$info->employee_idno"; ?> </td>
      <th class="tg-s6z2">Employee Name</th>
      <td class="tg-s6z2">: <?php echo "$info->employee_name"; ?></td>
    </tr>
  </table>
  <!-- ///////////////////// -->
<br>
  <table class="tg" style="width: 100%">
  <tr>
  <th style="width:3%;text-align:center">SN</th>
  <th style="width:30%;text-align:center">Name</th>
  <th style="width:10%;text-align:center;">Qty</th>
  <th style="width:10%;text-align:center;">Unit </th>
  <th style="width:15%;text-align:center;">Unit Price (BDT)</th>
  <th style="width:15%;text-align:center;">Amount(BDT)</th>
  </tr>
  <?php
   if(isset($detail)){
      $i=1; $totalqty=0;
      $totalweight=0;
      $totalvolweight=0;
      $totalamount=0;
      foreach($detail as $row){
      $totalqty=$totalqty+ $row->quantity; 
      $totalamount=$totalamount+ $row->amount; 
  ?>
  <tr>
    <td class="tg-baqh" style="text-align:center">
      <?php echo $i++;; ?></td>
    <td class="tg-baqh" ><?php echo $row->product_name; ?></td>
    <td style="text-align:center"><?php echo $row->quantity; ?></td>
    <td class="tg-baqh" style="text-align:center">
      <?php echo $row->unit_name; ?></td>
    <td class="tg-baqh" style="text-align:center">
      <?php echo $row->unit_price; ?></td>
    <td class="tg-baqh" style="text-align:center">
      <?php echo $row->amount; ?></td>
    </tr>
    <?php }
  } ?>
    <tr>
     <td style="text-align: center;" colspan="2">Total</td>
     <td style="text-align: center;"><?php echo $totalqty; ?></td>
     <td></td>
     <td></td>
     <td style="text-align: center;"><?php echo number_format($totalamount,2); ?></td>
    </tr>
  </table>
<p style="text-align: left;width: 100%;float: left;overflow: hidden;margin-top: 4px;font-weight: bold;">
 Amount In Word: <?php  echo number_to_word($totalamount); ?> BDT Only
</p> 
  <br>
  <table style="width: 100%">
  <tr>
    <th class="tg-s6z2" style="width: 10%">Note  : <?php echo $info->note; ?></th>
  </tr>
  
</table>
<br><br><br>
  <table style="width:100%">
  <tr>
    <td style="text-align:left;width: 50%">
      <?php if($info->status>=2){ echo $info->user_name; 
        echo "<br>"; echo findDate($info->create_date); }
      ?></td>
   
    </td>
     <td style="text-align:right;width: 50%">
      <?php if($info->status>=3) {
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
    
     <td style="text-align:right;font-size:15px;line-height:5px">
     --------------------------------</td>
  </tr>
  <tr>
  <td style="text-align:left">PREPARED BY</td>
  <td style="text-align:right">APPROVED BY</td>
  </tr>
</table>
<br>
<p style="margin:0;text-align:center">
<?php echo $this->session->userdata('caddress'); ?>                   
</p>
  <!-- ///////////////////// -->
</div>
</div>
</div>
  <!-- /.box-body -->
  <div class="box-footer">
     <div class="col-sm-6"><a href="<?php echo base_url(); ?>merch/<?php echo $controller; ?>/lists" class="btn btn-info"> <i class="fa fa-arrow-circle-o-left" aria-hidden="true"></i> Back</a>
     <button class="btn btn-info prints"><i class="fa fa-print" ></i> Print</button>
     <?php if($info->status==2&&$controller=='Ainvoice'){  ?>
       <a class="btn btn-primary" href="<?php echo base_url()?>merch/Ainvoice/approved/<?php echo $info->invoice_id;?>">
        <i class="fa fa-arrow-circle-right tiny-icon"></i>Approve</a>
  <?php } ?>
  <?php if($info->status==1&&$controller=='Invoice'){  ?>
       <a class="btn btn-primary" href="<?php echo base_url()?>merch/Invoice/submit/<?php echo $info->invoice_id;?>">
        <i class="fa fa-arrow-circle-right tiny-icon"></i>Submit</a>
  <?php } ?>
   </div>
    </div>
       
    </div>
  </div>
  <!-- /.box-footer -->
</div>
