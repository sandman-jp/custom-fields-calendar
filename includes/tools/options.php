<?php

namespace CFC\tools;

use CFC;
use CFC\tools;
use CFC\tools\options;

class options {
	
	private $front;
	private $admin;
	
	function __construct(){
		
		$this->front = get_option('cfc_options');
		$this->admin = get_option('cfc_admin_options');
		
	}
	
	
	function get_option($key){
		
		return empty($this->front[$key])? '' : $this->front[$key];
		
	}
	
	function update_option($key, $val){
		
		$this->front[$key] = $val;
		
		return update_option('cfc_options', $this->front);
		
	}
	
	function get_admin_option($key){
		
		return empty($this->admin[$key])? 'manage_options' : $this->admin[$key];
		
	}
	
	function update_admin_option($key, $val){
		
		$this->admin[$key] = $val;
		
		return update_option('cfc_options', $this->admin);
		
	}
	
}

CFC()->register_instance('CFC\tools\options');

