<?php

/**
 * Admin part of Dokan Vendors Filter
 */

class DokanVendorsFilterAdmin {

	/**
	 * DokanVendorsFilterAdmin constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		add_action( 'personal_options_update', array( $this, 'save_meta_fields' ) );
		add_action( 'edit_user_profile_update', array( $this, 'save_meta_fields' ) );
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

		foreach ( DokanVendorsFilterParemeters::$fields as $key => $field ) {
			if ( isset( $store_settings['address'][ $key ] ) ) {
				update_user_meta( $user_id, 'dokan_vf_' . $key, $store_settings['address'][ $key ] );
			}
		}
	}
}

/**
 * Run DokanVendorsFilterAdmin class
 *
 * @since 1.0.0
 *
 * @return DokanVendorsFilterAdmin
 */
function dokan_vendors_filter_admin_runner() {
	return new DokanVendorsFilterAdmin();
}

//Run just in admin part
if ( is_admin() ) {
	dokan_vendors_filter_admin_runner();
}