<?php
global $wp_locale;

//table rendar engine
$titles = array();

$table_num = 0;

$i = 0;


ob_start();

if($have_column_header){
	echo '<th></th>';
}

for($i=0; $i<7; $i++){

	$day_index = ($i + $first_dw) % 7;
	
	$weekday = 'day';
	
	if(wp_date('w', $init_id) == 6){
		$weekday = 'sat';
	}else if(wp_date('w', $init_id) == 0){
		$weekday = 'sun';
	}

	$weekname = $wp_locale->get_weekday_abbrev($wp_locale->get_weekday($day_index));
	
	cfc_get_template_part('/'.$calendar_type.'/table', 'header', array(
		'th_class' => $weekday,
		'conten_namet' => $weekname,
	));
	
}; 

$tableheader = ob_get_clean();

$time_id = $min_d;

$is_new_month = true;
$current_month = wp_date('m月', $min_d);

$cells = $this->_get_month_cells();
$month_cells = array();



//一列目にCFの項目だけ表示するthがある場合
$column_header = '';

if($have_column_header){
	
	$cf_items = cfc_get_field_items();
	$cf_keys = array();
	
	if($cf_items){
		foreach($cf_items as $item){
			$cf_keys[] = '<div class="cfc-item">'.$item['field-label'].'</div>';
		}
	}
	ob_start();
	cfc_get_template_part('/'.$calendar_type.'/table', 'header', array(
		'th_class' => 'cfc-items',
		'conten_namet' => implode('', $cf_keys) ,
	));
	$column_header = ob_get_clean();
}

while($time_id <= $max_d_end):
	
	$dw = cfc_get_start_week($time_id, $first_dw);
	
	//曜日クラス
	$weekday = 'day';
	
	if(wp_date('w', $time_id) == 6){
		$weekday = 'sat';
	}else if(wp_date('w', $time_id) == 0){
		$weekday = 'sun';
	}
	
	$is_in_term = ($time_id >= $min_d && $time_id <= $max_d);
	
	$td_classes = array('cfc-cell', 'week-'.$dw, strtolower(wp_date('D', $time_id)));
	
	if($time_id == $today){
		$td_classes[] = 'today';
	}
	
	$values = cfc_get_customs($time_id);
	
	if(!empty($values)){
		$have_data = false;
		foreach($values as $k=>$v){
			//どんなデータでもあれば
			if(!empty($v)){
				$have_data = true;
				break;
			}
		}
		if($have_data){
			$td_classes[] = 'have-data';
		}
	}
	
	//start table cell including
	ob_start(); //for td

	cfc_get_template_part('/'.$calendar_type.'/table', 'cell', array(
		'is_in_term' => $is_in_term,
		'time_id' => $time_id,
		'td_classes' => $td_classes,
		'values' => $values,
		'first_dw' => $first_dw,

		'have_column_header' => $have_column_header,
	));
	
	$cells[$dw] = ob_get_clean();
	
	//finished table cell including
	
	
	//1日進める
	$time_id += $day_length;
	

	$table_class = 'alignwide';
	if($have_column_header){
		$table_class .= ' have_column_header';
	}
	
	//月が変わったら出力
	if($is_seamless_month){
		
		if($dw ==  6) {
			$month_cells[] = $column_header.implode('', $cells);
			
			cfc_get_template_part('/'.$calendar_type.'/table', array(
				'th' => $tableheader,
				'td' => $month_cells,
				'monthname' => $current_month,
				'time_id' => $time_id,
				'table_class' => $table_class,
			));
			
			$cells = $this->_get_month_cells();
			$current_month = wp_date('m月', $time_id);
			$month_cells = array();
		}
	}else{
		if(wp_date('m月', $time_id) != $current_month){
			
			$month_cells[] = $column_header.implode('', $cells);
			
			cfc_get_template_part('/'.$calendar_type.'/table', array(
				'th' => $tableheader,
				'td' => $month_cells,
				'monthname' => $current_month,
				'time_id' => $time_id,
				'table_class' => $table_class,
			));
			
			//echo $tableheader.'<tr>'.implode('</tr><tr>', $month_cells).'</tr>';
			
			$cells = $this->_get_month_cells();
			$current_month = wp_date('m月', $time_id);
			$month_cells = array();
	
		}elseif($dw ==  6) {
			//週の終わり
			$month_cells[] = $column_header.implode('', $cells);
			$cells = $this->_get_month_cells();
		};
	}
	
	$i++;
	
endwhile;
