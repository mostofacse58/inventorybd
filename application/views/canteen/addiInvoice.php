<script src="<?php echo base_url('asset/js/plugins/datepicker/bootstrap-datepicker.js'); ?>"></script>
<script type="text/javascript">
var count = 1
$(function () {
$(document).on('click','input[type=number]',function(){ this.select(); });
  $('.date').datepicker({
      "format": "dd/mm/yyyy",
      "todayHighlight": true,
      "endDate": '0d',
      "autoclose": true
  });
});
//////////////
var deletedRow=[];
<?php  if(isset($info)){ ?>
     var id='<?php echo count($detail); ?>';
     <?php }else{ ?>
    var id=0;
    <?php } ?>
  var check='YES';
$(document).ready(function(){
  ///////  Search 搜索 Item Barcode or QCODE or Put Name //////////////////
  $("#add_item").autocomplete({
        source: function (request, response) {
          $.ajax({
              type: 'get',
              url: '<?= base_url('canteen/Invoice/suggestions'); ?>',
              dataType: "json",
              data: {
                term: request.term
              },
              success: function (data) {
                $(this).removeClass('ui-autocomplete-loading');
                response(data);
              }
          });
        },
        minLength: 3,
        autoFocus: false,
        delay: 250,
        response: function (event, ui) {
            if ($(this).val().length >= 16 && ui.content[0].id == 0) {
                bootbox.alert('Not Found', function () {
                    $('#add_item').focus();
                });
                $(this).removeClass('ui-autocomplete-loading');
                $(this).removeClass('ui-autocomplete-loading');
                $(this).val('');
            }
            else if (ui.content.length == 1 && ui.content[0].id != 0) {
                ui.item = ui.content[0];
                $(this).data('ui-autocomplete')._trigger('select', 'autocompleteselect', ui);
                $(this).autocomplete('close');
                $(this).removeClass('ui-autocomplete-loading');
            }
            else if (ui.content.length == 1 && ui.content[0].id == 0) {
                bootbox.alert('Not Found', function () {
                    $('#add_item').focus();
                });
                $(this).removeClass('ui-autocomplete-loading');
                $(this).val('');
            }
        },
        select: function (event, ui) {
            event.preventDefault();
            var productId=ui.item.product_id;
            var chkname=1;
            if (ui.item.id !== 0) {
              for(var i=0;i<id;i++){
                var prid= parseInt($("#product_id_" + i).val());
                if(prid==productId){
                   chkname=2;
                }
               }
           if(chkname==2){
            $("#alertMessageHTML").html("This Items already added!!");
            $("#alertMessagemodal").modal("show");
           }else{
           var nodeStr = '<tr id="row_' + id + '"><td  style="text-align:center"><input type="hidden" value="'+ui.item.product_id+'" name="product_id[]"  id="product_id_' + id + '"/><b></b></td> <td> <input type="text" name="product_name[]" readonly class="form-control" placeholder="Product Name" value="'+ui.item.product_name+'" style="margin-bottom:5px;width:98%" id="product_name_' + id + '"/> </td>'+
            '<td><input type="text" name="product_code[]" readonly class="form-control" placeholder="CODE" value="'+ui.item.product_code+'"  style="margin-bottom:5px;width:98%" id="product_code_' + id + '"/> </td>' +
            '<td><input type="text" name="specification[]" class="form-control" value="" style="margin-bottom:5px;width:98%" id="specification_' + id + '"/></td>' +

            '<td><input type="text" name="required_qty[]" readonly class="form-control" placeholder="Qty" value=""  style="margin-bottom:5px;width:98%" id="required_qty_' + id + '"/> </td>' +
            ' <td><input type="text" name="quantity[]" value="" onblur="return checkQuantity(' + id + ');" onkeyup="return checkQuantity(' + id + ');" class="form-control integerchk" placeholder="Qty" style="width:100%;float:left;text-align:center"  id="quantity_' + id + '"/> </td>' +
            '<td> <input type="text" name="unit_price[]" class="form-control integerchk" placeholder="Price" style="margin-bottom:5px;width:98%;text-align:center" onblur="return calculateRow(' + id + ');" onkeyup="return calculateRow(' + id + ');" value="'+ui.item.unit_price+'"  id="unit_price_' + id + '"/> </td>' +
            '<td> <input type="text" name="amount[]" readonly class="form-control" placeholder="Amount" style="margin-bottom:5px;width:98%;text-align:center" value="0.00"  id="amount_' + id + '"/> </td>' +
            '<td><select name="box_name[]" required class="form-control pull-left select2" style="width:100%;"  id="box_name_' + id + '" required><option value="" selected="selected">Select</option>'+boxselect+'</select> </td>' +
            ' <td style="text-align:center"> <button class="btn btn-danger btn-xs" onclick="return deleter(' + id + ');" style="margin-top:5px;"><i class="fa fa-trash-o"></i> </button> </td> </tr>';
          $("#form-table tbody").append(nodeStr);
          updateRowNo();
          id++;
          //var row = add_invoice_item(ui.item);
          $("#add_item").val('');
        }
        } else {
          alert('Not Found');
        }
        }
    });
////////////// end Add Item///////////////////
    });
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
    totalSum();
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
        ////////////// PUT VALUE ////////
        $("#amount_"+id).val(quantityAndPrice.toFixed(2));
        totalSum();
    }//calculateRow


