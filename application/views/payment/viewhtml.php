
<style type="text/css">
body {
   padding: 3px;
   font-size:13px;
   font-family: 'Hiragino Kaku Gothic Pro', 'WenQuanYi Zen Hei', '微軟正黑體', '蘋果儷中黑', Helvetica, Arial, sans-serif;
    }
.tg  {border-collapse:collapse;border-spacing:0;width:100%}
.tg td{
  font-family: 'Hiragino Kaku Gothic Pro', 'WenQuanYi Zen Hei', '微軟正黑體', '蘋果儷中黑', Helvetica, Arial, sans-serif;
  font-size:12px;padding:2px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;text-align: center;}
.tg th{
  font-family: 'Hiragino Kaku Gothic Pro', 'WenQuanYi Zen Hei', '微軟正黑體', '蘋果儷中黑', Helvetica, Arial, sans-serif;
  font-size:12px;font-weight:normal;padding:2px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;font-weight: bold}
.tg .tg-s6z2{text-align:center}
.tg .tg-right{text-align:right;vertical-align:top;padding-right: 20px}
hr{margin: 5px}
.tg1  {border-collapse:collapse;border-spacing:0;width:100%}
.tg1 td{
  font-family: 'Hiragino Kaku Gothic Pro', 'WenQuanYi Zen Hei', '微軟正黑體', '蘋果儷中黑', Helvetica, Arial, sans-serif;
  font-size:12px;padding:2px;overflow:hidden;word-break:normal;line-height: 18px;overflow: hidden;}
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
.error-msg{display: none;}
.bs-wizard {margin-top: 40px;}

