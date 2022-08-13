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
	
	function parse($settings, $meta_data){
		
		$panel_name = $this->name.'-settings';
		$settings = parent::parse($settings, $meta_data);
			
		
		$common_settings = $this->get_common_typeof_post_settings();
		
		if(!is_array($settings[$panel_name])){
			$settings[$panel_name] = array();
		}

		//キーを維持したまま
		foreach($common_settings as $k=>$v){
			
			if(isset($settings[$panel_name][$k])){
				$settings[$panel_name][$k] = array_merge($settings[$panel_name][$k], $v);
			}else {
				$settings[$panel_name][$k] = $v;
			}
		}
		
		return $settings;
	}
	
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