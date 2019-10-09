<?php

/**
 * Class DVF_Admin_User_Edit
 * Customization for user edit page
 *
 * @since 1.0.3
 */

class DVF_Admin_User_Edit {

	/**
	 * DVF_Admin_User_Edit constructor.
	 *
	 * @since 1.0.3
	 */
	public function __construct() {
		add_action( 'show_user_profile', array( $this, 'change_address_city_field' ), 21 );
		add_action( 'edit_user_profile', array( $this, 'change_address_city_field' ), 21 );

		add_action( 'personal_options_update', array( $this, 'save_meta_fields' ), 21 );
		add_action( 'edit_user_profile_update', array( $this, 'save_meta_fields' ), 21 );

		add_action( 'wp_ajax_dvf_multiple_list', array( $this, 'ajax_multiply_list' ), 99 );
		add_action( 'wp_ajax_dvf_add_multiply_element', array( $this, 'ajax_add_multiply_element' ), 99 );
	}

	/**
	 * Change default Stat/City field to multiply
	 *
	 * @since 1.0.3
	 *
	 * @param $user
	 *
	 * @return void
	 */
	public function change_address_city_field( $user ) {
		if ( ! current_user_can( 'manage_woocommerce' ) ) {
			return;
		}

		if ( ! user_can( $user, 'dokandar' ) ) {
			return;
		}

		?>
        <script>
            jQuery(document).ready(function () {
				<?php foreach (DVF_Params::$multiply_field_for as $field) { ?>
                changeToMultiplyPicker(
                    '<?php echo $field['key']; ?>',
                    '<?php echo $field['target']; ?>',
                    '<?php echo $field['title']; ?>');
				<?php } ?>
            });
        </script>
		<?php
	}

	/**
	 * Display multiply select form by AJAX
	 *
	 * @since 1.0.3
	 *
	 * @return void
	 */
	public function ajax_multiply_list() {
		ob_clean();

		parse_str( $_POST['data'], $postdata );

		if ( isset( $postdata['key'] ) ) {
			$html = '<tr data-key="' . $postdata['key'] . '">';
			$html .= '    <th>';
			$html .= '      Town/City';
			$html .= '    </th>';
			$html .= '    <td>';
			$html .= '      <a href="#" class="dvf-show-multiply-list" >
                                <span class="dvf-multiply-title">Nothin</span>
                                <b class="arrow-icon">
                                    <span class="left-bar"></span>
                                    <span class="right-bar"></span>
                                </b>
                            </a>';
			$html .= $this->multiply_picker( $postdata['key'], $postdata['user_id'] );
			$html .= '    </td>';
			$html .= '</tr>';

			wp_send_json_success( $html );
		} else {
			wp_send_json_error( 'Empty key' );
		}

		wp_die();
	}

	/**
	 * Prepare multiply picker list for display
	 *
	 * @since 1.0.3
	 *
	 * @param $key
	 * @param $user_id
	 *
	 * @return string
	 */
	private function multiply_picker( $key, $user_id = 0 ) {
		$elements = DVF_List::get_meta_values( DVF_Params::SLUG . $key );

		$html = '<div class="dvf-multiply-list">';

		$checked = array();
		if ( 0 != $user_id ) {
			$vendor     = dokan()->vendor->get( $user_id );
			$store_info = dokan_get_store_info( $vendor->data->ID );
			$checked    = get_user_meta( $user_id, DVF_Params::SLUG . $key );
			$checked[]  = $store_info['address'][ $key ];

			if ( ! in_array( $store_info['address'][ $key ], array_column( $elements, 'value' ) ) ) {
				$elements[] = array(
					'value' => $store_info['address'][ $key ],
					'title' => $store_info['address'][ $key ],
				);
			}
		}

		foreach ( $elements as $element ) {
			if ( empty( $element['value'] ) ) {
				continue;
			}

			$html .= '  <label>
                            <input type="checkbox" name="dvf_' . $key . '[]" value="' . $element['value'] . '"';

			if ( in_array( $element['value'], $checked ) ) {
				$html .= ' checked="checked" ';
			}

			$html .= '      >
                            ' . $element['title'] . '
                        </label>';
		}

		$html .= '  <form action="#" method="post" class="dvf-new-element-form">
                        <input type="text" name="dvf_new_element" class="dvf-new-element-field" >
                        <input type="submit" value="Add" >
                    </form>
                </div>';

		return $html;
	}

	/**
	 * Add new element to multiply list by AJAX
	 *
	 * @since 1.0.3
	 *
	 * @return void
	 */
	public function ajax_add_multiply_element() {
		ob_clean();

		parse_str( $_POST['data'], $postdata );

		if ( 0 == strlen( trim( $postdata['dvf_new_element'] ) ) ) {
			wp_send_json_error( 'Empty new element name' );
			wp_die();
		}

		$new_element = ucfirst( $postdata['dvf_new_element'] );

		$elements = DVF_List::get_meta_values( DVF_Params::SLUG . $postdata['key'] );
		if ( ! in_array( $new_element, array_column( $elements, 'value' ) ) ) {
			$html = '<label><input type="checkbox" checked="checked" name="dvf_' . $postdata['key'] . '[]" value="' . $new_element . '"> '
			        . $new_element . '</label>';

			wp_send_json_success( $html );
		} else {
			wp_send_json_error( 'That element already exist' );
		}

		wp_die();
	}

	/**
	 * Save all multiply fields data from user-edit page
	 *
	 * @since 1.0.3
	 *
	 * @return void
	 */
	public function save_meta_fields( $user_id ) {
		if ( ! current_user_can( 'manage_woocommerce' ) ) {
			return;
		}

		$post_data = wp_unslash( $_POST );

		foreach ( DVF_Params::$multiply_field_for as $field ) {
			delete_user_meta( $user_id, DVF_Params::SLUG . $field['key'] );

			if ( isset( $post_data[ 'dvf_' . $field['key'] ] ) ) {
				foreach ( $post_data[ 'dvf_' . $field['key'] ] as $val ) {
					$value = sanitize_text_field( $val );
					add_user_meta( $user_id, DVF_Params::SLUG . $field['key'], $value );
				}
			}
		}
	}

}

/**
 * Run DVF_Admin_User_Edit class
 *
 * @since 1.0.3
 *
 * @return DVF_Admin_User_Edit
 */
function dvf_admin_user_edit_runner() {
	return new DVF_Admin_User_Edit();
}

dvf_admin_user_edit_runner();