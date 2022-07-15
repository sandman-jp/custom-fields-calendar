<?php
global $wp_locale;
$start_date_year = '';
$start_date_month = '';
$end_date_year = '';
$end_date_month = '';
?>
<div id="condition_%id%_%cid%" class="c-fieldset">
	
<div class="c-field u-flex_column u-wauto u-bo_b">
	<div class="c-field_label u-bo_b u-bo_l u-bo_t">
		<span><?php _e('Duration', CFC_TEXTDOMAIN); ?></span>
	</div>
	
	<div class="c-field_input u-bo_l" >
		<div class="c-field  u-flex_column">
			<div class="c-field_label u-wauto"><?php _e('Start month', CFC_TEXTDOMAIN); ?> : </div>
			
			<div class="c-field_input u-wauto">
				<select name="custom-field-settings[fields][%id%][field-conditions][%cid%][start][year]" class="cfc-calendar-year u-w80">
					<option value="all"></option>
					<?php for($i=date('Y')-5; $i<date('Y')+5; $i++): ?>
					<option value="<?php echo $i ?>" <?php checked($start_date_year, $i); ?>><?php echo $i ?></option>
					<?php endfor; ?>
				</select>
				
				<div class="cfc-caltendar-month u-flex_row">
					<span style="padding: 0 3px;"> / </span>
					
					<select name="custom-field-settings[fields][%id%][field-conditions][%cid%][start][month]" class="u-w80" disabled>
						<?php for($i=1; $i<13; $i++): ?>
						<option value="<?php echo $i ?>" <?php checked($start_date_month, $i); ?>><?php echo $i ?></option>
						<?php endfor; ?>
					</select>
				</div>
			</div>
		</div>
	</div>
	
	<div class="c-field_input u-bo_l" >
		<div class="c-field  u-flex_column">
			<div class="c-field_label u-wauto"><?php _e('End month', CFC_TEXTDOMAIN); ?> : </div>
			<div class="c-field_input u-wauto">
				<select name="custom-field-settings[fields][%id%][field-conditions][%cid%][end][year]" class="cfc-calendar-year u-w80">
					<option value="all"></option>
					<?php for($i=date('Y')-5; $i<date('Y')+5; $i++): ?>
					<option value="<?php echo $i ?>" <?php checked($end_date_year, $i); ?>><?php echo $i ?></option>
					<?php endfor; ?>
				</select>
				<div class="cfc-caltendar-month u-flex_row">
					<span style="padding: 0 3px;"> / </span>
					<select name="custom-field-settings[fields][%id%][field-conditions][%cid%][end][month]" class="u-w80" disabled>
						<?php for($i=1; $i<13; $i++): ?>
						<option value="<?php echo $i ?>" <?php checked($end_date_month, $i); ?>><?php echo $i ?></option>
						<?php endfor; ?>
					</select>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="c-field u-flex_column u-bo_b">
	<div class="c-field_label u-bo_b u-bo_l u-bo_t">
		<span><?php _e('Interval', CFC_TEXTDOMAIN); ?>  </span>
	</div>
	
	<div class="c-field_input u-bo_l u-bo_r">
		<div class="c-field  u-flex_column">
			<div class="c-field_label u-wauto"><?php _e('Week', CFC_TEXTDOMAIN); ?> : </div>
			<div class="c-field_input u-wauto">
				<label>
					<input 
						type="checkbox" 
						name="custom-field-settings[fields][%id%][field-conditions][%cid%][cond1][]" 
						value="1"
						checked
						> <?php _ex('First', 'week', CFC_TEXTDOMAIN); ?></label>
				<label>
					<input 
						type="checkbox" 
						name="custom-field-settings[fields][%id%][field-conditions][%cid%][cond1][]" 
						value="2"
						checked
						> <?php _ex('Second', 'week', CFC_TEXTDOMAIN); ?></label>
				<label>
					<input 
						type="checkbox" 
						name="custom-field-settings[fields][%id%][field-conditions][%cid%][cond1][]" 
						value="3"
						checked
						> <?php _ex('Third', 'week', CFC_TEXTDOMAIN); ?></label>
				<label>
					<input 
						type="checkbox" 
						name="custom-field-settings[fields][%id%][field-conditions][%cid%][cond1][]" 
						value="4"
						checked
						> <?php _ex('Fourth','week',  CFC_TEXTDOMAIN); ?></label>
				<label>
					<input 
						type="checkbox" 
						name="custom-field-settings[fields][%id%][field-conditions][%cid%][cond1][]" 
						value="5"
						checked
						> <?php _ex('Fifth', 'week', CFC_TEXTDOMAIN); ?></label>
			</div>
		</div>
	</div>
	
	<div class="c-field_input u-bo_l u-bo_r">
		<div class="c-field  u-flex_column">
			<div class="c-field_label u-wauto"><?php _e('Weekday', CFC_TEXTDOMAIN); ?> : </div>
			<div class="c-field_input u-wauto">
				<?php for($i=0; $i<=6; $i++): ?>
				<label>
					<input 
						type="checkbox" 
						name="custom-field-settings[fields][%id%][field-conditions][%cid%][cond2][]" 
						value="<?php echo $i; ?>" 
						checked
						> <?php echo $wp_locale->get_weekday_abbrev($wp_locale->get_weekday($i)); ?></label>
				<?php endfor; ?>
			</div>
		</div>
	</div>
</div>

<div class="c-field u-flex_column u-bo_b u-wauto" style="min-width: 250px !important;">
	<div class="c-field_label u-bo_b u-bo_l u-bo_t">
		<span><?php _e('Options', CFC_TEXTDOMAIN); ?>  </span>
	</div>
	
	<div class="c-field_input">
		<div class="c-field  u-flex_column c-field__inline">
			<div class="c-field_label u-wauto"><?php _e('Holiday\'s behavior', CFC_TEXTDOMAIN); ?> : </div>
			<div class="c-field_input u-wauto" style="display:block">
				<label style="display:block">
					<input 
						type="radio" 
						name="custom-field-settings[fields][%id%][field-conditions][%cid%][holiday]" 
						value="" 
						checked
						> <?php _e('Follow interval setting'); ?></label>
						
				<label>
					<input 
						type="radio" 
						name="custom-field-settings[fields][%id%][field-conditions][%cid%][holiday]" 
						value="show" 
						> <?php _e('Show field'); ?></label>
						
				<label>
					<input 
						type="radio" 
						name="custom-field-settings[fields][%id%][field-conditions][%cid%][holiday]" 
						value="hide" 
						> <?php _e('Hide field'); ?></label>
						
			</div>
		</div>
	</div>
	
</div>

<div class="c-field c-field_action u-wauto u-bo_l">
	<div class="c-field_input u-h100per u-wauto">
		<button class="remove-item" title="コンディションを削除" data-action="remove-item" data-target="condition_%id%_%cid%"></button>
	</div>
	
</div>
</div>