<?php


use Illuminate\Database\Eloquent\Model as Eloquent;

class Contact extends Eloquent
{
	protected $table = 'msm_contact_info';
	protected $fillable = array('person_or_org','contact_no','organization_name',
		'ctype','salutation','first_name','last_name','legal_name',
		'creditor_number','phone_no1','zip_code','city','country','street'
	);
	public $timestamps = false;
}
