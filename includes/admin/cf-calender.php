<?php
/*
	
Edit Page for Calendar Post Type

*/
namespace CFC\admin;

use CFC;
use CFC\fields;
use CFC\settings;
use CFC\admin;
use CFC\admin\calendar;
use CFC\admin\calendar\table;


if ( ! defined('ABSPATH') ) {
	exit; // Exit if accessed directly
}

require_once CFC_DIR_INCLUDES.'/settings.php';
require_once CFC_DIR_INCLUDES.'/admin/calendar/table.php';


class cf_calendar{
	
	function __construct(){
		
		add_action('admin_init', array($this, 'admin_init'));
		
    add_action('edit_form_before_permalink', array($this, 'add_shortcode_box'));
    
		//$this->acf_admin_field_group = new acf_admin_field_group();
		add_action('admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts'), 12);
		add_action('admin_head', array($this, 'admin_head'));
		
		
		//add_action('add_meta_boxes', array($this, 'add_meta_box'));
		add_action('edit_form_after_editor', array($this, 'import_calendar_editor'));
		
		add_filter('wp_insert_post_data', array($this, 'before_save_post'), 10, 4);
		add_action('save_post_'.CF_CALENDAR, array($this, 'save_post'), 10, 3);
		
	}
	
	function admin_init(){
		
		if(empty($_GET['post']) || get_post_type($_GET['post']) != CF_CALENDAR){
			return ;
		}
		
		$this->post_id = $_GET['post'];
		
		$this->register_instances();
	}
	
	function register_instances(){
		
		if(!isset($this->settings)){
			$this->settings = new CFC\settings($this->post_id);
			CFC()->register_instance($this->settings);
			
		}
		
		
		if(!isset($this->fields)){
			$this->fields = new CFC\fields($this->post_id);
			CFC()->register_instance($this->fields);
		}		
		
		
		if(!isset($this->table)){
			$this->table = new CFC\admin\calendar\table($this->post_id);
			CFC()->register_instance($this->table);
		}
	}
	 //admin
  
	function admin_enqueue_scripts() {
		
		// kill autosave
		//wp_dequeue_script('autosave');
		
		global $post;
		
		if(get_post_type($post) == CF_CALENDAR){
			
			//wp_add_inline_style('cfc-admin', '');
		}
		
		
	}
	public function add_shortcode_box($post){
    if($post->post_type == CF_CALENDAR):
      $shortcode = 'cfc id=&quot;'.$post->ID.'&quot;';
	  ?>
		<p class="description">
		<label for="">このショートコードをコピーして、投稿、固定ページ、またはテキストウィジェットの内容にペーストしてください:</label>
		<span class="shortcode"><input type="text" readonly="readonly" class="large-text code" value="[<?php echo $shortcode; ?>]"></span>
		</p>
	  <?php
    endif;
  }
  
	function admin_head(){
		//nothing yet
	}
	
	function add_meta_box(){
		//
		add_meta_box(CF_CALENDAR, __('Calendar Contents', CFC_TEXTDOMAIN), array( $this, 'import_calendar_editor'), CF_CALENDAR, 'normal', 'high');
		
	}
	
	function import_calendar_editor(){
		
		if(get_current_screen()->id != CF_CALENDAR){
			return ;
		}
		
		include CFC_DIR_INCLUDES.'/admin/view/cfc-calender.php';
		
	}
	
	function before_save_post($data, $postarr, $unsanitized_postarr, $update ){
		
		$data['post_content'] = urldecode($data['post_content']);
		
		return $data;
	}
	
	function save_post($post_id, $post, $update){
		
		$this->post_id = $post_id;
		
		$this->register_instances();
		
		if(isset($_POST['content'])){
			$cfc_data = wp_parse_args($_POST['content']);
			
			if(!empty($cfc_data) && isset($cfc_data['calendar'])){
				$this->fields->update($cfc_data['calendar']);
			}
		}
		
		//カスタムフィールドグループ設定の保存
		$cf_setting = empty($_POST['custom-fields-setting']) ? array() : $_POST['custom-fields-setting'];
		$this->settings->update('custom-fields-setting', $cf_setting);
		
	}
	/*
	private function _update_all_cell_data($post_id, $cfc_data){
		
		if(!is_array($cfc_data)){
			return ;
		}
		
		foreach($cfc_data as $key=>$data){
			update_post_meta($this->post_id, 'cfc-'.$key, $data);
		}
		
	}
	*/
}

CFC()->register_instance('CFC\admin\cf_calendar');