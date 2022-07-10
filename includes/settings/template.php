<?php

namespace CFC\settings;

use CFC;
use CFC\settings;
use CFC\settings\setting;
use CFC\settings\template;

if ( ! defined('ABSPATH') ) {
	exit; // Exit if accessed directly
}


class template extends setting {
	
	public $name = 'template';

}