<?php


use Illuminate\Database\Eloquent\Model as Eloquent;

class Order_details extends Eloquent
{
	protected $table = 'msm_order_details';
	protected $fillable = array('order_id','product_id','product_name','product_description','quantity','unit_name',
		'unit_price_net','unit_price_gross','sale_tax_rate','sale_tax_amount','discount','discount_type','discount_amount',
		'net_subtotal','gross_subtotal','create_date','user_id','country_name','company_id','status');

	public function country(){
		return $this->belongsTo('Country','country_name');
	}
	public function user(){
		return $this->belongsTo('User','user_id');
	}
	public $timestamps = false;
	
}
