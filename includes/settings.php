<?php

namespace CFC;

use CFC;
use CFC\settings;

if ( ! defined('ABSPATH') ) {
	exit; // Exit if accessed directly
}

require_once CFC_DIR_INCLUDES.'/settings/custom-fields.php';
require_once CFC_DIR_INCLUDES.'/settings/general.php';

class settings{
	
	private $_settings_data;
	
	function __construct($post_id){
		
		$this->_settings_data = array();
		
		if(empty($post_id)){
			return ;
		}
		
		$this->post_id = $post_id;
		
		$this->settings = array(
			'custom-fields-settings' => new CFC\settings\custom_fields(),
			'general-settings' => new CFC\settings\general(),
		);
		
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
	
}

