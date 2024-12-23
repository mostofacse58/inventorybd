<style>
   table.table-bordered tbody tr td{
        border-bottom: 1px solid #e2e2e2;
    }
    table.table-bordered tbody tr td:last-child{
        border: 1px solid #e2e2e2;

    }
    table.table-bordered tbody tr td h3{margin:0px;}
    .employee-holder{
        position: absolute;
        top:30px;
        display: none;
        background-color: #ffffff;
        width:270px;
        border:1px solid #efefef;
        z-index: 1000;
        box-shadow: 0 0 4px 0px #ccc;
    }
    .employee-holder ul{
        list-style: none;
        margin: 0px;
        padding: 0px;
    }
    .employee-holder ul li{
        margin: 0px;
        list-style: none;
        width:100%;
        padding:5px 10px;
        color:#666;
        background-color: #fff;
        border-bottom: 1px solid #e2e2e2;
    }
    .employee-holder ul li:hover,.employee-holder ul li.active{
        background-color: #0C5889;
        color:#fff;
    }
    .error-msg{display:none;}
    .form-control{
        -webkit-border-radius:4px;
        -moz-border-radius:4px;
        border-radius:4px;
    }
</style>
<script src="<?php echo base_url('asset/js/plugins/datepicker/bootstrap-datepicker.js'); ?>"></script>
<script type="text/javascript">
var count = 1
$(function () {
  $(document).on('click','input[type=number]',function(){ this.select(); });
    $('.date').datepicker({
        "format": "dd/mm/yyyy",
        "todayHighlight": true,
        "autoclose": true
    });
    });
///////////////////////////////////////////

