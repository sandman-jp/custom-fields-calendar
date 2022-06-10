<?php
	
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class ACFC_field_group {
	
	function __construct(){
		add_action('init', array($this, 'register_post_type'));
		
	}
	
	function init(){
		$this->register_post_type();
	}

	function register_post_type() {
		
		$cap = acf_get_setting( 'capability' );
		
		register_post_type(
			ACFC_FIELD_GROUP,
			array(
				'labels'          => array(
					'name'               => __( 'ACF Calendar Field Groups', ACFC_TEXTDOMAIN ),
					'singular_name'      => __( 'ACF Calendar Field Group', ACFC_TEXTDOMAIN ),
					'add_new'            => __( 'Add New', ACFC_TEXTDOMAIN ),
					'add_new_item'       => __( 'Add New ACF Calendar Field Group', ACFC_TEXTDOMAIN ),
					'edit_item'          => __( 'Edit ACF Calendar Field Group', ACFC_TEXTDOMAIN ),
					'new_item'           => __( 'New ACF Calendar Field Group', ACFC_TEXTDOMAIN ),
					'view_item'          => __( 'View ACF Calendar Field Group', ACFC_TEXTDOMAIN ),
					'search_items'       => __( 'Search ACF Calendar Field Groups', ACFC_TEXTDOMAIN ),
					'not_found'          => __( 'No ACF Calendar Field Groups found', ACFC_TEXTDOMAIN ),
					'not_found_in_trash' => __( 'No ACF Calendar Field Groups found in Trash', ACFC_TEXTDOMAIN ),
				),
				'public'          => false,
				'hierarchical'    => true,
				'show_ui'         => true,
				'show_in_menu'    => false,
				'_builtin'        => false,
				'capability_type' => 'post',
				'capabilities'    => array(
					'edit_post'    => $cap,
					'delete_post'  => $cap,
					'edit_posts'   => $cap,
					'delete_posts' => $cap,
				),
				'supports'        => array( 'title' ),
				'rewrite'         => false,
				'query_var'       => false,
			)
		);
	}
	
}

new ACFC_field_group();