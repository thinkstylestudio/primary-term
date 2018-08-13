<?php

/*
Plugin Name: Primary Term
Plugin URI: http://URI_Of_Page_Describing_Plugin_and_Updates
Description: A brief description of the Plugin.
Version: 1.0
Author: t
Author URI: http://URI_Of_The_Plugin_Author
License: A "Slug" license name e.g. GPL2
*/
opcache_reset();

// If this file is accessed directory, then abort.

if ( ! defined('WPINC')) {
    die;
}
require_once __DIR__.'/vendor/autoload.php';

const PLUGIN_DIRECTORY_NAME = 'primary-term';
const PRIMARY_TERM          = 'primary_term';

$frontend = new \Tenup\Frontend\PrimaryTerm();
$frontend->init();

$admin = new \Tenup\Admin\PrimaryTerm();
$admin->init();
