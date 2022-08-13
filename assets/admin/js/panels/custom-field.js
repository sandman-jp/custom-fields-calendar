//custom field setting
jQuery(function($){
	
	var cf_data = false;
	
	//init
	if(fields_settings['custom-field-settings'] != null && typeof(fields_settings['custom-field-settings']['fields']) != 'undefined'){
		
		cf_data = fields_settings['custom-field-settings']['fields'];
		
		//initialize
		if(cf_data.length){
			
			for(i=0; i<cf_data.length; i++){
				let data = cf_data[i];
				
				add_field();
				
				let $item = $('#fields-list .c-fieldset:last');
				
				let fld_type = data['field-type'];
				
				change_field_view(fld_type, $item);
				
				for(let key in data){
					
					let index = parseInt($item.index());
					
					let $fld = $('#'+key+'_'+index, $item);
					let i_name = $fld.attr('name');
					if(key == 'field-conditions'){
						//condition
						
						if(data['field-conditions'].length){
							
							let conds = data['field-conditions'];
							
							for(let h=0; h < conds.length; h++){
								add_condition_field($item);
								
								let posname =  'custom-field-settings[fields]['+i+'][field-conditions]['+h+']';
								if(typeof(conds[h]['start']['year']) != 'undefined'){
									//startがセットされていたら
									$('[name="'+posname+'[start][year]"]').val(conds[h]['start']['year']);
								}
								if(typeof(conds[h]['start']['month']) != 'undefined'){
									//startがセットされていたら
									$('[name="'+posname+'[start][month]"]').val(conds[h]['start']['month']).prop('disabled', false);;
								}
								if(typeof(conds[h]['end']['year']) != 'undefined'){
									//endがセットされていたら
									$('[name="'+posname+'[end][year]"]').val(conds[h]['end']['year']);
								}
								if(typeof(conds[h]['end']['month']) != 'undefined'){
									//endがセットされていたら
									$('[name="'+posname+'[end][month]"]').val(conds[h]['end']['month']).prop('disabled', false);
								}
								
								let j;
								if(typeof(conds[h]['cond1']) != 'undefined' && $.isArray(conds[h]['cond1'])){
									//週番号
									$('[name="'+posname+'[cond1][]"]').prop('checked', false);
									for(j=0; j < conds[h]['cond1'].length; j++){
										$('[name="'+posname+'[cond1][]"][value="'+conds[h]['cond1'][j]+'"]').prop('checked', true);
									}
								}
								
								if(typeof(conds[h]['cond2']) != 'undefined' && $.isArray(conds[h]['cond2'])){
									//曜日番号
									$('[name="'+posname+'[cond2][]"]').prop('checked', false);
									for(j=0; j < conds[h]['cond2'].length; j++){
										$('[name="'+posname+'[cond2][]"][value="'+conds[h]['cond2'][j]+'"]').prop('checked', true);
									}
								}
								
								if(typeof(conds[h]['holiday']) != 'undefined'){
									//休日設定
									$('[name="'+posname+'[holiday]"][value="'+conds[h]['holiday']+'"]').prop('checked', true);
								}
								
							}
						}
						
						
					}else if(key == 'field-required'){
						
						$('[name="'+i_name+'"]').prop('checked', true);
						
					}else{
						
						let dd = typeof(data[key]) != 'string' ? data[key].join(',') : data[key];
						
						$('[name="'+i_name+'"]').val(dd);
						
					}
					
					
				}
				
			}
				
		}
		
	
	}
	
	if(!cf_data || !cf_data.length){
		add_field();
	}
	
	$('#fields-list .c-fieldset').each(function(){
		$(this).trigger('choices_changed');
	});
	
	$('#fields-list').sortable({
		update: function( event, ui ) {
			reorder_items();
		}
	});
	
	//Add Field
	$('#btn_add-field').click(function(e){
		e.preventDefault();
		
		add_field();
		
	});
	
	$('[type="checkbox"][required]', '#cfc-table').click(switch_required_checkbox_group);
	$('[type="checkbox"][required]', '#cfc-table').each(switch_required_checkbox_group);
	
	//ここから下は関数
	
	function switch_required_checkbox_group(e){
		let group_name = $(this).attr('name');
		//console.log(group_name)
		let group = $('[name="'+group_name+'"]', '#cfc-table');
		//一つでもチェックがあればrequiredははずす
		if(group.is(':checked')){
			group.prop('required', false);
		}else{
			group.prop('required', true);
		}
		
	}
	
	function change_field_view(fld_type, $elm){
		
		
		$('.field-place-holder', $elm).addClass('u-disabled');
		$('[name$="[place-holder]"]', $elm).prop('disabled', true);
		
		$('.field-choices', $elm).addClass('u-disabled');
		$('[name$="[field-choices]"]', $elm).prop('disabled', true);
		
		$('.field-validation', $elm).addClass('u-disabled');
		$('[name$="[validation]"]', $elm).prop('disabled', true);
		
		
		switch(fld_type){
		case 'radio':
			//radio
			choice_field_fields($elm);
			break;
		case 'checkbox':
			//checkbox	
			choice_field_fields($elm);
			break;
		case 'select':
			choice_field_fields($elm);
			break;
		case 'truefalse':
			simple_field_fields($elm);
			break;
		case 'textfield':
			$('.field-validation', $elm).removeClass('u-disabled');
			$('[name$="[validation]"]', $elm).prop('disabled', false);
			
		default:
			text_field_fields($elm);
		}
	}
	
	function simple_field_fields($elm){
		//$('.field-place-holder', $elm).css('visibility', 'hidden');
	}
	
	function choice_field_fields($elm){
		
		$('.field-choices', $elm).removeClass('u-disabled');
		$('[name$="[field-choices]"]', $elm).prop('disabled', false);
				
		$('.o-wrap_details', $elm).slideDown('fast');
	}
	
	function text_field_fields($elm){
		
		$('.field-place-holder', $elm).removeClass('u-disabled');
		$('[name$="[place-holder]"]', $elm).prop('disabled', false);
		
	}
	
	function get_fields_count(){
		return $('#fields-list .c-fieldset').length;
	}
	
	//for custom fields
	function add_field(){
		
		let count = parseInt($('#fields-list > .c-fieldset').length);
		
		let html = $('#field-template').text();
		
		html = html.replaceAll('%id%', count);
		html = html.replaceAll('%num%', count + 1);
		
		let $html = $(html);
		
		$html = init_field($html);
		
		
		$('.btn_add-condition', $html).click(function(e){
			e.preventDefault();
			let $fieldset = $(this).parents('.c-fieldset');
			
			add_condition_field($fieldset);
		});
		

		
		$('#fields-list').append($html);
	}
	
	//for conditions fields in custom fields
	function add_condition_field($elm){
		
		let fid = $elm.attr('data-field-id');
		let count = parseInt($('.field-condition-list > .c-fieldset', $elm).length);
		
		let html = $('#field-condition-template').text();

		html = html.replaceAll('%id%', fid);
		html = html.replaceAll('%cid%', count);
		
		let $html = $(html);
		

		$('.cfc-calendar-year', $html).change(function(e){
			e.preventDefault();
			console.log($(this));
			
			let $month = $(this).next();
			if(typeof($(this).val()) == 'undefined' || $(this).val() == '' || $(this).val() == 'all'){
				$('select', $month).prop('disabled', true).val('');
			}else{
				$('select', $month).prop('disabled', false).val('');
			}
		});
		
		$('.c-field_action button', $html).click(remove_repeater_item);
		
		$('.field-condition-list', $elm).append($html);
		
	}
	
	function init_field($html){
		
		$('.c-field_action button', $html).click(remove_repeater_item);
		
		
		//Show Field option
		$('.field-type select', $html).change(function(e){
			e.preventDefault();
			let $wrap = $(this).parents('.c-fieldset');
			
			let $choice_field = $('.field-choices', $wrap);
			
			$('textarea', $choice_field).val('').trigger('choices_changed');
			
			change_field_view($(this).val(), $wrap);
		});
		
		$('[name$="[field-label]"]', $html).blur(function(e){
			let $parent = $(this).parents('.c-fieldset');
			if($('[name$="[field-name]"]', $parent).val() == ''){
				$('[name$="[field-name]"]', $parent).val($(this).val());
			}
		});
		//半角スペースは-に
		$('[name$="[field-name]"]', $html).bind('blur change focus', function(e){
			let val = $(this).val().trim();
			
			val = val.replace(/[\s\\\_]/, '-');
			
			$(this).val(val);
		});
		
		//default value should be nessesary if required checked.
		$('.field-required input', $html).click(function(e){
			
			let required = $(this).is(':checked');
			let def = $('.field-default-value input', $html)
			def.prop('required', required);
			
			switch(def.attr('type')){
			case 'radio':
			case 'checkbox':
				if(required){
					$(def[0]).prop('checked', true);	
				}
				break;
			case 'select':
				
			}
			
		});
		
		//for option fields
		$('.field-choices textarea', $html).bind('change keyup', function(e){
			//let $parent = $html.parents('.c-fieldset');
			$html.trigger('choices_changed');
		});
		
		$html.bind('choices_changed', function(e){
			let type = $('.field-type select', this).val();
			//console.log(type);
			
			let $default = $('.field-default-value [name]', this);
			
			let input_val, input_name, input_id;
			
			if(!$default.length){
				$default = $('.field-choices [name]', this);
			}
			
			input_val = $default.val();
			if(input_val == null){
				input_val = '';
				$default.val('');
			}
			
			//チェックボックス用を汎用に
			input_name = $default.attr('name').replace('[]', '');
			//choicesであろうとなかろうと置き換え
			input_name = input_name.replace('choices', 'default-value');
			
			if($(this).data('id') != ''){
				//choicesであろうとなかろうと置き換え
				input_id = $default.attr('id').replace('choices', 'default-value');
				$(this).data('id', input_id);
			}else{
				input_id = $(this).data('id');
			}
			
			let choices = '';
			let field_html = '';
			
			switch(type){
			case 'checkbox':
				//checkboxのみ
				input_name = input_name+'[]';
			case 'radio':
				//checkboxとradioは選択肢を設定
				choices = $('.field-choices textarea', this).val();
				
			case 'truefalse':
				
				input_val = input_val.split(',');
				
				//真偽は1かどうかだけ
				if(type == 'truefalse'){
					choices = '1 : ';
					type = 'checkbox';
				}
				
				if(choices != ''){
					choices = choices.split(/\r\n|\n/);
					
					for(let i=0; i<choices.length; i++){
						let choice = choices[i].split(' : ');
						let key = choice[0];
						let val = choice[0];
						
						let checked = $.inArray(val, input_val) > -1 ? 'checked' : '';
						
						if(key != ''){
							if(choice.length > 1){
								val = choice[1];
							}
							
							field_html += '<label><input id="'+input_id+'_'+key+'" type="'+type+'" name="'+input_name+'" value="'+key+'" '+checked+'>'+val+'</label>';
						}
					}
				}
				
				break;
				case 'select':
					field_html = '<select id="'+input_id+'" name="'+input_name+'">';
					
					choices = $('.field-choices textarea', this).val();
					if(choices != ''){
						choices = choices.split(/\r\n|\n/);
						
						for(let i=0; i<choices.length; i++){
							let choice = choices[i].split(' : ');
							
							let key = choice[0];
							let val = choice[0];
							
							let selected = (val == input_val) ? 'selected' : '';
							if(key != ''){
								if(choice.length > 1){
									val = choice[1];
								}
								
								field_html += '<option value="'+key+'" '+selected+'>'+val+'</option>';
							}
						}
					}
					field_html += '</select>';
					
					break;
			case 'textarea':
				//input_val = $default.val();
				field_html = '<textarea id="'+input_id+'" name="'+input_name+'">'+input_val+'</textarea>';
				break;
			default:
				//input_val = $default.val();
				field_html = '<input id="'+input_id+'" type="text" name="'+input_name+'" value="'+input_val+'">';
			}
			
			$('.field-default-value .c-field_input', this).html(field_html);
			
		});
		//console.log('//////')
		//console.log($('.field-type select', $html).val());
		
		
		
		return $html;	
	}
	
	function remove_repeater_item(e){
		e.preventDefault();
		
		let target = '#'+$(this).data('target');
		
		switch($(this).data('action')){
		case 'remove-item':
			
			remove_field(target);
			
			break;
		case 'toggle-details':
			
			let $details = $('.o-wrap_details', $(target));
			
			if($details.filter(':visible').length){
				$(this).removeClass('is-active')
			}else{
				$(this).addClass('is-active')
			}
			$('.o-wrap_details', $(target)).slideToggle();
			
			break;
		}
	
	}
	
	function remove_field(target=null){
		
		if(!target){
			target = '#'+$(this).data('target');
		}
		
		$(target).remove();
		
		//re-ordering
		reorder_items();
	}
	
	function reorder_items(){
		$('#fields-list > .c-fieldset').each(function(i){
			this.id = $(this).attr('id').replace(/_(\d+)$/, '_'+String(i));
			$(this).attr('data-field-id', i);
			
			//アクションボタン
			//CF
			$('.o-headline [data-target]', this).attr('data-target', 'field_'+i);
			
			
			
			$('input, textarea, select', this).each(function(n){
				this.name = $(this).attr('name').replace(/\[fields\]\[(\d+?)\]/, '[fields]['+i+']');
				
				if(typeof($(this).attr('id')) != 'undefined'){
					$(this).attr('id', 'field_'+i);
				}
			});
			
			$('.c-field_label[for]', this).each(function(n){
				let val = $(this).attr('for', 'field_'+i);
				$(this).attr('for', val);
			});
			
			
			$('.c-field_order span', this).text(i + 1);
			
			//condition
			
			let $cond = $('.c-field_conditions', this);
			$('.c-fieldset', $cond).each(function(h){
				$(this).attr('id', 'condition_'+i+'_'+h);
			});
			
			$('[data-target]', $cond).each(function(h){
				$(this).attr('data-target', 'condition_'+i+'_'+h);
			});
			
			
		});
	}
	
});