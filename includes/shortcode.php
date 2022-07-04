<?php

namespace CFC;

use CFC;
use CFC\shortcode;

if ( ! defined('ABSPATH') ) {
	exit; // Exit if accessed directly
}

class shortcode{
	
	function __construct(){
		add_shortcode('cfc', array($this, 'do_shortcode'));
	}
	
	function do_shortcode($atts){
		$calendar = CFC()->get_instance('cf_calendar');
		
		ob_start();
		echo $calendar->rendar_table($atts);
		return ob_get_clean();
		
	}
	
}

CFC()->register_instance('CFC\shortcode');