/*Form Wizard*/
.bs-wizard {border-bottom: solid 1px #e0e0e0; padding: 0 0 10px 0;}
.bs-wizard > .bs-wizard-step {padding: 0; position: relative;}
.bs-wizard > .bs-wizard-step + .bs-wizard-step {}
.bs-wizard > .bs-wizard-step .bs-wizard-stepnum {color: #595959; font-size: 16px; margin-bottom: 5px;}
.bs-wizard > .bs-wizard-step .bs-wizard-info {color: #999; font-size: 14px;}
.bs-wizard > .bs-wizard-step > .bs-wizard-dot {position: absolute; width: 30px; height: 30px; display: block; background: #09ff8e; top: 45px; left: 50%; margin-top: -15px; margin-left: -15px; border-radius: 50%;} 
.bs-wizard > .bs-wizard-step > .bs-wizard-dot:after {content: ' '; width: 14px; height: 14px; background: #00a65a ; border-radius: 50px; position: absolute; top: 8px; left: 8px; } 
.bs-wizard > .bs-wizard-step > .progress {position: relative; border-radius: 0px; height: 8px; box-shadow: none; margin: 20px 0;}
.bs-wizard > .bs-wizard-step > .progress > .progress-bar {width:0px; box-shadow: none; background: #09ff8e;}
.bs-wizard > .bs-wizard-step.complete > .progress > .progress-bar {width:100%;}
.bs-wizard > .bs-wizard-step.active > .progress > .progress-bar {width:50%;}
.bs-wizard > .bs-wizard-step:first-child.active > .progress > .progress-bar {width:0%;}
.bs-wizard > .bs-wizard-step:last-child.active > .progress > .progress-bar {width: 100%;}
.bs-wizard > .bs-wizard-step.disabled > .bs-wizard-dot {background-color: #aeaeae;}
.bs-wizard > .bs-wizard-step.disabled > .bs-wizard-dot:after {opacity: 0;}
.bs-wizard > .bs-wizard-step:first-child  > .progress {left: 50%; width: 50%;}
.bs-wizard > .bs-wizard-step:last-child  > .progress {width: 50%;}
.bs-wizard > .bs-wizard-step.disabled a.bs-wizard-dot{ pointer-events: none; }
.progress { background-color: #aeaeae;}
</style>

 <div class="row bs-wizard" style="border-bottom:0;">
    <div class="col-xs-2 bs-wizard-step <?php if($info->status==1&&$info->status!=8) echo "active"; else if($info->status>=2&&$info->status!=8) echo "complete"; else echo "disabled"; ?>">
      <div class="text-center bs-wizard-stepnum">Prepared By</div>
      <div class="progress"><div class="progress-bar"></div></div>
      <a href="#" class="bs-wizard-dot"></a>
    </div>
    <div class="col-xs-2 bs-wizard-step <?php  if($info->status>=3&&$info->status!=8) echo "complete"; else echo "disabled"; ?>"><!-- complete -->
      <div class="text-center bs-wizard-stepnum">Confirmed By</div>
      <div class="progress"><div class="progress-bar"></div></div>
      <a href="#" class="bs-wizard-dot"></a>
    </div>
    
    <div class="col-xs-2 bs-wizard-step <?php if($info->status>=4&&$info->status!=8) echo "complete";  else echo "disabled"; ?>"><!-- complete -->
      <div class="text-center bs-wizard-stepnum">Verified By</div>
      <div class="progress"><div class="progress-bar"></div></div>
      <a href="#" class="bs-wizard-dot"></a>
    </div>
    
    <div class="col-xs-2 bs-wizard-step <?php if($info->status>=5&&$info->status!=8) echo "complete"; else echo "disabled"; ?>"><!-- active -->
      <div class="text-center bs-wizard-stepnum">Checked By</div>
      <div class="progress"><div class="progress-bar"></div></div>
      <a href="#" class="bs-wizard-dot"></a>
    </div>
    <div class="col-xs-2 bs-wizard-step <?php if($info->status>=6&&$info->status!=8) echo "complete"; else echo "disabled"; ?>"><!-- active -->
      <div class="text-center bs-wizard-stepnum">Approved By</div>
      <div class="progress"><div class="progress-bar"></div></div>
      <a href="#" class="bs-wizard-dot"></a>
    </div>
</div>
<div class="row">
  <div class="col-md-12">
   <div class="content-holder">
   <div class="box box-info" style="padding: 10px">
    <div class="primary_area1">
   <div class="table-responsive table-bordered">
<div  style="width:100%;float:left;font-size: 30px;text-align: center;overflow:hidden;margin:0;margin-top: 0px;">
<p style="margin:0px 0px;color: #538FD4">
<b><?php echo $info->company_name; ?></b></p>
</div>
 <div style="width:100%;overflow:hidden;text-align:center;margin-top: 0px;">
<p style="line-height: 20px;padding: 0px 5px;font-size: 18px" >
  <b>PAYMENT APPLICATION  </b></p>
</div>
<hr style="margin-top: 0px">
<table style="width: 100%">
  <tr>
    <th style="text-align: left" > 
     To Dept:  </th>
    <th style="text-align: left" > 
      <?php if(isset($info)) echo $info->acc_department_name; ?>
     </th>
     <th style="text-align: left" > 
     PA NO:  </th>
    <th style="text-align: left"> 
      <?php if(isset($info)) echo $info->applications_no; ?>
     </th>
   </tr>
  <tr>
    <th style="width:20%;text-align: left" > 
     To:  </th>
    <th style="width:50%;text-align: left"> 
      <?php echo $info->company_name; ?>
     </th>
    <th style="width:15%;text-align: left" > 
    Date: </th>
    <th style="width:15%">
      <?php if(isset($info)) echo  date("j-M-Y", strtotime("$info->applications_date")); ?>
    </th>
  </tr>
  <tr>
    <th style="width:20%;text-align: left" > 
     Pay To:</th>
    <th style="width:50%;text-align: left"> 
      <?php if($info->supplier_id==353) echo $info->other_name; 
      else echo $info->supplier_name; ?>
     </th>
    <th style="width:15%;text-align: left" > 
    PA Type: </th>
    <th style="width:15%;text-align: left;">
      <?php if(isset($info)) echo  $info->pa_type; ?>
    </th>
   </tr>
   <tr>
    <th style="width:20%;text-align: left" > 
     Currency:</th>
    <th style="width:50%;text-align: left"> 
      <?php if(isset($info)) echo $info->currency; ?>
     </th>
    <th style="width:15%;text-align: left" > 
    Rate in HKD: </th>
    <th style="width:15%;text-align: left;">
      <?php if(isset($info)) echo  $info->currency_rate_in_hkd; ?>
    </th>
   </tr>
</table>
<br>

<table class="tg"  style="overflow: hidden;">
  <thead>
  <tr>
    <th style="width:30%;text-align:center">Description</th>
    <th style="width:15%;text-align:center">Percentage</th>
    <th class="tg-right" style="width:15%;">Amount</th>
    <th style="width:15%;text-align:center">Remarks</th>
    <th style="width:20%;text-align:center">Department</th>
  </tr>
</thead>
<tbody>
  <?php
  if(isset($detail)){
	   $i=1;
	  foreach($detail as $value){ 

	  ?>
  <tr>
    <td class="tg-s6z2"><?php echo $value->head_name;  ?></td>
    <td class=""></td>
    <td class="tg-right"><?php echo number_format($value->amount,2); ?></td>
    <td class="tg-s6z2"><?php echo $value->remarks;  ?></td>
    <td class="tg-s6z2"> 
      <?php
      $detail1=$this->Applications_model->getDetails1($info->payment_id,$value->head_id);
      if(isset($detail1)){
         $i=1;
        foreach($detail1 as $value1){ 
        ?>
        <span style="padding: 3px;margin:0px;float: left">
         <?php echo "$value1->department_name: $value1->percentage%="; 
         echo number_format($value1->damount,2); echo ""; ?>
        </span>
      <?php } } ?>
    </td>

  </tr>
   <?php }
 } ?>
 <?php if($info->vat_add_per!=0){ ?>
   <tr>
    <td class="tg-s6z2">Add. VAT</td>
    <td><?php if(isset($info)) echo $info->vat_add_per; ?>%</td>
    <td class="tg-right"><?php if(isset($info)) echo $info->vat_add_amount; ?></td>
    <td></td>
  </tr>
<?php } ?>
<?php if($info->ait_add_per!=0){ ?>
   <tr>
    <td class="tg-s6z2">Add. AIT</td>
    <td><?php if(isset($info)) echo $info->ait_add_per; ?>%</td>
    <td class="tg-right"><?php if(isset($info)) echo $info->ait_add_amount; ?></td>
    <td></td>
    <td></td>
  </tr>
<?php } ?>

<?php if($info->vat_add_per!=0||$info->ait_add_per!=0){ ?>
   <tr>
    <th class="tg-s6z2">Adjusted Bill Amount</th>
    <td></td>
    <th class="tg-right"><?php if(isset($info)) 
    echo number_format($info->sub_total,2); ?></th>
    <td></td>
    <td></td>
  </tr>
<?php } ?>

<?php if($info->vat_less_per!=0){ ?>
   <tr>
    <td class="tg-s6z2">Less. VAT</td>
    <td><?php if(isset($info)) echo $info->vat_less_per; ?>%</td>
    <td class="tg-right"><?php if(isset($info)) echo $info->vat_less_amount; ?></td>
    <td></td>
    <td></td>
  </tr>
<?php } ?>
<?php if($info->ait_less_per!=0){ ?>
   <tr>
    <td class="tg-s6z2">Less. AIT</td>
    <td><?php if(isset($info)) echo $info->ait_less_per; ?>%</td>
    <td class="tg-right"><?php if(isset($info)) echo $info->ait_less_amount; ?></td>
    <td></td>
    <td></td>
  </tr>
<?php } ?>
<?php if($info->other_amount!=0){ ?>
   <tr>
    <td class="tg-s6z2"><?php if(isset($info)) echo $info->other_note; ?></td>
    <td><?php if(isset($info)) echo $info->other_plus_minus; ?></td>
    <td class="tg-right">
      <?php if(isset($info)) echo number_format($info->other_amount,2); ?></td>
      <td></td>
      <td></td>
  </tr>
<?php } ?>

   <tr>
    <th class="tg-s6z2"></th>
    <th>Net Payment:</th>
    <th class="tg-right">
      <?php if(isset($info)) echo number_format($info->total_amount,2); ?></th>
      <td></td>
      <td></td>
  </tr>
</tbody>
</table>

<p style="text-align: left;width: 100%;float: left;overflow: hidden;margin-top: 4px;font-weight: bold;">
 Amount In Word: <?php 
 $tmount=explode(".",$info->total_amount);

 if(isset($info)) echo number_to_word($tmount[0]); ?> <?php if($info->currency=='BDT') echo "Taka"; else echo $info->currency; ?>
 <?php if($tmount[1]>0){ echo " and "; echo number_to_word($tmount[1]); if($info->currency=='BDT') echo " Poysha"; elseif($info->currency=='RMB') echo " Jiao"; else echo " Cent";  } ?> Only
</p> 
<div style="width: 100%">
<table class="tg"  style="overflow: hidden;width: 45%;float: left;">
  <thead>
    <tr>
    <th style="width:30%;text-align:center">Sub-Total</th>
    <th class="tg-right" style="width:15%;">
      <?php 
      $sum = 0;
      foreach ($detail3 as $item) {
          $sum += $item->pamount;
      } 
      echo number_format($sum,2);
      ?></th>
  </tr>
  <tr>
    <th style="width:30%;text-align:center">PO Number</th>
    <th class="tg-right" style="width:15%;">Amount</th>
  </tr>
</thead>
<tbody>
  <?php
  if(isset($detail3)){
     $i=1;
    foreach($detail3 as $value){ 
    ?>
  <tr>
    <td class="tg-s6z2" >
      <?php if(substr($value->po_number, 0,3)=='BDW') { ?>
      <a href="<?php echo base_url(); ?>dashboard/downloadPO/<?php echo $value->po_number; ?>"><?php echo $value->po_number;  ?></a>
    <?php }else {  echo $value->po_number; } ?>
    </td>
    <td class="tg-right"><?php echo number_format($value->pamount,2); ?></td>
  </tr>
<?php }} ?>
  </tbody>
</table>
<table class="tg"  style="overflow: hidden;width: 45%;float: left;margin-left: 10%">
  <thead>
    <tr>
    <th style="width:30%;text-align:center">Sub-Total</th>
    <th class="tg-right" style="width:15%;">
    <?php 
      $sum = 0;
      foreach ($detail4 as $item) {
          $sum += $item->bamount;
      } 
      echo number_format($sum,2);
      ?></th>
  </tr>
  <tr>
    <th style="width:30%;text-align:center">Bill No</th>
    <th class="tg-right" style="width:15%;">Amount</th>
  </tr>
</thead>
<tbody>
  <?php
  if(isset($detail4)){
     $i=1;
    foreach($detail4 as $value){ 
    ?>
  <tr>
    <td class="tg-s6z2" ><?php echo $value->bill_no;  ?></td>
    <td class="tg-right"><?php echo number_format($value->bamount,2); ?></td>
  </tr>
<?php }} ?>
  </tbody>
</table>
</div>

<p style="text-align: left;width: 100%;float: left;overflow: hidden;margin-top: 1px;">
 Remarks : <?php if(isset($info)) echo $info->description; ?>
</p> 
<p style="text-align: left;width: 100%;float: left;overflow: hidden;margin-top: 1px;font-weight: bold;">
 Payment: <?php if($info->pay_term!='') echo $info->pay_term; ?>
</p>
<p style="text-align: left;width: 100%;float: left;overflow: hidden;margin-top: 1px;font-weight: bold;font-size: 20px">Attachment:
  <?php if(isset($info) &&!empty($info->attachemnt_file)) { ?>
        <a href="<?php echo base_url(); ?>dashboard/dpayment/<?php echo $info->attachemnt_file; ?>">Download</a>
      <?php } ?>
</p>
<p style="text-align: left;width: 100%;float: left;overflow: hidden;margin-top: 1px;">
 Note : <?php if(isset($info)) echo $info->comment_note; ?>
</p> 
<br><br>
<table class="tg1" style="overflow: hidden;">
  <tr>
  <td>&nbsp;</td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
</tr>
  <tr>
  <td style="width:20%;text-align:left;">
    <?php if($info->status>=1) echo "$info->user_name"; ?></td>
  <td style="width:20%;text-align:center;">
    <?php if($info->status>=3&&$info->status!=8) echo "$info->checked_by"; ?></td>
  <td style="width:20%;text-align:center;">
  <?php if($info->status>=4&&$info->status!=8) echo "$info->verified_by"; ?></td>
  <td style="width:20%;text-align:center;">
  <?php if($info->status>=5&&$info->status!=8) echo "$info->received_by"; ?></td>
  <td style="width:20%;text-align:right;">
  <?php if($info->status>=6&&$info->status!=8) echo "$info->approved_by_name"; ?></td>
  </tr>
  <tr>
  <td style="text-align:left;">
    <?php if($info->status>=1) echo findDate($info->prepared_date); ?></td>
  <td style="text-align:center;">
    <?php if($info->status>=3&&$info->status!=8) 
   echo findDate($info->checked_date); ?></td>
  <td style="text-align:center;">
  <?php if($info->status>=4&&$info->status!=8) 
   echo findDate($info->verified_date); ?></td>
  <td style="text-align:center;">
  <?php if($info->status>=5&&$info->status!=8) 
   echo findDate($info->received_date); ?></td>
  <td style="text-align:right;">
    <?php if($info->status>=6&&$info->status!=8)
   echo findDate($info->approved_date); ?></td>
  </tr>
  <tr>
  <td style="text-align:left;font-size: 15px;line-height: 5px">---------------</td>
  <td style="text-align:center;font-size: 15px;line-height: 5px">---------------</td>
  <td style="text-align:center;font-size: 15px;line-height: 5px">----------------</td>
  <td style="text-align:center;font-size: 15px;line-height: 5px">----------------</td>
  <td style="text-align:right;font-size: 15px;line-height: 5px">----------------</td>
  </tr>
  <tr>
  <td style="text-align:left;">Prepared By:</td>
  <td style="text-align:center;">Confirmed By: </td>
  <td style="text-align:center;">Verified By</td>
  <td style="text-align:center;">Checked By</td>
  <td style="text-align:right;">Approved By</td>
  </tr>
</table>
</div>
</div>
</div>
<div class="box-footer">
  
  <div class="col-sm-12" style="text-align: center;">
    <a class="btn btn-info" href="<?php echo base_url()?>payment/<?php echo $controller; ?>/lists">
    <i class="fa fa-arrow-circle-o-left tiny-icon"></i> Back</a>
    <?php if($info->status==1&&$controller=='applications'){ ?>
      <a class="btn btn-info" href="<?php echo base_url()?>payment/<?php echo $controller; ?>/submit/<?php echo $info->payment_id;?>">
    <i class="fa fa-arrow-circle-o-right tiny-icon"></i> Submit</a>
   <?php } ?>
    <?php if($info->status==2&&$controller=='checked'){ ?>
    <a class="btn btn-warning decisions"  data-pastatus="1" href="#">
    <i class="fa fa-arrow-circle-o-left  tiny-icon"> </i> Return </a>
    <a class="btn btn-info" href="<?php echo base_url()?>payment/<?php echo $controller; ?>/approved/<?php echo $info->payment_id;?>">
    <i class="fa fa-arrow-circle-o-right tiny-icon"></i> Confirm</a>
  <?php } ?>
 <!--  <?php if($info->status==4&&$controller=='papproved'){ ?>
    <a class="btn btn-warning decisions"  data-pastatus="1" href="#">
    <i class="fa fa-arrow-circle-o-left  tiny-icon"> </i> Return </a>
    <a class="btn btn-danger decisions"  data-pastatus="8" href="#">
    <i class="fa fa-times  tiny-icon"> </i> Reject </a>
    <a class="btn btn-info" href="<?php echo base_url()?>payment/<?php echo $controller; ?>/approved/<?php echo $info->payment_id;?>">
    <i class="fa fa-arrow-circle-o-right tiny-icon"></i> Approve</a>
  <?php } ?> -->
  <?php if($info->status==3&&$controller=='verified'){ ?>
    <a class="btn btn-warning decisions"  data-pastatus="1" href="#">
    <i class="fa fa-arrow-circle-o-left  tiny-icon"> </i> Return </a>
    <a class="btn btn-danger decisions"  data-pastatus="8" href="#">
    <i class="fa fa-times  tiny-icon"> </i> Reject </a>
    <a class="btn btn-info" href="<?php echo base_url()?>payment/<?php echo $controller; ?>/pass/<?php echo $info->payment_id;?>">
    <i class="fa fa-arrow-circle-o-right tiny-icon"></i> Pass</a>
    <a class="btn btn-info" href="<?php echo base_url()?>payment/<?php echo $controller; ?>/approved/<?php echo $info->payment_id;?>">
    <i class="fa fa-arrow-circle-o-right tiny-icon"></i> Verify</a>
  <?php } ?>
  <?php if($info->status==4&&$controller=='received'){ ?>
    <a class="btn btn-warning decisions"  data-pastatus="1" href="#">
    <i class="fa fa-arrow-circle-o-left  tiny-icon"> </i> Return </a>
    <a class="btn btn-danger decisions"  data-pastatus="8" href="#">
    <i class="fa fa-times  tiny-icon"> </i> Reject </a>
    <a class="btn btn-info" href="<?php echo base_url()?>payment/<?php echo $controller; ?>/approved/<?php echo $info->payment_id;?>">
    <i class="fa fa-arrow-circle-o-right tiny-icon"></i> Check</a>
  <?php } ?>
 
  </div>
</div>
</div>
</div>
</div>
<div class="modal fade " id="TeamModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title text-primary" id="myModalLabel">  Comments</h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" id="formId" method="POST" action="<?php echo base_url()?>payment/<?php echo $controller; ?>/decisions/<?php echo $info->payment_id;?>">
          <div class="form-group">
            <label class="col-sm-3 control-label">Comments </label>
            <div class="col-sm-6">
              <textarea class="form-control" name="comment_note" rows="2" id="comment_note" placeholder="Comments"></textarea> 
              <span class="error-msg">Comments field is required</span>
            </div>
          </div>
       <input type="hidden" name="status"  id="status">
       </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal"> Close</button>
        <button type="button" class="btn btn-primary" id="addNewTeam"><i class="fa fa-save"></i> OK</button>
      </div>
    </div>
  </div>
</div>
<script>
  
$(document).ready (function(){
 ///////////////////////////
  $("#addNewTeam").click(function(){
    var comment_note = $("#comment_note").val();
    var error = 0;
    if(comment_note==""){
      $("#comment_note").css({"border-color":"red"});
      $("#comment_note").parent().children("span").show(200).delay(3000).hide(200,function(){
      $("#comment_note").css({"border-color":"#ccc"});
      });
      error=1;
    }
    if(error == 0) {
      $("#formId").submit();
      //document.location=url1;
    }
  });
  ////////////////////// CALLING AJAX FOR DELETE PRODUCT/////////
  $(".decisions").click(function(e){
    e.preventDefault();
    var pastatus=$(this).data('pastatus');
    if(pastatus==8){
      $(".control-label").html("<span style='color: red;'>Comment</span>");
      $("#myModalLabel").html("<span style='color: red;'>Reject Comment</span>");
    }else if(pastatus==1){
      $(".control-label").html("<span style='color: #9F6000;'>Comment</span>");
      $("#myModalLabel").html("<span style='color: #9F6000;'>Return Comment</span>");
    }
     $("#status").val(pastatus);
     $("#TeamModal").modal("show");
  });
});//jquery ends here
</script>
