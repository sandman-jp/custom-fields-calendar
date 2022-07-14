<?php

namespace CFC\tools;

use CFC;
use CFC\tools;
use CFC\tools\timezone;


if ( ! defined('ABSPATH') ) {
	exit; // Exit if accessed directly
}

class timezone {
	
	public static $default_timezone;
	
	
	static function set_timezone(){
		self::$default_timezone = date_default_timezone_get();
		$timezone = wp_timezone_string();
		
		date_default_timezone_set($timezone);
	}
	
	static function reset_timezone(){
		date_default_timezone_set(self::$default_timezone);
	}
}
CFC()->register_instance('CFC\tools\timezone');