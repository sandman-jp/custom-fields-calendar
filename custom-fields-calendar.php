<?php
/*
Plugin Name: Custom Fields Calendar
Plugin URI: 
Description: Calendar with custom fields.
Version: 1.0.3-alpha
Author: 地空 Chhkuw Design
Author URI: 
Text Domain: CFC
Domain Path: /lang
License: GPLv2 or later
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if (!class_exists('CFC')){


define('CFC_VIRSION', '1.0.3-alpha');

//general settings
define('CFC_DIR', dirname(__FILE__));
define('CFC_DIR_INCLUDES', CFC_DIR.'/includes');
define('CFC_DIR_ASSETS', CFC_DIR.'/assets');
define('CFC_DIR_TEMPLATES', CFC_DIR.'/templates');
define('CFC_TEXTDOMAIN', 'CFC');

//post type
define('CF_CALENDAR', 'cf-calendar');



class CustomFieldsCalendar {
	
	
	function __construct() {
		
		add_action('plugins_loaded', array($this, 'load'));
		
		
		define('CFC_URL', plugins_url('/', __FILE__));
		define('CFC_ASSETS_URL', CFC_URL.'assets');
	}
	
	/*
   * Load plugin
   */
  function load(){
		
		//if(CFC_activate::is_acf_active()){
		require_once CFC_DIR_INCLUDES.'/tools/options.php';
		require_once CFC_DIR_INCLUDES.'/api/helper.php';
		require_once CFC_DIR_INCLUDES.'/cf-calendar.php';
		require_once CFC_DIR_INCLUDES.'/shortcode.php';
		
		if(is_admin()){
			require_once CFC_DIR_INCLUDES.'/admin/admin.php';
		}
			
		//}
		
  }
  
  function register_instance($class){
	  
	  if(is_object($class)){
		  $classname = get_class($class);
		  
		  $this->{$classname} = $class;
		  
		  return $class;
	  }
		
		
		$this->{$class} = new $class;
	  
	  return $this->get_instance($class);
  }
  
  function get_instance($classname){
	  
	  return isset($this->{$classname}) ? $this->{$classname} : false;
	  
  }
	
}

require_once CFC_DIR_INCLUDES.'/tools/activation.php';


$CFC = new CustomFieldsCalendar();


function CFC(){
	global $CFC;
	
	if(!$CFC){
		$CFC = new CustomFieldsCalendar();
	}
	
	return $CFC;
}

}