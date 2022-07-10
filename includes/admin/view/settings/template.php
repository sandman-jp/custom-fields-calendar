<?php
if ( ! defined('ABSPATH') ) {
	exit; // Exit if accessed directly
}
$templates = $this->settings->get('template-settings');


$calendar_type = empty($templates['calendar-type']) ? 'monthly' : $templates['calendar-type'];
$column_header = empty($templates['column-header']) ? false : $templates['column-header'];
$seamless_month = empty($templates['seamless-month']) ? false : $templates['seamless-month'];
ob_start();
?>
.cfc-table {
	width: 100%;
	border: 1px solid #9e9889;
	border-collapse: collapse; }
	.cfc-table th, .cfc-table td {
		font-size: 14px;
		width: calc(100% / 7);
		border-left: 1px solid #dcd7ca; }
	.cfc-table.have_column_header th, .cfc-table.have_column_header td {
		width: calc(100% / 8); }
	.cfc-table td {
		border-bottom: 1px solid #9e9889;
		position: relative;
		vertical-align: top; }
	.cfc-table time {
		display: -webkit-box;
		display: -ms-flexbox;
		display: flex;
		width: 30px;
		height: 30px;
		font-size: 12px;
		font-weight: bold;
		-webkit-box-align: center;
				-ms-flex-align: center;
						align-items: center;
		-webkit-box-pack: center;
				-ms-flex-pack: center;
						justify-content: center;
		position: absolute;
		top: 0;
		right: 0;
		color: #fff;
		background: #9e9889; }
	.cfc-table .cfc-item {
		font-weight: bold;
		color: #9e9889; }
	.cfc-table .cfc-data, .cfc-table .cfc-item {
		margin: 0;
		padding: 5px;
		font-size: 14px;
		border-bottom: 1px solid #dcd7ca; }
		.cfc-table .cfc-data:last-of-type, .cfc-table .cfc-item:last-of-type {
			border: none; }
		.cfc-table .cfc-data:first-of-type, .cfc-table .cfc-item:first-of-type {
			border-bottom: 1px solid #dcd7ca; }

.cfc-table-weekly td {
	padding-top: 32px; }
.cfc-table-weekly time {
	width: 100%; }
.cfc-table-weekly .cfc-items {
	padding-top: 32px; }
<?php ;
$add_css = ob_get_clean();
$add_css = !empty($templates['add-css']) ? $templates['add-css'] : $add_css;
?>
<div class="c-fieldset cfc-<?php echo $calendar_type ?>">

	<div class="c-field calendar-type">
		<div class="c-field_label"><?php _e('Calendar Type', CFC_TEXTDOMAIN); ?></div>
		
		<div class="c-field_input"">
			<label>
				<input type="radio" name="template-settings[calendar-type]" value="monthly" <?php checked( $calendar_type, 'monthly'); ?>> <?php _e('Monthly Type', CFC_TEXTDOMAIN); ?>
			</label>
			<label>
				<input type="radio" name="template-settings[calendar-type]" value="weekly" <?php checked( $calendar_type, 'weekly'); ?>> <?php _e('Weekly Type', CFC_TEXTDOMAIN); ?>
			</label>
		</div>
	</div>
	
	<div class="c-field continuity only-weekly">
		<div class="c-field_label"><?php _e('Continuity of Month', CFC_TEXTDOMAIN); ?></div>
		
		<div class="c-field_input"">
			<label>
				<input type="checkbox" name="template-settings[seamless-month]" value="1" <?php checked( $seamless_month, 1); ?>> <?php _e('Seamless', CFC_TEXTDOMAIN); ?>
			</label>
		</div>
		
	</div>
	
	<div class="c-field column-header">
		<div class="c-field_label"><?php _e('Column Header', CFC_TEXTDOMAIN); ?></div>
		
		<div class="c-field_input"">
			<label>
				<input type="checkbox" name="template-settings[column-header]" value="1" <?php checked( $column_header, 1); ?>> <?php _e('Show column header', CFC_TEXTDOMAIN); ?>
			</label>
		</div>
		
	</div>
	
	<div class="c-field add-css">
		<div class="c-field_label"><?php _e('Additional Stylesheet', CFC_TEXTDOMAIN); ?></div>
		
		<div class="c-field_input"">
			<textarea name="template-settings[add-css]" rows="10"><?php echo $add_css; ?></textarea>
		</div>
		
	</div>

</div>
