<?php 
global $wp_locale;
extract($args);
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
