<?php

class ACFC_activate{
	
	function __construct(){
		add_action('admin_notices', array($this, 'admin_notices'));
	}
	
	function admin_notices(){
		
		if (!self::is_acf_active()) {
      add_settings_error('ACFC_no_ACF', esc_attr( 'no-acf' ), __('ACF Calendar needs Advanced Custom Field.', ACFC_TEXTDOMAIN));
      settings_errors('ACFC_no_ACF');
    }
	}
	
	static function is_acf_active(){
		return class_exists('ACF');
	}
}

new ACFC_activate();