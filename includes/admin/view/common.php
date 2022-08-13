
<?php 
$tab = empty($_GET['tab']) ? 'schedule' : $_GET['tab'];
$args = empty($this->common_settings->{$tab}) ? array() : $this->common_settings->{$tab};

include CFC_DIR_INCLUDES.'/admin/view/common/'.$tab.'.php';
?>
<script>
var fields_settings = <?php echo json_encode($this->common_settings->get_all()); ?>
</script>