//front view settings
jQuery(function($){
	$('[name="template-settings[calendar-type]"]').click(function(){
		if($(this).is(':checked')){
			let $parent = $(this).parents('.c-fieldset:first');
			$parent.attr('class', 'c-fieldset');
			$parent.addClass('cfc-'+$(this).val());
		}
	});
});