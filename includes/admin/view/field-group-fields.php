<?php
/*
 * カスタムフィールドの設定画面
 */
?>
<style>

.handle-actions {
	border-radius: 5px;
	flex-shrink: 0;
	display: flex;
	background: #eee;
	margin: 3px 2px;
	overflow: hidden;
	border: 1px solid #ddd;
}

.postbox-header {
	border-bottom: 5px solid #eee;
}

.postbox-header .handle-actions a {
	background: #2271b1;
	color: #fff;
	cursor: pointer;
	pointer-events: inherit;
	display: flex;
	align-items: center;
	justify-content: center;
	width: 48px;
	height: 36px;
}

.postbox-header .handle-actions a.active {
	cursor: pointer;
	pointer-events: none;
	color: #2271b1;
	background: none;
}


#acfc-settings #setting-tabs {
	margin: 0 -12px;
	background: #999;
	padding: 0;
}
#acfc-settings #setting-tabs ul{
	display: flex;
	width: 100%;
	padding: 0;
	overflow: hidden;
}

#acfc-settings #setting-tabs li {
	padding: 0 5px;
	width: 100%;
	margin: 0;
	text-align: center;
	border: 1px solid #ddd;
	border-left: none;
	background: #eee;
}

#acfc-settings #setting-tabs li:first-child {
	border-left: 1px solid #eee;
}

#acfc-settings #setting-tabs li a {
	text-decoration: none;
	display: block;
	width: 100%;
	height: 36px;
	display: flex;
	justify-content: center;
	align-items: center;
	outline: none;
	box-shadow: none;
}

#acfc-settings #setting-tabs li.ui-state-active {
	cursor: pointer;
	pointer-events: none;
	background: #fff;
	border-bottom: none;
}

#acfc-settings #setting-tabs li.ui-state-active a {
	color: #333;
	font-weight: bold;
}
</style>



<div id="acfc-settings">
	<div id="setting-tabs">
	<ul>
    <li><a href="#acf-field-group-fields"><?php _e( 'Custom Fields', ACFC_TEXTDOMAIN ) ?></a></li>
    <li><a href="#holidays-setting"><?php _e( 'Holidays', ACFC_TEXTDOMAIN ) ?></a></li>
    <li><a href="#general-setting"><?php _e( 'General', ACFC_TEXTDOMAIN ) ?></a></li>
    <li><a href="#templates-setting"><?php _e( 'Template', ACFC_TEXTDOMAIN ) ?></a></li>
  </ul>
	</div>
	
  <div id="acf-field-group-fields" class="">
	  <h3><?php _e( 'Custom Fields', ACFC_TEXTDOMAIN ) ?></h3>
	  <?php include_once ACFC_DIR_INCLUDES.'/admin/view/settings/custom-fields-setting.php'; ?>
	</div>
  <div id="holidays-setting"><?php _e( 'Holidays', ACFC_TEXTDOMAIN ) ?></div>
  <div id="general-setting"><?php _e( 'General', ACFC_TEXTDOMAIN ) ?></div>
  <div id="templates-setting"><?php _e( 'Template', ACFC_TEXTDOMAIN ) ?></div>
  
	
	
</div>
<script>
jQuery(function($){
	//カレンダーと設定画面の切り替えボタン
	let $header = $('#acfc-field-group-fields .postbox-header .handle-actions')
	$header.html('');
	$header.append('<a class="dashicons dashicons-calendar-alt" title="設定を保存してカレンダーを表示"></a>');
	$header.append('<a class="dashicons dashicons-admin-generic active" title="各種設定画面を表示"></a>');
	//
	//h2をクリックしても閉じないように
	$('h2.hndle').removeClass('hndle');
	
	//設定画面のタブ
	$('#acfc-settings').tabs();
	
	//フィールドの選択肢optionからDisabledになっているProを削除
	acf.addAction('render_field_object', function(field){
		let $selects = $('select');
		
		$selects.map(function(i, elm){
			if($('[disabled]', elm).length){
				let $diabled = $('[disabled]', elm);
				$diabled.remove();
			}
		});
		return;
	});
});
	
</script>



