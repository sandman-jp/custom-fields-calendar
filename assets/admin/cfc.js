
//ページ全体
jQuery(function($){
	$('#edit-slug-box, #preview-action').remove();
	/*
	$('.datepicker').datepicker({
		buttonText: "Choose"
	});
	*/
	//監視
	const original_form = $('#post').serialize();
	
	//未設定でも空でもない、つまりデータがあるかどうか
	let have_data = (typeof(fields_settings['custom-fields-settings']['fields']) != 'undefined') && fields_settings['custom-fields-settings']['fields'].length;
	//console.log(have_data)
	//カレンダーと設定画面の切り替えボタン
	let $header = $('#cf-calendar .postbox-header');
	
	if(have_data){
		$('#show-table, #cfc-table').addClass('is-active');
		
	}else{
		$('#show-settings, #cfc-settings').addClass('is-active');
	}
	
	//$header.append('<div class="handle-actions cfc-actions"><button class="button dashicons dashicons-calendar-alt '+(have_data ? 'is-active' : '')+'" data-action="show-table" title="設定を保存してカレンダーを表示">Show Calendar</button><button class="button dashicons dashicons-admin-generic '+(have_data ? '' : 'is-active')+'" data-action="show-settings" title="各種設定画面を表示">Show Settings</button></div>');
	//
	//h2をクリックしても閉じないように
	$('h2.hndle').removeClass('hndle');
	
	//設定画面のタブ
	$('#cfc-settings').tabs();
	
	/*
	 * 保存
	 */
	//記事内容が送信される前各セルの内容をまとめて、送信するinput数を減らす
	$('[type="submit"][name="save"],[type="submit"][name="publish"]').click(function(e){
		
		if(!$('#post').get(0).checkValidity()){
			//e.preventDefault();
			return ;
		}
		
		let $form = $('form#post');
		
		//データのある項目のみ
		/*
		let cfc_data = $('.cfc-data').map(function(i){
			if($(this).val() != ''){
				return this;
			}
		});
		*/
		
		
		cfc_data = $('.cfc-data').serialize();
		
		let $submit_data = $('<input type="hidden" id="cfc-data" name="content" value="'+cfc_data+'">');
		
		$form.append($submit_data);
		
		$('.cfc-data').prop('disabled', true);
		
		
	});
	
	
});
	

	
//panel switch
jQuery(function($){
	
	$('.postbox-header .handle-actions button').click(function(e){
		
		if(!$('#post').get(0).checkValidity()){
			//e.preventDefault();
			return ;
		}
		
		switch($(this).data('action')){
		case 'show-table':
			if($('#cfc-table:visible').length){
				return false;
			}
			
			//変更があれば
			if(original_form != $('#post').serialize()){
				//submitする
				return confirm('設定が変更されています。設定内容を保存しますか？');
				//return;
			}
			
			e.preventDefault();
			
			$('.postbox-header .handle-actions button, .l-panel').toggleClass('is-active');
			
			
			break;
		case 'show-settings':
			e.preventDefault();
			
			if($('#cfc-settings:visible').length){
				return false;
			}
			
			$('.postbox-header .handle-actions button, .l-panel').toggleClass('is-active');
			
			original_form = $('#post').serialize();
			
			break;
			
		}
		
	});
	
	//監視
	var original_form = $('#post').serialize();
	
});


