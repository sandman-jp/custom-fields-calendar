
//ページ全体
jQuery(function($){
	$('#edit-slug-box, #preview-action').remove();
	
	//監視
	const original_form = $('#post').serialize();
	
	//未設定でも空でもない、つまりデータがあるかどうか
	let have_data = fields_settings['custom-field-settings'] != null && (typeof(fields_settings['custom-field-settings']['fields']) != 'undefined') && fields_settings['custom-field-settings']['fields'].length;
	
	//console.log(have_data)
	//カレンダーと設定画面の切り替えボタン
	let $header = $('#cf-calendar .postbox-header');
	
	if(have_data){
		$('#show-table, #cfc-table').addClass('is-active');
		
	}else{
		$('#show-settings, #cfc-settings').addClass('is-active');
	}
	
	//
	//h2をクリックしても閉じないように
	$('h2.hndle').removeClass('hndle');
	
	//設定画面のタブ
	$('#cfc-settings').tabs();
	
	/*
	 * 保存
	 */
	//記事内容が送信される前各セルの内容をまとめて、送信するinput数を減らす
	//$('[type="submit"][name="save"],[type="submit"][name="publish"]').click(function(e){
	$('#post').submit(function(e){
		
		//e.preventDefault();
		
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
	
	if(fields_settings['custom-field-settings'] != null && typeof(fields_settings['custom-field-settings']['fields-position']) != 'undefined' 
			&& fields_settings['custom-field-settings']['fields-position'] == 'outside'){
			
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
			
			if(typeof(content) != 'undefined' && content != '') {
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

const panels = ['custom-field', 'general', 'template', 'schedule'];

for(let i=0; i<panels.length; i++){
	document.write('<script src="'+CFC_ASSETS_URL+'/admin/js/panels/'+panels[i]+'.js"></script>');
}





jQuery(function($){
	$('html').removeClass('cfc-loading');
});

