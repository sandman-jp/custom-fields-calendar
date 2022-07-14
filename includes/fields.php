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
		
		$res = true;
		//保存前に全消し
		$this->_clean_data();
		
		foreach($_data as $k => $v){
			if(is_array($v)){
				foreach($v as $kk => $vv){
					update_post_meta($this->post_id, 'cfc_'.$k.'_'.$kk, $vv);
				}
			}else{
				update_post_meta($this->post_id, 'cfc_'.$k, $v);
			}
			
		}
		
	}
	
	private function _clean_data(){
		global $wpdb;
		
		//設定の除外
		$sql = sprintf("SELECT meta_key FROM %s WHERE post_id=%d AND meta_key LIKE '%s%%' AND meta_key != 'cfc_settings'", $wpdb->postmeta, $this->post_id, 'cfc_');
		
		$old_meta = $wpdb->get_col($sql);
		
		if(!empty($old_meta)){
			/*
			$sql = sprintf("DELETE FROM %s WHERE meta_id IN (%s)", $wpdb->postmeta, implode(',', $old_meta));
			return $wpdb->query($sql);
			*/
			foreach($old_meta as $k){
				delete_post_meta($this->post_id, $k);
			}
			
		}
		
	}
	
	private function _get_post_meta($key){
		global $wpdb;
		$sql = sprintf("SELECT * FROM %s WHERE post_id=%d AND meta_key LIKE '%s%%'", $wpdb->postmeta, $this->post_id, 'cfc_'.$key.'_');
		
		$metas = $wpdb->get_results($sql);
		$value = array();
		if($metas){
			foreach($metas as $meta){
				$cf_key = str_replace('cfc_'.$key.'_', '', $meta->meta_key);
				$value[$cf_key] = $meta->meta_value;
			}
		}
		
		return $value;
	} 
	
	//CFグループの表示
	function render($key){
		
		
		$this->settings = cfc_get_instance('CFC\settings');
		
		if(empty($this->settings)){
			return '';
		}
		
		$cf_setting = $this->settings->get('custom-field-settings');
		
		$default_value = array();
		
		if(!empty($cf_setting['fields'] )){
			foreach($cf_setting['fields'] as $k=>$d){
				// var_dump($k);
				// var_dump($d);
				if(isset($d['field-default-value'])){
					$default_value[$d['field-name']] = $d['field-default-value'];
				}
				
			}
		}else{
			$cf_setting['fields'] = array();
		}
		
		$value = $this->_get_post_meta($key);
		
		//var_dump($metas);
		//$value = get_post_meta($this->post_id, 'cfc_field_'.$key, true);
		//$value = array();
		
		
		
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
				$this->_field_inputs_template .= '<input type="hidden" class="cfc-data" name="calendar['.$key.']['.$field['field-name'].']" value="">';
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
		
		$template = $this->_make_template($key, $value);
		/*
		if(empty($template)){
			$template = '<input type="hidden" name="calendar['.$key.']" value="">';
		}
		*/
		return $template;
	}
	
	//値の配列を返す
	function values($key){
		//$metas = get_post_meta($this->post_id, 'cfc_field_'.$key, true);
		$metas = $this->_get_post_meta($key);
		
		if($metas){
			return array_values($metas);
		}
		return false;
	}
	
	//キー:値の配列を返す
	function customs($key){
		//$metas = get_post_meta($this->post_id, 'cfc_field_'.$key, true);
		$metas = $this->_get_post_meta($key);
		
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
			$limit = strtotime($condition['start']['year'].'-'.$condition['start']['month'].'-01');
			
			if($key <= $limit){
				return false;
			}
		}
		
		//終了が設定されている場合
		if(!empty($condition['end']['year']) && $condition['end']['year'] != 'all'){
			$limit = strtotime('last day of '.$condition['end']['year'].'-'.$condition['end']['month']);
			if($key > $limit){
				return false;
			}
		}
		
		//休日設定
		if(cfc_is_holiday($key) && !empty($condition['holiday'])){
			if($condition['holiday'] == 'hide'){
				return false;
			}else if($condition['holiday'] == 'show'){
				return true;
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

