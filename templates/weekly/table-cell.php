<?php 
global $wp_locale;

$day_index = cfc_get_start_week($time_id, $first_dw);
?>

<td <?php if($is_in_term): ?>id="cell_<?php echo $time_id; ?>"<?php endif; ?> class="<?php echo implode(' ', $td_classes); ?>" data-time="<?php echo $time_id; ?>" title="acd">
	
<?php if($is_in_term): ?>

  <!-- Custom Field area -->
	  <time datetime="<?php echo wp_date('c', $time_id); ?>"><?php echo wp_date('m/d', $time_id) ?>(<?php echo $wp_locale->get_weekday_abbrev($wp_locale->get_weekday(wp_date('w', $time_id)));?>)</time>
		
		<?php 
		 if(!empty($values)){
			 $arr = array();
			 foreach($values as $k=>$v){
				 
				$v = is_array($v) ? implode(',', $v) : (string)$v;
					 
				if($have_column_header){
					$arr[] = '<div class="cfc-data">'.$v.'</div>';
				}else{
					$arr[] = '<div class="cfc-item">'.$k.'</div><div class="cfc-data">'.$v.'</div>';
				}
				
			 }
			 
			 echo !empty($arr) ? implode('', $arr) : '';
		 }
		?>
<?php else: ?>
  <span class="nodata"></span>
<?php endif; ?>
  
</td>
