<?php

/**
 * Class DVF_Params
 * Parameters for DokanVendorsFilter
 *
 * @since 1.0.0
 */

class DVF_Params {

	/**
	 * Slug for plugin
	 *
	 * @since 1.0.0
	 */
	const SLUG = 'dokan_vf_';

	/**
	 * Field city
	 *
	 * @since 1.0.0
	 */
	const FIELD_CITY = 'city';

	/**
	 * Field country
	 *
	 * @since 1.0.0
	 */
	const FIELD_COUNTRY = 'country';

	/**
	 * Parameter field active status
	 *
	 * @since 1.0.0
	 */
	const ACTIVE = 'on';

	/**
	 * Parameter field inactive status
	 *
	 * @since 1.0.0
	 */
	const INACTIVE = 'off';

	/**
	 * Filter fields array
	 *
	 * @since 1.0.0
	 *
	 * @var array
	 */
	public static $fields = array(
		self::FIELD_CITY    => 'City',
		self::FIELD_COUNTRY => 'Country'
	);


	/**
	 * Get plugin parameters
	 *
	 * @since 1.0.0
	 *
	 * @param $name string Parameter name
	 *
	 * @return array|mixed
	 */
	public static function get_parameter( $name ) {
		$params = self::get_parameters();

		return ( isset( $params[ $name ] ) ) ? $params[ $name ] : '';
	}

	/**
	 * Get plugin parameters
	 *
	 * @since 1.0.0
	 *
	 * @return array|mixed
	 */
	public static function get_parameters() {
		return get_option( self::SLUG . 'params', array() );
	}

	/**
	 * Update plugin parameters
	 *
	 * @since 1.0.0
	 *
	 * @param $update
	 *
	 * @return bool
	 */
	public static function update_parameters( $update ) {
		$params = self::get_parameters();

		foreach ( $update as $name => $parameter ) {
			if ( is_array( $parameter ) ) {
				if ( ! isset( $params[ $name ] ) ) {
					$params[ $name ] = array();
				}

				foreach ( $parameter as $child_name => $child_parameter ) {
					$params[ $name ][ $child_name ] = $child_parameter;
				}
			} else {
				$params[ $name ] = $parameter;
			}
		}

		return update_option( self::SLUG . 'params', $params);
	}

}