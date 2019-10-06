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
		$html .= $this->make_body();

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
					<a href="#" class="nav-tab nav-tab-active" >General</a>
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
	private function make_body() {
		$html = '<form method="post" name="' . DVF_Params::SLUG . 'form">';
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
	 * Save settings
	 *
	 * @since 1.0.0
	 */
	private function save_changes() {
		$filters = array();

		if ( isset( $_POST['filters'] ) ) {
			foreach ( DVF_Params::$fields as $key => $filter ) {
				$filters[ $key ] = ( isset( $_POST['filters'][ $key ] )
				                     && $_POST['filters'][ $key ] == DVF_Params::ACTIVE ) ?
					DVF_Params::ACTIVE : DVF_Params::INACTIVE;
			}
		}

		DVF_Params::update_parameters( array( 'filters' => $filters ) );
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