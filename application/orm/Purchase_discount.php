<?php


use Illuminate\Database\Eloquent\Model as Eloquent;

class Purchase_discount extends Eloquent
{
	protected $table = 'msm_purchase_discount';
	protected $fillable = array('purchase_id','dplus_minus','discount_des','dpercent','dtype',
		'damount_amount','create_date','user_id','company_id','status');
	public $timestamps = false;
	
}