//called when key is pressed in textbox
$("#employee_id").keypress(function (e) {
   //if the letter is not digit then display error and don't type anything
   if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
      $('input[name=employee_id]').css('border', '1px solid #f00');
    return false;
  }else{
    $('input[name=employee_id]').css('border', '1px solid #ccc');
  }
});
//////////////
var deletedRow=[];
<?php  
if(isset($info)){ ?>
   var id=<?php echo  count($detail); ?>;
   <?php }else{ ?>
  var id=0;
<?php } ?>
$(document).ready(function(){
 
////////////////////////////////////
$("#AddManualItem").click(function(){
    var nodeStr = '<tr id="row_' + id + '"><td  style="text-align:center"><b>' + (id+1) + '</b></td><td><input type="text" name="product_name[]"  class="form-control"  placeholder="Name" style="margin-bottom:5px;width:98%" id="product_name_' + id + '" required></td>'+
    ' <td><input type="text" name="quantity[]" onfocus="this.select();" value="1"  class="form-control"  placeholder="Quantity" style="width:98%;float:left;text-align:center"  id="quantity_' + id + '" onblur="return calculateRow(' + id + ');" onkeyup="return calculateRow('+ id +');" ></td>' +

    ' <td><input type="text" name="unit_name[]" readonly value="PCS"  class="form-control"  placeholder="Unit" style="width:98%;float:left;text-align:center"  id="unit_name_' + id + '"/></td> '+

    '<td> <input type="text" name="unit_price[]" class="form-control" placeholder="Price" style="margin-bottom:5px;width:98%;text-align:center" onblur="return calculateRow(' + id + ');" onkeyup="return calculateRow('+ id +');" value="0"  id="unit_price_' + id + '"/> </td>' +

    '<td> <input type="text" name="amount[]" readonly class="form-control" placeholder="Amount" style="margin-bottom:5px;width:98%;text-align:center" value="0.00"  id="amount_' + id + '"/> </td>' +

    '<td><input type="text" name="remarks[]"  class="form-control" placeholder="remarks" style="width:100%;float:left" value="" id="remarks_' + id + '"></td>'+
    '<td style="text-align:center"><button class="btn btn-danger btn-xs" onclick="return deleter(' + id + ');" style="margin-top:5px;"><i class="fa fa-trash-o"></i> </button> </td> </tr>';
      $("#form-table tbody").append(nodeStr);
    updateRowNo();
    id++;
    
  });//addField

 
  });


  function formsubmit(){
      var error_status=false;
      var serviceNum=$("#form-table tbody tr").length;
      var chk;
      if(serviceNum<1){
        $("#alertMessageHTML").html("Please Adding at least one Material!!");
        $("#alertMessagemodal").modal("show");
        error_status=true;
      }
      
      var create_date=$("#create_date").val();
      if(create_date == ''){
        error_status=true;
        $('input[name=create_date]').css('border', '1px solid #f00');
      } else {
        $('input[name=create_date]').css('border', '1px solid #ccc');      
      }
      var employee_idno=$("#employee_idno").val();
      if(employee_idno == ''){
        error_status=true;
        $('input[name=employee_idno]').css('border', '1px solid #f00');
      } else {
        $('input[name=employee_idno]').css('border', '1px solid #ccc');      
      }
      var employee_name=$("#employee_name").val();
      if(employee_name == ''){
        error_status=true;
        $('input[name=employee_name]').css('border', '1px solid #f00');
      } else {
        $('input[name=employee_name]').css('border', '1px solid #ccc');      
      }
     

     
       for(var i=0;i<serviceNum;i++){
        if($("#product_name_"+i).val()==''){
          $("#product_name_"+i).css('border', '1px solid #f00');
          error_status=true;
        }
        if($("#quantity_"+i).val()==''||$("#quantity_"+i).val()==0){
          $("#quantity_"+i).css('border', '1px solid #f00');
          error_status=true;
        }
        if($("#unit_price_"+i).val()==''||$("#unit_price_"+i).val()==0){
          $("#unit_price_"+i).css('border', '1px solid #f00');
          error_status=true;
        }

      }
      if(error_status==true){
        return false;
      }else{
        $('button[type=submit]').attr('disabled','disabled');
        return true;
      }
}
//////////////////////////////
    function deleter(id){
        $("#row_"+id).remove();
        deletedRow.push(id);
        updateRowNo();
    }
    /////////////////////////////////////////////////////
    //////////UPDATE ROW NUmber
    ///////////////////////////////////////////////////////
    function updateRowNo(){
    var numRows=$("#form-table tbody tr").length;
    for(var r=0;r<numRows;r++){
        $("#form-table tbody tr").eq(r).find("td:first b").text(r+1);
    }
    }
    ////////////////////////////////////////////
    //////////CHECK QUANTITY
    ///////////////////////////////////////////
    function checkQuantity(id){
       var quantity=$("#quantity_"+id).val();
       if($.trim(quantity)==""|| $.isNumeric(quantity)==false){
          $("#quantity_"+id).val(0);
        }
      calculateRow(id);
    }
     ////// TOTAL SUM
    ////////////////////////////////////////////
    function totalSum(){
        var totalAmount=0;
        for(var i=0;i<id;i++){
        if(deletedRow.indexOf(i)<0) {
          totalAmount += parseFloat($.trim($("#amount_" + i).val()));
        }
        }
        $("#total_amount").val(totalAmount.toFixed(2));
      }
      //////////////////////////////////////////////
    /////////////CALCULATE ROW
    //////////////////////////////////////////////
    function calculateRow(id){
        var unit_price=$("#unit_price_"+id).val();
        var quantity=$("#quantity_"+id).val();
        if($.trim(quantity)==""|| $.isNumeric(quantity)==false){
            quantity=1;
        }
        if($.trim(unit_price)==""|| $.isNumeric(unit_price)==false){
            unit_price=0;
        }
        var quantityAndPrice=parseFloat($.trim(unit_price))*parseFloat($.trim(quantity));
        $("#amount_"+id).val(quantityAndPrice.toFixed(2));
        totalSum();
    }


</script>
<div class="row">
    <div class="col-md-12">
        <div class="box box-info">
      <!-- /.box-header -->
        <form class="form-horizontal" action="<?php echo base_url(); ?>merch/Invoice/save<?php if (isset($info)) echo "/$info->courier_id"; ?>" method="POST" enctype="multipart/form-data" onsubmit="return formsubmit();">
         <div class="box-body">
        
        <div class="form-group">
          <label class="col-sm-2 control-label">Date  <span style="color:red;">  *</span></label>
           <div class="col-sm-2">
            <div class="input-group">
             <div class="input-group-addon">
               <i class="fa fa-calendar"></i>
             </div>
             <input type="text" name="create_date" readonly id="create_date" class="form-control pull-right date" value="<?php if(isset($info)) echo findDate($info->create_date); else echo date('d/m/Y'); ?>">
           </div>
           <span class="error-msg"><?php echo form_error("create_date");?></span>
          </div>
          
         <label class="col-sm-2 control-label">Employee ID<span style="color:red;">  *</span></label>
         <div class="col-sm-2">
           <input type="text"  name="employee_idno" id="employee_idno" class="form-control" value="<?php if(isset($info)) echo $info->employee_idno; else echo set_value('employee_idno'); ?>">
           <span class="error-msg"><?php echo form_error("employee_idno");?></span>
         </div>
         <label class="col-sm-2 control-label">Employee Name<span style="color:red;">  </span></label>
         <div class="col-sm-2">
           <input type="text" name="employee_name" id="employee_name" class="form-control" value="<?php if(isset($info)) echo $info->employee_name; else echo set_value('employee_name'); ?>">
           <span class="error-msg"><?php echo form_error("employee_name");?></span>
         </div>
         </div>
      
      
 
    <div class="form-group">
      <div class="col-sm-12" style="">
       <a id="AddManualItem" class="btn btn-info">
        <i class="fa fa-plus-square"></i> Add Item</a>
      </div>
     </div><!-- ///////////////////// -->

