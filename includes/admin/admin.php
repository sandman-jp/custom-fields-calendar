<?php

namespace CFC;

use CFC\admin;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


//require_once CFC_DIR_INCLUDES.'/admin/custom-field-setting.php';


class admin{
	
	private $capability = 'manage_options';
	
	function __construct(){
		
		if(!is_admin()){
			return ;
		}
		
		require_once CFC_DIR_INCLUDES.'/fields.php';
		require_once CFC_DIR_INCLUDES.'/admin/cf-calender.php';

		add_action('admin_init', array($this, 'init'));
		
		add_action('admin_menu', array($this, 'admin_menu'), 11);
		add_action('admin_enqueue_scripts', array($this, 'admin_enqueue_scripts'), 11);
		
		//add_action('add_meta_boxes', array($this, 'adding_custom_meta_boxes'));
		
		
	}
	
	function init(){
		$admin_options = get_option('CFC_admin_options');
		
		if(!empty($admin_options)){
			$admin_options = array();
		}
		
		$admin_options['capability'] = 'manage_options';
		
	}
	
	function admin_enqueue_scripts() {
		
		
		wp_enqueue_script( 'jquery-ui-tabs' );
		
		global $post;
		
		if(get_post_type($post) == CF_CALENDAR){
			
			wp_enqueue_style('cfc-admin', CFC_ASSETS_URL.'/admin/cfc.css', array(), CFC_VIRSION);
			wp_enqueue_script('cfc-admin', CFC_ASSETS_URL.'/admin/cfc.js', array('jquery', 'jquery-ui-sortable', 'jquery-ui-tooltip'), CFC_VIRSION, true);
			
		}
	}
	
	function admin_menu(){
		
		//common settings page.
		add_submenu_page(
      'edit.php?post_type='.CF_CALENDAR,
			__( 'Custom Fields Calendar Common Settings', CFC_TEXTDOMAIN), 
			__( 'Common Settings', CFC_TEXTDOMAIN),
			$this->capability,
      'edit.php?post_type='.CF_CALENDAR.'?common-settings',
      null
		);
		
	}
	/*
	function render_my_meta_box(){
		echo 'わたしのメタボックス';
	}
	
	function adding_custom_meta_boxes($post_type) {
	    add_meta_box(
	        'my-meta-box',
	        'わたしのメタボックス',
	        array($this, 'render_my_meta_box'),
	        CF_CALENDAR,
	        'normal',
	        'default'
	    );
	}
	*/
	function option_page(){
		//do_action('CFC/load/field_groups');
	}
	
}

CFC()->register_instance('CFC\admin');