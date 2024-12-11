<?php


use Illuminate\Database\Eloquent\Model as Eloquent;

class Credit_details extends Eloquent
{
	protected $table = 'msm_credit_details';
	protected $fillable = array('credit_id','product_id','product_name','product_description','quantity','unit_name',
		'unit_price_net','unit_price_gross','sale_tax_rate','sale_tax_amount','discount','discount_type','discount_amount',
		'net_subtotal','gross_subtotal','create_date','user_id','company_id','status');
	public $timestamps = false;
	
}
