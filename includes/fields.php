<?php

namespace CFC;

use CFC;
use CFC\fields;
use CFC\settings;

if ( ! defined('ABSPATH') ) {
	exit; // Exit if accessed directly
}


require_once CFC_DIR_INCLUDES.'/fields/field.php';

class fields{
	
	private $_field_inputs_template; //使い回し用
	
	function __construct($post_id){
		
		if(empty($post_id)){
			return ;
		}
		
		$this->post_id = $post_id;
		
		$this->_load();
		
	}
	
	function get(){
		
		//return $this->_settings_data;
		
	}
	
	
	function update($_data){
		
		global $wpdb;
		
		$sql = sprintf("SELECT * FROM %s WHERE post_id=%d AND meta_key LIKE '%s%%'", $wpdb->postmeta, $this->post_id, 'cfc_field_');
		
		$old_meta = $wpdb->get_results($sql);
		
		if(!empty($old_meta)){
			//一回全消ししてから再登録
			foreach($old_meta as $meta){
				delete_post_meta( $meta->post_id, $meta->meta_key);
			}
		}
		
		foreach($_data as $k => $v){
			update_post_meta($this->post_id, 'cfc_field_'.$k, $v);
		}
		
		
	}
	
	
	//CFグループの表示
	function render($key){
		
		$this->settings = cfc_get_instance('CFC\settings');
		
		if(empty($this->settings)){
			return '';
		}
		
		$cf_setting = $this->settings->get('custom-fields-setting');
		
		$default_value = array();
		
		foreach($cf_setting as $k=>$d){
			$default_value[$d['field-name']] = '';
		}
		
		$value = get_post_meta(get_the_ID(), 'cfc_field_'.$key, true);
		
		$value = wp_parse_args($value, $default_value);
		
		
		if(!empty($this->_field_inputs_template)){
			return $this->_make_template($key, $value);
		}
		
		$this->_field_inputs_template = '';
		
		
		//各セルのCFのレンダリング
		//$fields = $this->_settings_data['custom-fields-setting'];
		
		foreach($cf_setting as $field){
			
			$type = $field['field-type'];
			
			require_once CFC_DIR_INCLUDES.'/fields/'.$type.'.php';
			
			$classname = 'CFC\\field\\'.$type;
			
			$fieldclass = new $classname;
			
			//データ各種を渡す
			foreach($field as $k=>$v){
				$fieldclass->update($k, $v);
			}
			
			$this->_field_inputs_template .= $fieldclass->rendar($key);
			
		}
		
		
		return $this->_make_template($key, $value);
	}
	
	//値の配列を返す
	function values($key){
		$metas = get_post_meta(get_the_ID(), 'cfc_field_'.$key, true);
		
		if($metas){
			return array_values($metas);
		}
		return false;
	}
	
	//キー:値の配列を返す
	function customs($key){
		$metas = get_post_meta(get_the_ID(), 'cfc_field_'.$key, true);
		
		if($metas){
			
			return $metas;
		}
		return false;
	}
	
	
	private function _load(){
		
		
	}
	
	private function _make_template($key, $value){
		
		$template = $this->_field_inputs_template;
		
		//key
		$template = str_replace('%key%', $key, $template);
		//
		foreach($value as $k=>$v){
			$template = str_replace('%'.$k.'_value%', $v, $template);
			
			//
			$template = str_replace('%selected:'.$v.'%', 'selected', $template);
			$template = str_replace('%checked:'.$v.'%', 'checked', $template);
		}
		
		
		return $template;
	}
	
}

