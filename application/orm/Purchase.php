<?php


use Illuminate\Database\Eloquent\Model as Eloquent;

class Purchase extends Eloquent
{
	protected $table = 'msm_purchase_master';
	protected $fillable = array('subject','purchase_no','purchase_date','contact_id','contact_name', 'contact_address',
		'reference_no','project_reference_no','country_name',
		'header_content','footer_content','currency',
		'no_of_day','day_wise_discount_amount','internal_contact_person_id','payment_method','subtotal_amount',
		'total_net_amount','total_tax','total_discount','shipping_value','grand_total_amount',
		'user_id','company_id','this_status','status');

	public function purchase_details(){
		return $this->hasMany('Purchase_details','purchase_id','id')->where('status',1);
	}
	public function purchase_discount(){
		return $this->hasMany('Purchase_discount','purchase_id','id')->where('status',1);
	}
	public function country(){
		return $this->belongsTo('country','country_name');
	}
	public function user(){
		return $this->belongsTo('User','user_id');
	}
	protected static function boot() {
		parent::boot();
		static::deleting(function(Purchase $purchase) {
			foreach ($purchase->purchase_details as $detail){
				$detail->delete();
			}
      });
	}


}
