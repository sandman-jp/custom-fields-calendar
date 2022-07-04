<?php
namespace CFC\admin\calendar;

use CFC;
use CFC\admin;
use CFC\admin\calendar;
use CFC\admin\calendar\table;

if ( ! defined('ABSPATH') ) {
	exit; // Exit if accessed directly
}


class table {
	
	function __construct($post_id){
		
		$this->post_id = $post_id;
		
	}
	
	private function _get_month_cells(){
		$td = array();
		for($i=0; $i<7; $i++){
			$td[] = '<td class="cfc-cell"></td>';
		}
		return $td;
	}
	
	
	
	function rendar_table(){
		global $wp_locale;
		
		$this->settings = CFC()->get_instance('CFC\settings');
		$general = $this->settings->get('general-settings');

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
		
		include_once CFC_DIR_INCLUDES.'/admin/view/calendar/table.php';
		
	}
	
}
