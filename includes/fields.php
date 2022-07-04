<?php

namespace CFC;

use CFC;

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
			/*
			foreach($old_meta as $meta){
				delete_post_meta( $meta->post_id, $meta->meta_key);
			}
			*/
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
		
		$cf_setting = $this->settings->get('custom-fields-settings');
		
		$default_value = array();
		
		foreach($cf_setting['fields'] as $k=>$d){
			// var_dump($k);
			// var_dump($d);
			if(isset($d['field-default-value'])){
				$default_value[$d['field-name']] = $d['field-default-value'];
			}
			
		}
		
		$value = get_post_meta($this->post_id, 'cfc_field_'.$key, true);
		
		$value = wp_parse_args($value, $default_value);
		
		/*
		if(!empty($this->_field_inputs_template)){
			return $this->_make_template($key, $value);
		}
		*/
		$this->_field_inputs_template = '';
		
		//各セルのCFのレンダリング
		//$fields = $this->_settings_data['custom-fields-setting'];
		
		foreach($cf_setting['fields'] as $field){
			
			if(empty($field['field-type'])){
				return;
			}
			
			$type = $field['field-type'];
			
			if(!empty($field['field-conditions']) && !$this->_check_conditions($key, $field['field-conditions'])){
				continue;
				//return;
			}
			
			require_once CFC_DIR_INCLUDES.'/fields/'.$type.'.php';
			
			$classname = 'CFC\\fields\\'.$type;
			
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
		$metas = get_post_meta($this->post_id, 'cfc_field_'.$key, true);
		
		if($metas){
			return array_values($metas);
		}
		return false;
	}
	
	//キー:値の配列を返す
	function customs($key){
		$metas = get_post_meta($this->post_id, 'cfc_field_'.$key, true);
		
		if($metas){
			
			return $metas;
		}
		return false;
	}
	
	
	private function _load(){
		
		
	}
	
	private function _make_template($key, $value, $template=null){
		
		if(empty($template)){
			$template = $this->_field_inputs_template;
		}
		
		//key
		$template = str_replace('%key%', $key, $template);
		//var_dump($template);
		
		foreach($value as $k=>$v){
			$k = urlencode($k);
			//checkbox対策
			$v = is_array($v) ? $v : array($v);
				
			foreach($v as $vv){
				$template = str_replace('%%'.$k.'_value%%', $vv, $template);
				//
				$template = str_replace('%%selected:'.$k.'_'.$vv.'%%', 'selected="selected"', $template);
				$template = str_replace('%%checked:'.$k.'_'.$vv.'%%', 'checked="checked"', $template);
				
				//preg_match("/\%\%(selected|checked)\:".$k."_(.+?)\%\%/", $template, $match);
				//var_dump($match);
			}
			$template = preg_replace("/\%\%(selected|checked)\:".$k."_(.+?)\%\%/", '', $template);
		}
		
		$template = preg_replace("/\%\%(.*?)\%\%/", '', $template);
		
		return $template;
	}
	
	//条件チェック
	private function _check_conditions($key, $conditions){
		//$keyは日付（秒）
		
		foreach($conditions as $condition){
			if($this->_verify_condition($key, $condition)){
				return true;
			}
		}
		
		return false;
	}
	private function _verify_condition($key, $condition){
		
		//$cleard = false;
		
		//開始が設定されている場合
		if(!empty($condition['start']['year']) && $condition['start']['year'] != 'all'){
			$limit = strtotime($condition['start']['year'].'-'.$condition['start']['month'].'-01 '.wp_timezone_string());
			
			if($key <= $limit){
				return false;
			}
		}
		
		//終了が設定されている場合
		if(!empty($condition['end']['year']) && $condition['end']['year'] != 'all'){
			$limit = strtotime('last day of '.$condition['end']['year'].'-'.$condition['end']['month'].' '.wp_timezone_string());
			if($key > $limit){
				return false;
			}
		}
		
		//週数が正しいかどうか
		$weec_count = ceil(wp_date('j', $key) / 7);
		if(!in_array($weec_count, $condition['cond1'])){
			return false;
		}
		
		//曜日が正しいかどうか
		if(!in_array(wp_date('w', $key), $condition['cond2'])){
			return false;
		}
		
		return true;
	}
}

