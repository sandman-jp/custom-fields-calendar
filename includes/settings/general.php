<?php

namespace CFC\settings;

use CFC;
use CFC\settings;
use CFC\settings\general;

if ( ! defined('ABSPATH') ) {
	exit; // Exit if accessed directly
}


class general{
	
	private $_data;
	
	function __construct (){
		
	}
	
	function parse($settings ,$meta_data){
		
		if(empty($meta_data['general-settings'])){
			$settings['general-settings'] = null;
			return $settings;
		}
		
		$this->_data = $meta_data['general-settings'];
		
		$this->get_datetime('start');
		$this->get_datetime('end');
		
		$settings['general-settings'] = $this->_data;
		
		return $settings;
	}
	
	function get_datetime($period){
		
		$type = $this->_data['calendar-term'][$period]['type'];
		$date_str = $this->_data['calendar-term'][$period][$type];
		
		if($type == 'absolute'){
			
			$day = $period == 'start' ? 'first day of' : 'last day of';
			$date = strtotime($day.' '.$date_str['year'].'-'.$date_str['month']);
			$date -= wp_date('Z');
		}else{
			if($period == 'end'){
				$start = $this->_data['calendar-term']['start']['datetime'];
				//var_dump(wp_date('Y-m-d', $start));
				$date = strtotime(wp_date('Y-m-d', $start).' + '.$date_str.' months');
			}else{
				//start
				$date = strtotime('first day of '.$date_str.' months 00:00:00');
				$date -= wp_date('Z');
			}
			
		}
		
		
		$this->_data['calendar-term'][$period]['datetime'] = $date;
		
	}
}