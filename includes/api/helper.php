<?php
	
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/* settings */
function cfc_get_options(){
	
	$cfc_options = CFC()->get_instance('CFC\tools\options');
	
	if(!$cfc_options){
		$cfc_options = CFC()->register_instance('CFC\tools\options');
	}
	
	return $cfc_options;
}

function cfc_get_option($key){
	
	return cfc_get_options()->get_option($key);
	
}

function cfc_update_option($key, $val){
	
	$this->front[$key] = $val;
	
	return cfc_get_options()->update_option($key);
	
}

function cfc_get_admin_option($key){
	
	return cfc_get_options()->get_admin_option($key);
	
}

function cfc_update_admin_option($key, $val){
	
	return cfc_get_options()->update_admin_option($key);
	
}

function cfc_get_instance($classname){
	
	return CFC()->get_instance($classname);
	
}


/* calendar */	
function cfc_get_start_week($time, $start=0){
  $w = wp_date('w', $time) - $start;
  
  if($w < 0){
    $w = 7 + $w;
  }
  
  return $w;
}

/* system */
function cfc_get_template_file_path($path){
	
	$roots = array(
		get_stylesheet_directory().'/cfc',
		get_template_directory().'/cfc',
		CFC_DIR_TEMPLATES,
	);
	
	$fullpath = '';
	foreach($roots as $root){
		$fullpath = $root.$path.'.php';
		
		if(file_exists($fullpath)){
			return $fullpath;
		}
	}
	return false;
}

function cfc_get_template_part($path, $sub=null, $args=array()){
	
	if(!is_null($sub) ){
		if(is_array($sub)){
			$args = $sub;
			$sub = '';
		}else{
			$path .= '-'.$sub;
		}
	}
	
	$fullpath = cfc_get_template_file_path($path);
	
	
	if($fullpath){
		
		if(!empty($args)){
			extract($args);
		}
		
		include $fullpath;
	}
}


/* form */
//フィールド入力欄HTMLを返す
function cfc_rendar_custom_fields($key){
	
	$fields = CFC()->get_instance('CFC\fields');
	
	if(empty($fields)){
		return ;
	}
	
	echo $fields->render($key);
}

//入力された値一覧を返す
function cfc_get_values($key){
	
	$fields = CFC()->get_instance('CFC\fields');
	
	if(empty($fields)){
		return ;
	}
	
	$values = $fields->values($key);
	
	if($values) {
		return $values;
	}
	
	return array();
	
}

function cfc_get_customs($key, $show_nodata_key=false){
	
	$fields = CFC()->get_instance('CFC\fields');
	
	if(empty($fields)){
		return ;
	}
	
	$values = $fields->customs($key, $show_nodata_key);
	
	if($values) {
		return $values;
	}
	
	return array();
	
}

function cfc_get_field_items(){
	//$fields = CFC()->get_instance('CFC\fields');
	
	$items = cfc_get_instance('CFC\settings');
	
	$cf_setting = $items->get('custom-field-settings');
	
	if(!empty($cf_setting['fields'])){
		return $cf_setting['fields'];
	}else{
		return false;
	}
}

function cfc_get_regex($pattern){
	$validation = CFC()->get_instance('CFC\validatoin');
	
	return isset($validation[$pattern]) ? $validation[$pattern] : false;
}

function cfc_is_holiday($key, $post_id=null){
	$is_holiday = false;
	$schedules = CFC()->get_instance('CFC\settings')->get('schedule-settings');
	//var_dump($schedules);
	if(isset($schedules[$key]) && is_array($schedules[$key])){
		
		foreach($schedules[$key] as $colum){
			if(!empty($colum['holiday'])){
				$is_holiday = true;
			}
		}
	}
	
	return $is_holiday;
}

function cfc_get_date_schedule_labels($key, $post_id=null){
	$labels = array();
	$schedules = CFC()->get_instance('CFC\settings')->get('schedule-settings');
	
	if(isset($schedules[$key]) && is_array($schedules[$key])){
		
		foreach($schedules[$key] as $colum){
			$labels[] = $colum['label'];
		}
	}
	
	return $labels;
}