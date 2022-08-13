<?php

namespace CFC\common;

use CFC;
use CFC\common;
use CFC\common\settings;

if ( ! defined('ABSPATH') ) {
	exit; // Exit if accessed directly
}

require_once CFC_DIR_INCLUDES.'/settings/setting.php';

class setting extends \CFC\settings\setting{
	
	
	function get_all_typeof_post_settings(){
		global $wpdb;
		
		$name = 'cfc_'.$this->name.'-settings';
		
		$sql = sprintf("SELECT * FROM %s WHERE meta_key LIKE '%s'", $wpdb->postmeta, $name);
		
		$settings = $wpdb->get_results($sql);
		
		return $settings;
	}
}