<?php


use Illuminate\Database\Eloquent\Model as Eloquent;

class Pdelivery extends Eloquent
{
	protected $table = 'msm_pdelivery_master';
	protected $fillable = array('subject','pdelivery_no','pdelivery_date',
		'contact_id','contact_name', 'contact_address',
		'reference_no','project_reference_no','country_name',
		'internal_contact_person_id',
		'user_id','company_id','this_status','status');

	public function pdelivery_details(){
		return $this->hasMany('Pdelivery_details','pdelivery_id','id')->where('status',1);
	}
	public function country(){
		return $this->belongsTo('country','country_name');
	}
	public function user(){
		return $this->belongsTo('User','user_id');
	}
	protected static function boot() {
		parent::boot();
		static::deleting(function(Pdelivery $pdelivery) {
			foreach ($pdelivery->pdelivery_details as $detail){
				$detail->delete();
			}
      });
	}


}
