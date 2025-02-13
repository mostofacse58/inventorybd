<style>
   table.table-bordered tbody tr td{
        border-bottom: 1px solid #e2e2e2;
    }
    table.table-bordered tbody tr td:last-child{
        border: 1px solid #e2e2e2;
    }
    table.table-bordered tbody tr td h3{margin:0px;}
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
          "endDate": '0d',
          "autoclose": true
      });
    });
///////////////////////////////////////////


//////////////
var deletedRow=[];
<?php  
if(isset($info)){ ?>
     var id=<?php echo  count($detail); ?>;
     <?php }else{ ?>
    var id=0;
    <?php } ?>


</script>
<div class="row">
    <div class="col-md-12">
        <div class="box box-info">
      <!-- /.box-header -->
        <form class="form-horizontal" action="<?php echo base_url(); ?>canteen/Vquotation/save<?php if (isset($info)) echo "/$info->quotation_id"; ?>" method="POST" enctype="multipart/form-data" onsubmit="return formsubmit();">
         <div class="box-body">
            <div class="form-group">
          <label class="col-sm-1 control-label">Type   <span style="color:red;">  *</span></label>
           <div class="col-sm-2">
            <select class="form-control" name="q_type" id="q_type" required="">
              <option value="" selected="selected">Select</option>
              <option value="1"
                <?php if(isset($info)) echo '1'==$info->q_type? 'selected="selected"':0; else echo set_select('q_type','1');?>>
              For BD Canteen</option>
              <option value="2"
                <?php if(isset($info)) echo '2'==$info->q_type? 'selected="selected"':0; else echo set_select('q_type','2');?>>
              For CN Canteen</option>
            </select>
           <span class="error-msg"><?php echo form_error("q_type");?></span>
         </div>
      
         <label class="col-sm-2 control-label">Quotation Date <span style="color:red;">  *</span></label>
         <div class="col-sm-2">
               <div class="input-group date">
             <div class="input-group-addon">
               <i class="fa fa-calendar"></i>
             </div>
             <input type="text" name="quotation_date" readonly id="quotation_date" class="form-control pull-right" value="<?php if(isset($info)) echo findDate($info->quotation_date); else echo date('d/m/Y'); ?>">
           </div>
           <span class="error-msg"><?php echo form_error("quotation_date");?></span>
          </div>
           <label class="col-sm-2 control-label">Note<span style="color:red;">  </span></label>
           <div class="col-sm-2">
           <input type="text" name="other_note" id="other_note" class="form-control" placeholder="Note" value="<?php if(isset($info->other_note)) echo $info->other_note; else echo set_value('other_note'); ?>">
           <span class="error-msg"><?php echo form_error("other_note");?></span>
         </div>  
       </div><!-- ///////////////////// -->
        <div class="form-group">
          <label class="col-sm-2 control-label">Attachment</label>
          <div class="col-sm-3">
            <input type="file" class="form-control"  name="attachment" class="form-control" >
            <?php if(isset($info) &&!empty($info->attachment)) { ?>
              <div style="margin-top:10px;">
              <a href="<?php echo base_url(); ?>dashboard/ReqAttach/<?php echo $info->attachment; ?>">Download</a>
              </div>
            <?php } ?>
            <span>Allow only: pdf,xls,jpg</span>
          </div>
      </div>

<div class="form-group">        
<div class="table-responsive">
<table class="table table-bordered" id="formtable">
<thead>
<tr>
  <th style="width:2%;text-align:center">SN</th>
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
</thead>
<tbody>
 <?php
 $i=0;
 $id=0;
  if(isset($detail)):
    foreach ($detail as  $value) {
      $stock=$value->main_stock+$value->quantity;
      $str='<tr id="row_' . $id . '"><td style="text-align:center"><input type="hidden" value="'.$value->quotation_detail_id.'" name="quotation_detail_id[]"  id="quotation_detail_id_' . $id . '"/><input type="hidden" value="'.$value->product_id.'" name="product_id[]"  id="product_id_' . $id . '"/><b>' . ($id +1).'</b></td><td>="'.$value->product_name.' </td>';
      $str.= '<td> <label  style="width:98%;float:left">'.$value->specification.'</label></td>';
      $str.= '<td> <label  style="width:98%;float:left">'.$value->unit_name.'</label></td>';
      $str.= '<td> <label  style="width:98%;float:left">'.$value->previous_price.'</label></td>';
      $str.= '<td><input type="text"  onfocus="this.select();" name="verified_market_price[]" value="'.$value->verified_market_price.'" class="form-control"  placeholder="verified_market_price" style="width:98%;float:left;text-align:center"  id="verified_market_price_' .$id. '"></td>';
      $str.= '<td> <label  style="width:98%;float:left">'.$value->market_price.'</label></td>';
      $str.= '<td> <label  style="width:98%;float:left">'.$value->operational_cost.'</label></td>';
      $str.= '<td> <label  style="width:98%;float:left">'.$value->profit.'</label></td>';
      $str.= '<td> <label  style="width:98%;float:left">'.$value->present_price.'</label></td>';
      $str.= '<td> <label  style="width:98%;float:left">'.$value->pricedifference.'</label></td>';

      $str.= '</tr>';
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
</div>

</div>
  <!-- /.box-body -->
  <div class="box-footer">
      <div class="col-sm-4"><a href="<?php echo base_url(); ?>canteen/Quotation/lists" class="btn btn-info">
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

