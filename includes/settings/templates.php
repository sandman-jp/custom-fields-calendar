<?php

namespace CFC\settings;

use CFC;
use CFC\settings;
use CFC\settings\templates;

if ( ! defined('ABSPATH') ) {
	exit; // Exit if accessed directly
}


class templates{
	
	private $_data;
	
	function __construct (){
		
	}
	
	function parse($settings ,$meta_data){
		
		if(empty($meta_data['templates-settings'])){
			$settings['templates-settings'] = null;
			return $settings;
		}
		
		$this->_data = $meta_data['templates-settings'];
		
		$settings['templates-settings'] = $this->_data;
		
		return $settings;
	}
	
	
}