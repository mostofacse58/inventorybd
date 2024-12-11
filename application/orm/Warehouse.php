<?php


use Illuminate\Database\Eloquent\Model as Eloquent;

class Warehouse extends Eloquent
{
	protected $table = 'msm_warehouse_info';
	protected $fillable = array('user_id','warehouse_name','stock_qty','company_id','status');

}
