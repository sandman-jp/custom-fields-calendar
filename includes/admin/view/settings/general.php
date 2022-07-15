<?php
if ( ! defined('ABSPATH') ) {
	exit; // Exit if accessed directly
}
?>

<?php
global $wp_locale;

$general = $this->settings->get('general-settings');


$start_week = isset($general['first-week']) ? $general['first-week'] : 1;


//$start_week = isset($general['start-week']) ? $general['start-week'] : 1;

$start_date_type = empty($general['calendar-term']['start']['type']) ? 'relative' : $general['calendar-term']['start']['type'];

$start_date_absolute_year = empty($general['calendar-term']['start']['absolute']['year']) ? wp_date('Y') : $general['calendar-term']['start']['absolute']['year'];
$start_date_absolute_month = empty($general['calendar-term']['start']['absolute']['month']) ? wp_date('j') : $general['calendar-term']['start']['absolute']['month'];

$start_date_relative = empty($general['calendar-term']['start']['relative']) ? '0' : $general['calendar-term']['start']['relative'];

$end_date_type = empty($general['calendar-term']['end']['type']) ? 'relative' : $general['calendar-term']['end']['type'];

$end_time = strtotime('+ 2 monaths');
$end_date_absolute_year = empty($general['calendar-term']['end']['absolute']['year']) ? wp_date('Y', $end_time) : $general['calendar-term']['end']['absolute']['year'];
$end_date_absolute_month = empty($general['calendar-term']['end']['absolute']['month']) ? wp_date('j', $end_time) : $general['calendar-term']['end']['absolute']['month'];

$end_date_relative = empty($general['calendar-term']['end']['relative']) ? '1' : $general['calendar-term']['end']['relative'];
?>
<!-- template -->
<div class="p-calender-term_tab">
<div class="c-fieldset">
	
	
	<div class="c-field start-week">

		<div class="c-field_label"><?php _e('First Week', CFC_TEXTDOMAIN); ?></div>
		
		<div class="c-field_input"">
			<select name="general-settings[first-week]">
			<?php for($i=0; $i<=6; $i++): ?>
				<option value="<?php echo $i; ?>" <?php selected($i, $start_week); ?>> <?php echo $wp_locale->get_weekday_abbrev($wp_locale->get_weekday($i)); ?></option>
			<?php endfor; ?>
				<option value="current" <?php selected('current', $start_week); ?>><?php _e('Current day of the week', CFC_TEXTDOMAIN); ?></option>

			</select>
		</div>
	</div>
	
</div>

<h4><?php _e('Display Period for editting', CFC_TEXTDOMAIN); ?></h4>
<div class="c-fieldset">
	<div class="c-field cfc-calendar-term">
		<div class="c-field_label"><?php _e('The beginning of the period', CFC_TEXTDOMAIN); ?></div>
		
		<div class="c-field_input"">
			<dl class=""">
				<dt>
					<label><input class="btn-calenadr_term-type" type="radio" name="general-settings[calendar-term][start][type]" value="absolute" <?php checked($start_date_type, 'absolute'); ?>> <?php _e('Absolute', CFC_TEXTDOMAIN); ?></label>
					<label><input class="btn-calenadr_term-type" type="radio" name="general-settings[calendar-term][start][type]" value="relative" <?php checked($start_date_type, 'relative'); ?>> <?php _e('Relative', CFC_TEXTDOMAIN); ?></label>
					<?php /*
					<label><input class="btn-calenadr_term-type" type="radio" name="general-settings[calendar-term][start][type]" value="today" <?php checked($start_date_type, 'today'); ?>> <?php _e('Today', CFC_TEXTDOMAIN); ?></label>
					*/ ?>
				</dt>
				
				<dd class="cfc-terms-absolute">
					<span> <?php _e('Start from', CFC_TEXTDOMAIN); ?> </span>
					<select name="general-settings[calendar-term][start][absolute][year]" class="u-w80">
						<?php for($i=date('Y')-5; $i<date('Y')+5; $i++): ?>
						<option value="<?php echo $i ?>" <?php selected($start_date_absolute_year, $i); ?>><?php echo $i ?></option>
						<?php endfor; ?>
					</select>
					<span> / </span>
					<select name="general-settings[calendar-term][start][absolute][month]" class="u-w80">
						<?php for($i=1; $i<13; $i++): ?>
						<option value="<?php echo $i ?>" <?php selected($start_date_absolute_month, $i); ?>><?php echo $i ?></option>
						<?php endfor; ?>
					</select>
				</dd>
				
				<dd class="cfc-terms-relative">
					<span> <?php _e('From', CFC_TEXTDOMAIN); ?> </span>
					<input type="number" name="general-settings[calendar-term][start][relative]" value="<?php echo $start_date_relative ?>" class="u-w100">
					<span> <?php _e('months from now', CFC_TEXTDOMAIN); ?> </span>
				</dd>
			</dl>
				
		</div>
	</div>
	<div class="c-field cfc-calendar-term">
		<div class="c-field_label"><?php _e('The end of the period', CFC_TEXTDOMAIN); ?></div>
		
		<div class="c-field_input"">
			<dl>
				<dt>
					<label><input class="btn-calenadr_term-type" type="radio" name="general-settings[calendar-term][end][type]" value="absolute" <?php checked($end_date_type, 'absolute'); ?>> <?php _e('Absolute', CFC_TEXTDOMAIN); ?></label>
					<label><input class="btn-calenadr_term-type" type="radio" name="general-settings[calendar-term][end][type]" value="relative" <?php checked($end_date_type, 'relative'); ?>> <?php _e('Relative', CFC_TEXTDOMAIN); ?></label>
					<?php /*
					<label><input class="btn-calenadr_term-type" type="radio" name="general-settings[calendar-term][end][type]" value="today" <?php checked($start_date_type, 'today'); ?>> <?php _e('Today', CFC_TEXTDOMAIN); ?></label>
					*/ ?>
				</dt>
				<dd class="cfc-terms-absolute">
					<span> <?php _e('Finish until', CFC_TEXTDOMAIN); ?> </span>
					<select name="general-settings[calendar-term][end][absolute][year]" class="u-w80">
						<?php for($i=date('Y')-5; $i<date('Y')+5; $i++): ?>
						<option value="<?php echo $i ?>" <?php selected($end_date_absolute_year, $i); ?>><?php echo $i ?></option>
						<?php endfor; ?>
					</select>
					<span> / </span>
					<select name="general-settings[calendar-term][end][absolute][month]" class="u-w80">
						<?php for($i=1; $i<13; $i++): ?>
						<option value="<?php echo $i ?>" <?php selected($end_date_absolute_month, $i); ?>><?php echo $i ?></option>
						<?php endfor; ?>
					</select>
				</dd>
				<dd class="cfc-terms-relative">
					<span> <?php _e('Until', CFC_TEXTDOMAIN); ?> </span>
					<input type="number" name="general-settings[calendar-term][end][relative]" value="<?php echo $end_date_relative ?>" class="u-w100" min="1">
					<span> <?php _e('months later from beginning.', CFC_TEXTDOMAIN); ?> </span>
				</dd>
			</dl>
				
		</div>
	</div>
	
</div>

</div>
