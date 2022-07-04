<?php
if ( ! defined('ABSPATH') ) {
	exit; // Exit if accessed directly
}
$templates = $this->settings->get('templates-settings');

$calendar_type = empty($templates['calendar-type']) ? 'monthly' : $templates['calendar-type'];
$column_header = empty($templates['column-header']) ? false : $templates['column-header'];
?>

<h4><?php _e('Front View Settings', CFC_TEXTDOMAIN); ?></h4>
<div class="c-fieldset">

<div class="c-field calendar-type">
	<div class="c-field_label"><?php _e('Calendar Type', CFC_TEXTDOMAIN); ?></div>
	
	<div class="c-field_input"">
		<label>
			<input type="radio" name="templates-settings[calendar-type]" value="monthly" <?php checked( $calendar_type, 'monthly'); ?>> <?php _e('Monthly Type', CFC_TEXTDOMAIN); ?>
		</label>
		<label>
			<input type="radio" name="templates-settings[calendar-type]" value="weekly" <?php checked( $calendar_type, 'weekly'); ?>> <?php _e('Weekly Type', CFC_TEXTDOMAIN); ?>
		</label>
	</div>
</div>

<div class="c-field column-header">
	<div class="c-field_label"><?php _e('Column Header', CFC_TEXTDOMAIN); ?></div>
	
	<div class="c-field_input"">
		<label>
			<input type="checkbox" name="templates-settings[column-header]" value="1" <?php checked( $column_header, 1); ?>> <?php _e('Show column header.', CFC_TEXTDOMAIN); ?>
		</label>
	</div>
	
</div>

</div>
