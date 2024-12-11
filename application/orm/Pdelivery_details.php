<?php


use Illuminate\Database\Eloquent\Model as Eloquent;

class Pdelivery_details extends Eloquent
{
	protected $table = 'msm_pdelivery_details';
	protected $fillable = array('pdelivery_id','product_id','product_name','product_description','quantity','unit_name',
		'create_date',
		'company_id','user_id','status');

	public function user(){
		return $this->belongsTo('User','user_id');
	}
	public $timestamps = false;
	
}
