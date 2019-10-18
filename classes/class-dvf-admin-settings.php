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
		$html .= $this->user_fields_tab();

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
					<a href="#user_fields" class="nav-tab" >User Fields</a>
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
	 * Make content for 'User Fields' tab
	 *
	 * @since 1.0.6
	 *
	 * @return string
	 */
	private function user_fields_tab() {
		$html = '<form method="post" name="' . DVF_Params::SLUG . 'user_fields_form" id="user_fields" class="dvf-hide" >';

		$html = $this->make_user_fields_table( $html );

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
				$params['filters'][ $key ] = ( isset( $_POST['filters'][ $key ] )
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

	private function make_user_fields_table( string $html ) {
		$html .= '<div class="top"><br class="clear"></div>
<table class="wp-list-table widefat fixed striped posts">
	<thead>
	<tr>
		<td id="cb" class="manage-column column-cb check-column"><label class="screen-reader-text" for="cb-select-all-1">Select All</label><input id="cb-select-all-1" type="checkbox"></td><th scope="col" id="title" class="manage-column column-title column-primary sortable desc"><a href="http://dokan-vendors-filter.local/wp-admin/edit.php?orderby=title&amp;order=asc"><span>Title</span><span class="sorting-indicator"></span></a></th><th scope="col" id="author" class="manage-column column-author">Author</th><th scope="col" id="categories" class="manage-column column-categories">Categories</th><th scope="col" id="tags" class="manage-column column-tags">Tags</th><th scope="col" id="comments" class="manage-column column-comments num sortable desc"><a href="http://dokan-vendors-filter.local/wp-admin/edit.php?orderby=comment_count&amp;order=asc"><span><span class="vers comment-grey-bubble" title="Comments"><span class="screen-reader-text">Comments</span></span></span><span class="sorting-indicator"></span></a></th><th scope="col" id="date" class="manage-column column-date sortable asc"><a href="http://dokan-vendors-filter.local/wp-admin/edit.php?orderby=date&amp;order=desc"><span>Date</span><span class="sorting-indicator"></span></a></th>	</tr>
	</thead>

	<tbody id="the-list">
				<tr id="post-1" class="iedit author-self level-0 post-1 type-post status-publish format-standard hentry category-uncategorized">
			<th scope="row" class="check-column">			<label class="screen-reader-text" for="cb-select-1">
			                                                                                       Select Hello world!			</label>
			<input id="cb-select-1" type="checkbox" name="post[]" value="1">
			<div class="locked-indicator">
				<span class="locked-indicator-icon" aria-hidden="true"></span>
				<span class="screen-reader-text">
				            “Hello world!” is locked				</span>
			</div>
			</th><td class="title column-title has-row-actions column-primary page-title" data-colname="Title"><div class="locked-info"><span class="locked-avatar"></span> <span class="locked-text"></span></div>
<strong><a class="row-title" href="http://dokan-vendors-filter.local/wp-admin/post.php?post=1&amp;action=edit" aria-label="“Hello world!” (Edit)">Hello world!</a></strong>

<div class="hidden" id="inline_1">
	<div class="post_title">Hello world!</div><div class="post_name">hello-world</div>
	<div class="post_author">1</div>
	<div class="comment_status">open</div>
	<div class="ping_status">open</div>
	<div class="_status">publish</div>
	<div class="jj">11</div>
	<div class="mm">08</div>
	<div class="aa">2019</div>
	<div class="hh">09</div>
	<div class="mn">34</div>
	<div class="ss">09</div>
	<div class="post_password"></div><div class="page_template">default</div><div class="post_category" id="category_1">1</div><div class="tags_input" id="post_tag_1"></div><div class="sticky"></div><div class="post_format"></div></div><div class="row-actions"><span class="edit"><a href="http://dokan-vendors-filter.local/wp-admin/post.php?post=1&amp;action=edit" aria-label="Edit “Hello world!”">Edit</a> | </span><span class="inline hide-if-no-js"><button type="button" class="button-link editinline" aria-label="Quick edit “Hello world!” inline" aria-expanded="false">Quick&nbsp;Edit</button> | </span><span class="trash"><a href="http://dokan-vendors-filter.local/wp-admin/post.php?post=1&amp;action=trash&amp;_wpnonce=1e774d77fc" class="submitdelete" aria-label="Move “Hello world!” to the Trash">Trash</a> | </span><span class="view"><a href="http://dokan-vendors-filter.local/2019/08/11/hello-world/" rel="bookmark" aria-label="View “Hello world!”">View</a></span></div><button type="button" class="toggle-row"><span class="screen-reader-text">Show more details</span></button></td><td class="author column-author" data-colname="Author"><a href="edit.php?post_type=post&amp;author=1">admin</a></td><td class="categories column-categories" data-colname="Categories"><a href="edit.php?category_name=uncategorized">Uncategorized</a></td><td class="tags column-tags" data-colname="Tags"><span aria-hidden="true">—</span><span class="screen-reader-text">No tags</span></td><td class="comments column-comments" data-colname="Comments">		<div class="post-com-count-wrapper">
		<a href="http://dokan-vendors-filter.local/wp-admin/edit-comments.php?p=1&amp;comment_status=approved" class="post-com-count post-com-count-approved"><span class="comment-count-approved" aria-hidden="true">1</span><span class="screen-reader-text">1 comment</span></a><span class="post-com-count post-com-count-pending post-com-count-no-pending"><span class="comment-count comment-count-no-pending" aria-hidden="true">0</span><span class="screen-reader-text">No pending comments</span></span>		</div>
		</td><td class="date column-date" data-colname="Date">Published<br><abbr title="2019/08/11 9:34:09 am">2019/08/11</abbr></td>		</tr>
			</tbody>

	<tfoot>
	<tr>
		<td class="manage-column column-cb check-column"><label class="screen-reader-text" for="cb-select-all-2">Select All</label><input id="cb-select-all-2" type="checkbox"></td><th scope="col" class="manage-column column-title column-primary sortable desc"><a href="http://dokan-vendors-filter.local/wp-admin/edit.php?orderby=title&amp;order=asc"><span>Title</span><span class="sorting-indicator"></span></a></th><th scope="col" class="manage-column column-author">Author</th><th scope="col" class="manage-column column-categories">Categories</th><th scope="col" class="manage-column column-tags">Tags</th><th scope="col" class="manage-column column-comments num sortable desc"><a href="http://dokan-vendors-filter.local/wp-admin/edit.php?orderby=comment_count&amp;order=asc"><span><span class="vers comment-grey-bubble" title="Comments"><span class="screen-reader-text">Comments</span></span></span><span class="sorting-indicator"></span></a></th><th scope="col" class="manage-column column-date sortable asc"><a href="http://dokan-vendors-filter.local/wp-admin/edit.php?orderby=date&amp;order=desc"><span>Date</span><span class="sorting-indicator"></span></a></th>	</tr>
	</tfoot>

</table>';

		return $html;
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