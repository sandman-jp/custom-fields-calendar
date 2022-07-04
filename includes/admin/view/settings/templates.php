<?php
if ( ! defined('ABSPATH') ) {
	exit; // Exit if accessed directly
}
$templates = $this->settings->get('templates-settings');


$calendar_type = empty($templates['calendar-type']) ? 'monthly' : $templates['calendar-type'];
$column_header = empty($templates['column-header']) ? false : $templates['column-header'];
$seamless_month = empty($templates['seamless-month']) ? false : $templates['seamless-month'];
?>
<div class="p-front-view_tab">
<div class="c-fieldset cfc-<?php echo $calendar_type ?>">

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
	
	<div class="c-field continuity only-weekly">
		<div class="c-field_label"><?php _e('Continuity of Month', CFC_TEXTDOMAIN); ?></div>
		
		<div class="c-field_input"">
			<label>
				<input type="checkbox" name="templates-settings[seamless-month]" value="1" <?php checked( $seamless_month, 1); ?>> <?php _e('Seamless', CFC_TEXTDOMAIN); ?>
			</label>
		</div>
		
	</div>
	
	<div class="c-field column-header">
		<div class="c-field_label"><?php _e('Column Header', CFC_TEXTDOMAIN); ?></div>
		
		<div class="c-field_input"">
			<label>
				<input type="checkbox" name="templates-settings[column-header]" value="1" <?php checked( $column_header, 1); ?>> <?php _e('Show column header', CFC_TEXTDOMAIN); ?>
			</label>
		</div>
		
	</div>

</div>
</div>
