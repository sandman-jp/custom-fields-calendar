<?php

namespace CFC\tools;

use CFC;
use CFC\tools;
use CFC\tools\validations;


if ( ! defined('ABSPATH') ) {
	exit; // Exit if accessed directly
}

class validations {
	
	var $validations;
	
	function __construct(){
		
		$this->validations = array(
			'email' => '[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$',
			'tel' => '(\+\d+)?\s?\d{2,4}-\d{3,4}-\d{3,4}', //国際番号対応
			'url' => '^https?\:\/\/.+$',
		);
	}
	
	function get($type){
		
		return isset($this->validations[$type]) ? $this->validations[$type] : false;
	}
}
CFC()->register_instance('CFC\tools\validations');