<?php

namespace CFC\fields;

use CFC;
use CFC\fields;
use CFC\fields\email;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

require_once CFC_DIR_INCLUDES.'/fields/textfield.php';

class email extends CFC\fields\field{
	
	var $type = 'email';
	
	
}