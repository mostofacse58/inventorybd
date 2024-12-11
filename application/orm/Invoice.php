<?php


use Illuminate\Database\Eloquent\Model as Eloquent;

class Invoice extends Eloquent
{
	protected $table = 'msm_invoice_master';
	protected $fillable = array('invoice_no','subject','inv_rinv',
		'invoice_date','contact_id','contact_name',
		'contact_address','reference_no','project_reference_no',
		'invoice_interval','country_name', 'due_days',
		'invoice_duedate','delivery_date','header_content',
		'footer_content','currency',
		'invoice_interval','next_inv_date','end_date',
		'no_of_day','day_wise_discount_amount',
		'internal_contact_person_id','payment_method',
		'total_net_amount','total_tax','total_discount',
		'shipping_value','grand_total_amount','subtotal_amount',
		'user_id','company_id','this_status','status');
	
	public function invoice_details(){
		return $this->hasMany('Invoice_details','invoice_id','id')->where('status',1);
	}
	public function invoice_discount(){
		return $this->hasMany('Invoice_discount','invoice_id','id')->where('status',1);
	}
	public function country(){
		return $this->belongsTo('Country','country_name');
	}
	public function user(){
		return $this->belongsTo('User','user_id');
	}
	protected static function boot() {
		parent::boot();
		static::deleting(function(Invoice $invoice) {
			foreach ($invoice->invoice_details as $detail){
				$detail->delete();
			}
      });
	}


}
