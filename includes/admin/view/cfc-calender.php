<?php
/*
 * カレンダーの設定画面
 */

if ( ! defined('ABSPATH') ) {
	exit; // Exit if accessed directly
}
$custom_field_setting_data = $settings->get('custom-fields-setting');
?>
<div id="cf-calendar">
	
<div class="postbox-header">
	<h2><?php _e( 'Calendar Contents', CFC_TEXTDOMAIN ); ?></h2>
	<div class="handle-actions cfc-actions">
		<button class="button dashicons dashicons-calendar-alt show-table" data-action="show-table" title="<?php _e( 'Save settings data and show calendar table', CFC_TEXTDOMAIN ) ?>">Calendar</button>
		<button class="button dashicons dashicons-admin-generic show-settings" data-action="show-settings" title="<?php _e( 'Show setting tabs asnd fields', CFC_TEXTDOMAIN ) ?>">Settings</button>
	</div>
</div>

<div class="inside">
<div id="cfc-table" class="cfc-panel <?php echo empty($custom_field_setting_data) ? '' : 'active'; ?>">
	
	<div class="calendar_wrap">
	  <div class="calendar_list">
		  <?php cfc_get_instance('CFC\admin\calendar\table')->rendar_table(); ?>
	  </div>
		<div id="field-panel">
		  <div class="fieldset_list"></div>
	  </div>
	</div>
  
</div>

<div id="cfc-settings" class="cfc-panel <?php echo empty($custom_field_setting_data) ? 'active' : ''; ?>">
	
	<div id="setting-tabs">
	<ul>
    <li><a href="#custom-fields-setting"><?php _e( 'Custom Fields', CFC_TEXTDOMAIN ) ?></a></li>
    <li><a href="#holidays-setting"><?php _e( 'Holidays', CFC_TEXTDOMAIN ) ?></a></li>
    <li><a href="#general-setting"><?php _e( 'General', CFC_TEXTDOMAIN ) ?></a></li>
    <li><a href="#templates-setting"><?php _e( 'Template', CFC_TEXTDOMAIN ) ?></a></li>
  </ul>
	</div>
	
  <div id="custom-fields-setting" class="setting-panel">
	  <h3><?php _e( 'Custom Fields', CFC_TEXTDOMAIN ) ?></h3>
	  <?php cfc_get_template_part('/admin/view/settings/custom-fields'); ?>
	</div>
	
  <div id="holidays-setting" class="setting-panel">
	  <h3><?php _e( 'Holidays', CFC_TEXTDOMAIN ) ?></h3>
	  <?php cfc_get_template_part('/admin/view/settings/holidays'); ?>
	</div>
  <div id="general-setting" class="setting-panel"><?php _e( 'General', CFC_TEXTDOMAIN ) ?></div>
  <div id="templates-setting" class="setting-panel"><?php _e( 'Template', CFC_TEXTDOMAIN ) ?></div>
  
</div>

</div>

</div>

<script>
var fields_settings = <?php echo json_encode($settings->get_all()); ?>
</script>