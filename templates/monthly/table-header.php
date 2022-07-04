<?php 
global $wp_locale;
extract($args);
?>

<th class="cf-calendar <?php echo $weekday; ?>">
<?php echo $wp_locale->get_weekday_abbrev($wp_locale->get_weekday($day_index)); ?>
</th>