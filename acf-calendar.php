<?php
/*
Plugin Name: ACF Calendar
Plugin URI: 
Description: Custom calendar fields with ACF.
Version: 1.0.0
Author: 地空 Chhkuw DEsign
Author URI: 
Text Domain: acf-calendar
Domain Path: /lang
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if (!class_exists('ACFC')){
	

define('ACFC_DIR', dirname(__FILE__));
define('ACFC_DIR_INCLUDES', ACFC_DIR.'/includes');
define('ACFC_TEXTDOMAIN', 'ACFC');
define('ACFC_FIELD_GROUP', 'acfc-field-group');

class ACFC {
	
	
	function __construct() {
		
		add_action('plugins_loaded', array($this, 'load'));
		
	}
	
	/*
   * Load plugin
   */
  function load(){
		
		if(ACFC_activate::is_acf_active()){
			require_once ACFC_DIR_INCLUDES.'/api/helper.php';
			require_once ACFC_DIR_INCLUDES.'/acfc-field-group.php';
			require_once ACFC_DIR_INCLUDES.'/admin/admin.php';
			
		}
  }
	
}

require_once ACFC_DIR_INCLUDES.'/tools/activation.php';


new ACFC();


}