<?php

namespace CFC\fields;

use CFC;
use CFC\fields;
use CFC\fields\textfield;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


class textfield extends CFC\fields\field{
	
	var $type = 'text';
	/*
	//テンプレートを返すよ
	final function rendar($key){
		
		
		$value = $this->get('field-value');
		$value = empty($value) ? $this->get('field-default-value') : $value;
			
		$validation = CFC()->get_instance('CFC\tools\validation')->get($this->type);
		
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
				<input 
					type="<?php echo $this->type; ?>" 
					name="<?php echo esc_html($this->get_field_name()); ?>" 
					value="%%<?php echo urlencode($this->get('field-name')); ?>_value%%" 
					placeholder="<?php echo $this->get('field-place-holder'); ?>" 
					<?php if($required): ?>required<?php endif; ?> 
					class="<?php echo $this->get_field_class($additional_class); ?>"
					<?php if(!empty($validation)): ?>pattern="<?php echo $validation ?>"<?php endif; ?>
				>
			</span>
			
		</div>
		<?php
		$field_tags = ob_get_clean();
		
		$field_tags = apply_filters('cfc/field/render', $field_tags);
		
		$field_tags = apply_filters('cfc/field/render/'.$this->type, $field_tags);
		
		//keyは%key%と、valueは%value%して返すして、group側で置き換え
		return $field_tags;
	}
	*/
}