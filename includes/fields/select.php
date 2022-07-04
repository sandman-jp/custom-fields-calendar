<?php

namespace CFC\fields;

use CFC;
use CFC\fields;
use CFC\fields\select;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


class select extends CFC\fields\field{
	
	var $type = 'radio';
	
	final function rendar($parent_key){
		
		$value = $this->get('field-value');
		$value = empty($value) ? $this->get('field-default-value') : $value;
		
		$required = $this->is_required();
		
		$additional_class = $required ? array('is-required') : array();
		
		ob_start();
		?>
		<div class="c-field">
			
			<span class="c-field_label">
				<span><?php echo $this->get('field-label'); ?> <?php if($required): ?><span class="required">*</span><?php endif; ?></span>
				<small><?php echo $this->get('field-description'); ?></small>
			</span>
			
			<span class="c-field_input">
				<select 
					name="<?php echo esc_html($this->get_field_name()); ?>" 
					<?php if($required): ?>required<?php endif; ?> 
					class="<?php echo $this->get_field_class($additional_class); ?>"
					>
					<?php
					$choices = $this->get('field-choices');
					
					$choices = str_replace(array("\r\n", "\r", "\n"), "\n", $choices);
					$choices = explode("\n", $choices);
					
					foreach($choices as $choice):
						$arr = explode(' : ', $choice);
						$value = $label = $arr[0];
						if(count($arr) == 2){
							$label = $arr[1];
						}
						?>
						<option 
							value="<?php echo $value; ?>"  
							%%selected:<?php echo urlencode($this->get('field-name')); ?>_<?php echo trim($value); ?>%%
							title="<?php echo $this->get('field-title'); ?>"
							> <?php echo $label; ?></option>
					<?php endforeach; ?>
				
				</select>
			</span>
			
		</div>
		<?php
		$field_tags = ob_get_clean();
		
		return $field_tags;
	}
	
}