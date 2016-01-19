<?php
/*
Plugin Name: Canvas-Nest.js
Plugin URI: https://github.com/aTool-org/canvas-nest-for-wp
Description: [正版]A wordpress plugin for canvas-nest.js | 一个很炫酷网页背景效果（canvas-nest.js）的wordpress插件。
Version: 1.0.0
Author: aTool.org
Author URI: http://www.aTool.org/
License: MIT
*/

if(!class_exists('WP_Canvas_Nest')) {
	class WP_Canvas_Nest {
		/**
		 * Construct the plugin object
		 */
		public function __construct() {
			// Initialize Settings
			require_once(sprintf("%s/settings.php", dirname(__FILE__)));
			$WP_Canvas_Nest_Settings = new WP_Canvas_Nest_Settings();

			$plugin = plugin_basename(__FILE__);
			add_filter("plugin_action_links_$plugin", array( $this, 'plugin_settings_link' ));
		} // END public function __construct

		/**
		 * Activate the plugin
		 */
		public static function activate() {
			// Do nothing
		} // END public static function activate

		/**
		 * Deactivate the plugin
		 */
		public static function deactivate() {
			// Do nothing
		} // END public static function deactivate

		// Add the settings link to the plugins page
		function plugin_settings_link($links) {
			$settings_link = '<a href="options-general.php?page=WP_Canvas_Nest">Settings</a>';
			array_unshift($links, $settings_link);
			return $links;
		}


	} // END class WP_Canvas_Nest
} // END if(!class_exists('WP_Canvas_Nest'))

if(class_exists('WP_Canvas_Nest'))
{
	// Installation and uninstallation hooks
	register_activation_hook(__FILE__, array('WP_Canvas_Nest', 'activate'));
	register_deactivation_hook(__FILE__, array('WP_Canvas_Nest', 'deactivate'));

	// instantiate the plugin class
	$WP_Canvas_Nest = new WP_Canvas_Nest();

}
