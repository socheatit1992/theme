<?php
/*Commercial theme update*/
require_once(dirname(__FILE__). DIRECTORY_SEPARATOR. 'wpThemeUpdater.php');
if(!defined('S_YOUR_SECRET_HASH_startcommerce'))
	define('S_YOUR_SECRET_HASH_startcommerce', 'df9(*Df9sfwefoR03#3232f0)ef8efFwfwefew');
add_filter('pre_set_site_transient_update_themes', 'myCheckForThemeUpdateStartcommerce');
// Take over the Theme info screen on WP multisite
add_filter('themes_api', 'myThemeApiCallStartcommerce', 10, 3);
if(!function_exists('myCheckForThemeUpdateStartcommerce')) {
	function myCheckForThemeUpdateStartcommerce($checkedData) {
		if(class_exists('wpThemeUpdater')) {
			return wpThemeUpdater::getInstance()->checkForThemeUpdate($checkedData);
		}
		return $checkedData;
	}
}
if(!function_exists('myThemeApiCallStartcommerce')) {
	function myThemeApiCallStartcommerce($def, $action, $args) {
		if(class_exists('wpThemeUpdater')) {
			return wpThemeUpdater::getInstance()->myThemeApiCall($def, $action, $args);
		}
		return $def;
	}
}
/*****/
define('TOE_TPL_NAME', 'StartCommerce');
define('TOE_TPL_CODE', 'startcommerce');
define('TOE_TPL_NEED_ECOMMERCE', true);
function toeAddBootstrap() {
	wp_enqueue_style('bootstrap', get_template_directory_uri(). '/css/bootstrap.css');
	wp_enqueue_style('bootstrap-responsive', get_template_directory_uri(). '/css/bootstrap-responsive.min.css');
	wp_enqueue_script('bootstrap', get_template_directory_uri(). '/js/bootstrap.min.js');
}
if(class_exists('frame')) {
	require_once (TEMPLATEPATH . '/theme-functions.php'); 
} elseif(TOE_TPL_NEED_ECOMMERCE) {
	require_once (TEMPLATEPATH . '/functions/need-plugin-alert.php'); 
}

?>
