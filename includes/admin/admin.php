<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

require_once ACFC_DIR_INCLUDES.'/admin/acfc-field-group.php';

class ACFC_admin{
	
	
	function __construct(){
		add_action('admin_menu', array($this, 'admin_menu'), 11);
		add_action('admin_enqueue_scripts', array($this, 'admin_enqueue_scripts'), 11);
	}
	
	function admin_enqueue_scripts() {
		
		// no autosave
		wp_dequeue_script( 'autosave' );
		
		wp_enqueue_script( 'jquery-ui-tabs' );
		
		// custom scripts
		wp_enqueue_style( 'acf-field-group' );
		wp_enqueue_script( 'acf-field-group' );
	}
	
	function admin_menu(){
		
		if(!acf_get_setting('show_admin')) {
			return;
		}
		
		
		add_menu_page(
			__( 'ACF Calendar', ACFC_TEXTDOMAIN), 
			__( 'ACF Calendar Field Group', ACFC_TEXTDOMAIN),
			acf_get_setting('capability'),
      'edit.php?post_type='.ACFC_FIELD_GROUP,
      null
		);
		
		//add_action('load-'.$page, array($this, 'option_page'));
	}
	
	function option_page(){
		//do_action('ACFC/load/field_groups');
	}
	
}

new ACFC_admin();