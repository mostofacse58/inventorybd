<script src="<?php echo base_url('asset/js/plugins/datepicker/bootstrap-datepicker.js'); ?>"></script>
<div class="row">
<div class="col-md-12">
    <div class="box box-info">
      <!-- /.box-header -->
    <form class="form-horizontal" action="<?php echo base_url(); ?>aformat/Deptrequisn/save<?php if (isset($info)) echo "/$info->pi_id"; ?>" method="POST" enctype="multipart/form-data" onsubmit="return formsubmit();">
         <div class="box-body">
         <div class="form-group">
          <label class="col-sm-2 control-label">Purchase Type <span style="color:red;">  *</span></label>
           <div class="col-sm-3">
            <select class="form-control select2" name="purchase_type_id" id="purchase_type_id" required> 
              <option value="" selected="selected">===Select Type===</option>
              <?php foreach ($ptlist as $rows) { ?>
                <option value="<?php echo $rows->purchase_type_id; ?>" 
                <?php if (isset($info))
                    echo $rows->purchase_type_id == $info->purchase_type_id ? 'selected="selected"' : 0;
                else
                    echo $rows->purchase_type_id == set_value('purchase_type_id') ? 'selected="selected"' : 0;
                ?>><?php echo $rows->p_type_name; ?></option>
                    <?php } ?>
            </select>
           <span class="error-msg"><?php echo form_error("use_type");?></span>
         </div>
         <label class="col-sm-1 control-label">PI NO<span style="color:red;">  *</span></label>
          <div class="col-sm-2">
            <input type="text" name="pi_no" id="pi_no" class="form-control" placeholder="PI NO" value="<?php if(isset($info)) echo $info->pi_no; else echo set_value('pi_no'); ?>"  <?php if(isset($info)) echo "readonly" ?> readonly>
            <span class="error-msg"><?php echo form_error("pi_no"); ?></span>
          </div>
          <label class="col-sm-1 control-label">PI Date <span style="color:red;">  *</span></label>
         <div class="col-sm-2">
            <div class="input-group date">
             <div class="input-group-addon">
               <i class="fa fa-calendar"></i>
             </div>
             <input type="text" name="pi_date" readonly id="pi_date" class="form-control pull-right" value="<?php if(isset($info)) echo findDate($info->pi_date); else echo date('d/m/Y'); ?>">
           </div>
           <span class="error-msg"><?php echo form_error("pi_date");?></span>
          </div>
        </div>
        <div class="form-group">
         <label class="col-sm-2 control-label">Demand Date<span style="color:red;">  *</span> </label>
         <div class="col-sm-2">
            <div class="input-group date">
             <div class="input-group-addon">
               <i class="fa fa-calendar"></i>
             </div>
             <input type="text" name="demand_date" readonly id="demand_date" class="form-control pull-right" value="<?php if(isset($info)) echo findDate($info->demand_date); else echo date('d/m/Y'); ?>">
           </div>
           <span class="error-msg"><?php echo form_error("demand_date");?></span>
          </div>
          <label class="col-sm-2 control-label">Promised Date<span style="color:red;">  *</span> </label>
         <div class="col-sm-2">
               <div class="input-group date">
             <div class="input-group-addon">
               <i class="fa fa-calendar"></i>
             </div>
             <input type="text" name="promised_date" readonly id="promised_date" class="form-control pull-right" value="<?php if(isset($info)) echo findDate($info->promised_date); else echo date('d/m/Y'); ?>">
           </div>
           <span class="error-msg"><?php echo form_error("promised_date");?></span>
          </div>
          <label class="col-sm-2 control-label ">Demand Department对于部门 <span style="color:red;">  </span></label>
          <div class="col-sm-2">
          <select class="form-control select2" name="for_department_id" id="for_department_id" style="width: 100%"> 
            <option value="" selected="selected">Select 选择</option>
            <?php foreach ($dlist as $rows) { ?>
              <option value="<?php echo $rows->department_id; ?>" 
              <?php if (isset($info))
                  echo $rows->department_id == $info->for_department_id ? 'selected="selected"' : 0;
                  else
                  echo $rows->department_id ==$this->session->userdata('department_id') ? 'selected="selected"' : 0;
              ?>><?php echo $rows->department_name; ?></option>
                  <?php } ?>
              </select>
              <span class="error-msg"><?php echo form_error("department_id"); ?></span>
            </div>
      </div><!-- ///////////////////// -->
      <div class="form-group">
        <label class="col-sm-2 control-label">Purchase Category <span style="color:red;">  *</span></label>
        <div class="col-sm-2">
          <select class="form-control select2" name="purchase_category" id="purchase_category">
          <option value="Normal" 
            <?php if (isset($info))
                echo "Normal" == $info->purchase_category ? 'selected="selected"' : 0; else echo "Normal" == set_value('purchase_category') ? 'selected="selected"' : 0;
            ?>>Normal</option>
          <option value="Urgent" 
            <?php if (isset($info))
                echo "Urgent" == $info->purchase_category ? 'selected="selected"' : 0; else echo "Urgent" == set_value('purchase_category') ? 'selected="selected"' : 0;
            ?>>Urgent</option>
          </select>
          <span class="error-msg"><?php echo form_error("purchase_category");?></span>
         </div>
          <label class="col-sm-2 control-label">Note<span style="color:red;">  </span></label>
           <div class="col-sm-6">
           <input type="text" name="other_note" id="other_note" class="form-control" placeholder="Note" value="<?php if(isset($info->other_note)) echo $info->other_note; else echo set_value('other_note'); ?>">
           <span class="error-msg"><?php echo form_error("other_note");?></span>
         </div>         
        
        </div><!-- ///////////////////// -->
    <?php if($this->session->userdata('stock_holder')==1){ ?>
    <div class="form-group">
      <label class="col-sm-2 control-label" style="margin-top: 14px">SCAN CODE or Search 搜索Item<span style="color:red;">  </span></label>
        <div class="col-sm-8">
          <div class="col-md-12" id="sticker" style="width: 100%; z-index: 2;">
            <div class="well well-sm"  style="overflow: hidden;">
              <div class="form-group" style="margin-bottom:0;">
                <div class="input-group wide-tip">
                  <div class="input-group-addon" style="padding-left: 10px; padding-right: 10px;">
                    <i class="fa fa-2x fa-barcode addIcon"></i></div>
                  <input id="add_item" class="form-control ui-autocomplete-input input-lg" name="add_item" value="" placeholder="Please add Asset/Item to order list" autocomplete="off" tabindex="1" type="text">
                <div class="input-group-addon" style="padding-left: 10px; padding-right: 10px;">
              </div>
            </div>
            </div>
          <div class="clearfix"></div>
        </div>
      </div>
      </div>
     </div><!-- ///////////////////// -->
     <?php }else{ ?>
    <div class="form-group">
      <div class="col-sm-12" style="">
       <a id="AddManualItem" class="btn btn-info">
        <i class="fa fa-plus-square"></i> Add Item</a>
      </div>
     </div><!-- ///////////////////// -->
     <?php } ?>
