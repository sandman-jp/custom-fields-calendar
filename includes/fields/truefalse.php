<?php

namespace CFC\field;

use CFC;
use CFC\field;
use CFC\field\truefalse;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


class truefalse extends CFC\field{
	
	var $type = 'truefalse';
	
	final function rendar($parent_key){
		
		$required = !empty($this->get('field-required'));
		
		$value = $this->get('field-value');
		$value = empty($value) ? $this->get('field-default-value') : $value;
		
		ob_start();
		?>
		<div class="__input-field-wrap">
			
			<span class="__input-field_label">
				<span><?php echo $this->get('field-label'); ?> <?php if($required): ?><span class="required">*</span><?php endif; ?></span>
				<small><?php echo $this->get('field-description'); ?></small>
			</span>
			
			<span class="__input-field">
				<input type="checkbox" name="<?php echo $this->get_field_name(); ?>" value="1" <?php if($required): ?>required<?php endif; ?> class="<?php echo $this->get_field_class(); ?>" %checked:1%>
			</span>
			
		</div>
		<?php
		$field_tags = ob_get_clean();
		
		return $field_tags;
	}
	
}