<?php
//table rendar engine
$titles = array();

$table_num = 0;

$i = 0;


ob_start();
for($i=0; $i<7; $i++): 
?>
	<?php
	$day_index = ($i + $first_dw) % 7;
	
	$weekday = 'day';
  
  if(wp_date('w', $init_id) == 6){
    $weekday = 'sat';
  }else if(wp_date('w', $init_id) == 0){
    $weekday = 'sun';
  }
  
  ?>
  
  <th class="cf-calendar <?php echo $weekday; ?>">
	<?php echo $wp_locale->get_weekday_abbrev($wp_locale->get_weekday($day_index)); ?>
	</th>
	
<?php 
endfor; 
$tableheader = ob_get_clean();

$time_id = $min_d;

$is_new_month = true;
$current_month = wp_date('m月', $min_d);

$cells = $this->_get_month_cells();
$month_cells = array();


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
	
	if($time_id == strtotime('today')){
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

	cfc_get_template_part('/admin/table', 'cell', array(
		'is_in_term' => $is_in_term,
		'time_id' => $time_id,
		'td_classes' => $td_classes,
		'values' => $values,
		'first_dw' => $first_dw,
	));
	
	$cells[$dw] = ob_get_clean();
	//finished table cell including
	
	
	//1日進める
	$time_id += $day_length;
	
	//月が変わったら出力
	if(wp_date('m月', $time_id) != $current_month){
		//var_dump($cells);
		
		$month_cells[] = implode('', $cells);
		
		echo cfc_get_template_part('/admin/table', array(
			'th' => $tableheader,
			'td' => '<tr>'.implode('</tr><tr>', $month_cells).'</tr>',
			'monthname' => $current_month,
			'time_id' => $time_id,
		));
		
		//echo $tableheader.'<tr>'.implode('</tr><tr>', $month_cells).'</tr>';
		
		$cells = $this->_get_month_cells();
		$current_month = wp_date('m月', $time_id);
		$month_cells = array();

	}elseif($dw ==  6) {
		//週の終わり
		$month_cells[] = implode('', $cells);
		$cells = $this->_get_month_cells();
	};
  
  $i++;
  
endwhile;
