<?php

if ( ! defined('ABSPATH') ) {
	exit; // Exit if accessed directly
}
?>
<?php 
$fields_position = $this->settings->get('custom-fields-setting');
$fields_position = isset($fields_position['fields-position']) ? $fields_position['fields-position'] : 'inside';

?>
	
<div id="fields-list" class="c-fieldset_wrap sotable">
	
</div>

<div class="btn-wrap btn-add-field">
	<button id="btn_add-field" class="button button-primary button-large">Add Field</button>
</div>


<h3><?php _e( 'Advanced Setings', CFC_TEXTDOMAIN ) ?></h3>

<div class="">
	<div class="c-fieldset">
		
		<div class="c-field">
			<div class="c-field_label" for="cf-position"><?php _e( 'Custom Field Position', CFC_TEXTDOMAIN ) ?> <span class="required">*</span></div>
			<div class="c-field_input" data-type="textfield">
				<label>
					<input type="radio" id="cf-position" name="custom-fields-setting[fields-position]" value="inside" <?php checked('inside', $fields_position) ?>>
					<?php _e( 'Inside', CFC_TEXTDOMAIN ) ?> 
				</label>
				<label>
					<input type="radio" id="cf-position" name="custom-fields-setting[fields-position]" value="outside" <?php checked('outside', $fields_position) ?>>
					<?php _e( 'Outside', CFC_TEXTDOMAIN ) ?> 
				</label>
			</div>
		</div>
		
	</div>
</div>

<script type="text/html" id="field-template">
	<?php cfc_get_template_part('/admin/custom-fields'); ?>
</script>

<script>
	
</script>