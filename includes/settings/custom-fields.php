<?php

namespace CFC\settings;

use CFC;
use CFC\settings;
use CFC\settings\custom_fields;

if ( ! defined('ABSPATH') ) {
	exit; // Exit if accessed directly
}


class custom_fields{
	
	function __construct (){
		
	}
	
	function parse($settings ,$meta_data){
		
		if(empty($meta_data['custom-fields-settings'])){
			$settings['custom-fields-settings'] = null;
			return $settings;
		}
		
		foreach($meta_data['custom-fields-settings'] as $kk => $vv){
			
			if($kk == 'fields' && !empty($meta_data['custom-fields-settings']['fields'])){
				
				foreach($meta_data['custom-fields-settings']['fields'] as $k=>$v){
					
					$settings['custom-fields-settings']['fields'][(int)$k] = $v;
				}
				
			}else{
				$settings['custom-fields-settings'][$kk] = $vv;
			}
		}
		
		return $settings;
	}
}