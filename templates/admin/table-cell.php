<?php 
global $wp_locale;
extract($args);
?>
<td <?php if($is_in_term): ?>id="cell_<?php echo $time_id; ?>"<?php endif; ?> class="<?php echo implode(' ', $td_classes); ?>" data-time="<?php echo $time_id; ?>" title="acd">
	
<?php if($is_in_term): ?>

  <!-- Custom Field area -->
  <div class="u-anc">
	  <time><?php echo wp_date('n/j', $time_id); ?></time>
	  
	  <div class="c-fieldset" id="fieldset_<?php echo $time_id; ?>" data-id="<?php echo $time_id; ?>">
		
		  <h3 class="sortable-handle">
			  <span><?php echo wp_date('n/j', $time_id); ?> (<?php echo $wp_locale->get_weekday_abbrev($wp_locale->get_weekday($day_index)); ?>)</span>
			  <div class="handle-actions c-button_wrap">
				  <button class="close-fieldset c-button" title="このフィールドを閉じる" data-action="close-inputs"><i></i></button>
				  <button class="stick-fieldset c-button" title="このフィールドをピンどめ" data-action="stick-inputs"><i></i></button>
			  </div>
		  </h3>
			
		  <div class="p-fields">
	  	<?php cfc_rendar_custom_fields($time_id); ?>
		  </div>
	  </div>
	  
  </div>
  
	  <span class="tooltip-content"><?php 
		 if(!empty($values)){
			 $arr = array();
			 foreach($values as $k=>$v){
				 
				 $v = is_array($v) ? implode(',', $v) : (string)$v;
				 $vv = mb_substr($v, 0, 20);
				 
				 if($vv != $v){
					 $vv .= '...';
				 }
				 
				 $arr[] = '<b>'.$k.' : </b>'.$vv;
			 }
			 
			 echo !empty($arr) ? implode(' ; ', $arr) : '';
		 }
		?></span>
<?php else: ?>
  <span class="disabled"></span>
<?php endif; ?>
  
</td>
