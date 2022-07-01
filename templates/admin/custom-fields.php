
<!-- template -->
<div class="c-fieldset" id="field_%id%">
		
		
		<div class="l-col o-headline">
			
			<!-- 上段 -->
			<div class="c-field_order sortable-handle"><span>%num%</span></div>

			<div class="c-field">
				<label class="c-field_label" for="field-label_%id%"><?php _e('Label', CFC_TEXTDOMAIN); ?> <span class="required">*</span></label>
				<div class="c-field_input" data-type="textfield"><input id="field-label_%id%" name="custom-fields-settings[fields][%id%][field-label]" value="" type="text" required></div>
			</div>
			
			<div class="c-field">
				<label class="c-field_label" for="field-name_%id%"><?php _e('Field Name', CFC_TEXTDOMAIN); ?> <span class="required">*</span></label>
				<div class="c-field_input" data-type="textfield"><input id="field-name_%id%" name="custom-fields-settings[fields][%id%][field-name]" value="" type="text" required></div>
			</div>
			
			<div class="c-field field-type">
				<label class="c-field_label" for="field-type_%id%"><?php _e('Field Type', CFC_TEXTDOMAIN); ?></label>
				<div class="c-field_input" data-type="select">
					<select id="field-type_%id%" name="custom-fields-settings[fields][%id%][field-type]">
						<option value="textfield">Text</option>
						<option value="textarea">TextArea</option>
						<option value="select" data-choices="1">Select</option>
						<option value="radio" data-choices="1">Radio</option>
						<option value="checkbox" data-choices="1">Checkbox</option>
						<option value="truefalse">True/False</option>
						<option value="email">Email Address</option>
						<option value="tel">Telephone Number</option>
						<option value="url">Web URL</option>
					</select>
				</div>
			</div>
			
			
			
			<div class="c-field_action">
				<button class="remove-item" title="このフィールドを削除" data-action="remove-item" data-target="field_%id%"></button>
				<button class="toggle-details" title="詳細を見る" data-action="toggle-details" data-target="field_%id%">
			</div>
		</div>
		
		<div class="o-wrap_details">
			
			<!-- 下段 -->
			<div class="support-props">
				
				<?php cfc_get_template_part('/admin/custom-fields/supports/choices'); ?>
				
				<?php cfc_get_template_part('/admin/custom-fields/supports/required'); ?>
				<?php cfc_get_template_part('/admin/custom-fields/supports/default-value'); ?>
				<?php cfc_get_template_part('/admin/custom-fields/supports/place-holder'); ?>
				
				<?php cfc_get_template_part('/admin/custom-fields/supports/validation'); ?>
				
				<?php cfc_get_template_part('/admin/custom-fields/supports/conditions'); ?>
		
			</div>
			
		</div>
		
		
</div><!-- .__item -->