<?php

if ( ! defined('ABSPATH') ) {
	exit; // Exit if accessed directly
}
?>

<div class="cfc-custom-field-wrap">
	
	<div id="cfc-custom-field-list" class="sotable">
		
	</div>
	
	<div class="btn-wrap add-field">
		<button id="btn_add-field" class="button button-primary button-large">Add Field</button>
	</div>
</div>


<script type="text/html" id="field-template">
	<?php cfc_get_template_part('/admin/view/templates/custom-fields'); ?>
</script>

<script>
	
</script>