<?php

namespace CFC;

use CFC;
use CFC\shortcode;

if ( ! defined('ABSPATH') ) {
	exit; // Exit if accessed directly
}

class shortcode{
	
	function __construct(){
		add_shortcode('cfc', array($this, 'do_shortcode'));
		
		add_action('wp_enqueue_scripts', array($this, 'enqueue_styles'));
	}
	
	function do_shortcode($atts){
		$calendar = CFC()->get_instance('cf_calendar');
		
		ob_start();
		echo $calendar->rendar_table($atts);
		return ob_get_clean();
		
	}
	
	function enqueue_styles(){
		global $posts;
		require_once CFC_DIR_INCLUDES.'/settings.php';
		
		wp_register_style( 'cfc', false );
		wp_enqueue_style( 'cfc' );
		
		$add_css = '';
		//var_dump($posts);
		foreach($posts as $p){
			$cotent = $p->post_content;
			if(preg_match("/\[cfc.+?id=\"(\d+?)\"\]/", $cotent, $match)){
				
				$settings = new CFC\settings($match[1]);
				//CFC()->register_instance($this->settings);
				$add_css .= $settings->get_stylesheet();
				
			}
		}
		wp_add_inline_style( 'cfc', $add_css );
	}
	
}

CFC()->register_instance('CFC\shortcode');