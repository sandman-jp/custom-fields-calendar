<?php

namespace CFC\fields;

use CFC;
use CFC\fields;
use CFC\fields\textarea;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


class textarea extends CFC\fields\field{
	
	var $type = 'textarea';
	
	final function rendar($parent_key){
		
		$validation = $this->validation->get($this->type);
		
		$required = $this->is_required();
		
		$additional_class = $required ? array('is-required') : array();
			
		ob_start();
		?>
		<div class="c-field">
			<span class="c-field_label"><?php echo $this->get('field-label'); ?></span>
			<span class="c-field_input">
				<textarea 
					name="<?php echo esc_html($this->get_field_name()); ?>" 
					placeholder="<?php echo $this->get('field-place-holder'); ?>" 
					<?php if($required): ?>required<?php endif; ?> 
					class="<?php echo $this->get_field_class($additional_class); ?>"
					<?php if(!empty($validation)): ?>pattern="<?php echo $validation ?>"<?php endif; ?>
					>%%<?php echo urlencode($this->get('field-name')); ?>_value%%</textarea>
			</span>
			
		</div>
		<?php
		$field_tags = ob_get_clean();
		
		return $field_tags;
	}
	
}