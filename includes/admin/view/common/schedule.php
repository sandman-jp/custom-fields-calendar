
<div id="cf-calendar">
<h1><?php _e('Common Settings', CFC_TEXTDOMAIN) ?></h1>


<nav class="nav-tab-wrapper woo-nav-tab-wrapper">
	<a href="<?php admin_url('edit.php');  ?>?post_type=<?php echo CF_CALENDAR ?>&page=common-settings" class="nav-tab nav-tab-active"><?php _e('Schedule & Holiday Settings', CFC_TEXTDOMAIN); ?></a>
	<a href="<?php admin_url('edit.php');  ?>?post_type=<?php echo CF_CALENDAR ?>&page=common-settings&tab=validation" class="nav-tab"><?php _e('Validation Rule Settings', CFC_TEXTDOMAIN); ?>(<?php _e('Not Available', CFC_TEXTDOMAIN); ?>)</a>
	<a href="<?php admin_url('edit.php');  ?>?post_type=<?php echo CF_CALENDAR ?>&page=common-settings&tab=option" class="nav-tab"><?php _e('Other Settings', CFC_TEXTDOMAIN); ?></a>
</nav>

<div id="cfc-settings">
	<form id="schedule-settings" class="wrap" action="" method="post">
		<input type="hidden" name="cfc-action" value="save-common-settings" />
		<?php wp_nonce_field('save-common-schedule', '_cfc_nonce'); ?>
		<h3><?php _e('Schedule & Holiday Settings', CFC_TEXTDOMAIN); ?></h3>
		
		
			<div class="c-fieldset">
				<div class="c-field">
					<div class="c-field_input u-w50 c-field_input-short"></div>
					<div class="c-field_input u-w80 u-bo_l c-field_input-short"><?php _e('Post ID', CFC_TEXTDOMAIN); ?></div>
					<div class="c-field_label u-w300"><?php _e('Date', CFC_TEXTDOMAIN); ?></div>
					<div class="c-field_input"><?php _e('Label', CFC_TEXTDOMAIN); ?></div>
					<div class="c-field_input u-w50 u-bo_l c-field_input-short"><?php _e('Holiday', CFC_TEXTDOMAIN); ?></div>
					<div class="c-field_input u-w50 u-bo_l c-field_input-short"></div>
				</div>
			</div>
		
			<div id="schedule-list" class="p-schedule_tab">
				
			</div>
			
			<div class="btn-wrap btn-add-field">
				<button id="btn_add-schedule" class="button button-primary button-large"><?php _e('Add Schedule', CFC_TEXTDOMAIN); ?></button>
			</div>
			
			<div class="btn-wrap">
				<button id="btn_save-schedule" class="button button-primary button-large"><?php _e('Save'); ?></button>
			</div>
			
	</form>
	
</div>

</div>

<script type="text/html" id="schedule-template">
	<?php cfc_get_template_part('/admin/schedule'); ?>
</script>
