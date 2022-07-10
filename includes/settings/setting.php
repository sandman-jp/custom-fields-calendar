<?php

namespace CFC\settings;

use CFC;
use CFC\settings;
use CFC\settings\setting;

if ( ! defined('ABSPATH') ) {
	exit; // Exit if accessed directly
}


class setting {
	
	private $_data;
	public $name;
	
	function parse($settings ,$meta_data){
		
		if(empty($this->name)){
			return $settings;
		}
		$pane_name = $this->name.'-settings';
		
		if(empty($meta_data[$pane_name])){
			$settings[$pane_name] = null;
			return $settings;
		}
		
		$this->_data = $meta_data[$pane_name];
		
		$settings[$pane_name] = $this->_data;
		
		return $settings;
	}
	
	function format($data){
		
		return $data;
		
	}
	
}