function formsubmit(){
  var error_status=false;
  var invoice_date=$("#invoice_date").val();
  var serviceNum=$("#form-table tbody tr").length;
  var chk;
  if(serviceNum<1){
    $("#alertMessageHTML").html("Please Adding at least one Items!!");
    $("#alertMessagemodal").modal("show");
    error_status=true;
  }
  
  for(var i=0;i<serviceNum;i++){
    if($("#unit_price_"+i).val()==''){
      $("#unit_price_"+i).css('border', '1px solid #f00');
      error_status=true;
    }
    if($("#quantity_"+i).val()==''||$("#quantity_"+i).val()==0){
      $("#quantity_"+i).css('border', '1px solid #f00');
      error_status=true;
    }
  }
 

  if(invoice_date == '') {
    error_status=true;
    $("#invoice_date").css('border', '1px solid #f00');
  } else {
    $("#invoice_date").css('border', '1px solid #ccc');      
  }
 
  if(error_status==true){
    return false;
  }else{
    $('button[type=submit]').attr('disabled','disabled');
     return true;
  }
  $(".error-flash").delay(5000).hide(200);
}
////////////////////////////
function getPOwiseitem(){
      var requisition_no=$("#requisition_no").val();
      if(requisition_no !=''&&requisition_no.length>=10){
      $.ajax({
        type:"post",
        url:"<?php echo base_url()?>"+'canteen/Invoice/getReqInfo',
        data:{requisition_no:requisition_no,requisition_no:requisition_no},
        success:function(data1){
          data1=JSON.parse(data1);
          check=data1.check
          if(check=='YES'){
            $("#requisition_id").val(data1.requisition_id);
            $("#invoice_type").val(data1.for_canteen).change();
            $(".Searchclass").hide();
            totalSum();
          }else{
            $("#alertMessageHTML").html("This Req not found or not approved!!");
            $("#alertMessagemodal").modal("show");
            $(".Searchclass").show();
          }
        }
      });
      $.ajax({
        type:"post",
        url:"<?php echo base_url()?>"+'canteen/Invoice/getReqwiseitem',
        data:{requisition_no:requisition_no},
        success:function(data){
          $("#form-table tbody").empty();
          $("#form-table tbody").append(data);
          var serviceNum=$("#form-table tbody tr").length;
          id=serviceNum;
          totalSum();
          }
      });
    }else{
      $("#form-table tbody").empty();
      $(".Searchclass").show();
      id=0;
    }
  }
