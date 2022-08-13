//general settings
jQuery(function($){
	
	$('.btn-calenadr_term-type').click(function(e){
		let $parent = $(this).parents('dl');
		let $type = $(this).val();
		$parent.removeClass('is-absolute');
		$parent.removeClass('is-relative');
		
		$parent.addClass('is-'+$type);
		
	})
	$('.btn-calenadr_term-type:checked').click();
});
