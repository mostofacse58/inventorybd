<?php 
	if(!function_exists('_dd')){
	    function _dd($arr, $die=false){
	        echo '<pre>';
	        if(empty($arr)){
	            var_dump($arr);
	        }else{
	            print_r($arr);
	        }
	        echo '</pre>';
	        if($die)die();
	    }
	}
	function preecho($data){
	   // return '<pre>'.$data.'</pre>';
		return nl2br($data);
	}
	////////////////
	function getdetails($details='',$check=FALSE){
		$CI	=&	get_instance();
		$CI->load->database();
		$currency=$CI->session->userdata('currency');
		$language=$CI->session->userdata('language');
		$ddd=array();
		/*
			foreach ($details as $key => $value) {
				if($language=='deutsch') {
				if($check=='pdelivery'){
					$details[$key]->quantity =str_replace(".",",",$value->quantity);
				}else{
					$details[$key]->quantity =str_replace(".",",",$value->quantity);
					$details[$key]->unit_price_net =str_replace(".",",",$value->unit_price_net);
					$details[$key]->unit_price_gross =str_replace(".",",",$value->unit_price_gross);
					$details[$key]->discount =str_replace(".",",",$value->discount);
					$details[$key]->sale_tax_rate =str_replace(".",",",$value->sale_tax_rate);
					$details[$key]->discount_amount =str_replace(".",",",$value->discount_amount);
					$details[$key]->sale_tax_amount =str_replace(".",",",$value->sale_tax_amount);
					$details[$key]->net_subtotal =str_replace(".",",",$value->net_subtotal);
					$details[$key]->gross_subtotal =str_replace(".",",",$value->gross_subtotal);
				}
			}
			$details[$key]->product_description =tremove2($value->product_description);
	    	}
	    	*/
		
		if($language=='deutsch') {
			foreach ($details as $key => $value) {
				if($check=='pdelivery'){
					$details[$key]->quantity =str_replace(".",",",$value->quantity);
					$proName = $value->product_name;
					$proName= trim($proName);
					$proName = stripslashes($proName);
					$proName = str_replace( array( '"' ), '\"', $proName);
					$proName = str_replace( array( '`' ), '', $proName);
					$details[$key]->product_name = $proName;
					
					$proDes = $value->product_description;
					$proDes = stripslashes($proDes);
					$proDes = preg_replace('/\r|\n/', '\n', $proDes);
					$proDes = str_replace( array( '"' ), '\"', $proDes);
					$proDes = str_replace( array( '`' ), '', $proDes);
					$details[$key]->product_description = $proDes;
					
					$unitName = $value->unit_name;
					$unitName = stripslashes($unitName);
					$unitName = str_replace( array( '"' ), '\"', $unitName);
					$unitName = str_replace( array( '`' ), '', $unitName);
					$details[$key]->unit_name = $unitName;
				}else{
					$details[$key]->quantity =str_replace(".",",",$value->quantity);
					$details[$key]->unit_price_net =str_replace(".",",",$value->unit_price_net);
					$details[$key]->unit_price_gross =str_replace(".",",",$value->unit_price_gross);
					$details[$key]->discount =str_replace(".",",",$value->discount);
					$details[$key]->sale_tax_rate =str_replace(".",",",$value->sale_tax_rate);
					$details[$key]->discount_amount =str_replace(".",",",$value->discount_amount);
					$details[$key]->sale_tax_amount =str_replace(".",",",$value->sale_tax_amount);
					$details[$key]->net_subtotal =str_replace(".",",",$value->net_subtotal);
					$details[$key]->gross_subtotal =str_replace(".",",",$value->gross_subtotal);

					$proName = $value->product_name;
					$proName= trim($proName);
					$proName = stripslashes($proName);
					$proName = str_replace( array( '"' ), '\"', $proName);
					$proName = str_replace( array( '`' ), '', $proName);
					$details[$key]->product_name = $proName;
					
				    $proDes = $value->product_description;
				    $proDes= trim($proDes);
					$proDes = stripslashes($proDes);
					$proDes = preg_replace('/\r|\n/', '\n', $proDes);
					$proDes = str_replace( array( '"' ), '\"', $proDes);
					$proDes = str_replace( array( '`' ), '', $proDes);
					$details[$key]->product_description = $proDes;
					
					$unitName = $value->unit_name;
					$unitName = stripslashes($unitName);
					$unitName = str_replace( array( '"' ), '\"', $unitName);
					$unitName = str_replace( array( '`' ), '', $unitName);
					$details[$key]->unit_name = $unitName;
				}
			}
		} else {
			foreach ($details as $key => $value) {
				$proName = $value->product_name;
				$proName= trim($proName);
				$proName = stripslashes($proName);
				$proName = str_replace( array( '"' ), '\"', $proName);
				$proName = str_replace( array( '`' ), '', $proName);
				$details[$key]->product_name = $proName;
				
				$proDes = $value->product_description;
				$proDes= trim($proDes);
				$proDes = stripslashes($proDes);
				$proDes = preg_replace('/\r|\n/', '\n', $proDes);
				$proDes = str_replace( array( '"' ), '\"', $proDes);
				$proDes = str_replace( array( '`' ), '', $proDes);
				$details[$key]->product_description = $proDes;
				
				$unitName = $value->unit_name;
				$unitName = stripslashes($unitName);
				$unitName = str_replace( array( '"' ), '\"', $unitName);
				$unitName = str_replace( array( '`' ), '', $unitName);
				$details[$key]->unit_name = $unitName;
			}
		}
		return $details;
	}
	function getdetails2($details='',$check=FALSE){
		$CI	=&	get_instance();
		$CI->load->database();
		$currency=$CI->session->userdata('currency');
		$language=$CI->session->userdata('language');
		$ddd=array();
		if($language=='deutsch') {
			foreach ($details as $key => $value) {
				$details[$key]->inv_amount =str_replace(".",",",$value->inv_amount);
				$details[$key]->inv_off_amount =str_replace(".",",",$value->inv_off_amount);
			}
		}
		return $details;
	}
	function getdiscount($details=''){
		$CI	=&	get_instance();
		$CI->load->database();
		$language=$CI->session->userdata('language');
		$ddd=array();
		if($language=='deutsch') {
		foreach ($details as $key => $value) {
			$details[$key]->dpercent =str_replace(".",",",$value->dpercent);
			$details[$key]->damount_amount =str_replace(".",",",$value->damount_amount);
		  }
		}
		return $details;
	}

	function onlyamountFormat($value=''){
		$CI	=&	get_instance();
		$CI->load->database();
		$currency=$CI->session->userdata('currency');
		$language=$CI->session->userdata('language');
		if($value==0){
			if($language=='deutsch') 
			    return number_format($value, 2, ',', '.');
		    else return number_format($value, 2);
		}
		if($language==''){
		  $language='deutsch';
		}
		if($language=='deutsch')
		$amount=number_format($value, 2, ',', '.');
	    else $amount=number_format($value,2);

		if($value!='')
		return $amount;
	    else return '';
	}
	function iTg($value=''){
		if($value==''){
			$value=0;
		}
		$CI	=&	get_instance();
		$CI->load->database();
		$language=$CI->session->userdata('language');
		if($language=='deutsch') 
		    return number_format($value, 2, ',', '.');
	    else return $value;
	}
	function tremove($value){
		$CI	=&	get_instance();
		$CI->load->database();
		$value= trim($value);
		//$value=str_replace("'","",$value);
		///$value=str_replace('"',"",$value);
		//$value=str_replace("  ","",$value);
		//$value=str_replace("  ","",$value);
		//$value=str_replace("  ","",$value);
		//$value = str_replace('/', ' ', $value);
		//$value = str_replace('®', '', $value);
		//$value = str_replace('-', ' ', $value);
		//$value = str_replace('(', '', $value);
		//$value = str_replace(')', '', $value);
		//$value = str_replace('. .', '', $value);
		//$value = str_replace("\n", ' ', $value);
		//$value = preg_replace("/\r|\n/", ", ", $value);
		return $value;
	}
	function tremove2($value){
		$CI	=&	get_instance();
		$CI->load->database();
		$value= trim($value);
		$value=str_replace("'","",$value);
		$value=str_replace('"'," Zoll",$value);
		$value=str_replace("  ","",$value);
		$value=str_replace("  ","",$value);
		$value=str_replace("  ","",$value);
		$value = str_replace('/', ' ', $value);
		$value = str_replace('®', '', $value);
		$value = str_replace('-', ' ', $value);
		$value = str_replace('(', '', $value);
		$value = str_replace(')', '', $value);
		$value = str_replace('. .', '', $value);
		$value = str_replace("\n", ' ', $value);
		$value = preg_replace("/\r|\n/", ", ", $value);
		return $value;
	}
	function gTg($value){
		if($value==''){
			$value=0;
		}
		$CI	=& get_instance();
		$CI->load->database();
		$language=$CI->session->userdata('language');
		if($language==''){
		  $language='deutsch';
		}

		if($language=='deutsch'){
			$value=str_replace(".","",$value);
			$value=str_replace(",",".",$value);
		}
		return $value;
	 }
	function amountFormat($value=''){
		$CI	=&	get_instance();
		$CI->load->database();
		$currency=$CI->session->userdata('currency');
		$language=$CI->session->userdata('language');
		if($value==0){
			if($language=='deutsch') 
			    return number_format($value, 2, ',', '.');
		    else return number_format($value, 2);
		}
		
		if($language==''){
		  $language='deutsch';
		}
		if($language=='deutsch')
		$amount=number_format($value, 2, ',', '.');
	    else $amount=number_format($value,2);

		if($value!='')
		return $amount.' '.$currency;
	    else return '';
	}
	//////// Get language phrase from language table////////
	function getLanguage($phrase_name=''){
		$CI	=&	get_instance();
		$CI->load->database();
		$language=$CI->session->userdata('language');
		if($language==''){
	        $ip = $_SERVER['REMOTE_ADDR']; 
	        $url = file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip);
		    $getInfo = json_decode($url); 
		    if(substr($getInfo->geoplugin_timezone, 0,6)=='Europe')  $language='deutsch'; else $language='english';
		}
		$query	=	$CI->db->get_where('msm_language_setup' , array('phrase_name' => $phrase_name));
		$row   	=	$query->row();	
		//Return language
		if (isset($row->$language) && $row->$language !="")
		   return $row->$language;
		else 
		   return ucwords(str_replace('_',' ',$phrase_name));
	}
	/////////////////////////
	function invoiceStatus($status){
	 $fullmean=null;
	 switch ($status) {
	 	case '1':
	 	$fullmean='<span class="btn" style="color:#808080"><i class="fas fa-drafting-compass"></i> '.getLanguage('draft').'</span>';
	 	break;
	 	case '2':
	 	$fullmean='<span class="btn" style="color:red"><i class="fas fa-adjust"></i> '.getLanguage('submitted').'</span>';
	 	break;
	 	case '3':
	 	$fullmean='<span class="btn" style="color:#50C878"><i class="fas fa-check-circle"></i> '.getLanguage('accepted').'</span>';
	 	break;
	 	case '4':
	 	$fullmean='<span class="btn" style="color:#50C878"><i class="fas fa-truck"></i> '.getLanguage('delivery').' '.getLanguage('notes').'</span>';
	 	break;
	 	case '5':
	 	$fullmean='<span class="btn" style="color:#50C878"><i class="fas fa-bell"></i> '.getLanguage('reminder').'</span>';
	 	break;

	 	case '7':
	 	$fullmean='<span class="btn" style="color:#C0C0C0"><i class="fas fa-times-circle"></i> '.getLanguage('rejected').'</span>';
	 	break;
	 	case '8':
	 	$fullmean='<span class="btn" style="color:#C0C0C0"><i class="fas fa-times-circle"></i> '.getLanguage('reversal').'</span>';
	 	break;
	 	default:
	 	$fullmean='<span class="btn" style="color:red"><i class="fas fa-adjust"></i> '.getLanguage('draft').'</span>';
	 	break;
	 }
	 return $fullmean;
	 }
	function proposalStatus($status){
	 $fullmean=null;
	 switch ($status) {
	 	case '1':
	 	$fullmean='<span class="btn" style="color:#808080"><i class="fas fa-drafting-compass"></i> '.getLanguage('draft').'</span>';
	 	break;
	 	case '2':
	 	 $fullmean='<span class="btn" style="color:red"><i class="fas fa-adjust"></i> '.getLanguage('submitted').'</span>';
	 	 break;
	 	 case '3':
	 	$fullmean='<span class="btn" style="color:#50C878"><i class="fas fa-check-circle"></i> '.getLanguage('accepted').'</span>';
	 	break;
	 	case '4':
	 	$fullmean='<span class="btn" style="color:#50C878"><i class="fas fa-truck"></i> '.getLanguage('orders').'</span>';
	 	break;
	 	case '5':
	 	$fullmean='<span class="btn" style="color:#50C878"><i class="fas fa-check-circle"></i> '.getLanguage('invoices').'</span>';
	 	break;
	 	case '7':
	 	$fullmean='<span class="btn" style="color:#C0C0C0"><i class="fas fa-times-circle"></i> '.getLanguage('rejected').'</span>';
	 	break;

	 	case '8':
	 	$fullmean='<span class="btn" style="color:#C0C0C0"><i class="fas fa-times-circle"></i> '.getLanguage('reversal').'</span>';
	 	break;
	 	default:
	 	$fullmean='<span class="btn" style="color:red"><i class="fas fa-adjust"></i> '.getLanguage('draft').'</span>';
	 	break;
	 }
	 return $fullmean;
	 }
	 function orderStatus($status){
	 $fullmean=null;
	 switch ($status) {
	 	case '1':
	 	$fullmean='<span class="btn" style="color:#808080"><i class="fas fa-drafting-compass"></i> '.getLanguage('draft').'</span>';
	 	break;
	 	case '2':
	 	$fullmean='<span class="btn" style="color:red"><i class="fas fa-adjust"></i> '.getLanguage('submitted').'</span>';
	 	break;
	 	case '3':
	 	$fullmean='<span class="btn" style="color:#50C878"><i class="fas fa-check-circle"></i> '.getLanguage('accepted').'</span>';
	 	break;
	 	case '4':
	 	$fullmean='<span class="btn" style="color:#50C878"><i class="fas fa-truck"></i> '.getLanguage('delivery').' '.getLanguage('notes').'</span>';
	 	break;
	 	case '5':
	 	$fullmean='<span class="btn" style="color:#50C878"><i class="fas fa-check-circle"></i> '.getLanguage('invoices').'</span>';
	 	break;
	 	case '7':
	 	$fullmean='<span class="btn" style="color:#C0C0C0"><i class="fas fa-times-circle"></i> '.getLanguage('rejected').'</span>';
	 	break;

	 	case '8':
	 	$fullmean='<span class="btn" style="color:#C0C0C0"><i class="fas fa-times-circle"></i> '.getLanguage('reversal').'</span>';
	 	break;
	 	default:
	 	$fullmean='<span class="btn" style="color:red"><i class="fas fa-adjust"></i> '.getLanguage('draft').'</span>';
	 	break;
	 }
	 return $fullmean;
	 }
	 function deliveryStatus($status){
		$fullmean=null;
		switch ($status) {
		 	case '1':
		 	$fullmean='<span class="btn" style="color:#808080"><i class="fas fa-drafting-compass"></i> '.getLanguage('draft').'</span>';
		 	break;
		 	case '2':
		 	$fullmean='<span class="btn" style="color:red"><i class="fas fa-adjust"></i> '.getLanguage('submitted').'</span>';
		 	break;
		 	case '3':
		 	$fullmean='<span class="btn" style="color:#50C878"><i class="fas fa-check-circle"></i> '.getLanguage('accepted').'</span>';
		 	break;
		 	case '5':
		 	$fullmean='<span class="btn" style="color:#50C878"><i class="fas fa-check-circle"></i> '.getLanguage('invoices').'</span>';
		 	break;
		 	case '7':
		 	$fullmean='<span class="btn" style="color:#C0C0C0"><i class="fas fa-times-circle"></i> '.getLanguage('rejected').'</span>';
		 	break;

		 	case '8':
		 	$fullmean='<span class="btn" style="color:#C0C0C0"><i class="fas fa-times-circle"></i> '.getLanguage('reversal').'</span>';
		 	break;
		 	default:
		 	$fullmean='<span class="btn" style="color:red"><i class="fas fa-adjust"></i> '.getLanguage('draft').'</span>';
		 	break;
		}
		return $fullmean;
	 }
	 function reminderStatus($status){
		 $fullmean=null;
		 switch ($status) {
		 	case '1':
		 	$fullmean='<span class="btn" style="color:#808080"><i class="fas fa-drafting-compass"></i> '.getLanguage('draft').'</span>';
		 	break;
		 	
		 	case '2':
		 	$fullmean='<span class="btn" style="color:#50C878"><i class="fas fa-check-circle"></i> '.getLanguage('accepted').'</span>';
		 	break;
		 	case '3':
		 	$fullmean='<span class="btn" style="color:green"><i class="fas fa-wallet"></i> '.getLanguage('paid').'</span>';
		 	break;
		 	case '8':
		 	$fullmean='<span class="btn" style="color:#C0C0C0"><i class="fas fa-times-circle"></i> '.getLanguage('reversal').'</span>';
		 	break;
		 	default:
		 	$fullmean='<span class="btn" style="color:red"><i class="fas fa-adjust"></i> '.getLanguage('draft').'</span>';
		 	break;
		 }
		 return $fullmean;
	 }
	//////////////GET DIFFERENT DATE FORMAT///////////////
	function findDate($date){
		$CI	=&	get_instance();
		$company_id=$CI->session->userdata('company_id');
		$CI->load->database();
		$row	=	$CI->db->query("SELECT date_format FROM msm_company_info where id=$company_id")->row();
		$format=null;
		if($date==''||$date==NULl){
			return '';
		}
		switch ($row->date_format) {
			case 'dd/mm/yyyy':
				$format='d/m/Y';
				break;
			case 'mm/dd/yyyy':
				$format='m/d/Y';
				break;
			case 'yyyy/mm/dd':
				$format='Y/m/d';
				break;
			case 'yyyy-mm-dd':
				$format='Y-m-d';
				break;
			default:
				$format='d/m/Y';
				break;
		}
		return date($format,strtotime($date));
	}
	function findDate2($date){
		$CI	=&	get_instance();
		$format=null;
		if($date==''||$date==NULl){
			return '';
		}
		$format='d/m/Y';
		return date($format,strtotime($date));
	}
		/////////////////// alterDateFormat////////////////
	function alterDateFormat($date){
		$CI	=&	get_instance();
		$CI->load->database();
		$company_id=$CI->session->userdata('company_id');
		$row	=	$CI->db->query("SELECT date_format FROM msm_company_info where id=$company_id")->row();
		$format=null;
		if($date==''||$date==NULl){
			return '';
		}
		if($date!=""){
			$dateSlug=explode('/',$date);
			//return $dateSlug[2].'-'.$dateSlug[1].'-'.$dateSlug[0];
			switch ($row->date_format) {
			case 'dd/mm/yyyy':
				$format=$dateSlug[2].'-'.$dateSlug[1].'-'.$dateSlug[0];
				break;
			case 'mm/dd/yyyy':
				$format=$dateSlug[2].'-'.$dateSlug[0].'-'.$dateSlug[1];
				break;
			case 'yyyy/mm/dd':
				$format=$dateSlug[0].'-'.$dateSlug[1].'-'.$dateSlug[2];
				break;
			case 'yyyy-mm-dd':
				$format=$dateSlug[0].'-'.$dateSlug[1].'-'.$dateSlug[2];
				break;
			default:
				$format=$dateSlug[2].'-'.$dateSlug[1].'-'.$dateSlug[0];
				break;
				}
		return $format;
		}else{
			return "0000-00-00 00:00:00";
		}
	}
	function findDates($date){
		date_default_timezone_set('Asia/Dhaka');
		$CI	=&	get_instance();
		$CI->load->database();
		$company_id=$CI->session->userdata('company_id');
		$query1	=	$CI->db->query("SELECT date_format FROM msm_company_info where id=$company_id")->row();
		$row=mysqli_fetch_array($query1);
		$format=null;
		switch ($row['date_format']) {
		 	case 'dd/mm/yyyy':
		 	$format='d/m/Y h:i:s A';
		 	break;
		 	case 'mm/dd/yyyy':
		 	$format='m/d/Y h:i:s A';
		 	break;
		 	case 'yyyy/mm/dd':
		 	$format='Y/m/d h:i:s A';
		 	break;
		 	default:
		 	$format='d/m/Y h:i:s A';
		 	break;
		}
		return date($format,strtotime($date));
	}

	function getCompanyInfo(){
		$CI = & get_instance();
		$CI->load->database();
		$company_id=$CI->session->userdata('company_id');
		$query1=$CI->db->query("SELECT * FROM msm_company_info WHERE id='$company_id'")->row();
		return $query1;
	}
	function getfin(){
		$CI = & get_instance();
		$CI->load->database();
		$company_id=$CI->session->userdata('company_id');
		$result=$CI->db->query("SELECT * FROM msm_mostofa 
			WHERE id=1")->row();
		return $result;
	}
	function getcolor($project_status){
		$CI = & get_instance();
		$CI->load->database();
		$company_id=$CI->session->userdata('company_id');
		$btncolor=$CI->db->query("SELECT btncolor FROM msm_project_status 
			WHERE project_status='$project_status' 
			AND (company_id=$company_id OR company_id=0) ")->row('btncolor');
		return $btncolor;
	}
	function checkCat($ecategory_id){
		$CI = & get_instance();
		$CI->load->database();
		$company_id=$CI->session->userdata('company_id');
		$result=$CI->db->query("SELECT * FROM msm_income_expenditure 
			WHERE ecategory_id=$ecategory_id")->result();
		return count($result);
	}
	function getContactNote($contact_id){
		$CI = & get_instance();
		$CI->load->database();
		$company_id=$CI->session->userdata('company_id');
		$information=$CI->db->query("SELECT * FROM msm_contact_note 
			WHERE contact_id=$contact_id 
			AND company_id=$company_id 
			AND status=1
			ORDER BY id DESC")->row();

		if(!is_null($information))
	    return $information->title;
	    else return " ";
	}
	function getProjectNote($project_ref){
		$CI = & get_instance();
		$CI->load->database();
		$company_id=$CI->session->userdata('company_id');
		$information=$CI->db->query("SELECT * FROM msm_project_note 
			WHERE project_ref='$project_ref' 
			AND company_id=$company_id 
			AND status=1
			ORDER BY id DESC")->row();

		if(count($information)>0)
	    return $information->project_note;
	    else return "";
	}
	function getName($id='',$table,$name){
		$CI = & get_instance();
	    $information = $CI->db->query("SELECT * FROM $table 
	    	WHERE id='$id'")->row();
	    if(count($information)>0)
	    return $information->$name;
	    else echo "";
	}
	function getCode($id=''){
		$CI = & get_instance();
		if($id!=0){
		    $information = $CI->db->query("SELECT * FROM msm_product_info
		    	WHERE id='$id'")->row();
	    if(count($information)>0)
	         return $information->product_code;
	    else return "";
	    }else{
	    	return "";
	    } 
	}
	function getUName($id=''){
		$CI = & get_instance();
	    $information = $CI->db->query("SELECT * FROM msm_user_info 
	    	WHERE id='$id'")->row();
	    if(count($information)>0)
	    return "$information->first_name $information->last_name";
	    else echo "";
	}
	function getCat($id=''){
		$CI = & get_instance();
	    $information = $CI->db->query("SELECT * FROM msm_category_info 
	    	WHERE id='$id'")->row();
	    if(count($information)>0)
	    return "$information->category_name";
	    else echo "";
	}
	function getEcategory($mcategory_id=''){
		$CI = & get_instance();
		$company_id=$CI->session->userdata('company_id');
	    $result = $CI->db->query("SELECT * FROM msm_expenditure_category 
	    	WHERE mcategory_id='$mcategory_id' AND (company_id=$company_id OR company_id=0)
	    	ORDER BY id ASC")->result();
	    return $result;

	}
	if (!function_exists('getMainModuleName')) {
	    function getMainModuleName($id)
	    {
	        $CI = &get_instance();
	        $CI->db->select("*");
	        $CI->db->from("msm_main_modules");
	        $CI->db->where("id", $id);
	        $result = $CI->db->get()->row();
	        if ($result) {
	            return $result->name;
	        } else {
	            return '';
	        }
	    }
	}
	if ( ! function_exists('checkAccess')) {
	    function checkAccess($controller, $function)
	    {  
	        $CI = &get_instance();
	        $user_type = $CI->session->userdata('user_type');
	        $package_type = $CI->session->userdata('package_type');
	        if($user_type==1){
	            return true;
	        }else{
	            $cmenu=$CI->db->query("SELECT * FROM msm_access
			        WHERE id=$controller 
			        AND package_type LIKE '%$package_type%' ")->result();
	            $controllerFunction = $function . "-" . $controller;
	            if (!in_array($controllerFunction, $CI->session->userdata("function_access"))||is_null($cmenu)) {
	                return false;
	            } else {
	                return true;
	            }
	        }

	    }
	}
	if ( ! function_exists('checkLectmenu')) {
	    function checkLeftmenu($controller, $function)
	    {  
	        $CI = &get_instance();

	        $user_type = $CI->session->userdata('user_type');
	        if($user_type==1) return true;
	        $controllerFunction = $function . "-" . $controller;
	        if (!in_array($controllerFunction, $CI->session->userdata("function_access"))) {
	            return false;
	        } else {
	            return true;
	        }
	        
	        

	    }
	}
	if ( ! function_exists('checkLectmenu2')) {
	    function checkLeftmenu2($controller, $function)
	    {  
	        $CI = &get_instance();
	        $user_type = $CI->session->userdata('user_type');
	        $package_type = $CI->session->userdata('package_type');
	        if($user_type==1){
	            return true;
	        }else{
	            $cmenu=$CI->db->query("SELECT * FROM msm_access
			        WHERE id=$controller 
			        AND package_type LIKE '%$package_type%'")->result();
	           // $controllerFunction = $function . "-" . $controller;
	            if (is_null($cmenu)) {
	                return false;
	            } else {
	                return true;
	            }
	        }

	    }
	}
	if ( ! function_exists('checkpackage')) {
	    function checkpackage($controller, $function)
	    {  
	        $CI = &get_instance();
	        $user_type = $CI->session->userdata('user_type');
	        $package_type = $CI->session->userdata('package_type');
	        $cmenu=$CI->db->query("SELECT * FROM msm_access
		        WHERE id=$controller 
		        AND package_type LIKE '%$package_type%'")->result();
	        $controllerFunction = $function . "-" . $controller;
	        if (!in_array($controllerFunction, $CI->session->userdata("function_access"))||is_null($cmenu)) {
	            return 'restriction';
	        } else {
	            return '';
	        }        

	    }
	}

	function get_payment_methods(){
		return array('SEPA Überweisung'=>'SEPA Überweisung','SEPA Lastschrift'=>'SEPA Lastschrift','Bargeld'=>'Bargeld','Schuldenausgleich zwischen beiden Parteien'=>'Schuldenausgleich zwischen beiden Parteien','Scheck'=>'Scheck');
	}



////////////////////////////////////


?>
