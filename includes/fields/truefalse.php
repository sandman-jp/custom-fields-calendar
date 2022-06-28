<?php

namespace CFC\fields;

use CFC;
use CFC\fields;
use CFC\fields\truefalse;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


class truefalse extends CFC\fields\field{
	
	var $type = 'truefalse';
	
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
				<input 
					type="checkbox" 
					name="<?php echo $this->get_field_name(); ?>" 
					value="1" 
					<?php if($required): ?>required<?php endif; ?> 
					class="<?php echo $this->get_field_class($additional_class); ?>" 
					%%checked:<?php echo urlencode($this->get('field-name')); ?>_1%%
					>
			</span>
			
		</div>
		<?php
		$field_tags = ob_get_clean();
		
		return $field_tags;
	}
	
}