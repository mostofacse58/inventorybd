<?php
/**
 * Redirect to previous page if http referer is set. Otherwise to server root.
 */
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

if ( ! function_exists('redirect_back'))
{
    function redirect_back()
    {
        if(isset($_SERVER['HTTP_REFERER']))
        { 
              header('Location: '.$_SERVER['HTTP_REFERER']);
          
        }
        else
        {
         
             header('Location: http://'.$_SERVER['SERVER_NAME']);

        }
        exit;
    }
}
?>