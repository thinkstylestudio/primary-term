<?php

/*
Plugin Name: Primary Term
Plugin URI: http://thinkstylestudio.com
Description: A WordPress plugin that allows a user to set a primary category.
Version: 1.0
Author: Theron Smith
Author URI: http://thinkstylestudio.com
License: GPL2

Primary Term is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

Primary Term is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Primary Term. If not, see {License URI}.
*/

// If this file is accessed directory, then abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
require_once __DIR__ . '/vendor/autoload.php';

const PLUGIN_DIRECTORY_NAME = 'primary-term';
const PRIMARY_TERM          = 'primary_term';

$frontend = new \Thnk\Frontend\PrimaryTerm();
$frontend->init();

$admin = new \Thnk\Admin\PrimaryTerm();
$admin->init();
