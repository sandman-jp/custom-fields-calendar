<?php
/*
 * カレンダーの設定画面
 */
?>
<?php
if ( ! defined('ABSPATH') ) {
	exit; // Exit if accessed directly
}
?>
<?php
$custom_field_setting_data = $this->settings->get('custom-field-settings');
$has_cap = current_user_can('manage_options');

?>
<div id="cf-calendar" style="padding-top: 15px;">
	
<div class="postbox-header">
	<h2><?php _e( 'Calendar Contents', CFC_TEXTDOMAIN ); ?></h2>
	<div class="handle-actions cfc-actions c-button_wrap">
		<button id="show-table" class="button dashicons dashicons-calendar-alt c-button have-text" data-action="show-table" title="<?php _e( 'Save settings data and show calendar table', CFC_TEXTDOMAIN ) ?>">Calendar</button>
		<?php if($has_cap): ?>
		<button id="show-settings" class="button dashicons dashicons-admin-generic c-button have-text" data-action="show-settings" title="<?php _e( 'Show setting tabs asnd fields', CFC_TEXTDOMAIN ) ?>">Settings</button>
		<?php endif; ?>
	</div>
</div>

<div class="inside">
	
<div id="cfc-table" class="l-panel <?php echo empty($custom_field_setting_data) ? '' : 'is-active'; ?>">
	
	<div class="l-col">
		<?php $position = $custom_field_setting_data['fields-position']; ?>
	  <div class="p-table_wrap p-table--<?php echo $position; ?>_wrap">
		  <?php cfc_get_instance('CFC\admin\calendar\table')->rendar_table(); ?>
	  </div>
		
		<?php if($position == 'outside'): ?>
		<div class="p-field_wrap c-fieldset_wrap">
			<div id="fields-panel"><!-- ここにfieldsetが入る --></div>
		</div>
		<?php endif; ?>
	</div>
  
</div>

<?php if($has_cap): ?>
<div id="cfc-settings" class="l-panel <?php echo empty($custom_field_setting_data) ? 'is-active' : ''; ?>">
	
	<div id="setting-tabs">
		<ul>
    	<li><a href="#custom-field-settings"><?php _e( 'Custom Fields', CFC_TEXTDOMAIN ) ?></a></li>
    	<li><a href="#general-settings"><?php _e( 'General', CFC_TEXTDOMAIN ) ?></a></li>
    	<li><a href="#template-settings"><?php _e( 'Front View', CFC_TEXTDOMAIN ) ?></a></li>
			<li><a href="#schedule-settings"><?php _e( 'Schedule', CFC_TEXTDOMAIN ) ?></a></li>
  	</ul>
	</div>
	
  <div id="custom-field-settings" class="c-panel p-custom-fields_tab">
	  <h3><?php _e( 'Custom Fields Settings', CFC_TEXTDOMAIN ) ?></h3>
	  <?php include CFC_DIR_INCLUDES.'/admin/view/settings/custom-field.php'; ?>
	</div>
  <div id="general-settings" class="c-panel p-general_tab">
		<h3><?php _e( 'General Settings', CFC_TEXTDOMAIN ) ?></h3>
		<?php include CFC_DIR_INCLUDES.'/admin/view/settings/general.php'; ?>
	</div>
	
  <div id="template-settings" class="c-panel p-front-view_tab">
		<h3><?php _e( 'Front View Settings', CFC_TEXTDOMAIN ) ?></h3>
		<?php include CFC_DIR_INCLUDES.'/admin/view/settings/template.php'; ?>
	</div>
	
	<div id="schedule-settings" class="c-panel  p-schedule_tab">
		<h3><?php _e( 'Schedule Settings', CFC_TEXTDOMAIN ) ?></h3>
		<?php include CFC_DIR_INCLUDES.'/admin/view/settings/schedule.php'; ?>
	</div>
  
</div>
<?php endif; ?>

</div>

</div>

<script>
var fields_settings = <?php echo json_encode($this->settings->get_all()); ?>
</script>