</script>
<div class="row">
    <div class="col-md-12">
    <div class="box box-info">
      <!-- /.box-header -->
    <form class="form-horizontal" action="<?php echo base_url(); ?>canteen/Invoice/save" method="POST" enctype="multipart/form-data" onsubmit="return formsubmit();">
         <div class="box-body">
          <input type="hidden" name="requisition_id" id="requisition_id" value="<?php if(isset($info)) echo $info->requisition_id; else echo set_value('requisition_id'); ?>">
          <input type="hidden" name="supplier_id" id="supplier_id" value="<?php if(isset($info)) echo $info->supplier_id; else echo 917; ?>">
         <div class="form-group">
          <label class="col-sm-2 control-label">Requsition No<span style="color:red;">  </span></label>
          <div class="col-sm-2">
            <input type="text" name="requisition_no" id="requisition_no" class="form-control" value="<?php if(isset($info)) echo $info->requisition_no; else echo set_value('requisition_no'); ?>"  onkeyup="return getPOwiseitem();">
          </div>
          <label class="col-sm-2 control-label">Type   <span style="color:red;">  *</span></label>
           <div class="col-sm-2">
            <select class="form-control" name="invoice_type" id="invoice_type" required="">
              <option value="" selected="selected">Select</option>
              <option value="1"
                <?php if(isset($info)) echo '1'==$info->invoice_type? 'selected="selected"':0; else echo set_select('invoice_type','1');?>> For BD Canteen</option>
              <option value="2"
                <?php if(isset($info)) echo '2'==$info->invoice_type? 'selected="selected"':0; else echo set_select('invoice_type','2');?>> For CN Canteen</option>
              <option value="3"
                <?php if(isset($info)) echo '3'==$info->invoice_type? 'selected="selected"':0; else echo set_select('invoice_type','3');?>> For Guest</option>
              <option value="4"
                <?php if(isset($info)) echo '4'==$info->invoice_type? 'selected="selected"':0; else echo set_select('invoice_type','4');?>>For 8th Floor</option>
            </select>
           <span class="error-msg"><?php echo form_error("invoice_type");?></span>
         </div>
   
      </div><!-- ///////////////////// -->
      <div class="form-group">
       <label class="col-sm-2 control-label"> Date  <span style="color:red;">  *</span></label>
       <div class="col-sm-2">
             <div class="input-group date">
           <div class="input-group-addon">
             <i class="fa fa-calendar"></i>
           </div>
           <input type="text" name="invoice_date" readonly id="invoice_date" class="form-control pull-right" value="<?php if(isset($info)) echo findDate($info->invoice_date); else echo date('d/m/Y'); ?>">
         </div>
         <span class="error-msg"><?php echo form_error("invoice_date");?></span>
        </div>
     
        <label class="col-sm-1 control-label">Ref No<span style="color:red;">  </span></label>
          <div class="col-sm-2">
            <input type="text" name="ref_no" id="ref_no" class="form-control" value="<?php if(isset($info)) echo $info->ref_no; else echo set_value('ref_no'); ?>">
          </div>
      </div><!-- ///////////////////// -->
     <?php if(!isset($show)){ ?>
    <div class="form-group Searchclass">
      <label class="col-sm-2 control-label" style="margin-top: 14px">SCAN CODE or Search 搜索<span style="color:red;">  </span></label>
        <div class="col-sm-8">
          <div class="col-md-12" id="sticker" style="width: 100%; z-index: 2;">
            <div class="well well-sm"  style="overflow: hidden;">
              <div class="form-group" style="margin-bottom:0;">
                <div class="input-group wide-tip">
                  <div class="input-group-addon" style="padding-left: 10px; padding-right: 10px;">
                    <i class="fa fa-2x fa-barcode addIcon"></i></div>
                  <input id="add_item" class="form-control ui-autocomplete-input input-lg" name="add_item" value="" placeholder="Please add Items to order list" autocomplete="off" tabindex="1" type="text">
                <div class="input-group-addon" style="padding-left: 10px; padding-right: 10px;">
              </div>
            </div>
            </div>
          <div class="clearfix"></div>
        </div>
      </div>
      </div>
     </div><!-- ///////////////////// -->
   <?php } ?>
   <input type="hidden" name="ovgrn_id" value="<?php if(isset($info)) echo $info->purchase_id; else echo 0; ?>">
