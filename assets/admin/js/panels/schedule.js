//Schedule settings
jQuery(function($){
	
	if(fields_settings['schedule-settings'] != null && typeof(fields_settings['schedule-settings']) != 'undefined'){
	
		var _sdata = fields_settings['schedule-settings'];
		
		
		
		//initialize
		for(let p in _sdata){
			let datedata = _sdata[p];
			
			for(let i=0; i<datedata.length; i++){
				
				let is_disabled = 'disabled="disabled"';
				let post_id = (typeof(datedata[i]['post_id']) == 'undefined' || datedata[i]['post_id'] == 'undefined') ? 0 : datedata[i]['post_id'];
				
				
				if(post_id && $('#post_ID').val() == post_id){
					is_disabled = '';
				}else if(!$('#post_ID').val() && !parseInt(datedata[i]['post_id'])){
					is_disabled = '';
				}
				
				
				add_schedule(post_id, is_disabled);
				
				let $schedule = $('.c-fieldset:last', '#schedule-list');
				$('[name$="[date]"]', $schedule).val(datedata[i]['date']);
				$('[name$="[label]"]', $schedule).val(datedata[i]['label']);
				
				if(typeof(datedata[i]['post_id']) != 'undefined'){
					$('[name$="[post_id]"]', $schedule).val(datedata[i]['post_id']);
					
				}
				
				
				if(typeof(datedata[i]['holiday']) != 'undefined' && datedata[i]['holiday'] == 1){
					$('[name$="[holiday]"]', $schedule).prop('checked', true);
				}
			}
			
		}
	}
	
	//Add Field
	$('#btn_add-schedule').click(function(e){
		e.preventDefault();
		let post_id =  $('#post_ID').val() ?  $('#post_ID').val() : 0;
		
		add_schedule(post_id, '');
	});
	
	
	
	function add_schedule(post_id, is_disabled){
		let count = parseInt($('#schedule-list > .c-fieldset').length);
		let html = $('#schedule-template').text();
		
		html = html.replaceAll('%id%', count);
		html = html.replaceAll('%num%', count + 1);
		
		html = html.replaceAll('%post_id%', post_id);
		
		html = html.replaceAll('%disabled%', is_disabled);
		
		let $html = $(html);
		
		$('.datepicker', $html).datepicker({
			showOn: 'both',
			buttonText: '',
			dateFormat: 'yy-mm-dd',
		});
		
		$('.remove-item', $html).click(function(e){
			e.preventDefault();
			let tgt = $(this).data('target');
			$('#'+tgt).remove();
		});
		
		$('#schedule-list').append($html);
	}
});