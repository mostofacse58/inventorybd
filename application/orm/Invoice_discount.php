<?php


use Illuminate\Database\Eloquent\Model as Eloquent;

class Invoice_discount extends Eloquent
{
	protected $table = 'msm_invoice_discount';
	protected $fillable = array('invoice_id','dplus_minus','discount_des','dpercent','dtype',
		'damount_amount','create_date','user_id','company_id','status');
	public $timestamps = false;
	
}
