<?php
/*
Plugin Name: WP EMR
Plugin URI: http://basoro.org/wpemr 
Description: A simple wordpress plugin for electronic medical records 
Version: 1.0
Author: Faisol Basoro 
Author URI: http://basoro.org 
License: GPL2
*/

/*
Copyright 2015  Faisol Basoro  (email : drg.faisol@basoro.org)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

if(!class_exists('Wpemr'))
{
	class Wpemr
	{
		/**
		 * Construct the plugin object
		 */
		public function __construct()
		{
			// Initialize Settings
			require_once(sprintf("%s/updater.php", dirname(__FILE__)));
			$Wpemr_Updater = new Wpemr_Updater(__FILE__);
			$Wpemr_Updater->set_username( 'basoro' );
			$Wpemr_Updater->set_repository( 'wpemr' );
			$Wpemr_Updater->initialize();

			// Initialize Settings
			require_once(sprintf("%s/settings.php", dirname(__FILE__)));
			$Wpemr_Settings = new Wpemr_Settings();

			// Register custom post types
			require_once(sprintf("%s/admin/post-type.php", dirname(__FILE__)));
			$Wpemr_Patient = new Wpemr_Patient();

			$plugin = plugin_basename(__FILE__);
			add_filter("plugin_action_links_$plugin", array( $this, 'plugin_settings_link' ));
			add_action('admin_print_scripts', array( $this, 'wpemr_scripts' ));
			add_action('edit_form_after_title', array( $this, 'wpemr_move_metabox' ));

		} // END public function __construct

		/**
		 * Activate the plugin
		 */
		public static function activate()
		{
			// Do nothing
		} // END public static function activate

		/**
		 * Deactivate the plugin
		 */
		public static function deactivate()
		{
			// Do nothing
		} // END public static function deactivate

		// Add the settings link to the plugins page
		function plugin_settings_link($links)
		{
			$settings_link = '<a href="options-general.php?page=wpemr_settings">Settings</a>';
			array_unshift($links, $settings_link);
			return $links;
		}

		function wpemr_scripts() 
		{
			if ( 'wpemr_patient' === get_current_screen()->id ) 
			{

				wp_enqueue_style( 'jquery-ui-style', plugins_url( 'assets/css/jquery-ui.min.css', __FILE__ ));
				wp_enqueue_style( 'jquery-datepicker-css', plugins_url( 'assets/css/jquery.datePicker.css', __FILE__ ));
				wp_enqueue_style( 'wpemr-css', plugins_url( 'assets/css/wpemr.css', __FILE__ ));

				wp_enqueue_media();
				wp_enqueue_script( 'jquery' );
				wp_enqueue_script( 'jquery-ui-core' );
				wp_enqueue_script( 'jquery-ui-datepicker' );

				wp_enqueue_script( 'wpemr-js', plugins_url( 'assets/js/wpemr.js', __FILE__ ), array('jquery'), time(), false );

			}
		}

		function wpemr_move_metabox() 
		{
			global $post, $wp_meta_boxes;
			if ( 'wpemr_patient' === get_current_screen()->id ) 
			{
			    do_meta_boxes(get_current_screen(), 'advanced', $post);
			    unset($wp_meta_boxes['wpemr_patient']['advanced']);
			}
		}


	} // END class Wpemr
} // END if(!class_exists('Wpemr'))

if(class_exists('Wpemr'))
{
	// Installation and uninstallation hooks
	register_activation_hook(__FILE__, array('Wpemr', 'activate'));
	register_deactivation_hook(__FILE__, array('Wpemr', 'deactivate'));

	// instantiate the plugin class
	$wpemr = new Wpemr();

}
