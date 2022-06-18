<?php
	
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/* settings */
function cfc_get_options(){
	global $cfc_options;
	
	if(!$cfc_options){
		$cfc_options = new CFC_options();
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
function cfc_get_template_part($path, $args=array()){
	
	$fullpath = CFC_DIR_INCLUDES.$path.'.php';
	
	if(file_exists($fullpath)){
		
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

function cfc_get_customs($key){
	
	$fields = CFC()->get_instance('CFC\fields');
	
	
	if(empty($fields)){
		return ;
	}
	
	$values = $fields->customs($key);
	
	if($values) {
		return $values;
	}
	
	return array();
	
}