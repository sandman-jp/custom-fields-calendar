<?php

namespace CFC\settings;

use CFC;
use CFC\settings;
use CFC\settings\setting;
use CFC\settings\schedule;

if ( ! defined('ABSPATH') ) {
	exit; // Exit if accessed directly
}


class schedule extends setting{
	
	public $name = 'schedule';
	
	
	function format($data){
		
		$return = array();
		
		foreach($data as $date){
			
			$datetime = strtotime($date['date'].' '.wp_timezone_string());
			
			if(!isset($return[$datetime])){
				$return[$datetime] = array();
			}
			$return[$datetime][] = $date;
		}
		
		return $return;	
	}
	
}