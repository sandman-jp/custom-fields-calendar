<?php
$class = 'cfc-table cfc-table-weekly month-'.wp_date('m', $time_id).' '.$table_class;
?>
<table class="<?php echo $class ?>"><tr><?php echo implode('</tr></table><table class="'.$class.'"><tr>', $td); ?></tr></table>