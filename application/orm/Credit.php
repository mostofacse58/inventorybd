<?php


use Illuminate\Database\Eloquent\Model as Eloquent;

class Credit extends Eloquent
{
	protected $table = 'msm_credit_master';
	protected $fillable = array('credit_no','subject','inv_rinv',
		'credit_date','contact_id','contact_name',
		'contact_address','reference_no','invoice_no',
		'tax_ref','country_name', 'sale_tax_id',
		'delivery_date','header_content',
		'footer_content','currency',
		'day_wise_discount_amount',
		'internal_contact_person_id','payment_method',
		'total_net_amount','total_tax','total_discount',
		'shipping_value','grand_total_amount','subtotal_amount',
		'user_id','company_id','this_status','status');
	
	public function credit_details(){
		return $this->hasMany('Credit_details','credit_id','id')->where('status',1);
	}
	public function credit_discount(){
		return $this->hasMany('Credit_discount','credit_id','id')->where('status',1);
	}
	public function country(){
		return $this->belongsTo('Country','country_name');
	}
	public function user(){
		return $this->belongsTo('User','user_id');
	}
	protected static function boot() {
		parent::boot();
		static::deleting(function(Credit $credit) {
			foreach ($credit->credit_details as $detail){
				$detail->delete();
			}
      });
	}


}
