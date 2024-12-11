<?php


use Illuminate\Database\Eloquent\Model as Eloquent;

class Order_discount extends Eloquent
{
	protected $table = 'msm_order_discount';
	protected $fillable = array('order_id','dplus_minus','discount_des','dpercent','dtype',
		'damount_amount','create_date','user_id','company_id','status');
	public $timestamps = false;
	
}
