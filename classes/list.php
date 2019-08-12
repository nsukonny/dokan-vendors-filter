<?php

/**
 * Class for display list from Dokan Vendors Filter
 */

class DokanVendorsFilterList {

	/**
	 * DokanVendorsFilterList constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		add_action( 'wp_ajax_dokan_vendors_ajax_list', array( $this, 'dokan_vendors_ajax_list' ), 99 );
		add_action( 'wp_ajax_nopriv_dokan_vendors_ajax_list', array( $this, 'dokan_vendors_ajax_list' ), 99 );
		add_action( 'wp_enqueue_scripts', array( $this, 'add_scripts' ) );
		add_shortcode( 'dvf-list', array( $this, 'show_list' ) );
	}

	/**
	 * Load styles and scripts
	 *
	 * @since  1.0.0
	 */
	public function add_scripts() {
		wp_enqueue_style(
			'dokan-vendors-style',
			DOKAN_VF_PLUGIN_URL . 'assets/style.css',
			array(),
			DOKAN_VF_VERSION
		);
		wp_enqueue_script(
			'dokan-vendors-script',
			DOKAN_VF_PLUGIN_URL .
			'assets/scripts.js',
			array( 'jquery' ),
			DOKAN_VF_VERSION,
			true
		);

		wp_localize_script(
			'dokan-vendors-script',
			'DokanVendorsFilter',
			array(
				'ajaxUrl' => admin_url( 'admin-ajax.php' ),
			)
		);
	}

	public function show_list( $attrs ) {
		$html = '<div class="dvf-wrapper">';

		$html .= $this->get_header();

		$html .= $this->get_filters();

		$vendors = $this->get_vendors();

		if ( count( $vendors ) ) {
			$html .= '	<section class="dvf-items">';

			foreach ( $vendors as $vendor ) {
				$html .= $this->get_vendor_item( $vendor );
			}

			$html .= '	</section>';
		}

		$html .= $this->get_footer();

		$html .= '</div > ';

		return $html;
	}

	/**
	 * Make list header
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	private function get_header() {
		$html = '	<section class="dvf-head" >

				        <ul class="dvf-pages" >
				            <li ><span > Show</span ></li >
				            <li ><a href = "" class="active" ><span > 30</span ></a ></li >
				            <li ><a href = "" ><span > 60</span ></a ></li >
				            <li ><a href = "" ><span > 120</span ></a ></li >
				        </ul >
				
				        <ul class="dvf-pagination" >
				            <li ><a href = "" ><span ><</span ></a ></li >
				            <li ><a href = "" ><span > 1</span ></a ></li >
				            <li ><a href = "" class="active" ><span > 2</span ></a ></li >
				            <li ><a href = "" ><span > 3</span ></a ></li >
				            <li ><a href = "" ><span > 4</span ></a ></li >
				            <li ><a href = "" ><span > 5</span ></a ></li >
				            <li ><a href = "" ><span >></span ></a ></li >
				        </ul >
				
				        <div class="dvf-filter-button" >
				            <a href = "#" > Filter</a >
				        </div >
				
				    </section > ';

		return $html;
	}

	/**
	 * Get filters for list
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	private function get_filters() {

		$html = '	<section class="dvf-filter-section" >
						<form id="dokan-vendors-filters-form">';

		foreach ( DokanVendorsFilterParemeters::$fields as $key => $field ) {
			$meta_values = $this->get_meta_values( DokanVendorsFilterParemeters::SLUG . $key );

			if ( count( $meta_values ) ) {
				$html .= '	<div class="dvf-dropdown" >
			                <div class="dvf-dropdown-title" >' . $field . '</div >
			                <div class="dvf-dropdown-preview" >' . ( count( $meta_values ) > 1
						? 'All ' . $field : $meta_values[0]['title'] ) . ' <i class="arrow down"></i ></div >
			                <div class="dvf-dropdown-list" >';

				if ( count( $meta_values ) > 1 ) {
					$html .= '  <input type="checkbox" value="all" 
									name="' . DokanVendorsFilterParemeters::SLUG . $key . '[0]" 
									id="' . $key . '_all" >
								<label for="' . $key . '_all" >All ' . $field . ' </label >';
				}

				$i = 1;
				foreach ( $meta_values as $meta_value ) {
					$html .= '  <input type="checkbox" value="' . $meta_value['value'] . '" 
									name="' . DokanVendorsFilterParemeters::SLUG . $key . '[' . $i . ']" 
									id="' . $key . '_' . $i . '" >
								<label for="' . $key . '_' . $i . '" >' . $meta_value['title'] . '</label >';
					$i ++;
				}

				$html .= '	    </div>
	                    </div>';
			}
		}
		$html .= '		</form>
						<div class="clear" ></div >
					</section>';

		return $html;
	}

	/**
	 * Make list footer
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	private function get_footer() {
		$html = '	<section class="dvf-footer" >

				        <ul class="dvf-pages" >
				            <li ><span > Show</span ></li >
				            <li ><a href = "" class="active" ><span > 30</span ></a ></li >
				            <li ><a href = "" ><span > 60</span ></a ></li >
				            <li ><a href = "" ><span > 120</span ></a ></li >
				        </ul >
				
				        <ul class="dvf-pagination" >
				            <li ><a href = "" ><span ><</span ></a ></li >
				            <li ><a href = "" ><span > 1</span ></a ></li >
				            <li ><a href = "" class="active" ><span > 2</span ></a ></li >
				            <li ><a href = "" ><span > 3</span ></a ></li >
				            <li ><a href = "" ><span > 4</span ></a ></li >
				            <li ><a href = "" ><span > 5</span ></a ></li >
				            <li ><a href = "" ><span >></span ></a ></li >
				        </ul >
				
				    </section > ';

		return $html;
	}

	/**
	 * Get vendors from dokan by current filters
	 *
	 * @since 1.0.0
	 *
	 * @return mixed|array
	 */
	private function get_vendors() {
		$args['meta_query'] = array(
			'relation' => 'OR',
			array(
				'key'     => DokanVendorsFilterParemeters::SLUG . 'city',
				'value'   => array( 'Moskow', 'Rovenki' ),
				'compare' => 'IN',
			),
			array(
				'key'     => DokanVendorsFilterParemeters::SLUG . 'country',
				'value'   => array( 'RU', 'UA' ),
				'compare' => 'IN',
			),
		);

		$results = [];
		$vendors = dokan_get_sellers( $args );

		foreach ( $vendors['users'] as $vendor ) {
			$store_info  = dokan_get_store_info( $vendor->data->ID );
			$description = get_user_meta( $vendor->data->ID, 'description', true );

			if ( strlen( $description ) > 65 ) {
				$description = substr( $description, 0, 65 ) . '...';
			}

			$results[] = array(
				'store_id'    => $vendor->data->ID,
				'store_url'   => dokan_get_store_url( $vendor->data->ID ),
				'store_name'  => $store_info['store_name'],
				'description' => $description,
				'phone'       => $store_info['phone'],
			);
		}

		return $results;
	}