<div class="table-responsive">
<table class="table table-bordered" id="form-table">
<thead>
<tr>
  <th style="width:3%;text-align:center">SN</th>
  <th style="width:10%;text-align:center">Item code</th>
  <th style="width:20%;text-align:center">Materials Description</th>
  <th style="width:12%;text-align:center">Spacification</th>
  <th style="width:10%;text-align:center">Material Picture  </th>
  <th style="width:7%;text-align:center;">Req. Qty</th>
  <th style="width:7%;text-align:center;">Stock Qty</th>
  <th style="width:7%;text-align:center;">Pur. Qty</th>
  <th style="width:4%;text-align:center;">Unit</th>
  <th style="width:7%;text-align:center;">Unit Price</th>
  <th style="width:4%;text-align:center;">Currency</th>
  <th style="width:15%;text-align:center;">Remarks</th>
  <th style="width:5%;text-align:center">
    <i class="fa fa-trash-o"></i></th></tr>
</thead>
<tbody>
 <?php
 $i=0;
 $id=0;
  if(isset($detail)):
    foreach ($detail as  $value){
      $optionTree="";
        foreach ($clist as $rowc):
            $selected=($rowc->currency==$value->currency)? 'selected="selected"':'';
               $optionTree.='<option value="'.$rowc->currency.'" '.$selected.'>'.$rowc->currency.'</option>'; 
        endforeach;

      $str='<tr id="row_' . $id . '"><td style="text-align:center"><input type="hidden" value="'.$value->product_id.'" name="product_id[]"  id="product_id_' . $id . '"/><b>' . ($id +1).'</b></td>';
      $str.='<td><input type="text" name="product_code[]" class="form-control"  placeholder="Material Code" value="'.$value->product_code.'"  style="margin-bottom:5px;width:98%" id="product_item_'  .$id. '"/> </td>';

      $str.='<td><input type="text" name="product_name[]"  class="form-control" placeholder="'.$value->product_name.'" value="'.$value->product_name.'"  style="margin-bottom:5px;width:98%" id="product_item_'  .$id. '"/> </td>';
     $str.='<td><input type="text" name="specification[]" class="form-control" placeholder="'.$value->specification.'" value="'.$value->specification.'"  style="margin-bottom:5px;width:98%" id="specification_'  .$id. '"/> </td>';
     if($value->product_image==''){
       $str.='<td><input type="file" class="form-control"  name="image_link'  . $id . '" class="form-control" value="" id="image_link_' . $id . '"/></td>';
        }else{
         $str.='<td></td>';
       }
      $str.= '<td><input type="text" name="required_qty[]" readonly value="'.$value->required_qty.'" class="form-control"  placeholder="Quantity" style="width:98%;float:left;text-align:center"  id="required_qty_' .$id. '"/></td>';
      $str.= '<td><input type="text" name="stock_qty[]" readonly class="form-control" placeholder="Stock" value="'.$value->stock_qty.'"   style="margin-bottom:5px;width:98%;text-align:center" id="stock_qty_'.$id.'"/> </td>';
      $str.= '<td><input type="text" name="purchased_qty[]" class="form-control" placeholder="Qty"  onblur="return checkQuantity(' .$id.');" onkeyup="return checkQuantity(' .$id.');"  value="'.$value->purchased_qty.'"   style="margin-bottom:5px;width:98%;text-align:center" id="purchased_qty_'.$id.'"/> </td>';
      $str.= '<td><input type="text" name="unit_name[]"  class="form-control" value="'.$value->unit_name.'"   style="margin-bottom:5px;width:98%;text-align:center" id="unit_name_'.$id.'"></td>';
      $str.= '<td><input type="text" name="unit_price[]" class="form-control" placeholder="Price" value="'.$value->unit_price.'"   style="margin-bottom:5px;width:98%;text-align:center" id="unit_price_'.$id.'"/> </td>';
      $str.='<td> <select name="currency[]" class="form-control select2"  style="width:100%;" id="currency_' . $id . '"> '.$optionTree.' </select> </td> ';
      $str.= '<td><textarea name="remarks[]" class="form-control" placeholder="Remarks"  style="margin-bottom:0px;width:98%;padding: 2px 9px;" rows="2" id="remarks_'.$id.'">'.$value->remarks.'</textarea> </td>';
      $str.= '<td style="text-align:center"><span class="btn btn-danger btn-xs" onclick="return deleter('. $id .');" style="margin-top:5px;"><i class="fa fa-trash-o"></i></span></td></tr>';
      echo $str;
      $id++;
      }
      endif;
      ?>
