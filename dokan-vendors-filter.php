<?php

/**
 * Plugin Name: Dokan Vendors Filter
 * Plugin URI: http://nsukonny.ru/dokan-vendors-filter
 * Description: Display vendors list with filters
 * Version: 1.0.3
 * Author: nSukonny
 * Author URI: http://nsukonny.ru
 * License: A "Slug" license name e.g. GPL2
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Check if class DokanVendorsFilter already exists
if ( ! class_exists( 'DVF' ) ) {

	class DVF {

		/**
		 * The one and only true DokanVendorsFilter instance
		 *
		 * @since 1.0.0
		 *
		 * @access private
		 * @var object $instance
		 */
		private static $instance;

		/**
		 * DVF constructor.
		 *
		 * @since 1.0.3
		 *
		 * @return void
		 */
		public function __construct() {
			register_activation_hook( __FILE__, array( 'DVF', 'plugin_activation' ) );
			register_deactivation_hook( __FILE__, array( 'DVF', 'plugin_deactivation' ) );

			add_action( 'dokan_loaded', array( $this, 'init_plugin' ) );
		}

		/**
		 * Load the plugin after Dokan isloaded
		 *
		 * @since 1.0.3
		 *
		 * @return void
		 */
		public function init_plugin() {
			$this->setup_constants();
			$this->includes();
			$this->init_hooks();
		}

		/**
		 * Instantiate the main class
		 *
		 * This function instantiates the class, initialize all functions and return the object.
		 *
		 * @since 1.0.0
		 *
		 * @return object The one and only true DokanVendorsFilter instance.
		 */
		public static function instance() {

			if ( ! isset( self::$instance ) && ( ! self::$instance instanceof DVF ) ) {
				self::$instance = new DVF();
			}

			return self::$instance;
		}

		/**
		 * Function for setting up constants
		 *
		 * This function is used to set up constants used throughout the plugin.
		 *
		 * @since 1.0.0
		 *
		 * @return void
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
		 *
		 * @return void
		 */
		public function includes() {
			include DOKAN_VF_PLUGIN_PATH . 'classes/class-dvf-params.php';
			include DOKAN_VF_PLUGIN_PATH . 'classes/class-dvf-admin.php';
			include DOKAN_VF_PLUGIN_PATH . 'classes/class-dvf-list.php';
		}

		/**
		 * Init plugin hooks and actions
		 *
		 * @since 1.0.03
		 *
		 * @return void
		 */
		public function init_hooks() {
			add_action( 'plugin_action_links_' . plugin_basename( __FILE__ ), array( $this, 'addition_links' ) );
		}

		/**
		 * Add links to plugins page for fast view settings
		 *
		 * @since 1.0.3
		 *
		 * @param  array $links List of existing plugin action links.
		 *
		 * @return array         List of modified plugin action links.
		 */
		function addition_links( $links ) {
			$links = array_merge( array(
				'<a href="' . esc_url( admin_url( '/admin.php?page=' . DVF_Params::SLUG . 'settings' ) ) . '">' . __( 'Settings' ) . '</a>'
			), $links );

			return $links;
		}


		/**
		 * On activation plugin, parse all dokan stores data to user_meta
		 *
		 * @since 1.0.1
		 *
		 * @return void
		 */
		static function plugin_activation() {
			$vendors = dokan_get_sellers();

			foreach ( $vendors['users'] as $seller ) {
				$vendor     = dokan()->vendor->get( $seller->ID );
				$store_info = dokan_get_store_info( $vendor->data->ID );

				foreach ( DVF_Params::$fields as $key => $field ) {
					if ( isset( $store_info['address'][ $key ] ) ) {
						update_user_meta( $seller->ID, DVF_Params::SLUG . $key, $store_info['address'][ $key ] );
					}
				}
			}
		}

		/**
		 * On deactivation plugin, clear all user_meta
		 *
		 * @since 1.0.1
		 *
		 * @return void
		 */
		static function plugin_deactivation() {
			delete_option( DVF_Params::SLUG . 'params' );

			$vendors = dokan_get_sellers();

			foreach ( $vendors['users'] as $seller ) {
				foreach ( DVF_Params::$fields as $key => $field ) {
					delete_user_meta( $seller->ID, DVF_Params::SLUG . $key );
				}
			}
		}
	}

}

/**
 * The main function for returning DokanVendorsFilter instance
 *
 * @since 1.0.0
 * @return object The one and only true DokanVendorsFilter instance.
 */
function dvf_runner() {
	return DVF::instance();
}

// Run plugin
dvf_runner();