	/**
	 * Make vendor item HTML block
	 *
	 * @since 1.0.0
	 *
	 * @param $vendor
	 *
	 * @return string
	 */
	private function get_vendor_item( $vendor ) {
		$html = '	<div class="dvf-item" >
			            <a href="' . $vendor['store_url'] . '" class="dvf-thumb" >
			            <span class="dvf-show-more" > More details </span >
			            <img src = "' . DOKAN_VF_PLUGIN_URL . 'assets/img/example1.png" title = "" alt = "" >
			            </a >
			            <div class="dvf-item-description" >
			                <a href="' . $vendor['store_url'] . '" class="dvf-item-title" > 
			                    ' . $vendor['store_name'] . '
		                    </a >
			                <div class="dvf_item_address" >' . $vendor['description'] . '</div >
			                <div class="dvf-item-phone" >' . $vendor['phone'] . '</div >
			            </div >
		            </div >';

		return $html;
	}

	/**
	 * Get all isset meta values
	 *
	 * @since 1.0.0
	 *
	 * @param string $key
	 *
	 * @return array|void
	 */
	private function get_meta_values( $key = '' ) {
		if ( empty( $key ) ) {
			return;
		}

		global $wpdb;

		$results = $wpdb->get_col(
			$wpdb->prepare( "SELECT um.meta_value FROM {$wpdb->usermeta} um WHERE um.meta_key = %s", $key )
		);

		return $this->prepare_meta_titles( $results, $key );
	}

	/**
	 * Add titles with country names and other
	 *
	 * @since 1.0.0
	 *
	 * @param $meta_values
	 * @param $key
	 *
	 * @return array
	 */
	private function prepare_meta_titles( $meta_values, $key ) {
		$results = [];
		$titles  = [];

		if ( $key == DokanVendorsFilterParemeters::SLUG . DokanVendorsFilterParemeters::FIELD_COUNTRY ) {
			$titles = WC()->countries->get_allowed_countries();
		}

		foreach ( $meta_values as $meta_value ) {
			$results[] = array(
				'value' => $meta_value,
				'title' => isset( $titles[ $meta_value ] ) ? $titles[ $meta_value ] : $meta_value,
			);
		}

		return $results;
	}

	/**
	 * Return vendors list by filtering and pagination
	 *
	 * @since 1.0.0
	 */
	public function dokan_vendors_ajax_list() {
		ob_clean();

		parse_str( $_POST['data'], $postdata );

		$vendors = $this->get_vendors();

		if ( count( $vendors ) ) {
			$html = '';

			foreach ( $vendors as $vendor ) {
				$html .= $this->get_vendor_item( $vendor );
			}

			wp_send_json_success( $html );
		}
		
		wp_die();
	}
}

/**
 * Run DokanVendorsFilterAdmin class
 *
 * @since 1.0.0
 *
 * @return DokanVendorsFilterList
 */
function dokan_vendors_filter_list_runner() {
	return new DokanVendorsFilterList();
}

dokan_vendors_filter_list_runner();