</tbody>
</table>
</div>
</div>
  <!-- /.box-body -->
  <div class="box-footer">
  <div class="col-sm-4"><a href="<?php echo base_url(); ?>aformat/Deptrequisn/lists" class="btn btn-info">
    <i class="fa fa-arrow-circle-o-left" aria-hidden="true"></i> 
    Back</a></div>
  <div class="col-sm-4">
    <button type="submit" class="btn btn-info pull-right"> <i class="fa fa-save"></i> SAVE 保存</button>
  </div>
  </div>
  <!-- /.box-footer -->
</form>
</div>
</div>
</div>

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
//////////////
var deletedRow=[];
var pi_ids='';
<?php  
if(isset($info)){ 
   ?>
    var id=<?php echo count($detail); ?>;
    var pi_ids=<?php echo $info->pi_id; ?>;
    var prid=12000+<?php echo count($detail); ?>;
  <?php }else{ ?>
    var id=0;
    var prid=12000;
<?php  } ?>
var currencyselect='<?php if(isset($clist))
     {
     foreach ($clist as $rows) {?><option value="<?php echo $rows->currency; ?>"><?php echo "$rows->currency";?></option><?php }} ?> ';

$(document).ready(function(){
$("#AddManualItem").click(function(){
  var nodeStr = '<tr id="row_' + id + '"><td  style="text-align:center"><input type="hidden" value="'+prid+'" name="product_id[]"  id="product_id_' + id + '"/><b></b></td>'+
           '<td><input type="text" name="product_code[]" class="form-control" placeholder="Material Code" value="" style="margin-bottom:5px;width:98%" id="product_code_' + id + '"/> </td>' +
            '<td> <input type="text" name="product_name[]" class="form-control" placeholder="Product Name" value="" style="margin-bottom:5px;width:98%" id="product_name_' + id + '"/> </td>'+
            '<td><input type="text" name="specification[]" class="form-control" placeholder="Specification" value="" style="margin-bottom:5px;width:98%" id="specification_' + id + '"/> </td>'+          
            '<td></td>'+
            '<td><input type="text" name="required_qty[]" readonly value="1" onblur="return checkQuantity(' + id + ');" onkeyup="return checkQuantity(' + id + ');" class="form-control"  placeholder="Quantity" style="width:98%;float:left;text-align:center"  id="required_qty_' + id + '"/> </td>' +
           
            '<td> <input type="text" name="stock_qty[]"  class="form-control" placeholder="Stock" style="margin-bottom:5px;width:98%;text-align:center" value="0"  id="stock_qty_' + id + '"/> </td>' +

             '<td> <input type="text" name="purchased_qty[]" value="1" onblur="return checkQuantity(' + id + ');" onkeyup="return checkQuantity(' + id + ');" class="form-control"  placeholder="Quantity" style="width:98%;float:left;text-align:center"  id="purchased_qty_' + id + '"/> </td>' +

            '<td><input type="text" name="unit_name[]" class="form-control" placeholder="Unit Name" style="margin-bottom:5px;width:98%;text-align:center" value="Pcs"  id="unit_name_' + id + '"/></td>' +
            '<td> <input type="text" name="unit_price[]" value="0" class="form-control"  placeholder="Price" style="width:98%;float:left;text-align:center"  id="unit_price_' + id + '"/> </td>' +
            '<td><select name="currency[]" required class="form-control pull-left select2" style="width:100%;"  id="currency_' + id + '" ><option value="" selected="selected">Please Select</option>'+currencyselect+'</select> </td>' +

            '<td class="remarks"><textarea  name="remarks[]" class="form-control" placeholder="Remarks"  style="margin-bottom:0px;width:98%;padding: 2px 9px;" rows="2" id="remarks_' + id + '"></textarea> </td>' +
            ' <td style="text-align:center"> <span class="btn btn-danger btn-xs" onclick="return deleter(' + id + ');" style="margin-top:5px;"><i class="fa fa-trash-o"></i> </span> </td> </tr>';
          $("#form-table tbody").append(nodeStr);
          updateRowNo();
          id++;
          prid++;
});
  ///////  Search 搜索 Item Barcode or QCODE or Put Name //////////////////
  $("#add_item").autocomplete({
        source: function (request, response) {
        $.ajax({
            type: 'get',
            url: '<?= base_url('aformat/Deptrequisn/suggestions'); ?>',
            dataType: "json",
            data: {
                term: request.term,
                responsible_department: $('#responsible_department').val()
            },
            success: function (data) {
                $(this).removeClass('ui-autocomplete-loading');
                response(data);
            }
        });
        },
        minLength: 2,
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
            $("#alertMessageHTML").html("This Material already added!!");
            $("#alertMessagemodal").modal("show");
           }else{
            if(ui.item.image_link==null){
             var links='Please add image in item lists';
            }else{
             var links='';
            }
              //////////////////////////////
           var nodeStr = '<tr id="row_' + id + '"><td  style="text-align:center"><input type="hidden" value="'+ui.item.product_id+'" name="product_id[]"  id="product_id_' + id + '"/><b></b></td>'+
           '<td> <input type="text" name="product_code[]" class="form-control" placeholder="Material Code" value="'+ui.item.product_code+'" style="margin-bottom:5px;width:98%" id="product_code_' + id + '"/> </td>' +
            '<td> <input type="text" name="product_name[]" readonly class="form-control" placeholder="Product Name" value="'+ui.item.product_name+'" style="margin-bottom:5px;width:98%" id="product_name_' + id + '"/> </td>'+
            '<td> <input type="text" name="specification[]" class="form-control" placeholder="Specification" value="" style="margin-bottom:5px;width:98%" id="specification_' + id + '"/> </td>'+          
            '<td>'+links+'</td>'+
            '<td> <input type="text" name="required_qty[]" readonly value="'+ui.item.stock+'" onblur="return checkQuantity(' + id + ');" onkeyup="return checkQuantity(' + id + ');" class="form-control"  placeholder="Quantity" style="width:98%;float:left;text-align:center"  id="required_qty_' + id + '"/> </td>' +
           
            '<td> <input type="text" name="stock_qty[]" readonly class="form-control" placeholder="Stock" style="margin-bottom:5px;width:98%;text-align:center" value="'+ui.item.stock+'"  id="stock_qty_' + id + '"/> </td>' +

             '<td> <input type="text" name="purchased_qty[]" value="0" onblur="return checkQuantity(' + id + ');" onkeyup="return checkQuantity(' + id + ');" class="form-control"  placeholder="Quantity" style="width:98%;float:left;text-align:center"  id="purchased_qty_' + id + '"/> </td>' +

            ' <td><input type="text" name="unit_name[]" readonly class="form-control" style="margin-bottom:5px;width:98%;text-align:center" value="'+ui.item.unit_name+'"  id="unit_name_' + id + '"/></td>' +
            '<td><input type="text" name="unit_price[]" class="form-control" placeholder="Price" style="margin-bottom:5px;width:98%;text-align:center" value="'+ui.item.unit_price+'" id="unit_price_' + id + '"/> </td>' +
            '<td><select name="currency[]" required class="form-control select2" style="width:100%;"  id="currency_' + id + '"> <option value="" selected="selected">Please Select</option>'+currencyselect+'</select> </td>' +

            '<td class="remarks"><textarea  name="remarks[]" class="form-control" placeholder="Remarks"  style="margin-bottom:0px;width:98%;padding: 2px 9px;" rows="2" id="remarks_' + id + '"></textarea> </td>' +
            ' <td style="text-align:center"> <span class="btn btn-danger btn-xs" onclick="return deleter(' + id + ');" style="margin-top:5px;"><i class="fa fa-trash-o"></i> </span> </td> </tr>';
          $("#form-table tbody").append(nodeStr);
          $("#currency_"+id).val(ui.item.currency).change();
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
      if(pi_ids!=''){
        var item_id=$("#product_id_"+id).val();
         $.ajax({
            type:"post",
            url:"<?php echo base_url()?>"+'aformat/Deptrequisn/deleteitem',
            data:{pi_id:pi_ids,product_id:item_id},
            success:function(data){
              
            }
          });
        }

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
  var pinocheck=0;
 // function checkpino(){
 //      var pi_no=$("#pi_no").val();
 //      if(pi_no !=''&&pi_ids==''){
 //        $.ajax({
 //        type:"POST",
 //        url:"<?php echo base_url()?>"+'format/Deptrequisn/checkpino',
 //        data:{pi_no:pi_no,pi_id:pi_ids},
 //        success:function(data){
 //          data=JSON.parse(data);
 //          if(data.check=='YES'){
 //            pinocheck=1;
 //            $("#pi_no").val('');
 //            $('input[name=pi_no]').css('border', '1px solid #f00');
 //            $("#alertMessageHTML").html("This PI No already exit!!");
 //            $("#alertMessagemodal").modal("show");
 //          }else{
 //            $('input[name=pi_no]').css('border', '1px solid #ccc'); 
 //            pinocheck=0;
 //          }
 //        }
 //      });
 //    }else{
 //      $("#form-table tbody").empty();
 //      $(".Searchclass").show();
 //      id=0;
 //    }
 //  }
  function formsubmit(){
  var error_status=false;
  var serviceNum=$("#form-table tbody tr").length;
  var chk;
  if(serviceNum<1){
    $("#alertMessageHTML").html("Please Adding at least one Item!!");
    $("#alertMessagemodal").modal("show");
    error_status=true;
  }
  var pi_date=$("#pi_date").val();
  var demand_date=$("#demand_date").val();
  //var pi_no=$("#pi_no").val();
  // if(pi_no ==''){
  //     error_status=true;
  //     $('input[name=pi_no]').css('border', '1px solid #f00');
  //   } else {
  //     $('input[name=pi_no]').css('border', '1px solid #ccc');      
  //   }
  // if(pinocheck==1){
  //   error_status=true;
  //   $('input[name=pi_no]').css('border', '1px solid #f00');
  // }
  /////////////
  for(var i=0;i<serviceNum;i++){
    if($("#required_qty_"+i).val()==''){
      $("#required_qty_"+i).css('border', '1px solid #f00');
      error_status=true;
    }
    if($("#purchased_qty_"+i).val()==''){
      $("#purchased_qty_"+i).css('border', '1px solid #f00');
      error_status=true;
    }
    }
  if(pi_date == '') {
    error_status=true;
    $("#pi_date").css('border', '1px solid #f00');
  } else {
    $("#pi_date").css('border', '1px solid #ccc');      
  }
  if(demand_date == '') {
    error_status=true;
    $("#demand_date").css('border', '1px solid #f00');
  } else {
    $("#demand_date").css('border', '1px solid #ccc');      
  }
  if(error_status==true){
    return false;
  }else{
    return true;
  }
  $(".error-flash").delay(5000).hide(200);
}
 ////////////////////////////////////////////
//////////CHECK QUANTITY
///////////////////////////////////////////
function checkQuantity(ids){
   var purchased_qty=parseFloat($.trim($("#purchased_qty_"+ids).val()));
   var stock_qty=parseFloat($.trim($("#stock_qty_"+ids).val()));
  if($.trim(purchased_qty)==""|| $.isNumeric(purchased_qty)==false){
     $("#required_qty_"+ids).val(stock_qty);
     purchased_qty=0;
   }
   $("#required_qty_"+ids).val(purchased_qty+stock_qty);
  }
</script>