<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('pr'))
{
        function pr($d)
        {
                echo "<pre>";
                print_r($d);
                echo "</pre>"; 
                exit();
        }
}
?>
