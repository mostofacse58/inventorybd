<?php


use Illuminate\Database\Eloquent\Model as Eloquent;

class Proposal extends Eloquent
{
	protected $table = 'msm_proposal_master';
	protected $fillable = array('subject','proposal_no','proposal_date','contact_id','contact_name', 'contact_address',
		'reference_no','project_reference_no','country_name',
		'header_content','footer_content','currency',
		'no_of_day','day_wise_discount_amount','internal_contact_person_id','payment_method','subtotal_amount',
		'total_net_amount','total_tax','total_discount','shipping_value','grand_total_amount',
		'user_id','company_id','this_status','status');

	public function proposal_details(){
		return $this->hasMany('Proposal_details','proposal_id','id')->where('status',1);
	}
	public function proposal_discount(){
		return $this->hasMany('Proposal_discount','proposal_id','id')->where('status',1);
	}
	public function country(){
		return $this->belongsTo('country','country_name');
	}
	public function user(){
		return $this->belongsTo('User','user_id');
	}
	protected static function boot() {
		parent::boot();
		static::deleting(function(Proposal $proposal) {
			foreach ($proposal->proposal_details as $detail){
				$detail->delete();
			}
      });
	}


}
