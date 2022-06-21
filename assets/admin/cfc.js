
//ページ全体
jQuery(function($){
	$('#edit-slug-box, #preview-action').remove();
	
	//監視
	const original_form = $('#post').serialize();
	
	//未設定でも空でもない、つまりデータがあるかどうか
	let have_data = (typeof(fields_settings['custom-fields-setting']) != 'undefined') && fields_settings['custom-fields-setting'].length;
	
	//カレンダーと設定画面の切り替えボタン
	let $header = $('#cf-calendar .postbox-header');
	
	//$('.handle-actions', $header).remove();
	
	if(have_data){
		$('.cfc-actions .show-table, #cfc-table').addClass('active');
		
	}else{
		$('.cfc-actions .show-settings, #cfc-settings').addClass('active');
	}
	
	//$header.append('<div class="handle-actions cfc-actions"><button class="button dashicons dashicons-calendar-alt '+(have_data ? 'active' : '')+'" data-action="show-table" title="設定を保存してカレンダーを表示">Show Calendar</button><button class="button dashicons dashicons-admin-generic '+(have_data ? '' : 'active')+'" data-action="show-settings" title="各種設定画面を表示">Show Settings</button></div>');
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
		
		
		let $form = $('form#post');
		
		//データのある項目のみ
		let cfc_data = $('.cfc-data').map(function(i){
			if($(this).val() != ''){
				return this;
			}
		});
		
		cfc_data = cfc_data.serialize();
		
		let $submit_data = $('<input type="hidden" id="cfc-data" name="content" value="'+cfc_data+'">');
		
		$form.append($submit_data);
		
		$('.cfc-data').prop('disabled', true);
		
		
	});
	
	
});
	
	
	
//panel switch
jQuery(function($){
	
	$('.postbox-header .handle-actions button').click(function(e){
		
		switch($(this).data('action')){
		case 'show-table':
			if($('#cfc-table:visible').length){
				return;
			}
			
			//変更があれば
			if(original_form != $('#post').serialize()){
				//submitする
				return confirm('設定が変更されています。設定内容を保存しますか？');
				//return;
			}
			
			e.preventDefault();
			
			$('.postbox-header .handle-actions button, .cfc-panel').toggleClass('active');
			
			
			break;
		case 'show-settings':
			e.preventDefault();
			
			if($('#cfc-settings:visible').length){
				return;
			}
			
			$('.postbox-header .handle-actions button, .cfc-panel').toggleClass('active');
			
			original_form = $('#post').serialize();
			
			break;
			
		}
		
	});
	
	//監視
	var original_form = $('#post').serialize();
	
});


//Calendar table
jQuery(function($){
	
	
	$('#field-panel .fieldset_list').sortable({
		update: function( event, ui ) {
			//reorder_items();
		}
	});
	
	
	var cell = $('.cfc-cell', '#cf-calendar');
	
	//テーブルをクリックすると、右にフォームが出てくる
	cell.click(function(e){
		//e.preventDefault();
		let $anc = $('a', this);
		
		if(!$anc.length || $(this).hasClass('active')){
			return;
		}
		
		$('.cfc-cell', '#cf-calendar').removeClass('active');
		$(this).addClass('active');
		
		let $prechild = $('#field-panel .fieldset_list .fieldset:not(.sticked)');
		
		if($prechild.length){
			back_to_calendar($prechild);
		}
		
		let $fieldset = $('.fieldset', this);
		let fieldset_id = $fieldset.attr('name');
		
		if($('[name="'+fieldset_id+'"]', '#field-panel .fieldset_list').length){
			return;
		}
		
		$('.close-inputs', $fieldset).click(function(e){
			e.preventDefault();
			back_to_calendar($fieldset);
		});
		
		//フォームのピンどめ
		$('.stick-inputs', $fieldset).click(function(e){
			e.preventDefault();
			$(this).parents('.fieldset').toggleClass('sticked');
			
			$(this).toggleClass('active');
			$(this).siblings('.close-inputs').toggleClass('active');
		});
		
		let $fieldlist = $('.fieldlist', $fieldset.filter(':not(.sticked)'));
		$fieldlist.hide();
		
		$anc.addClass('selected');
		$('#field-panel .fieldset_list').append($fieldset);
		$fieldlist.slideDown('fast');
		
		
	});
	
	
	$('.cfc-data').bind('change blur', function(e){
		
		let $parent = $(this).parents('.fieldset');
		let have_data = false;
		let values = $('.cfc-data', $parent).each(function(i){
			
			if($(this).val() != ''){
				have_data = true; //とりあえず一つでもデータがあるかないかだけ
			}
		});
		
		let parent_id = $parent.data('id');
	
		if(have_data){
			$('#cell_'+parent_id).addClass('have_data');
		}else{
			$('#cell_'+parent_id).removeClass('have_data');
		}		
	});
	
	//テーブルのデータ簡易表示用
	$('a', cell).tooltip({
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
				return '<div class="single-value">'+content.split(',').join('</div><div class="single-value">')+'</div>';
			}
			return '<div class="single-value" style="text-align:center">no data</div>';
			
		},
	});
	
	function back_to_calendar($elm){
		
		let id = $elm.data('id');
		
		let $cell = $('#cell_'+id);
		
		$('a', $cell).removeClass('selected');
		
		//$elm.fadeOut(500, function(){
			$('a', $cell).append($elm);
		//});
		
	}
	
	
	//最初の一つを開けておく
	if($('#cfc-table').hasClass('active')){
		$('#cfc-table .cfc-cell a:first').click();
	}
	
	
});


