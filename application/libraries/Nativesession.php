<?php
if ( ! defined('BASEPATH') )
    exit( 'No direct script access allowed' );

class Nativesession
{
    public function __construct()
    {
//      if (session_status() === PHP_SESSION_NONE){session_start();}
        if(!isset($_SESSION)){session_start();}
    }

    public function set( $key, $value )
    {
        $_SESSION[$key] = $value;
        
    }

    public function get( $key )
    {
        return isset( $_SESSION[$key] ) ? $_SESSION[$key] : null;
    }

    public function regenerateId( $delOld = false )
    {
        session_regenerate_id( $delOld );
    }

    public function delete( $key )
    {
        unset( $_SESSION[$key] );
    }
}

?>