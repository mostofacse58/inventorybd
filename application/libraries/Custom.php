<?php if (!defined('BASEPATH'))  exit('No direct script access allowed');
class Custom{
	var $CI;

    function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->library('session');
        $this->CI->load->library('user_agent');
    }

    function getCSRF() {
        $csrf_input = "<input type='hidden' ";
        $csrf_input .= "name='" . $this->CI->security->get_csrf_token_name() . "'";
        $csrf_input .= " value='" . $this->CI->security->get_csrf_hash() . "'/>";
        return $csrf_input;
    }
	function encrypt_decrypt($key, $type){	
		//return $key;
		$encryptionMethod = "AES-256-CBC";
		$secretHash = "25c6c7ff35b9979b151f2136cd13b0ff";
		//if( !$key ){ return false; }
		if($type=='decrypt'){
			$key = strtr(urldecode($key),'-_,','+/=');
		    return openssl_decrypt($key, $encryptionMethod, $secretHash);
		}elseif($type=='encrypt'){
			$decryptedMessage = openssl_encrypt($key, $encryptionMethod, $secretHash);
			return urlencode(strtr($decryptedMessage,'+/=','-_,'));
		}

	}
}
?>