//custom field setting
jQuery(function($){

	
	if(typeof(fields_settings['custom-fields-setting']) != 'undefined'){
		
		var cf_data = fields_settings['custom-fields-setting'];
		
		//initialize
		if(cf_data.length){
			
			for(i=0; i<cf_data.length; i++){
				let data = cf_data[i];
				
				
				add_field();
				
				let $item = $('#cfc-custom-field-list .__item:last');
				
				let fld_type = data['field-type'];
				
				switch(fld_type){
				case 'radio':
					//radio
				case 'checkbox':
					//checkbox or true/false	
				case 'select':
					switch_choice_field($item);
					break;
				default:
					
				}
				
				for(let key in data){
					
					let index = parseInt($item.index());
					
					let $fld = $('#'+key+'_'+index, $item);
					let i_name = $fld.attr('name');
					
					console.log(i_name);
					console.log(data[key]);
					
					$('[name="'+i_name+'"]').val(data[key]);
					
				}
				
			}
				
		}
		
	
	}
	
	if(!cf_data || !cf_data.length){
		add_field();
	}
	
	$('#cfc-custom-field-list').sortable({
		update: function( event, ui ) {
			reorder_items();
		}
	});
	
	//Add Field
	$('#btn_add-field').click(function(e){
		e.preventDefault();
		
		add_field();
		
	});
	
	function switch_choice_field($elm){
		
		$('.field-choices', $elm).toggleClass('disabled');
		$('.field-place-holder', $elm).toggleClass('disabled');
			
		let bool = $('[name$="[field-choices]"]', $elm).prop('disabled');
		
		$('[name$="[field-choices]"]', $elm).prop('disabled', !bool);
		$('[name$="[place-holder]"]', $elm).prop('disabled', bool);
				
	}
	
	function get_fields_count(){
		return $('#cfc-custom-field-list .__item').length;
	}
	
	function add_field(){
		
		let count = parseInt($('#cfc-custom-field-list .__item').length);
		
		let html = $('#field-template').text();
		
		html = html.replaceAll('%id%', count);
		html = html.replaceAll('%num%', count + 1);
		
		let $html = $(html);
		
		$html = init_field($html);
		
		$('#cfc-custom-field-list').append($html);
		
	}
	
	function init_field($html){
		
		$('.__list_action button', $html).click(function(e){
			e.preventDefault();
			
			let target = '#'+$(this).data('target');
			
			switch($(this).data('action')){
			case 'remove-item':
				
				remove_field(target);
				
				break;
			case 'toggle-details':
				
				let $details = $('.__item_field_wrap_bottom', $(target));
				
				if($details.filter(':visible').length){
					$(this).removeClass('active')
				}else{
					$(this).addClass('active')
				}
				$('.__item_field_wrap_bottom', $(target)).slideToggle();
				
				break;
			}
			
		});
		
		
		//Show Field option
		$('.field-type select', $html).change(function(e){
			e.preventDefault();
			let $wrap = $(this).parents('.__item');
			
			let $choice_field = $('.field-choices', $wrap);
			
			if($('option:selected', this).data('choices') == 1){
				
				$('.field-type', $html).removeClass('no-choice');
				
				$choice_field.removeClass('disabled');
				$('[disabled]', $wrap).prop('disabled', false);
				
			}else{
				
				$('.field-type').addClass('no-choice');
				$choice_field.addClass('disabled');
				$('.__input-field', $wrap).children().prop('disabled', false);
			}
			
		});
		
		console.log('//////')
		console.log($('.field-type select', $html).val());
		
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
		$('#cfc-custom-field-list .__item').each(function(i){
			
			$('input, textarea, select', this).each(function(n){
				this.name = $(this).attr('name').replace(/\[(\d+?)\]/, '['+i+']');
				this.id = $(this).attr('id').replace(/_(\d+)$/, '_'+String(i));
			});
			
			$('.field_label[for]', this).each(function(n){
				let val = $(this).attr('for').replace(/_(\d+)$/, '_'+String(i));
				$(this).attr('for', val);
			});
			
				
			$('.__list_order span', this).text(i + 1);
			
		});
	}
	
});

	