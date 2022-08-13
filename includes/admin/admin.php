<?php

namespace CFC;

use CFC\admin;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


//require_once CFC_DIR_INCLUDES.'/admin/custom-field-setting.php';

require_once CFC_DIR_INCLUDES.'/common.php';
class admin{
	
	private $capability = 'manage_options';
	
	var $common_settings;
	
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
		
		if(isset($_POST['cfc-action']) && $_POST['cfc-action'] == 'save-common-settings'){
			$this->_save_common_settings();
		}
	}
	
	function init(){
		$admin_options = get_option('CFC_admin_options');
		
		if(!empty($admin_options)){
			$admin_options = array();
		}
		
		$admin_options['capability'] = 'manage_options';
		
	}
	
	function admin_enqueue_scripts() {
		
		
		wp_register_script('cfc-admin', '');
		wp_enqueue_script('cfc-admin');
		wp_add_inline_script( 'cfc-admin', 'const CFC_ASSETS_URL = "'.CFC_ASSETS_URL.'"');
		
		
		//global $post;
		switch(get_current_screen()->id){
		case CF_CALENDAR:
			//個別カレンダー
			
			wp_enqueue_script( 'jquery-ui-tabs' );
			
			wp_register_style('jquery-ui', 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css');
			wp_enqueue_style( 'jquery-ui' );
			//CFC
			wp_enqueue_style('cfc-admin-post_type', CFC_ASSETS_URL.'/admin/css/cfc.css', array(), CFC_VIRSION);
			wp_enqueue_script('cfc-admin-post_type', CFC_ASSETS_URL.'/admin/js/cfc.js', array('jquery', 'jquery-ui-sortable', 'jquery-ui-tooltip', 'jquery-ui-datepicker'), CFC_VIRSION, true);
			
			wp_enqueue_script('jquery-validate', '//cdn.jsdelivr.net/npm/jquery-validation@1.19.2/dist/jquery.validate.js',  array('jquery'), CFC_VIRSION, true);
			
			wp_register_script('cfc-admin-header', false);
			wp_enqueue_script('cfc-admin-header');
			wp_add_inline_script('cfc-admin-header', 'document.getElementsByTagName("html")[0].classList.add("cfc-loading")', array());
			break;
			
		case CF_CALENDAR.'_page_common-settings':
			//共通設定
			wp_enqueue_script( 'jquery-ui-tabs' );
			
			wp_register_style('jquery-ui', 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css');
			wp_enqueue_style( 'jquery-ui' );
			
			wp_enqueue_style('cfc-admin-common', CFC_ASSETS_URL.'/admin/css/cfc.css', array(), CFC_VIRSION);
			wp_enqueue_script('cfc-admin-common', CFC_ASSETS_URL.'/admin/js/common.js', array('jquery', 'jquery-ui-sortable', 'jquery-ui-tooltip', 'jquery-ui-datepicker'), CFC_VIRSION);
			
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
		$this->common_settings = new \CFC\common();
		include CFC_DIR_INCLUDES.'/admin/view/common.php';
	}
	
	function _save_common_settings(){
		
		if (!isset($_POST['_cfc_nonce'] ) || !wp_verify_nonce( $_POST['_cfc_nonce'], 'save-common-schedule' )) {
			return;
		}
		
		//設定パネルの保存
		if(empty($this->common_settings)){
			$this->common_settings = new \CFC\common();
		}
		$panels = $this->common_settings->get_panels();
		
		foreach($panels as $setting_name){
			$postdata = empty($_POST[$setting_name]) ? array() : $_POST[$setting_name];
			
			$this->common_settings->update($setting_name, $postdata);
		}
		
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