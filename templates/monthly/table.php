

<table class="cfc-table cfc-table-monthly month-<?php echo wp_date('m', $time_id) ?> <?php echo $table_class; ?>" data-datetime="<?php echo $time_id; ?>">
	
		<caption><?php echo $monthname; ?></caption>
		
		<thead>
			<?php echo $th; ?>
		</thead>
		

		<tr><?php echo implode('</tr><tr>', $td); ?></tr>

</table>