<div class="table-responsive">
<table class="table table-bordered" id="form-table">
<thead>
<tr>
  <th style="width:3%;text-align:center">SN</th>
  <th style="width:20%;text-align:center">Name</th>
  <th style="width:5%;text-align:center;">Qty</th>
  <th style="width:5%;text-align:center;">Unit </th>
  <th style="width:10%;text-align:center;">Unit Price</th>
  <th style="width:10%;text-align:center;">Amount</th>
  <th style="width:8%;text-align:center;">Remarks</th>
  <th style="width:5%;text-align:center">
    <i class="fa fa-trash-o"></i></th></tr>
</thead>
<tbody>
 <?php
 $i=0;
 $id=0;
  if(isset($detail)):
    foreach ($detail as  $value) {
      $str='<tr id="row_' . $id . '"><td style="text-align:center"><b>' . ($id +1).'</b></td>';
      $str.= '<td><input type="text" name="product_name[]" class="form-control" placeholder="product_name" value="'.$value->product_name.'"  style="margin-bottom:5px;width:98%" id="product_name_'.$id. '"/> </td>';
      $str.= '<td><input type="text" name="quantity[]" value="'.$value->quantity.'"  class="form-control"  placeholder="Quantity" style="width:100%;float:left;text-align:center"  id="quantity_' .$id. '" onblur="return calculateRow(' .$id.');" onkeyup="return calculateRow(' .$id.');"></td>'; 
      $str.= '<td><input style="width:100%;float:left" class="form-control" name="unit_name[]" value="'.$value->unit_name.'" ></td>';
      $str.= '<td><input type="text" name="unit_price[]" value="'.$value->unit_price.'"  class="form-control"  placeholder="unit_price" style="width:100%;float:left;text-align:center"  id="unit_price_' .$id. '"  onblur="return calculateRow(' .$id.');" onkeyup="return calculateRow(' .$id.');">'; 
      $str.= '<td><input type="text" name="amount[]" value="'.$value->amount.'"  class="form-control"  placeholder="amount style="width:100%;float:left;text-align:center"  id="amount_' .$id. '"  onblur="return calculateRow(' .$id.');" onkeyup="return calculateRow(' .$id.');">';
 
      $str.= '<td><input type="text" name="remarks[]" value="'.$value->remarks.'"  class="form-control"  placeholder="remarks" style="width:100%;float:left;text-align:center"  id="remarks_' .$id. '">';
      $str.= '<td style"text-align:center"><button class="btn btn-danger btn-xs" style"text-align:center" onclick="return deleter('. $i .');" style="margin-top:5px;"><i class="fa fa-trash-o"></i></button></td></tr>';
      echo $str;
       ?>
      <?php 
      $id++;
       }
      endif;
      ?>
</tbody>
</table>
</div>
     <div class="form-group">
       <label class="col-sm-2 control-label">Note</label>
          <div class="col-sm-3">
            <textarea  name="note" class="form-control" rows="3"><?php if(isset($info)) echo $info->note; else echo set_value('note'); ?> </textarea>
             <span class="error-msg"><?php echo form_error("note");?></span>
          </div>
      <label class="col-sm-2 control-label">Total Amount<span style="color:red;">  </span></label>
     <div class="col-sm-3">
       <input type="text" name="total_amount" readonly id="total_amount" class="form-control" value="<?php if(isset($info)) echo $info->total_amount; else echo set_value('total_amount'); ?>">
       <span class="error-msg"><?php echo form_error("total_amount");?></span>
     </div>
    </div>

    
     
<br>
</div>
  <!-- /.box-body -->
  <div class="box-footer">
      <div class="col-sm-4"><a href="<?php echo base_url(); ?>merch/Invoice/lists" class="btn btn-info">
        <i class="fa fa-arrow-circle-o-left" aria-hidden="true"></i> 
        Back</a></div>
      <div class="col-sm-4">
          <button type="submit" class="btn btn-info pull-right">SAVE 保存</button>
      </div>
  </div>
  <!-- /.box-footer -->
</form>
</div>
</div>
</div>




<script type="text/javascript" src="<?php echo base_url('asset/shipto.js');?>"></script>

<script>
  $(document).ready(function(){
    
 

 
  });
</script>