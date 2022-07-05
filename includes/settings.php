<?php

namespace CFC;

use CFC;
use CFC\settings;

if ( ! defined('ABSPATH') ) {
	exit; // Exit if accessed directly
}


class settings{
	
	private $_settings_data;
	private $_panels = array('custom-fields', 'general', 'templates');
	
	function __construct($post_id){
		
		$this->_settings_data = array();
		
		if(empty($post_id)){
			return ;
		}
		
		$this->post_id = $post_id;
		/*
		$this->settings = array(
			'custom-fields-settings' => new CFC\settings\custom_fields(),
			'general-settings' => new CFC\settings\general(),
			'templates-settings' => new CFC\settings\templates(),
		);
		*/
		foreach($this->_panels as $panelname){
			require_once CFC_DIR_INCLUDES.'/settings/'.$panelname.'.php';
			
			$classkey = 'CFC\settings\\'.str_replace('-', '_', $panelname);
			
			$this->settings[$panelname.'-settings'] = new $classkey();
		}
		$this->_load();
		
	}
	
	private function _load(){
		
		$this->_settings_data = array();
		
		$meta_data = get_post_meta($this->post_id, 'cfc_settings', true);
		
		///
		foreach($this->settings as $setting){
			$this->_settings_data = $setting->parse($this->_settings_data, $meta_data);
		}
		
	}
	
	function get($key=null){
		
		if(empty($this->_settings_data)){
			return false;
		}
		
		if(empty($this->_settings_data[$key])){
			return false;
		}else{
			return $this->_settings_data[$key];
		}
		
		
		return $this->_settings_data;
		
	}
	
	function get_all(){
		
		return $this->_settings_data;
		
	}
	
	//
	function update($key, $_data){
		
		$this->_settings_data[$key] = $_data;
		
		update_post_meta($this->post_id, 'cfc_settings', $this->_settings_data);
		
	}
	
	function get_panels(){
		$panels = array();
		
		foreach($this->_panels as $panelname){
			$panels[] = $panelname.'-settings';
		}
		
		return $panels;
	}
	
	function get_stylesheet(){
		$add_css = $this->_settings_data['templates-settings']['add-css'];
		
		return $add_css;
	}
}

