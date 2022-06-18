<?php

namespace CFC\field;

use CFC;
use CFC\field;
use CFC\field\textfield;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

require_once CFC_DIR_INCLUDES.'/fields/textfield.php';

class tel extends CFC\field\textfield{
	
	var $type = 'tel';
	
	
}