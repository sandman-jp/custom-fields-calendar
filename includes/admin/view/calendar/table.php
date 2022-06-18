<?php

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

$time_id = strtotime(wp_date('Y-m-01', $min_d));
$last_day = strtotime('last day of '.wp_date('Y-m', $max_d_end));

//$last_day = ;

$is_new_month = true;
$current_month = wp_date('m月', $min_d);

$cells = $this->_get_month_cells();
$month_cells = array();

while($time_id <= $last_day):
	
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
		$td_classes[] = 'have_data';
	}
  ob_start(); //for td
?>
<td <?php if($is_in_term): ?>id="cell_<?php echo $time_id; ?>"<?php endif; ?> class="<?php echo implode(' ', $td_classes); ?>" data-time="<?php echo $time_id; ?>" title="acd">
	
<?php if($is_in_term): ?>

  <!-- Custom Field area -->
  <a href="javascript:void(0)">
	  <time><?php echo wp_date('n/j', $time_id); ?></time>
	  
	  <div class="fieldset" id="fieldset_<?php echo $time_id; ?>" data-id="<?php echo $time_id; ?>">
		  <h3 class="sortable-handle">
			  <span><?php echo wp_date('n/j', $time_id); ?> (<?php echo $wp_locale->get_weekday_abbrev($wp_locale->get_weekday($day_index)); ?>)</span>
			  <div class="handle-actions">
				  <button class="close-inputs" title="このフィールドを閉じる" data-action="close-inputs"><i></i></button>
				  <button class="stick-inputs" title="このフィールドをピンどめ" data-action="stick-inputs"><i></i></button>
			  </div>
		  </h3>
		  <div class="fieldlist">
	  	<?php cfc_rendar_custom_fields($time_id); ?>
		  </div>
	  </div>
	  
  </a>
  
	  <span class="tooltip-content"><?php 
		 if(!empty($values)){
			 $arr = array();
			 foreach($values as $k=>$v){
				 
				 $vv = mb_substr((string)$v, 0, 20);
				 
				 if($vv != $v){
					 $vv .= '...';
				 }
				 
				 $arr[] = '<b>'.$k.' : </b>'.$vv;
			 }
			 echo !empty($arr) ? implode(',', $arr) : '';
		 }
		?></span>
<?php else: ?>
  <span class="out_of_term"></span>
<?php endif; ?>
  
</td>

<?php
	$cells[$dw] = ob_get_clean();
	
	
	//1日進める
	$time_id += $day_length;
	
	//月が変わったら出力
	if(wp_date('m月', $time_id) != $current_month){
		//var_dump($cells);
		
		$month_cells[] = implode('', $cells);
		
		echo cfc_get_template_part('/admin/view/templates/table', array(
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
