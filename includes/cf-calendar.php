<?php
/*
Calendar for custom post type
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class cf_calendar {
	
	function __construct(){
		
		add_action('init', array($this, 'register_post_type'));
		
		add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'), 11);
		
	}
	
	function init(){
		$this->register_post_type();
	}

	function register_post_type() {
		
		$cap = cfc_get_admin_option('capabilitiy');
		//var_dump($cap);
		
		register_post_type(
			CF_CALENDAR,
			array(
				'labels' => array(
					'name' => __( 'CF Calendars', CFC_TEXTDOMAIN ),
					'singular_name' => __( 'CF Calendar', CFC_TEXTDOMAIN ),
					'add_new' => __( 'Add New', CFC_TEXTDOMAIN ),
					'add_new_item' => __( 'Add New Calendar', CFC_TEXTDOMAIN ),
					'edit_item' => __( 'Edit Calendar', CFC_TEXTDOMAIN ),
					'new_item' => __( 'New Calendar', CFC_TEXTDOMAIN ),
					'view_item' => __( 'View Calendar', CFC_TEXTDOMAIN ),
					'search_items' => __( 'Search Calendars', CFC_TEXTDOMAIN ),
					'not_found' => __( 'No Calendars found', CFC_TEXTDOMAIN ),
					'not_found_in_trash' => __( 'No Calendars found in Trash', CFC_TEXTDOMAIN ),
				),
				'menu_icon' => 'dashicons-calendar-alt',
				'public' => false,
				'hierarchical' => false,
				'show_ui' => true,
				'show_in_menu' => true,
				'show_in_nav_menus' => false,
				'show_in_admin_bar' => false,
				'show_in_rest' => false,
				'_builtin' => false,
				'capability_type' => 'post',
				'capabilities' => array(
					
					'edit_post' => 'edit_posts',
					'edit_posts' => 'edit_posts',
					'edit_others_posts' => 'edit_posts',
					
					'create_posts' => $cap,
					'publish_posts' => $cap,
					'delete_post' => $cap,
					'delete_posts' => $cap,
				),
				// 'supports' => array('title', 'revisions'),
				'supports' => array('title'),
				'rewrite' => false,
				'query_var' => false,
			)
		);
		
	}
	
	function enqueue_scripts(){
		if(!is_admin()){
			wp_enqueue_style('cf-alendar', CFC_ASSETS_URL.'/cfc.css', array(), CFC_VIRSION);
		}
		
	}

	private function _get_month_cells(){
		$td = array();
		for($i=0; $i<7; $i++){
			$td[] = '<td class="cfc-cell"></td>';
		}
		return $td;
	}
	
	function rendar_table($atts){
		global $wp_locale;
		
		if(empty($atts['id'])){
			return;
		}
		
		require_once CFC_DIR_INCLUDES.'/settings.php';
		
		$this->settings = new CFC\settings($atts['id']);
		CFC()->register_instance($this->settings);
		
		require_once CFC_DIR_INCLUDES.'/fields.php';
		
		$this->fields = new CFC\fields($atts['id']);
		CFC()->register_instance($this->fields);
		
		
		
		$general = $this->settings->get('general-settings');
		$templates = $this->settings->get('template-settings');
		
		//ローカルタイム変更後
		$min_d = $general['calendar-term']['start']['datetime'];
		$max_d = $general['calendar-term']['end']['datetime'];
		
		//1日の長さ
		$day_length = 24 * 60 * 60;
		
		//今日のパラメータ
		$y = wp_date('Y');
		$m = wp_date('n');
		$d = wp_date('j');
		$h = wp_date('H');
		$min = wp_date('i');
		
		$today = strtotime($y.'/'.$m.'/'.$d.' '.wp_timezone_string());
		//曜日を月曜日から始めるようにする
		$first_dw = $general['first-week'] == 'current' ? wp_date('w') : $general['first-week'];//月曜日

		//最終表日（開始が月曜(1)なら最終は日(0)、水曜(3)なら最終は火(2)）;
		//$end_dw = $first_dw - 1;
		//$end_dw = $end_dw < 0 ? 6 : $end_dw;
		
		
		$args = array(
			'min_d' => isset($atts['from']) ? strtotime($atts['from']) : $min_d,
			'max_d' => isset($atts['until']) ? strtotime($atts['until']) : $max_d,
			'first_dw' => isset($atts['start']) ? $atts['start'] : $first_dw,
			'calendar_type' => isset($atts['type']) ? $atts['type'] : $templates['calendar-type'],
		);
		
		extract($args);
		
		//カレンダーを開始する日
		$min_dw = cfc_get_start_week($min_d, $first_dw);
		
		$init_id = $min_d - ($min_dw * $day_length);
		
		//カレンダーを終了する日
		$max_dw = cfc_get_start_week($max_d, $first_dw);
		
		if($max_dw < 6){
			$diff_w = 6 - $max_dw;
			$max_d_end = $max_d + ($day_length * $diff_w);
			
			//$max_d_end -= $day_length * $max_dw;
		}else{
			$max_d_end = $max_d;
		}
		
		$have_column_header = !empty($templates['column-header']);
		$is_seamless_month = $calendar_type == 'weekly' && !empty($templates['seamless-month']);

		include CFC_DIR_INCLUDES.'/view/calendar.php';
		
	}
}

CFC()->register_instance('cf_calendar');