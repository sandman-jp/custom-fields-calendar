<?php
	
namespace CFC;

use CFC;
use CFC\field;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


class field{
	
	private $_field_data;
	var $type;
	var $post_id;
	
	var $supports = array();
	
	function __construct(){
		$this->supports = array('required', 'default-value', 'place-holder');
	}
	
	function init(){
		
	}
	
	function get($key){
		
		return isset($this->_field_data[$key]) ? $this->_field_data[$key] : '';
		
	}
	
	function update($key, $val){
		
		$this->_field_data[$key] = $val;
		
		//$this->_update();
		//
	}
	
	//テンプレートを返すよ
	function rendar($key){
		
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
				<input type="<?php echo $this->type; ?>" name="<?php echo $this->get_field_name(); ?>" value="%<?php echo $this->get('field-name'); ?>_value%" placeholder="<?php echo $this->get('field-place-holder'); ?>" <?php if($required): ?>required<?php endif; ?> class="<?php echo $this->get_field_class(); ?>">
			</span>
			
		</div>
		<?php
		$field_tags = ob_get_clean();
		
		$field_tags = apply_filters('cfc/field/render', $field_tags);
		
		$field_tags = apply_filters('cfc/field/render/'.$this->type, $field_tags);
		
		//keyは%key%と、valueは%value%して返すして、group側で置き換え
		return $field_tags;
	}
	
	//
	
	function get_supports(){
		return $this->supports;
	}
	
	function get_field_name(){
		return 'calendar[%key%]['.$this->get('field-name').']';
	}
	
	function get_field_class(){
		$class = array('cfc-data');
		
		return implode(' ', $class);
	}
	
	private function _update() {
		
	}
}