//Calendar table
jQuery(function($){
	
	
	$('#fields-panel').sortable({
		update: function( event, ui ) {
			//reorder_items();
		}
	});
	
	
	var cell = $('.cfc-cell', '#cf-calendar');
	
	if(typeof(fields_settings['custom-fields-settings']['fields-position']) != 'undefined' 
			&& fields_settings['custom-fields-settings']['fields-position'] == 'outside'){
			
		//テーブルをクリックすると、右にフォームが出てくる
		cell.click(function(e){
			//e.preventDefault();
			let $anc = $('.u-anc', this);
			
			
			if(!$anc.length || $(this).hasClass('is-active') || !$('.c-fieldset', this).length){
				return;
			}
			
			$('.cfc-cell', '#cf-calendar').removeClass('is-active');
			$(this).addClass('is-active');
			
			let $prechild = $('#fields-panel .c-fieldset:not(.is-sticked)');
			
			if($prechild.length){
				back_to_calendar($prechild);
			}
			
			let $fieldset = $('.c-fieldset', this);
			
			let fieldset_id = $fieldset.attr('name');
			
			if($('[name="'+fieldset_id+'"]', '#fields-panel').length){
				return;
			}
			
			$('.close-fieldset', $fieldset).click(function(e){
				e.preventDefault();
				back_to_calendar($fieldset);
			});
			
			//フォームのピンどめ
			$('.stick-fieldset', $fieldset).click(function(e){
				e.preventDefault();
				$(this).parents('.c-fieldset').toggleClass('is-sticked');
				
				$(this).toggleClass('is-active');
				$(this).siblings('.close-fieldset').toggleClass('is-active');
			});
			
			let $fieldlist = $('.p-fields', $fieldset.filter(':not(.is-sticked)'));
			$fieldlist.hide();
			
			$anc.addClass('is-selected');
			$('#fields-panel').append($fieldset);
			
			$fieldlist.slideDown('fast');
			
			
		});
	}
	
	$('.cfc-data').bind('change blur', function(e){
		
		let $parent = $(this).parents('.c-fieldset');
		let have_data = false;
		let values = $('.cfc-data', $parent).each(function(i){
			
			if($(this).val() != ''){
				have_data = true; //とりあえず一つでもデータがあるかないかだけ
			}
		});
		
		let parent_id = $parent.data('id');
	
		if(have_data){
			$('#cell_'+parent_id).addClass('have-data');
		}else{
			$('#cell_'+parent_id).removeClass('have-data');
		}		
	});
	
	//テーブルのデータ簡易表示用
	$('.u-anc', cell).tooltip({
		position: {
      my: "center bottom-20",
      at: "center top",
      using: function( position, feedback ) {
        $( this ).css( position );
        $( "<div>" )
          .addClass( "arrow" )
          .addClass( feedback.vertical )
          .addClass( feedback.horizontal )
          .appendTo( this );
      }
    },
		content: function(){
			let content = $('.tooltip-content', this).html();
			
			if(content != '') {
				return '<div class="single-value">'+content.split(' ; ').join('</div><div class="single-value">')+'</div>';
			}
			return '<div class="single-value" style="text-align:center">no data</div>';
			
		},
	});
	
	function back_to_calendar($elm){
		
		let id = $elm.data('id');
		
		let $cell = $('#cell_'+id);
		
		$('.u-anc', $cell).removeClass('is-selected');
		
		//$elm.fadeOut(500, function(){
			$('.u-anc', $cell).append($elm);
		//});
		
	}
	
	
	//最初の一つを開けておく
	if($('#cfc-table').hasClass('is-active')){
		$('#cfc-table .cfc-cell .u-anc:first').click();
	}
	
	
});


//custom field setting
jQuery(function($){

	//init
	
	if(typeof(fields_settings['custom-fields-settings']['fields']) != 'undefined'){
		
		var cf_data = fields_settings['custom-fields-settings']['fields'];
		
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
					let dd = typeof(data[key]) != 'string' ? data[key].join(',') : data[key];
					$('[name="'+i_name+'"]').val(dd);
					
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
	
	function add_field(){
		
		let count = parseInt($('#fields-list .c-fieldset').length);
		
		let html = $('#field-template').text();
		
		html = html.replaceAll('%id%', count);
		html = html.replaceAll('%num%', count + 1);
		
		let $html = $(html);
		
		$html = init_field($html);
		
		$('#fields-list').append($html);
				
	}
	
	function init_field($html){
		
		$('.c-field_action button', $html).click(function(e){
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
			
		});
		
		
		//Show Field option
		$('.field-type select', $html).change(function(e){
			e.preventDefault();
			let $wrap = $(this).parents('.c-fieldset');
			
			let $choice_field = $('.field-choices', $wrap);
			
			$('textarea', $choice_field).val('').trigger('choices_changed');
			
			change_field_view($(this).val(), $wrap);
			
			/*
			if($('option:selected', this).data('choices') == 1){
				
				$('.field-type', $html).removeClass('no-choice');
				
				$choice_field.removeClass('disabled');
				$('[disabled]', $wrap).prop('disabled', false);
				
			}else{
				
				$('.field-type').addClass('no-choice');
				$choice_field.addClass('disabled');
				$('.__input-field', $wrap).children().prop('disabled', false);
			}
			*/
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
			input_val = '';
			
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
				field_html = '<textarea id="'+input_id+'" name="'+input_name+'">'+input_val+'</textarea>';
				break;
			default:
				field_html = '<input id="'+input_id+'" type="text" name="'+input_name+'" value="'+input_val+'">';
			}
			
			$('.field-default-value .c-field_input', this).html(field_html);
		});
		//console.log('//////')
		//console.log($('.field-type select', $html).val());
		
		
		return $html;	
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
		$('#fields-list .c-fieldset').each(function(i){
			
			$('input, textarea, select', this).each(function(n){
				this.name = $(this).attr('name').replace(/\[(\d+?)\]/, '['+i+']');
				this.id = $(this).attr('id').replace(/_(\d+)$/, '_'+String(i));
			});
			
			$('.c-field_label[for]', this).each(function(n){
				let val = $(this).attr('for').replace(/_(\d+)$/, '_'+String(i));
				$(this).attr('for', val);
			});
			
				
			$('.c-field_order span', this).text(i + 1);
			
		});
	}
	
});

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
	