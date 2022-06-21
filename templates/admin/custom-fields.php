
<!-- template -->
<div class="__item" id="field_%id%">
		
	<div class="__item_field_wrap">
		
		<div class="__item_field_wrap_top">
			
			<!-- 上段 -->
			<div class="__item_field __list_order sortable-handle"><span>%num%</span></div>

			<div class="__item_field">
				<label class="field_label" for="field-label_%id%"><?php _e('Label', CFC_TEXTDOMAIN); ?> <span class="required">*</span></label>
				<div class="field_input" data-type="textfield"><input id="field-label_%id%" name="custom-fields-setting[%id%][field-label]" value="" type="text" required></div>
			</div>
			
			<div class="__item_field">
				<label class="field_label" for="field-name_%id%"><?php _e('Field Name', CFC_TEXTDOMAIN); ?> <span class="required">*</span></label>
				<div class="field_input" data-type="textfield"><input id="field-name_%id%" name="custom-fields-setting[%id%][field-name]" value="" type="text" required></div>
			</div>
			
			<div class="__item_field field-type">
				<label class="field_label" for="field-type_%id%"><?php _e('Field Type', CFC_TEXTDOMAIN); ?></label>
				<div class="field_input" data-type="select">
					<select id="field-type_%id%" name="custom-fields-setting[%id%][field-type]">
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
			
			
			
			<div class="__list_action">
				<div class="btn-wrap remove-item"><button class="" title="このフィールドを削除" data-action="remove-item" data-target="field_%id%"><i></i></button></div>
				<div class="btn-wrap toggle-details"><button class="" title="詳細を見る" data-action="toggle-details" data-target="field_%id%"><i></i></div>
			</div>
		</div>
		
		<div class="__item_field_wrap_bottom">
			
			<!-- 下段 -->
			<div class="field-col support-props">
				
				<?php cfc_get_template_part('/admin/custom-fields/supports/choices'); ?>
				
				<?php cfc_get_template_part('/admin/custom-fields/supports/required'); ?>
				<?php cfc_get_template_part('/admin/custom-fields/supports/default-value'); ?>
				<?php cfc_get_template_part('/admin/custom-fields/supports/place-holder'); ?>
				
			<!-- .col -->
			</div>
			
			<div class="field-col">
				
				<div class="__item_field">
					<label class="field_label" for="field-description_%id%"><?php _e('Description', CFC_TEXTDOMAIN); ?></label>
					<div class="field_input" data-type="textarea"><textarea id="field-description" name="custom-fields-setting[%id%][field-description]" value="" type="text"></textarea></div>
				</div>
				<!-- .col -->
		
			</div>
			
			<div class="field-col">
				
				<div class="__item_field">
					<div class="field_label" for="field-conditions"><?php _e('Conditions', CFC_TEXTDOMAIN); ?></div>
					<div class="field_input __conditions" data-type="group">
						
						<div class="btn-wrap add-condition">
							<button id="btn_add-condition" class="button">Add Condition</button>
						</div>
					</div>
					
				</div>
				<!-- .col -->
		
			</div>
			
		</div>
		
	</div>
		
</div><!-- .__item -->