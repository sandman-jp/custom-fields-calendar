<?php

namespace CFC\field;

use CFC;
use CFC\field;
use CFC\field\textarea;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


class textarea extends CFC\field{
	
	var $type = 'textarea';
	
	final function rendar($parent_key){
		
		ob_start();
		?>
		<div class="__input-field-wrap">
			<span class="__input-field_label"><?php echo $this->get('field-label'); ?></span>
			<span class="__input-field">
			<textarea name="<?php echo $this->get_field_name(); ?>" class="<?php echo $this->get_field_class(); ?>">%<?php echo $this->get('field-name'); ?>_value%</textarea>
			</span>
			
		</div>
		<?php
		$field_tags = ob_get_clean();
		
		return $field_tags;
	}
	
}