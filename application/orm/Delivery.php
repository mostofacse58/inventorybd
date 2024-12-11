<?php


use Illuminate\Database\Eloquent\Model as Eloquent;

class Delivery extends Eloquent
{
	protected $table = 'msm_delivery_master';
	protected $fillable = array('subject','delivery_no','delivery_date','contact_id','contact_name', 'contact_address',
		'reference_no','project_reference_no','country_name',
		'header_content','footer_content','currency',
		'no_of_day','day_wise_discount_amount','internal_contact_person_id','payment_method','subtotal_amount',
		'total_net_amount','total_tax','total_discount','shipping_value','grand_total_amount',
		'user_id','company_id','this_status','status');

	public function delivery_details(){
		return $this->hasMany('Delivery_details','delivery_id','id')->where('status',1);
	}
	public function delivery_discount(){
		return $this->hasMany('Delivery_discount','delivery_id','id')->where('status',1);
	}
	public function country(){
		return $this->belongsTo('country','country_name');
	}
	public function user(){
		return $this->belongsTo('User','user_id');
	}
	protected static function boot() {
		parent::boot();
		static::deleting(function(Delivery $delivery) {
			foreach ($delivery->delivery_details as $detail){
				$detail->delete();
			}
      });
	}


}
