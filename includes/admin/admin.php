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
		
		//global $post;
		
		if(get_current_screen()->id == CF_CALENDAR){
			
			wp_register_style('jquery-ui', 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css');
			wp_enqueue_style( 'jquery-ui' );
			wp_enqueue_style('cfc-admin', CFC_ASSETS_URL.'/admin/cfc.css', array(), CFC_VIRSION);
			wp_enqueue_script('cfc-admin', CFC_ASSETS_URL.'/admin/cfc.js', array('jquery', 'jquery-ui-sortable', 'jquery-ui-tooltip', 'jquery-ui-datepicker'), CFC_VIRSION, true);
			
			wp_enqueue_script('jquery-validate', '//cdn.jsdelivr.net/npm/jquery-validation@1.19.2/dist/jquery.validate.js',  array('jquery'), CFC_VIRSION, true);
			
			wp_register_script('cfc-admin-header', false);
			wp_enqueue_script('cfc-admin-header');
			wp_add_inline_script('cfc-admin-header', 'document.getElementsByTagName("html")[0].classList.add("cfc-loading")', array());
		}
	}
	
	function admin_menu(){
		
		//common settings page.
		add_submenu_page(
      'edit.php?post_type='.CF_CALENDAR,
			__( 'Custom Fields Calendar Common Settings', CFC_TEXTDOMAIN), 
			__( 'Common Settings', CFC_TEXTDOMAIN),
			$this->capability,
      'common-settings',
      array($this, 'common_settings_page'),
		);
		
	}
	
	function common_settings_page(){
		include CFC_DIR_INCLUDES.'/admin/view/common-settings.php';
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
	
}

CFC()->register_instance('CFC\admin');