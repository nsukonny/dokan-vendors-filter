<?php
/**
 * Class DVF_Admin
 * Admin part of Dokan Vendors Filter
 *
 * @since 1.0.0
 */

class DVF_Admin {

	/**
	 * DokanVendorsFilterAdmin constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		add_action( 'personal_options_update', array( $this, 'save_meta_fields' ) );
		add_action( 'edit_user_profile_update', array( $this, 'save_meta_fields' ) );

		add_action( 'admin_menu', array( $this, 'add_link_to_menu' ) );
	}

	/**
	 * Catch Dokan store data to user meta for fast search
	 *
	 * @since 1.0.0
	 */
	public function save_meta_fields( $user_id ) {
		if ( ! current_user_can( 'manage_woocommerce' ) ) {
			return;
		}

		$post_data = wp_unslash( $_POST );

		if ( isset( $post_data['dokan_update_user_profile_info_nonce'] ) && ! wp_verify_nonce( $post_data['dokan_update_user_profile_info_nonce'], 'dokan_update_user_profile_info' ) ) {
			return;
		}

		if ( ! isset( $post_data['dokan_enable_selling'] ) ) {
			return;
		}

		$store_settings['store_name'] = sanitize_text_field( $post_data['dokan_store_name'] );
		$store_settings['address']    = isset( $post_data['dokan_store_address'] ) ? array_map( 'sanitize_text_field', $post_data['dokan_store_address'] ) : array();

		foreach ( DVF_Params::$fields as $key => $field ) {
			if ( isset( $store_settings['address'][ $key ] ) ) {
				update_user_meta( $user_id, DVF_Params::SLUG . $key, $store_settings['address'][ $key ] );
			}
		}
	}

	/**
	 * Add link to admin left menu
	 *
	 * @since 1.0.0
	 */
	function add_link_to_menu() {
		add_menu_page( __( 'Vendors filter' ), __( 'Vendors filter' ), 'manage_options', DVF_Params::SLUG . 'settings', array(
			$this,
			'display_settings'
		), '', 56 );
	}

	/**
	 * Show plugin setting page
	 *
	 * @since 1.0.0
	 */
	public function display_settings() {
		include DOKAN_VF_PLUGIN_PATH . 'classes/admin-settings.php';
	}
}

/**
 * Run DokanVendorsFilterAdmin class
 *
 * @since 1.0.0
 *
 * @return DVF_Admin
 */
function dokan_vendors_filter_admin_runner() {
	return new DVF_Admin();
}

//Run just in admin part
if ( is_admin() ) {
	dokan_vendors_filter_admin_runner();
}