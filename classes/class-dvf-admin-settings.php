<?php

/**
 * Class DVF_Admin_Settings
 * Display setting page in admin part
 *
 * @since 1.0.0
 */

class DVF_Admin_Settings {

	/**
	 * Plugin parameters
	 *
	 * @since 1.0.0
	 *
	 * @var array|mixed
	 */
	private $params;

	/**
	 * DVFAdminSettings constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		$this->save_changes();
		$this->params = DVF_Params::get_parameters();
		$this->render_page();
	}

	/**
	 * Render the settings page
	 *
	 * @since 1.0.0
	 */
	private function render_page() {
		$html = $this->make_tabs();

		$html .= $this->general_tab();
		$html .= $this->map_tab();

		echo $html;
	}

	/**
	 * Make head with tabs
	 *
	 * @since 1.0.1
	 *
	 * @return string
	 */
	private function make_tabs() {
		$html = '<nav class="nav-tab-wrapper dvf-tabs">
					<a href="#general" class="nav-tab nav-tab-active" >General</a>
					<a href="#map" class="nav-tab" >Map</a>
				</nav>';

		return $html;
	}

	/**
	 * Make all lines with parameters
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	private function general_tab() {
		$html = '<form method="post" name="' . DVF_Params::SLUG . 'general_form" id="general" >';
		$html .= '<table class="form-table"><tbody>';

		$html = $this->make_shortcode_line( $html );

		$html = $this->make_filters_line( $html );

		$html .= '</tbody></table>';

		$html .= '	<p class="submit">
					<input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes">
					</p>';

		$html .= '</form>';

		return $html;
	}

	/**
	 * Make content for 'Map' tab
	 *
	 * @since 1.0.5
	 *
	 * @return string
	 */
	private function map_tab() {
		$html = '<form method="post" name="' . DVF_Params::SLUG . 'map_form" id="map" class="dvf-hide" >';
		$html .= '<table class="form-table"><tbody>';

		$html = $this->make_map_shortcode_line( $html );

		$html = $this->make_google_api_key_line( $html );

		$html .= '</tbody></table>';

		$html .= '	<p class="submit">
					<input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes">
					</p>';

		$html .= '</form>';

		return $html;
	}

	/**
	 * Add shortcode tip to config page
	 *
	 * @since 1.0.0
	 *
	 * @param $html string
	 *
	 * @return string
	 */
	private function make_shortcode_line( $html ) {
		$html .= '<tr>
					<th scope="row"><label>Shortcode</label></th>
						<td>
							<p>
								<span id="utc-time"><code>[dvf-list]</code></span>
							</p>
							<p class="description" id="timezone-description">
								Use that shortcode for display list in post or page content
								                                                    </p>
						</td>
					</tr>';

		return $html;
	}

	/**
	 * Add shortcode to display map
	 *
	 * @since 1.0.5
	 *
	 * @param $html string
	 *
	 * @return string
	 */
	private function make_map_shortcode_line( $html ) {
		$html .= '<tr>
					<th scope="row"><label>Shortcode</label></th>
						<td>
							<p>
								<span id="utc-time"><code>[dvf-list map]</code></span>
							</p>
							<p class="description" id="timezone-description">
								Use that shortcode for display Google Map
							</p>
						</td>
					</tr>';

		return $html;
	}

	/**
	 * Add filters parameters to page
	 *
	 * @since 1.0.0
	 *
	 * @param $html string
	 *
	 * @return string
	 */
	private function make_filters_line( $html ) {
		$filters_params = isset( $this->params['filters'] ) ? $this->params['filters'] : array();

		$html .= '<tr>
					<th scope="row">Filters</th>
						<td>
							<fieldset>
								<legend class="screen-reader-text"><span>Filters</span></legend>';

		foreach ( DVF_Params::$fields as $key => $filter ) {
			if ( isset( $filters_params[ $key ] ) && $filters_params[ $key ] == DVF_Params::ACTIVE ) {
				$checked = true;
			} else {
				$checked = false;
			}

			$html .= '			<label><input type="checkbox" name="filters[' . $key . ']" value="' .
			         DVF_Params::ACTIVE . '" ' . ( $checked ? 'checked="checked"' : '' ) .
			         ' > <span class="date-time-text format-i18n">' . $filter . '</span></label><br>';
		}

		$html .= '
							</fieldset>
						</td>
						</tr>';

		return $html;
	}

	/**
	 * Add line to save Google Api key
	 *
	 * @since 1.0.5
	 *
	 * @param $html
	 *
	 * @return string
	 */
	private function make_google_api_key_line( $html ) {
		$google_key = isset( $this->params['google']['key'] ) ? $this->params['google']['key'] : '';

		$html .= '	<tr>
						<th scope="row"><label for="dvf-google-api-key">Google API key</label></th>
						<td>
							<input name="google_api_key" type="text" id="dvf-google-api-key" 
								value="' . $google_key . '" class="regular-text code" >
							<p class="description" id="home-description" >
	                          	For work need API key with enabled "Maps JavaScript API" and "Geocoding API". 
								<a href="https://developers.google.com/maps/documentation/javascript/get-api-key#get-the-api-key"
									target="_blank" >
									Where i can get it?
								</a>
	                        </p>
						</td>
					</tr>';

		return $html;
	}

	/**
	 * Save settings
	 *
	 * @since 1.0.0
	 */
	private function save_changes() {
		$params = array();

		if ( isset( $_POST['filters'] ) ) {
			$params['filters'] = array();

			foreach ( DVF_Params::$fields as $key => $filter ) {
				$filters[ $key ] = ( isset( $_POST['filters'][ $key ] )
				                     && $_POST['filters'][ $key ] == DVF_Params::ACTIVE ) ?
					DVF_Params::ACTIVE : DVF_Params::INACTIVE;
			}
		}

		if ( isset( $_POST['google_api_key'] ) ) {
			$params['google'] = array(
				'key' => sanitize_text_field( $_POST['google_api_key'] ),
			);
		}

		DVF_Params::update_parameters( $params );
	}

}

/**
 * Run DVFAdminSetting class
 *
 * @since 1.0.0
 *
 * @return DVF_Admin_Settings
 */
function dvf_admin_settings_runner() {
	return new DVF_Admin_Settings();
}

dvf_admin_settings_runner();