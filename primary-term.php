<?php
/**
 * Plugin Name: Primary Term
 * Plugin URI: http://thinkstylestudio.com
 * Description: A WordPress plugin that allows a user to set a primary category.
 * Version: 1.0
 * Author: Theron Smith
 * Author URI: http://thinkstylestudio.com
 * License: GPL2
 *
 * @package Primary_Term
 */

// If this file is accessed directory, then abort.

if ( ! defined('WPINC' ) ) {
    die;
}


require_once __DIR__ . '/vendor/autoload.php';

const PLUGIN_DIRECTORY_NAME = 'primary-term';
const PRIMARY_TERM          = 'primary_term';

if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
    $frontend = new \Thnk\Frontend\PrimaryTerm();
    $frontend->init();

    $admin = new \Thnk\Admin\PrimaryTerm();
    $admin->init();
}
