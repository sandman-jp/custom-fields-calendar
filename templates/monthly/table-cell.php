<?php 
global $wp_locale;
extract($args);

$day_index = cfc_get_start_week($time_id, $first_dw);
?>
<td <?php if($is_in_term): ?>id="cell_<?php echo $time_id; ?>"<?php endif; ?> class="<?php echo implode(' ', $td_classes); ?>" data-time="<?php echo $time_id; ?>" title="acd">
	
<?php if($is_in_term): ?>

  <!-- Custom Field area -->
	  <time datetime="<?php echo wp_date('c', $time_id); ?>"><?php echo wp_date('d', $time_id); ?></time>
		<dl>
		<?php 
		 if(!empty($values)){
			 $arr = array();
			 foreach($values as $k=>$v){
				 
				 $v = is_array($v) ? implode(',', $v) : (string)$v;
				 $vv = mb_substr($v, 0, 20);
				 
				 if($vv != $v){
					 $vv .= '...';
				 }
				 
				 $arr[] = '<dt>'.$k.'</dt><dd>'.$vv.'</dd>';
			 }
			 
			 echo !empty($arr) ? implode(' ; ', $arr) : '';
		 }
		?>
		</dl>
<?php else: ?>
  <span class="nodata">-</span>
<?php endif; ?>
  
</td>
