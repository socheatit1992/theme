<?php
if(!class_exists('wpThemeUpdater')) {
	class wpThemeUpdater {
		protected $_themeBase = '';
		protected $_themeSlug = '';
		protected $_themeVersion = '';
		protected $_userAgentHash = 'odfgre4$$Jj(4032123klk((33kr-$245gk+_\=ekGne';
		protected $_apiUrl = 'http://readyshoppingcart.com/?pl=com&mod=updater&action=requestAction';

		public function __construct($themeBase = '', $themeSlug = '', $themeVersion = '') {
			$this->_themeBase		= $themeBase;
			$this->_themeSlug		= $themeSlug;
			$this->_themeVersion	= $themeVersion;
		}
		static public function getInstance() {
			static $instances = array();
			// Instance key
			if(function_exists('wp_get_theme')){
				$themeData = wp_get_theme(get_option('template'));
				$themeVersion = $themeData->Version;  
			} else {
				$themeData = get_theme_data( TEMPLATEPATH . '/style.css');
				$themeVersion = $themeData['Version'];
			}    
			$themeBase = get_option('template');
			$themeSlug = basename($themeBase);

			$instKey = $themeBase. '/'. $themeVersion;
			if(!isset($instances[ $instKey ])) {
				$instances[ $instKey ] = new wpThemeUpdater($themeBase, $themeSlug, $themeVersion);
			}
			return $instances[ $instKey ];
		}
		public function checkForThemeUpdate($checkedData) {
			global $wp_version;
			
			$request = array(
				'slug' => $this->_themeSlug,
				'version' => $this->_themeVersion,
			);
			// Start checking for an update
			$send_for_check = array(
				'body' => array(
					'action' => 'theme_update', 
					'request' => serialize($request),
					'api-key' => md5(get_bloginfo('url')),
					'hash' => constant('S_YOUR_SECRET_HASH_'. $this->_themeSlug),
				),
				'user-agent' => $this->_userAgentHash. '/' . $wp_version . '; ' . get_bloginfo('url'). ';'. $this->getIP()
			);
			$raw_response = wp_remote_post($this->_apiUrl, $send_for_check);
			if (!is_wp_error($raw_response) && ($raw_response['response']['code'] == 200))
				$response = unserialize($raw_response['body']);

			// Feed the update data into WP updater
			if (!empty($response)) 
				$checkedData->response[$this->_themeBase] = $response;

			return $checkedData;
		}
		public function myThemeApiCall($def, $action, $args) {
			
			if ($args->slug != $this->_themeSlug)
				return false;

			// Get the current version

			$args->version = $this->_themeVersion;
			$request_string = prepare_request($action, $args);
			$request = wp_remote_post($this->_apiUrl, $request_string);

			if (is_wp_error($request)) {
				$res = new WP_Error('themes_api_failed', __('An Unexpected HTTP Error occurred during the API request.</p> <p><a href="?" onclick="document.location.reload(); return false;">Try again</a>'), $request->get_error_message());
			} else {
				$res = unserialize($request['body']);

				if ($res === false)
					$res = new WP_Error('themes_api_failed', __('An unknown error occurred'), $request['body']);
			}

			return $res;
		}
		public function getIP() {
			return (empty($_SERVER['HTTP_CLIENT_IP']) ? (empty($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['REMOTE_ADDR'] : $_SERVER['HTTP_X_FORWARDED_FOR']) : $_SERVER['HTTP_CLIENT_IP']);
		}
	}
}
