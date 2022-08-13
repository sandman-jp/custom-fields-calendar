<div class="c-fieldset" id="schedule-settings-%id%">
	<input type="hidden" name="schedule-settings[%id%][post_id]" value="%post_id%" %disabled%>
	<div class="c-field">
		<div class="c-field_order u-w50  c-field_input-short">
			<span>%num%</span>
		</div>
		<div class="c-field_postid u-w80 c-field_input-short">
			<span>%post_id%</span>
		</div>
		<div class="c-field_label u-w300">
			<input name="schedule-settings[%id%][date]" value="" class="datepicker" required %disabled%>
		</div>
		<div class="c-field_input">
			<input name="schedule-settings[%id%][label]" value="" class="u-w100per" %disabled%>
		</div>
		<div class="c-field_input u-w50 u-bo_l c-field_input-short">
			<input type="checkbox" name="schedule-settings[%id%][holiday]" value="1" %disabled%>
		</div>
		
		<div class="c-field_input u-w50 c-field_input-short u-bo_l">
			<button class="remove-item" title="スケジュールを削除" data-action="remove-item" data-target="schedule-settings-%id%" %disabled%></button>
		</div>
	</div>
	
</div>