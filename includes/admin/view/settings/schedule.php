<div class="c-fieldset">
	<div class="c-field">
		<div class="c-field_input u-w50"></div>
		<div class="c-field_label u-w300"><?php _e('Date', CFC_TEXTDOMAIN); ?></div>
		<div class="c-field_input"><?php _e('Label', CFC_TEXTDOMAIN); ?></div>
		<div class="c-field_input u-w100"><?php _e('Holiday', CFC_TEXTDOMAIN); ?></div>
	</div>
</div>

<div id="schedule-list">







</div>

<div class="btn-wrap btn-add-field">
	<button id="btn_add-schedule" class="button button-primary button-large">Add Schedule</button>
</div>

<script type="text/html" id="schedule-template">
	<?php cfc_get_template_part('/admin/schedule'); ?>
</script>