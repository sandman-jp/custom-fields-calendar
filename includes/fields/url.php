<?php

namespace CFC\field;

use CFC;
use CFC\field;
use CFC\field\textfield;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

require_once CFC_DIR_INCLUDES.'/fields/textfield.php';

class url extends CFC\field\textfield{
	
	var $type = 'url';
	
	/*
	function __construct() {
		add_filter('cfc/field/render/url' , array($this, 'set_default_value'));
	}
	
	function set_default_value($html){
		
		$search = '%'.$this->get('field-name').'_value%';
		
		$html = str_replace($search, 'https://', $html);
		
		return $html;
	}
	*/
}