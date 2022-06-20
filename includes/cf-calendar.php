<?php
/*
Calendar for custom post type
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class cf_calendar {
	
	function __construct(){
		
		add_action('init', array($this, 'register_post_type'));
		
	}
	
	function init(){
		$this->register_post_type();
	}

	function register_post_type() {
		
		$cap = cfc_get_admin_option('capabilitiy');
		
		register_post_type(
			CF_CALENDAR,
			array(
				'labels' => array(
					'name' => __( 'CF Calendars', CFC_TEXTDOMAIN ),
					'singular_name' => __( 'CF Calendar', CFC_TEXTDOMAIN ),
					'add_new' => __( 'Add New', CFC_TEXTDOMAIN ),
					'add_new_item' => __( 'Add New Calendar', CFC_TEXTDOMAIN ),
					'edit_item' => __( 'Edit Calendar', CFC_TEXTDOMAIN ),
					'new_item' => __( 'New Calendar', CFC_TEXTDOMAIN ),
					'view_item' => __( 'View Calendar', CFC_TEXTDOMAIN ),
					'search_items' => __( 'Search Calendars', CFC_TEXTDOMAIN ),
					'not_found' => __( 'No Calendars found', CFC_TEXTDOMAIN ),
					'not_found_in_trash' => __( 'No Calendars found in Trash', CFC_TEXTDOMAIN ),
				),
				'menu_icon' => 'dashicons-calendar-alt',
				'public' => false,
				'hierarchical' => false,
				'show_ui' => true,
				'show_in_menu' => true,
				'_builtin' => false,
				'capability_type' => 'post',
				'capabilities' => array(
					'edit_post' => $cap,
					'delete_post' => $cap,
					'edit_posts' => $cap,
					'delete_posts' => $cap,
				),
				'supports' => array('title', 'revisions'),
				'rewrite' => false,
				'query_var' => false,
			)
		);
		
	}
	
}

CFC()->register_instance('cf_calendar');