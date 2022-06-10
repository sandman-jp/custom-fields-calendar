<?php
	
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function acfcalender_get_field_types( $args = array() ) {

	// default
	$args = wp_parse_args(
		$args,
		array(
			'public' => true,    // true, false
		)
	);

	// get field types
	$field_types = acf()->fields->get_field_types();

	// filter
	return wp_filter_object_list( $field_types, $args );
}

function ACFC_get_grouped_field_types(){
	
	$fields = array('text', 'textarea', 'number', 'email', 'url', 'image', 'filed', 'wysiwyg', 'oembed', 'select', 'checkbox', 'radio', 'button_group', 'true_false', 'link', 'post_object', 'page_link', 'time_picker', 'color_picker', 'message', 'group');
	
	$field_types = array();
	
	// get field types
	foreach($fields as $key){
		$field_types[] = acf()->fields->get_field_type($key);
	}
	
	// filter
	$types = wp_filter_object_list($field_types, wp_parse_args(
		array(),
		array(
			'public' => true,    // true, false
		)
	));
	
	$groups = array();
	$l10n   = array(
		'basic'      => __( 'Basic', 'acf' ),
		'content'    => __( 'Content', 'acf' ),
		'choice'     => __( 'Choice', 'acf' ),
		'relational' => __( 'Relational', 'acf' ),
		'jquery'     => __( 'jQuery', 'acf' ),
		'layout'     => __( 'Layout', 'acf' ),
	);

	// loop
	foreach ( $types as $type ) {

		// translate
		$cat = $type->category;
		$cat = isset( $l10n[ $cat ] ) ? $l10n[ $cat ] : $cat;

		// append
		$groups[ $cat ][ $type->name ] = $type->label;
	}
	
	// filter
	$groups = apply_filters( 'acf/get_field_types', $groups );
	
	// return
	return $groups;
	
}