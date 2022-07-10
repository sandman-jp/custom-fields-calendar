<?php

namespace CFC\settings;

use CFC;
use CFC\settings;
use CFC\settings\setting;
use CFC\settings\custom_field;

if ( ! defined('ABSPATH') ) {
	exit; // Exit if accessed directly
}


class custom_field extends setting{
	
	public $name = 'custom-field';
	
	function parse($settings ,$meta_data){
		
		$pane_name = $this->name.'-settings';
		
		if(empty($meta_data[$pane_name])){
			$settings[$pane_name] = null;
			return $settings;
		}
		
		foreach($meta_data[$pane_name] as $kk => $vv){
			
			if($kk == 'fields' && !empty($meta_data[$pane_name]['fields'])){
				
				foreach($meta_data[$pane_name]['fields'] as $k=>$v){
					
					$settings[$pane_name]['fields'][(int)$k] = $v;
				}
				
			}else{
				$settings[$pane_name][$kk] = $vv;
			}
		}
		
		if(empty($settings[$pane_name]['fields'])){
			$settings[$pane_name] = array();
		}
		
		return $settings;
	}
}