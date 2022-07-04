<?php 
/*
<table class="cfc-table cfc-table-monthly month-<?php echo wp_date('m', $time_id) ?> <?php echo $table_class; ?>" data-datetime="<?php echo $time_id; ?>">
	
		<caption><?php echo $monthname; ?></caption>
		
		<thead>
			<?php echo $th; ?>
		</thead>
		
		<?php echo $td; ?>
		
</table>
*/
?>
<?php
$class = 'cfc-table cfc-table-weekly month-'.wp_date('m', $time_id).' '.$table_class;
?>
<table class="<?php echo $class ?>"><tr><?php echo implode('</tr></table><table class="'.$class.'"><tr>', $td); ?></tr></table>