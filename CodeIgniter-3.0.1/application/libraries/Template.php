<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
/** 
 * 
 *  This template library can be used to automatically build 
 *    views with a header and footer 
 * 
 * 
 *    Usage: $this->template->show('view', $args); 
 *    Note: make sure to include in autoload.php 
 * 
 * 
 */ 
class Template 
{ 
    function show($view, $title, $TPL) 
    { 
        $CI =& get_instance(); 
		
		$TPL['title'] = $title;
			
		// Load the view, passing in the template array
		$CI->load->view('header', $TPL); 
		$CI->load->view($view, $TPL); 
		$CI->load->view('footer', $TPL); 
    }
}