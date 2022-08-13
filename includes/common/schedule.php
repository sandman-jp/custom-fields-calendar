<?php

namespace CFC\common;

use CFC;
use CFC\common;
use CFC\common\setting;
use CFC\common\schedule;

if ( ! defined('ABSPATH') ) {
	exit; // Exit if accessed directly
}

class schedule extends setting {
	
	public $name = 'schedule';
	
	function parse($settings, $meta_data){
		
		$panel_name = $this->name.'-settings';
		$settings = parent::parse($settings, $meta_data);
		
		$post_settings = $this->get_all_typeof_post_settings();
		
		foreach($post_settings as $ps){
			if(!empty($ps->meta_value)){
				$vals = maybe_unserialize($ps->meta_value);
				
				if(!empty($vals) && is_array($vals)){
					
					if(!isset($settings[$panel_name]) || !is_array($settings[$panel_name])){
						$settings[$panel_name] = array();
					}
					//キーを維持したまま
					foreach($vals as $k=>$v){
						
						if(isset($settings[$panel_name][$k])){
							$settings[$panel_name][$k] = array_merge($settings[$panel_name][$k], $v);
						}else {
							$settings[$panel_name][$k] = $v;
						}
					}
					
				}
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