<div class="table-responsive">
<table class="table table-bordered" id="form-table">
<thead>
<tr>
  <th style="width:5%;text-align:center;">SL</th>
  <th style="width:25%;text-align:center;">Item Name</th>
  <th style="width:12%;text-align:center;">Item Code</th>
  <th style="width:12%;text-align:center;">Specification</th>
  <th style="width:8%;text-align:center;">Req Qty</th>
  <th style="width:8%;text-align:center;">Send Qty</th>
  <th style="width:10%;text-align:center;">Unit Price</th>
  <th style="width:10%;text-align:center;">Amount</th>
  <th style="width:5%;text-align:center">
     <i class="fa fa-trash-o"></i></th></tr>
</thead>
<tbody>
 <?php
 $i=0;
 $id=0;
  if(isset($detail)):
    $boxselect='';
     foreach ($blist as $rows){ 
      $boxselect.='<option value="'.$rows->box_name.'">'.$rows->box_name.'</option>';
    }

    foreach ($detail as  $value) {
       $str='<tr id="row_' . $id . '"><td style="text-align:center"><input type="hidden" value="'.$value->product_id.'" name="product_id[]"  id="product_id_' . $id . '"/><b>' . ($id +1).'</b></td> <td> <input type="text" name="product_name[]" class="form-control" readonly placeholder="'.$value->product_name.'" value="'.$value->product_name.'"  style="margin-bottom:5px;width:98%" id="product_item_'  .$id. '"/> </td>';

      $str.= '<td><input type="text" name="product_code[]" readonly class="form-control" placeholder="Item Code" value="'.$value->product_code.'" style="margin-bottom:5px;width:98%" id="product_code_'.$id. '"/> </td>';
      $str.= '<td><input type="text" name="specification[]" class="form-control" value="'.$value->specification.'" style="margin-bottom:5px;width:98%" id="specification_'.$id. '"/> </td>';
      $str.= '<td><input type="text" name="required_qty[]" readonly class="form-control" value="'.$value->required_qty.'"  style="margin-bottom:5px;width:98%" id="required_qty_'.$id. '"/> </td>';
      $str.= '<td><input type="text" name="quantity[]" value="'.$value->quantity.'" onblur="return checkQuantity(' .$id.');" onkeyup="return checkQuantity(' .$id.');" class="form-control"  placeholder="Quantity" style="width:100%;float:left;text-align:center"  id="quantity_' .$id. '"/> </td>';

      $str.= '<td> <input type="text" name="unit_price[]" class="form-control" placeholder="Unit Price" value="'.$value->unit_price.'" onblur="return calculateRow(' .$id.');" onkeyup="return calculateRow(' .$id.');"  style="margin-bottom:5px;width:98%;text-align:center" id="unit_price_'.$id.'"/> </td>';
      $str.= '<td><input type="text" name="amount[]" readonly class="form-control" placeholder="Amount" value="'.$value->amount.'"   style="margin-bottom:5px;width:98%;text-align:center" id="amount_'.$id.'"/> </td>';
      $str.= '<td> <a class="btn btn-danger btn-xs" onclick="return deleter('. $id .');" style="margin-top:5px;"><i class="fa fa-trash-o"></i></a></td></tr>';
         echo $str;
       ?>
      <?php 
      $id++; 
      $i++;
       }
      endif;
      ?>
</tbody>
</table>
</div>
<div class="form-group">

    <label class="col-sm-2 control-label">Total Amount<span style="color:red;">  *</span></label>
    <div class="col-sm-2">
      <input type="text" name="total_amount" id="total_amount" readonly class="form-control pull-right" value="<?php if(isset($info)) echo $info->total_amount; else echo set_value('total_amount'); ?>">
      <span class="error-msg"><?php echo form_error("total_amount"); ?></span>
    </div>
  </div><!-- ///////////////////// -->

</div>
   <div class="form-group">
          <label class="col-sm-2 control-label">Note<span style="color:red;">  </span></label>
           <div class="col-sm-8">
           <input type="text" name="note" id="note" class="form-control" placeholder="Note" value="<?php if(isset($info->note)) echo $info->note; else echo set_value('note'); ?>">
           <span class="error-msg"><?php echo form_error("note");?></span>
         </div>
      </div><!-- ///////////////////// -->
  <!-- /.box-body -->
  <div class="box-footer">
  <div class="col-sm-4"><a href="<?php echo base_url(); ?>canteen/Invoice/lists" class="btn btn-info">
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

