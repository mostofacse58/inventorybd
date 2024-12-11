<?php


use Illuminate\Database\Eloquent\Model as Eloquent;

class Country extends Eloquent
{
	protected $table = 'msm_country_info';
	protected $fillable = array('department_id','company_id');
	
}
