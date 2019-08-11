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
		add_action( 'wp_enqueue_scripts', array( $this, 'add_scripts' ) );
		add_shortcode( 'dvf-list', array( $this, 'show_list' ) );
	}

	/**
	 * Load styles and scripts
	 *
	 * @since  1.0.0
	 */
	public function add_scripts() {
		wp_enqueue_style( 'dokan-vendors-style', DOKAN_VF_PLUGIN_URL . 'assets/style.css', array(), DOKAN_VF_VERSION );
		wp_enqueue_script( 'dokan-vendors-script', DOKAN_VF_PLUGIN_URL . 'assets/scripts.js', array( 'jquery' ), DOKAN_VF_VERSION, true );
	}

	public function show_list( $attrs ) {
		$html = '<div class="dvf-wrapper">';

		$html .= $this->get_header();

		$html .= $this->get_filters();

		$vendors = $this->get_vendors();

		if ( count( $vendors ) ) {
			$html .= '	<section class="dvf-items">';

			foreach ( $vendors as $vendor ) {
				$html .= '	<div class="dvf-item" >
					            <a href="' . $vendor['store_url'] . '" class="dvf-thumb" >
					                <span class="dvf-show-more" > More details </span >
					                <img src = "' . DOKAN_VF_PLUGIN_URL . 'assets/img/example1.png" title = "" alt = "" >
					            </a >
					            <div class="dvf-item-description" >
					                <a href="' . $vendor['store_url'] . '" class="dvf-item-title" > ' . $vendor['store_name'] . '</a >
					                <div class="dvf_item_address" >' . $vendor['description'] . '</div >
					                <div class="dvf-item-phone" >' . $vendor['phone'] . '</div >
					            </div >
				        	</div >';
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
		$html = '<section class="dvf-filter-section" >
			        <form action = "" method = "post" >
			            <div class="dvf-dropdown" >
			                <div class="dvf-dropdown-title" > Country</div >
			                <div class="dvf-dropdown-preview" > All city < i class="arrow down" ></i ></div >
			                <div class="dvf-dropdown-list" >
			                    <input type = "checkbox" value = "all" id = "city_1" >
			                    <label for="city_1" > All city </label >
			                    <input type = "checkbox" id = "city_2" >
			                    <label for="city_2" > Berlin</label >
			                    <input type = "checkbox" id = "city_3" >
			                    <label for="city_3" > New York</label >
			                    <input type = "checkbox" id = "city_4" checked = "checked" >
			                    <label for="city_4" > Berlin</label >
			                    <input type = "checkbox" id = "city_5" >
			                    <label for="city_5" > New York </label >
			                    <input type = "checkbox" id = "city_6" >
			                    <label for="city_6" > Berlin </label >
			                    <input type = "checkbox" id = "city_7" >
			                    <label for="city_7" > New York </label >
			                    <input type = "checkbox" id = "city_8" >
			                    <label for="city_8" > Berlin </label >
			                    <input type = "checkbox" id = "city_9" >
			                    <label for="city_9" > New York </label >
			                    <input type = "checkbox" id = "city_10" >
			                    <label for="city_10" > Berlin </label >
			                    <input type = "checkbox" id = "city_11" >
			                    <label for="city_11" > New York </label >
			                    <input type = "checkbox" id = "city_12" >
			                    <label for="city_12" > Berlin </label >
			                    <input type = "checkbox" id = "city_13" >
			                    <label for="city_13" > New York </label >
			                </div >
			            </div >
			
			            <div class="dvf-dropdown" >
			                <div class="dvf-dropdown-title" > Country</div >
			                <div class="dvf-dropdown-preview" > All city < i class="arrow down" ></i ></div >
			                <div class="dvf-dropdown-list" >
			                    <input type = "checkbox" value = "all" id = "city_12" >
			                    <label for="city_12" > All city </label >
			                    <input type = "checkbox" id = "city_22" >
			                    <label for="city_22" > Berlin</label >
			                    <input type = "checkbox" id = "city_32" >
			                    <label for="city_32" > New York</label >
			                    <input type = "checkbox" id = "city_42" checked = "checked" >
			                    <label for="city_42" > Berlin</label >
			                    <input type = "checkbox" id = "city_52" >
			                    <label for="city_52" > New York </label >
			                    <input type = "checkbox" id = "city_62" >
			                    <label for="city_62" > Berlin </label >
			                    <input type = "checkbox" id = "city_72" >
			                    <label for="city_72" > New York </label >
			                    <input type = "checkbox" id = "city_82" >
			                    <label for="city_82" > Berlin </label >
			                    <input type = "checkbox" id = "city_92" >
			                    <label for="city_92" > New York </label >
			                    <input type = "checkbox" id = "city_102" >
			                    <label for="city_102" > Berlin </label >
			                    <input type = "checkbox" id = "city_112" >
			                    <label for="city_112" > New York </label >
			                    <input type = "checkbox" id = "city_122" >
			                    <label for="city_122" > Berlin </label >
			                    <input type = "checkbox" id = "city_132" >
			                    <label for="city_132" > New York </label >
			                </div >
			            </div >
			
			            <div class="dvf-dropdown" >
			                <div class="dvf-dropdown-title" > Country</div >
			                <div class="dvf-dropdown-preview" > All city < i class="arrow down" ></i ></div >
			                <div class="dvf-dropdown-list" >
			                    <input type = "checkbox" value = "all" id = "city_1" >
			                    <label for="city_1" > All city </label >
			                    <input type = "checkbox" id = "city_2" >
			                    <label for="city_2" > Berlin</label >
			                    <input type = "checkbox" id = "city_3" >
			                    <label for="city_3" > New York</label >
			                    <input type = "checkbox" id = "city_4" checked = "checked" >
			                    <label for="city_4" > Berlin</label >
			                    <input type = "checkbox" id = "city_5" >
			                    <label for="city_5" > New York </label >
			                    <input type = "checkbox" id = "city_6" >
			                    <label for="city_6" > Berlin </label >
			                    <input type = "checkbox" id = "city_7" >
			                    <label for="city_7" > New York </label >
			                    <input type = "checkbox" id = "city_8" >
			                    <label for="city_8" > Berlin </label >
			                    <input type = "checkbox" id = "city_9" >
			                    <label for="city_9" > New York </label >
			                    <input type = "checkbox" id = "city_10" >
			                    <label for="city_10" > Berlin </label >
			                    <input type = "checkbox" id = "city_11" >
			                    <label for="city_11" > New York </label >
			                    <input type = "checkbox" id = "city_12" >
			                    <label for="city_12" > Berlin </label >
			                    <input type = "checkbox" id = "city_13" >
			                    <label for="city_13" > New York </label >
			                </div >
			            </div >
			
			            <div class="dvf-dropdown" >
			                <div class="dvf-dropdown-title" > Country</div >
			                <div class="dvf-dropdown-preview" > All city < i class="arrow down" ></i ></div >
			                <div class="dvf-dropdown-list" >
			                    <input type = "checkbox" value = "all" id = "city_1" >
			                    <label for="city_1" > All city </label >
			                    <input type = "checkbox" id = "city_2" >
			                    <label for="city_2" > Berlin</label >
			                    <input type = "checkbox" id = "city_3" >
			                    <label for="city_3" > New York</label >
			                    <input type = "checkbox" id = "city_4" checked = "checked" >
			                    <label for="city_4" > Berlin</label >
			                    <input type = "checkbox" id = "city_5" >
			                    <label for="city_5" > New York </label >
			                    <input type = "checkbox" id = "city_6" >
			                    <label for="city_6" > Berlin </label >
			                    <input type = "checkbox" id = "city_7" >
			                    <label for="city_7" > New York </label >
			                    <input type = "checkbox" id = "city_8" >
			                    <label for="city_8" > Berlin </label >
			                    <input type = "checkbox" id = "city_9" >
			                    <label for="city_9" > New York </label >
			                    <input type = "checkbox" id = "city_10" >
			                    <label for="city_10" > Berlin </label >
			                    <input type = "checkbox" id = "city_11" >
			                    <label for="city_11" > New York </label >
			                    <input type = "checkbox" id = "city_12" >
			                    <label for="city_12" > Berlin </label >
			                    <input type = "checkbox" id = "city_13" >
			                    <label for="city_13" > New York </label >
			                </div >
			            </div >
			
			            <div class="dvf-dropdown" >
			                <div class="dvf-dropdown-title" > Country</div >
			                <div class="dvf-dropdown-preview" > All city < i class="arrow down" ></i ></div >
			                <div class="dvf-dropdown-list" >
			                    <input type = "checkbox" value = "all" id = "city_13" >
			                    <label for="city_13" > All city </label >
			                    <input type = "checkbox" id = "city_23" >
			                    <label for="city_23" > Berlin</label >
			                    <input type = "checkbox" id = "city_33" >
			                    <label for="city_33" > New York</label >
			                    <input type = "checkbox" id = "city_43" checked = "checked" >
			                    <label for="city_43" > Berlin</label >
			                    <input type = "checkbox" id = "city_53" >
			                    <label for="city_53" > New York </label >
			                    <input type = "checkbox" id = "city_63" >
			                    <label for="city_63" > Berlin </label >
			                    <input type = "checkbox" id = "city_73" >
			                    <label for="city_73" > New York </label >
			                    <input type = "checkbox" id = "city_83" >
			                    <label for="city_83" > Berlin </label >
			                    <input type = "checkbox" id = "city_93" >
			                    <label for="city_93" > New York </label >
			                    <input type = "checkbox" id = "city_103" >
			                    <label for="city_103" > Berlin </label >
			                    <input type = "checkbox" id = "city_113" >
			                    <label for="city_113" > New York </label >
			                    <input type = "checkbox" id = "city_123" >
			                    <label for="city_123" > Berlin </label >
			                    <input type = "checkbox" id = "city_133" >
			                    <label for="city_133" > New York </label >
			                </div >
			            </div >
			
			            <div class="dvf-dropdown" >
			                <div class="dvf-dropdown-title" > Country</div >
			                <div class="dvf-dropdown-preview" > All city < i class="arrow down" ></i ></div >
			                <div class="dvf-dropdown-list" >
			                    <input type = "checkbox" value = "all" id = "city_1" >
			                    <label for="city_1" > All city </label >
			                    <input type = "checkbox" id = "city_2" >
			                    <label for="city_2" > Berlin</label >
			                    <input type = "checkbox" id = "city_3" >
			                    <label for="city_3" > New York</label >
			                    <input type = "checkbox" id = "city_4" checked = "checked" >
			                    <label for="city_4" > Berlin</label >
			                    <input type = "checkbox" id = "city_5" >
			                    <label for="city_5" > New York </label >
			                    <input type = "checkbox" id = "city_6" >
			                    <label for="city_6" > Berlin </label >
			                    <input type = "checkbox" id = "city_7" >
			                    <label for="city_7" > New York </label >
			                    <input type = "checkbox" id = "city_8" >
			                    <label for="city_8" > Berlin </label >
			                    <input type = "checkbox" id = "city_9" >
			                    <label for="city_9" > New York </label >
			                    <input type = "checkbox" id = "city_10" >
			                    <label for="city_10" > Berlin </label >
			                    <input type = "checkbox" id = "city_11" >
			                    <label for="city_11" > New York </label >
			                    <input type = "checkbox" id = "city_12" >
			                    <label for="city_12" > Berlin </label >
			                    <input type = "checkbox" id = "city_13" >
			                    <label for="city_13" > New York </label >
			                </div >
			            </div >
			
			            <div class="dvf-dropdown" >
			                <div class="dvf-dropdown-title" > Country</div >
			                <div class="dvf-dropdown-preview" > All city < i class="arrow down" ></i ></div >
			                <div class="dvf-dropdown-list" >
			                    <input type = "checkbox" value = "all" id = "city_1" >
			                    <label for="city_1" > All city </label >
			                    <input type = "checkbox" id = "city_2" >
			                    <label for="city_2" > Berlin</label >
			                    <input type = "checkbox" id = "city_3" >
			                    <label for="city_3" > New York</label >
			                    <input type = "checkbox" id = "city_4" checked = "checked" >
			                    <label for="city_4" > Berlin</label >
			                    <input type = "checkbox" id = "city_5" >
			                    <label for="city_5" > New York </label >
			                    <input type = "checkbox" id = "city_6" >
			                    <label for="city_6" > Berlin </label >
			                    <input type = "checkbox" id = "city_7" >
			                    <label for="city_7" > New York </label >
			                    <input type = "checkbox" id = "city_8" >
			                    <label for="city_8" > Berlin </label >
			                    <input type = "checkbox" id = "city_9" >
			                    <label for="city_9" > New York </label >
			                    <input type = "checkbox" id = "city_10" >
			                    <label for="city_10" > Berlin </label >
			                    <input type = "checkbox" id = "city_11" >
			                    <label for="city_11" > New York </label >
			                    <input type = "checkbox" id = "city_12" >
			                    <label for="city_12" > Berlin </label >
			                    <input type = "checkbox" id = "city_13" >
			                    <label for="city_13" > New York </label >
			                </div >
			            </div >
			
			            <div class="dvf-dropdown" >
			                <div class="dvf-dropdown-title" > Country</div >
			                <div class="dvf-dropdown-preview" > All city < i class="arrow down" ></i ></div >
			                <div class="dvf-dropdown-list" >
			                    <input type = "checkbox" value = "all" id = "city_1" >
			                    <label for="city_1" > All city </label >
			                    <input type = "checkbox" id = "city_2" >
			                    <label for="city_2" > Berlin</label >
			                    <input type = "checkbox" id = "city_3" >
			                    <label for="city_3" > New York</label >
			                    <input type = "checkbox" id = "city_4" checked = "checked" >
			                    <label for="city_4" > Berlin</label >
			                    <input type = "checkbox" id = "city_5" >
			                    <label for="city_5" > New York </label >
			                    <input type = "checkbox" id = "city_6" >
			                    <label for="city_6" > Berlin </label >
			                    <input type = "checkbox" id = "city_7" >
			                    <label for="city_7" > New York </label >
			                    <input type = "checkbox" id = "city_8" >
			                    <label for="city_8" > Berlin </label >
			                    <input type = "checkbox" id = "city_9" >
			                    <label for="city_9" > New York </label >
			                    <input type = "checkbox" id = "city_10" >
			                    <label for="city_10" > Berlin </label >
			                    <input type = "checkbox" id = "city_11" >
			                    <label for="city_11" > New York </label >
			                    <input type = "checkbox" id = "city_12" >
			                    <label for="city_12" > Berlin </label >
			                    <input type = "checkbox" id = "city_13" >
			                    <label for="city_13" > New York </label >
			                </div >
			            </div >
			
			            <div class="dvf-dropdown" >
			                <div class="dvf-dropdown-title" > Country</div >
			                <div class="dvf-dropdown-preview" > All city < i class="arrow down" ></i ></div >
			                <div class="dvf-dropdown-list" >
			                    <input type = "checkbox" value = "all" id = "city_1" >
			                    <label for="city_1" > All city </label >
			                    <input type = "checkbox" id = "city_2" >
			                    <label for="city_2" > Berlin</label >
			                    <input type = "checkbox" id = "city_3" >
			                    <label for="city_3" > New York</label >
			                    <input type = "checkbox" id = "city_4" checked = "checked" >
			                    <label for="city_4" > Berlin</label >
			                    <input type = "checkbox" id = "city_5" >
			                    <label for="city_5" > New York </label >
			                    <input type = "checkbox" id = "city_6" >
			                    <label for="city_6" > Berlin </label >
			                    <input type = "checkbox" id = "city_7" >
			                    <label for="city_7" > New York </label >
			                    <input type = "checkbox" id = "city_8" >
			                    <label for="city_8" > Berlin </label >
			                    <input type = "checkbox" id = "city_9" >
			                    <label for="city_9" > New York </label >
			                    <input type = "checkbox" id = "city_10" >
			                    <label for="city_10" > Berlin </label >
			                    <input type = "checkbox" id = "city_11" >
			                    <label for="city_11" > New York </label >
			                    <input type = "checkbox" id = "city_12" >
			                    <label for="city_12" > Berlin </label >
			                    <input type = "checkbox" id = "city_13" >
			                    <label for="city_13" > New York </label >
			                </div >
			            </div >
			
			            <div class="dvf-dropdown" >
			                <div class="dvf-dropdown-title" > Country</div >
			                <div class="dvf-dropdown-preview" > All city < i class="arrow down" ></i ></div >
			                <div class="dvf-dropdown-list" >
			                    <input type = "checkbox" value = "all" id = "city_1" >
			                    <label for="city_1" > All city </label >
			                    <input type = "checkbox" id = "city_2" >
			                    <label for="city_2" > Berlin</label >
			                    <input type = "checkbox" id = "city_3" >
			                    <label for="city_3" > New York</label >
			                    <input type = "checkbox" id = "city_4" checked = "checked" >
			                    <label for="city_4" > Berlin</label >
			                    <input type = "checkbox" id = "city_5" >
			                    <label for="city_5" > New York </label >
			                    <input type = "checkbox" id = "city_6" >
			                    <label for="city_6" > Berlin </label >
			                    <input type = "checkbox" id = "city_7" >
			                    <label for="city_7" > New York </label >
			                    <input type = "checkbox" id = "city_8" >
			                    <label for="city_8" > Berlin </label >
			                    <input type = "checkbox" id = "city_9" >
			                    <label for="city_9" > New York </label >
			                    <input type = "checkbox" id = "city_10" >
			                    <label for="city_10" > Berlin </label >
			                    <input type = "checkbox" id = "city_11" >
			                    <label for="city_11" > New York </label >
			                    <input type = "checkbox" id = "city_12" >
			                    <label for="city_12" > Berlin </label >
			                    <input type = "checkbox" id = "city_13" >
			                    <label for="city_13" > New York </label >
			                </div >
			            </div >
			
			            <div class="dvf-dropdown" >
			                <div class="dvf-dropdown-title" > Country</div >
			                <div class="dvf-dropdown-preview" > All city < i class="arrow down" ></i ></div >
			                <div class="dvf-dropdown-list" >
			                    <input type = "checkbox" value = "all" id = "city_1" >
			                    <label for="city_1" > All city </label >
			                    <input type = "checkbox" id = "city_2" >
			                    <label for="city_2" > Berlin</label >
			                    <input type = "checkbox" id = "city_3" >
			                    <label for="city_3" > New York</label >
			                    <input type = "checkbox" id = "city_4" checked = "checked" >
			                    <label for="city_4" > Berlin</label >
			                    <input type = "checkbox" id = "city_5" >
			                    <label for="city_5" > New York </label >
			                    <input type = "checkbox" id = "city_6" >
			                    <label for="city_6" > Berlin </label >
			                    <input type = "checkbox" id = "city_7" >
			                    <label for="city_7" > New York </label >
			                    <input type = "checkbox" id = "city_8" >
			                    <label for="city_8" > Berlin </label >
			                    <input type = "checkbox" id = "city_9" >
			                    <label for="city_9" > New York </label >
			                    <input type = "checkbox" id = "city_10" >
			                    <label for="city_10" > Berlin </label >
			                    <input type = "checkbox" id = "city_11" >
			                    <label for="city_11" > New York </label >
			                    <input type = "checkbox" id = "city_12" >
			                    <label for="city_12" > Berlin </label >
			                    <input type = "checkbox" id = "city_13" >
			                    <label for="city_13" > New York </label >
			                </div >
			            </div >
			
			            <div class="dvf-dropdown" >
			                <div class="dvf-dropdown-title" > Country</div >
			                <div class="dvf-dropdown-preview" > All city < i class="arrow down" ></i ></div >
			                <div class="dvf-dropdown-list" >
			                    <input type = "checkbox" value = "all" id = "city_1" >
			                    <label for="city_1" > All city </label >
			                    <input type = "checkbox" id = "city_2" >
			                    <label for="city_2" > Berlin</label >
			                    <input type = "checkbox" id = "city_3" >
			                    <label for="city_3" > New York</label >
			                    <input type = "checkbox" id = "city_4" checked = "checked" >
			                    <label for="city_4" > Berlin</label >
			                    <input type = "checkbox" id = "city_5" >
			                    <label for="city_5" > New York </label >
			                    <input type = "checkbox" id = "city_6" >
			                    <label for="city_6" > Berlin </label >
			                    <input type = "checkbox" id = "city_7" >
			                    <label for="city_7" > New York </label >
			                    <input type = "checkbox" id = "city_8" >
			                    <label for="city_8" > Berlin </label >
			                    <input type = "checkbox" id = "city_9" >
			                    <label for="city_9" > New York </label >
			                    <input type = "checkbox" id = "city_10" >
			                    <label for="city_10" > Berlin </label >
			                    <input type = "checkbox" id = "city_11" >
			                    <label for="city_11" > New York </label >
			                    <input type = "checkbox" id = "city_12" >
			                    <label for="city_12" > Berlin </label >
			                    <input type = "checkbox" id = "city_13" >
			                    <label for="city_13" > New York </label >
			                </div >
			            </div >
			
			            <div class="dvf-dropdown" >
			                <div class="dvf-dropdown-title" > Country</div >
			                <div class="dvf-dropdown-preview" > All city < i class="arrow down" ></i ></div >
			                <div class="dvf-dropdown-list" >
			                    <input type = "checkbox" value = "all" id = "city_1" >
			                    <label for="city_1" > All city </label >
			                    <input type = "checkbox" id = "city_2" >
			                    <label for="city_2" > Berlin</label >
			                    <input type = "checkbox" id = "city_3" >
			                    <label for="city_3" > New York</label >
			                    <input type = "checkbox" id = "city_4" checked = "checked" >
			                    <label for="city_4" > Berlin</label >
			                    <input type = "checkbox" id = "city_5" >
			                    <label for="city_5" > New York </label >
			                    <input type = "checkbox" id = "city_6" >
			                    <label for="city_6" > Berlin </label >
			                    <input type = "checkbox" id = "city_7" >
			                    <label for="city_7" > New York </label >
			                    <input type = "checkbox" id = "city_8" >
			                    <label for="city_8" > Berlin </label >
			                    <input type = "checkbox" id = "city_9" >
			                    <label for="city_9" > New York </label >
			                    <input type = "checkbox" id = "city_10" >
			                    <label for="city_10" > Berlin </label >
			                    <input type = "checkbox" id = "city_11" >
			                    <label for="city_11" > New York </label >
			                    <input type = "checkbox" id = "city_12" >
			                    <label for="city_12" > Berlin </label >
			                    <input type = "checkbox" id = "city_13" >
			                    <label for="city_13" > New York </label >
			                </div >
			            </div >
			
			            <div class="dvf-dropdown" >
			                <div class="dvf-dropdown-title" > Country</div >
			                <div class="dvf-dropdown-preview" > All city < i class="arrow down" ></i ></div >
			                <div class="dvf-dropdown-list" >
			                    <input type = "checkbox" value = "all" id = "city_1" >
			                    <label for="city_1" > All city </label >
			                    <input type = "checkbox" id = "city_2" >
			                    <label for="city_2" > Berlin</label >
			                    <input type = "checkbox" id = "city_3" >
			                    <label for="city_3" > New York</label >
			                    <input type = "checkbox" id = "city_4" checked = "checked" >
			                    <label for="city_4" > Berlin</label >
			                    <input type = "checkbox" id = "city_5" >
			                    <label for="city_5" > New York </label >
			                    <input type = "checkbox" id = "city_6" >
			                    <label for="city_6" > Berlin </label >
			                    <input type = "checkbox" id = "city_7" >
			                    <label for="city_7" > New York </label >
			                    <input type = "checkbox" id = "city_8" >
			                    <label for="city_8" > Berlin </label >
			                    <input type = "checkbox" id = "city_9" >
			                    <label for="city_9" > New York </label >
			                    <input type = "checkbox" id = "city_10" >
			                    <label for="city_10" > Berlin </label >
			                    <input type = "checkbox" id = "city_11" >
			                    <label for="city_11" > New York </label >
			                    <input type = "checkbox" id = "city_12" >
			                    <label for="city_12" > Berlin </label >
			                    <input type = "checkbox" id = "city_13" >
			                    <label for="city_13" > New York </label >
			                </div >
			            </div >
			
			            <div class="dvf-dropdown" >
			                <div class="dvf-dropdown-title" > Country</div >
			                <div class="dvf-dropdown-preview" > All city < i class="arrow down" ></i ></div >
			                <div class="dvf-dropdown-list" >
			                    <input type = "checkbox" value = "all" id = "city_1" >
			                    <label for="city_1" > All city </label >
			                    <input type = "checkbox" id = "city_2" >
			                    <label for="city_2" > Berlin</label >
			                    <input type = "checkbox" id = "city_3" >
			                    <label for="city_3" > New York</label >
			                    <input type = "checkbox" id = "city_4" checked = "checked" >
			                    <label for="city_4" > Berlin</label >
			                    <input type = "checkbox" id = "city_5" >
			                    <label for="city_5" > New York </label >
			                    <input type = "checkbox" id = "city_6" >
			                    <label for="city_6" > Berlin </label >
			                    <input type = "checkbox" id = "city_7" >
			                    <label for="city_7" > New York </label >
			                    <input type = "checkbox" id = "city_8" >
			                    <label for="city_8" > Berlin </label >
			                    <input type = "checkbox" id = "city_9" >
			                    <label for="city_9" > New York </label >
			                    <input type = "checkbox" id = "city_10" >
			                    <label for="city_10" > Berlin </label >
			                    <input type = "checkbox" id = "city_11" >
			                    <label for="city_11" > New York </label >
			                    <input type = "checkbox" id = "city_12" >
			                    <label for="city_12" > Berlin </label >
			                    <input type = "checkbox" id = "city_13" >
			                    <label for="city_13" > New York </label >
			                </div >
			            </div >
			
			            <div class="dvf-dropdown" >
			                <div class="dvf-dropdown-title" > Country</div >
			                <div class="dvf-dropdown-preview" > All city < i class="arrow down" ></i ></div >
			                <div class="dvf-dropdown-list" >
			                    <input type = "checkbox" value = "all" id = "city_1" >
			                    <label for="city_1" > All city </label >
			                    <input type = "checkbox" id = "city_2" >
			                    <label for="city_2" > Berlin</label >
			                    <input type = "checkbox" id = "city_3" >
			                    <label for="city_3" > New York</label >
			                    <input type = "checkbox" id = "city_4" checked = "checked" >
			                    <label for="city_4" > Berlin</label >
			                    <input type = "checkbox" id = "city_5" >
			                    <label for="city_5" > New York </label >
			                    <input type = "checkbox" id = "city_6" >
			                    <label for="city_6" > Berlin </label >
			                    <input type = "checkbox" id = "city_7" >
			                    <label for="city_7" > New York </label >
			                    <input type = "checkbox" id = "city_8" >
			                    <label for="city_8" > Berlin </label >
			                    <input type = "checkbox" id = "city_9" >
			                    <label for="city_9" > New York </label >
			                    <input type = "checkbox" id = "city_10" >
			                    <label for="city_10" > Berlin </label >
			                    <input type = "checkbox" id = "city_11" >
			                    <label for="city_11" > New York </label >
			                    <input type = "checkbox" id = "city_12" >
			                    <label for="city_12" > Berlin </label >
			                    <input type = "checkbox" id = "city_13" >
			                    <label for="city_13" > New York </label >
			                </div >
			            </div >
			
			            <div class="dvf-dropdown" >
			                <div class="dvf-dropdown-title" > Country</div >
			                <div class="dvf-dropdown-preview" > All city < i class="arrow down" ></i ></div >
			                <div class="dvf-dropdown-list" >
			                    <input type = "checkbox" value = "all" id = "city_1" >
			                    <label for="city_1" > All city </label >
			                    <input type = "checkbox" id = "city_2" >
			                    <label for="city_2" > Berlin</label >
			                    <input type = "checkbox" id = "city_3" >
			                    <label for="city_3" > New York</label >
			                    <input type = "checkbox" id = "city_4" checked = "checked" >
			                    <label for="city_4" > Berlin</label >
			                    <input type = "checkbox" id = "city_5" >
			                    <label for="city_5" > New York </label >
			                    <input type = "checkbox" id = "city_6" >
			                    <label for="city_6" > Berlin </label >
			                    <input type = "checkbox" id = "city_7" >
			                    <label for="city_7" > New York </label >
			                    <input type = "checkbox" id = "city_8" >
			                    <label for="city_8" > Berlin </label >
			                    <input type = "checkbox" id = "city_9" >
			                    <label for="city_9" > New York </label >
			                    <input type = "checkbox" id = "city_10" >
			                    <label for="city_10" > Berlin </label >
			                    <input type = "checkbox" id = "city_11" >
			                    <label for="city_11" > New York </label >
			                    <input type = "checkbox" id = "city_12" >
			                    <label for="city_12" > Berlin </label >
			                    <input type = "checkbox" id = "city_13" >
			                    <label for="city_13" > New York </label >
			                </div >
			            </div >
			
			            <div class="dvf-dropdown" >
			                <div class="dvf-dropdown-title" > Country</div >
			                <div class="dvf-dropdown-preview" > All city < i class="arrow down" ></i ></div >
			                <div class="dvf-dropdown-list" >
			                    <input type = "checkbox" value = "all" id = "city_1" >
			                    <label for="city_1" > All city </label >
			                    <input type = "checkbox" id = "city_2" >
			                    <label for="city_2" > Berlin</label >
			                    <input type = "checkbox" id = "city_3" >
			                    <label for="city_3" > New York</label >
			                    <input type = "checkbox" id = "city_4" checked = "checked" >
			                    <label for="city_4" > Berlin</label >
			                    <input type = "checkbox" id = "city_5" >
			                    <label for="city_5" > New York </label >
			                    <input type = "checkbox" id = "city_6" >
			                    <label for="city_6" > Berlin </label >
			                    <input type = "checkbox" id = "city_7" >
			                    <label for="city_7" > New York </label >
			                    <input type = "checkbox" id = "city_8" >
			                    <label for="city_8" > Berlin </label >
			                    <input type = "checkbox" id = "city_9" >
			                    <label for="city_9" > New York </label >
			                    <input type = "checkbox" id = "city_10" >
			                    <label for="city_10" > Berlin </label >
			                    <input type = "checkbox" id = "city_11" >
			                    <label for="city_11" > New York </label >
			                    <input type = "checkbox" id = "city_12" >
			                    <label for="city_12" > Berlin </label >
			                    <input type = "checkbox" id = "city_13" >
			                    <label for="city_13" > New York </label >
			                </div >
			            </div >
			
			            <div class="dvf-dropdown" >
			                <div class="dvf-dropdown-title" > Country</div >
			                <div class="dvf-dropdown-preview" > All city < i class="arrow down" ></i ></div >
			                <div class="dvf-dropdown-list" >
			                    <input type = "checkbox" value = "all" id = "city_1" >
			                    <label for="city_1" > All city </label >
			                    <input type = "checkbox" id = "city_2" >
			                    <label for="city_2" > Berlin</label >
			                    <input type = "checkbox" id = "city_3" >
			                    <label for="city_3" > New York</label >
			                    <input type = "checkbox" id = "city_4" checked = "checked" >
			                    <label for="city_4" > Berlin</label >
			                    <input type = "checkbox" id = "city_5" >
			                    <label for="city_5" > New York </label >
			                    <input type = "checkbox" id = "city_6" >
			                    <label for="city_6" > Berlin </label >
			                    <input type = "checkbox" id = "city_7" >
			                    <label for="city_7" > New York </label >
			                    <input type = "checkbox" id = "city_8" >
			                    <label for="city_8" > Berlin </label >
			                    <input type = "checkbox" id = "city_9" >
			                    <label for="city_9" > New York </label >
			                    <input type = "checkbox" id = "city_10" >
			                    <label for="city_10" > Berlin </label >
			                    <input type = "checkbox" id = "city_11" >
			                    <label for="city_11" > New York </label >
			                    <input type = "checkbox" id = "city_12" >
			                    <label for="city_12" > Berlin </label >
			                    <input type = "checkbox" id = "city_13" >
			                    <label for="city_13" > New York </label >
			                </div >
			            </div >
			
			            <div class="clear" ></div >
			        </form >
			    </section > ';

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
				'key'     => 'dokan_vf_city',
				'value'   => array( 'Moskow', 'Rovenki' ),
				'compare' => 'IN',
			),
			array(
				'key'     => 'dokan_vf_country',
				'value'   => array( 'RU', 'UA' ),
				'compare' => 'IN',
			),
		);

		$results = [];
		$vendors = dokan_get_sellers( $args );

		foreach ( $vendors['users'] as $vendor ) {
			$store_info = dokan_get_store_info( $vendor->data->ID );
			$description = get_user_meta( $vendor->data->ID, 'description', true );

			if (strlen($description) > 65) {
				$description = substr($description, 0, 65) . '...';
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