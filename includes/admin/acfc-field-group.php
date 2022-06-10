<?php

if ( ! defined('ABSPATH') ) {
	exit; // Exit if accessed directly
}

class ACFC_admin_field_group {
	
	function __construct(){
		
		//$this->acf_admin_field_group = new acf_admin_field_group();
		add_action('admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts'));
		add_action('admin_head', array($this, 'admin_head'));
		
	}
	
	function admin_enqueue_scripts() {
		
		// no autosave
		wp_dequeue_script('autosave');

		// custom scripts
		wp_enqueue_style('acf-field-group');
		wp_enqueue_script('acf-field-group');

		// localize text
		acf_localize_text(
			array(
				'The string "field_" may not be used at the start of a field name' => __('The string "field_" may not be used at the start of a field name', ACFC_TEXTDOMAIN),
				'This field cannot be moved until its changes have been saved' => __('This field cannot be moved until its changes have been saved', ACFC_TEXTDOMAIN),
				'Field group title is required' => __('Field group title is required', ACFC_TEXTDOMAIN),
				'Move to trash. Are you sure?'  => __('Move to trash. Are you sure?', ACFC_TEXTDOMAIN),
				'No toggle fields available'    => __('No toggle fields available', ACFC_TEXTDOMAIN),
				'Move Custom Field'             => __('Move Custom Field', ACFC_TEXTDOMAIN),
				'Checked'                       => __('Checked', ACFC_TEXTDOMAIN),
				'(no label)'                    => __('(no label)', ACFC_TEXTDOMAIN),
				'(this field)'                  => __('(this field)', ACFC_TEXTDOMAIN),
				'copy'                          => __('copy', ACFC_TEXTDOMAIN),
				'or'                            => __('or', ACFC_TEXTDOMAIN),
				'Show this field group if'      => __('Show this field group if', ACFC_TEXTDOMAIN),
				'Null'                          => __('Null', ACFC_TEXTDOMAIN),

				// Conditions
				'Has any value'                 => __('Has any value', ACFC_TEXTDOMAIN),
				'Has no value'                  => __('Has no value', ACFC_TEXTDOMAIN),
				'Value is equal to'             => __('Value is equal to', ACFC_TEXTDOMAIN),
				'Value is not equal to'         => __('Value is not equal to', ACFC_TEXTDOMAIN),
				'Value matches pattern'         => __('Value matches pattern', ACFC_TEXTDOMAIN),
				'Value contains'                => __('Value contains', ACFC_TEXTDOMAIN),
				'Value is greater than'         => __('Value is greater than', ACFC_TEXTDOMAIN),
				'Value is less than'            => __('Value is less than', ACFC_TEXTDOMAIN),
				'Selection is greater than'     => __('Selection is greater than', ACFC_TEXTDOMAIN),
				'Selection is less than'        => __('Selection is less than', ACFC_TEXTDOMAIN),

				// Pro-only fields
				'Repeater (Pro only)'           => __('Repeater (Pro only)', ACFC_TEXTDOMAIN),
				'Flexibly Content (Pro only)'   => __('Flexible Content (Pro only)', ACFC_TEXTDOMAIN),
				'Clone (Pro only)'              => __('Clone (Pro only)', ACFC_TEXTDOMAIN),
				'Gallery (Pro only)'            => __('Gallery (Pro only)', ACFC_TEXTDOMAIN),
			)
		);
		
		
		// localize data
		acf_localize_data(
			array(
				'fieldTypes' => acf_get_field_types_info(),
			)
		);

		// 3rd party hook
		do_action('acf/field_group/admin_enqueue_scripts');

	}
	
	function admin_head(){
		$this->add_meta_box();
	}
	
	function add_meta_box(){
		add_meta_box('acfc-field-group-fields', __('Calendar Contents', ACFC_TEXTDOMAIN), array( $this, 'meta_box_fields'), ACFC_FIELD_GROUP, 'advanced', 'high');
		/*
		add_meta_box( ACFC_FIELD_GROUP.'-locations', __('Location', ACFC_TEXTDOMAIN), array( $this->acf_admin_field_group, 'mb_locations'), 'acf-field-group', 'normal', 'high');
		add_meta_box( ACFC_FIELD_GROUP.'-options', __('Settings', ACFC_TEXTDOMAIN), array( $this->acf_admin_field_group, 'mb_options'), 'acf-field-group', 'normal', 'high');
		*/
	}
	
	function meta_box_fields(){
		
		$fields = acf_get_fields(ACFC_FIELD_GROUP);
		$parent = 0;
		include_once ACFC_DIR_INCLUDES.'/admin/view/field-group-fields.php';
		
	}
	
	
	
}

new ACFC_admin_field_group();