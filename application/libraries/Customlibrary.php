<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Customlibrary {

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

}