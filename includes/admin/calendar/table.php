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
		
		//for debug
		//$min_d = strtotime(date('Y-m-01'));
		$min_d = strtotime('12 May 2022');
		
		$max_d = strtotime('15 October 2022');
		
		//1日の長さ
		$day_length = 24 * 60 * 60;
		
		//今日のパラメータ
		$y = wp_date('Y');
		$m = wp_date('n');
		$d = wp_date('j');
		$h = wp_date('H');
		$min = wp_date('i');
		
		$today = strtotime($y.'/'.$m.'/'.$d.' - 9 hours');
		
		//曜日を月曜日から始めるようにする
		$first_dw = 1;//月曜日
		
		//カレンダーを開始する日
		$min_dw = cfc_get_start_week($min_d, $first_dw);
		
		$init_id = $min_d - ($min_dw * $day_length);
		
		//カレンダーを終了する日
		$max_dw = cfc_get_start_week($max_d, $first_dw);
		
		if($max_dw && $max_dw < 6){
			$max_d_end = $max_d + ($day_length * 7);
		}else{
			$max_d_end = $max_d;
		}
		
		include_once CFC_DIR_INCLUDES.'/admin/view/calendar/table.php';
		
	}
	
}
