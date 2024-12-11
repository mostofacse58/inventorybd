<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class Proposal_details extends Eloquent
{
	protected $table = 'msm_proposal_details';
	protected $fillable = array('proposal_id','product_id',
		'product_name','product_description','quantity','unit_name',
		'unit_price_net','unit_price_gross',
		'sale_tax_rate','sale_tax_amount','discount',
		'discount_type','discount_amount',
		'net_subtotal','gross_subtotal','create_date',
		'company_id','user_id','status');

	public function user(){
		return $this->belongsTo('User','user_id');
	}
	public $timestamps = false;
	
}
