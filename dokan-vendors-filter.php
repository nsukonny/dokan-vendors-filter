<?php

/**
 * Plugin Name: Dokan Vendors Filter
 * Plugin URI: http://nsukonny.ru/dokan-vendors-filter
 * Description: Display vendors list with filters
 * Version: 1.0.0
 * Author: nSukonny
 * Author URI: http://nsukonny.ru
 * License: A "Slug" license name e.g. GPL2
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Check if class DokanVendorsFilter already exists
if ( ! class_exists( 'DokanVendorsFilter' ) ) {

	class DokanVendorsFilter {

		/**
		 * The one and only true DokanVendorsFilter instance
		 *
		 * @since 1.0.0
		 * @access private
		 * @var object $instance
		 */
		private static $instance;

		/**
		 * Instantiate the main class
		 *
		 * This function instantiates the class, initialize all functions and return the object.
		 *
		 * @since 1.0.0
		 * @return object The one and only true DokanVendorsFilter instance.
		 */
		public static function instance() {

			if ( ! isset( self::$instance ) && ( ! self::$instance instanceof DokanVendorsFilter ) ) {

				self::$instance = new DokanVendorsFilter;
				self::$instance->setup_constants();
				self::$instance->includes();
				self::$instance->inits();

			}

			return self::$instance;
		}

		/**
		 * Function for setting up constants
		 *
		 * This function is used to set up constants used throughout the plugin.
		 *
		 * @since 1.0.0
		 */
		public function setup_constants() {

			// Plugin version
			if ( ! defined( 'DOKAN_VF_VERSION' ) ) {
				define( 'DOKAN_VF_VERSION', '1.0.0' . time() );
			}

			// Plugin folder path
			if ( ! defined( 'DOKAN_VF_PLUGIN_PATH' ) ) {
				define( 'DOKAN_VF_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
			}

			// Plugin folder URL
			if ( ! defined( 'DOKAN_VF_PLUGIN_URL' ) ) {
				define( 'DOKAN_VF_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
			}
		}

		/**
		 * Includes all necessary PHP files
		 *
		 * This function is responsible for including all necessary PHP files.
		 *
		 * @since  1.0.0
		 */
		public function includes() {
			include DOKAN_VF_PLUGIN_PATH . 'classes/parameters.php';
			include DOKAN_VF_PLUGIN_PATH . 'classes/admin.php';
			include DOKAN_VF_PLUGIN_PATH . 'classes/list.php';
		}

		/**
		 * Initialization hooks and filters
		 *
		 * @since 1.0.0
		 */
		public function inits() {

		}
	}

}

/**
 * The main function for returning DokanVendorsFilter instance
 *
 * @since 1.0.0
 * @return object The one and only true DokanVendorsFilter instance.
 */
function dokan_vendors_filter_runner() {
	return DokanVendorsFilter::instance();
}

// Run plugin
dokan_vendors_filter_runner();