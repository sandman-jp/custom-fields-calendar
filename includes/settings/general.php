<?php

namespace CFC\settings;

use CFC;
use CFC\settings;
use CFC\settings\setting;
use CFC\settings\general;

if ( ! defined('ABSPATH') ) {
	exit; // Exit if accessed directly
}


class general extends setting{
	
	public $name = 'general';
	
	function parse($settings ,$meta_data){
		
		$pane_name = $this->name.'-settings';
		// 
		// if(empty($meta_data)){
		// 	$settings[$pane_name] = null;
		// 	return $settings;
		// }
		// 
		$this->_data = $meta_data;
		
		$this->get_datetime('start');
		$this->get_datetime('end');
		
		$settings[$pane_name] = $this->_data;
		
		return $settings;
	}
	
	function get_datetime($period){
		
		
		CFC\tools\timezone::set_timezone();
		
		
		$type = $this->_data['calendar-term'][$period]['type'];
		$date_str = isset($this->_data['calendar-term'][$period][$type]) ? $this->_data['calendar-term'][$period][$type] : '';
		
		if($type == 'absolute'){
			
			$day = $period == 'start' ? 'first day of' : 'last day of';
			$date = strtotime($day.' '.$date_str['year'].'-'.$date_str['month']);
			
		}elseif($type == 'relative'){
			if($period == 'end'){
				$start = $this->_data['calendar-term']['start']['datetime'];
				//var_dump(wp_date('Y-m-d', $start));
				$date = strtotime(wp_date('Y-m-d', $start).' + '.$date_str.' months')-1;
			}else{
				//start
				$date = strtotime('first day of '.$date_str.' months 00:00:00');
			}
			
		}
		/*
		else{
			$str = $type;
			if($period == 'end'){
				$date = strtotime('tomorrow '.wp_timezone_string());
			}else{
				$date = strtotime($str.' '.wp_timezone_string());
			}
			
		}
		*/
		
		
		$this->_data['calendar-term'][$period]['datetime'] = $date;
		
		CFC\tools\timezone::reset_timezone();
	}
}