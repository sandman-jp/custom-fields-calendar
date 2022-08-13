<?php

namespace CFC;

use CFC;
use CFC\common;

if ( ! defined('ABSPATH') ) {
	exit; // Exit if accessed directly
}

require_once CFC_DIR_INCLUDES.'/common/setting.php';

class common {
	
	private $_panels = array('schedule', 'validation', 'option');
	
	function __construct(){
		
		$this->_settings_data = array();
		
		foreach($this->_panels as $panelname){
			require_once CFC_DIR_INCLUDES.'/common/'.$panelname.'.php';
			
			$classkey = 'CFC\common\\'.str_replace('-', '_', $panelname);
			$this->settings[$panelname.'-settings'] = new $classkey();
		}
		
		$this->_load();
		
	}
	
	private function _load(){
		
		$this->_settings_data = array();
		
		
		
		///
		foreach($this->settings as $key => $val){
			$meta_data = get_option('cfc_'.$key);
			$this->_settings_data = $val->parse($this->_settings_data, $meta_data);
		}
	}
	
	function get_all(){
		
		return $this->_settings_data;
		
	}
	
	function get_panels(){
		$panels = array();
		
		foreach($this->_panels as $panelname){
			$panels[] = $panelname.'-settings';
		}
		
		return $panels;
	}
	
	//
	function update($key, $_data){
		
		update_option('cfc_'.$key, $this->settings[$key]->format($_data));
		
		
		
	}
}