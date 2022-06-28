<?php

namespace CFC\tools;

use CFC;
use CFC\tools;
use CFC\tools\activation;

class activation{
	
	function __construct(){
		add_action('admin_notices', array($this, 'admin_notices'));
	}
	
	function admin_notices(){
		/*
		if (!self::is_acf_active()) {
      add_settings_error('CFC_no_ACF', esc_attr( 'no-acf' ), __('ACF Calendar needs Advanced Custom Field.', CFC_TEXTDOMAIN));
      settings_errors('CFC_no_ACF');
    }
    */
	}
	
	static function is_acf_active(){
		return class_exists('ACF');
	}
}

new CFC\tools\activation();