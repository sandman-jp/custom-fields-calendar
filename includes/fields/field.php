<?php
	
namespace CFC\fields;

use CFC;
use CFC\fields;
use CFC\fields\field;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

require_once CFC_DIR_INCLUDES.'/tools/validations.php';

class field {
	
	private $_field_data;
	var $type;
	var $post_id;
	
	var $field_class = array();
	var $validation = array();
	var $supports = array();
	
	function __construct(){
		$this->field_class = array('cfc-data');
		$this->supports = array('required', 'default-value', 'place-holder');
		$this->validation = CFC()->get_instance('CFC\tools\validations');
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
		
		$value = $this->get('field-value');
		$value = empty($value) ? $this->get('field-default-value') : $value;
		
		$validation = $this->get('field-validation');
		if(empty($validation)){
			$validation = $this->validation->get($this->type);
		}
		
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
					title="<?php echo $this->get('field-title'); ?>"
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
	
	function is_required(){
		return !empty($this->get('field-required'));
	}
	//
	
	function get_supports(){
		return $this->supports;
	}
	
	function get_field_name(){
		return 'calendar[%key%]['.$this->get('field-name').']';
	}
	
	function get_field_class($additional=array()){
		
		$field_class = array_merge($this->field_class, $additional);
		
		return implode(' ', $field_class);
	}
	
	
	private function _update() {
		
	}
}