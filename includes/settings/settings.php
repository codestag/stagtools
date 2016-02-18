<?php
/**
 * Admin Options Page.
 *
 * @package StagTools
 * @since 1.2
 * @access private
 * @return void
 */

/**
 * Get all settings.
 *
 * @return arran An array containing settings.
 */
function stagtools_get_settings() {
	$settings = get_option( 'stag_options' );

	if ( empty( $settings ) ) {
		$general_settings = is_array( get_option( 'stagtools_settings_general' ) ) ? get_option( 'stagtools_settings_general' ) : array();
		$social_settings  = is_array( get_option( 'stagtools_settings_social' ) ) ? get_option( 'stagtools_settings_social' ) : array();

		$settings = array_merge( $general_settings, $social_settings );

		update_option( 'stag_options', $settings );
	}

	return apply_filters( 'stagtools_get_settings', $settings );
}

function stagtools_options_page() {
	$active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'general';

	ob_start(); ?>

	<div class="wrap">
		<h2 class="nav-tab-wrapper">
			<?php
			foreach ( stagtools_get_settings_tabs() as $tab_id => $tab_name ) {

				$tab_url = add_query_arg( array(
					'settings-updated' => false,
					'tab'              => $tab_id,
				) );

				$is_showing = true;

				if ( 'portfolio' == $tab_id ) {
					$is_showing = false;
					if ( current_theme_supports( 'post-type',  array( 'portfolio' ) ) || current_theme_supports( 'stag-portfolio' ) ) {
						$is_showing = true;
					}
				}

				if ( $is_showing ) :

				$active = $active_tab == $tab_id ? ' nav-tab-active' : '';

				echo '<a href="' . esc_url( $tab_url ) . '" title="' . esc_attr( $tab_name ) . '" class="nav-tab' . $active . '">';
					echo esc_html( $tab_name );
				echo '</a>';

				endif;
			}
			?>
		</h2>

		<div id="tab_container">
			<form method="post" action="options.php">
				<table class="form-table">
				<?php

				if ( 'stagtools' == $_GET['page'] && isset( $_GET['settings-updated'] ) && 'true' == $_GET['settings-updated'] ) {
					flush_rewrite_rules();
				}

				settings_fields( 'stag_options' );
				do_settings_fields( 'stagtools_settings_' . $active_tab, 'stagtools_settings_' . $active_tab );
				?>
				</table>
				<?php submit_button(); ?>
			</form>
		</div><!-- #tab_container -->
	</div><!-- .wrap -->

	<?php
	echo ob_get_clean();
}

/**
 * Get settings tabs.
 *
 * @return array An array containing tab names.
 */
function stagtools_get_settings_tabs() {
	$tabs              = array();
	$tabs['general']   = __( 'General', 'stag' );
	$tabs['social']    = __( 'Social', 'stag' );
	$tabs['portfolio'] = __( 'Portfolio', 'stag' );

	return apply_filters( 'stagtools_settings_tabs', $tabs );
}

/**
 * Validate user inputs upon save.
 *
 * @param  array  $input An array containing values to filter
 * @return array         Filtered values array
 */
function stagtools_settings_sanitize( $input = array() ) {
	global $stag_options;

	parse_str( $_POST['_wp_http_referer'], $referrer );

	$output    = array();
	$settings  = stagtools_get_registered_settings();
	$tab       = isset( $referrer['tab'] ) ? $referrer['tab'] : 'general';
	$post_data = isset( $_POST[ 'stagtools_settings_' . $tab ] ) ? $_POST[ 'stagtools_settings_' . $tab ] : array();

	$input = apply_filters( 'stagtools_settings_' . $tab . '_sanitize', $post_data );

	// Loop through each setting being saved and pass it through a sanitization filter
	foreach ( $input as $key => $value ) {
		// Get the setting type (checkbox, select, etc)
		$type = isset( $settings[ $key ][ 'type' ] ) ? $settings[ $key ][ 'type' ] : false;

		if ( $type ) {
			// Field type specific filter
			$output[ $key ] = apply_filters( 'stagtools_settings_sanitize_' . $type, $value, $key );
		}

		// General filter
		$output[ $key ] = apply_filters( 'stagtools_settings_sanitize', $value, $key );
	}

	// Loop through the whitelist and unset any that are empty for the tab being saved
	if ( ! empty( $settings[ $tab ] ) ) {
		foreach ( $settings[ $tab ] as $key => $value ) {

			// settings used to have numeric keys, now they have keys that match the option ID. This ensures both methods work
			if ( is_numeric( $key ) ) {
				$key = $value['id'];
			}

			if ( empty( $_POST[ 'stagtools_settings_' . $tab ][ $key ] ) ) {
				unset( $stag_options[ $key ] );
			}
		}
	}

	// Merge our new settings with the existing
	$output = array_merge( $stag_options, $output );

	add_settings_error( 'stagtools-notices', '', __( 'Settings Updated', 'stag' ), 'updated' );

	return $output;
}

/**
 * Register settings fields.
 *
 * Fires upon admin_init.
 *
 * @return void
 */
function stagtools_register_settings() {
	if ( false == get_option( 'stag_options' ) ) {
		add_option( 'stag_options' );
	}

	foreach ( stagtools_get_registered_settings() as $tab => $settings ) {
		add_settings_section(
			'stagtools_settings_' . $tab,
			__return_null(),
			'__return_false',
			'stagtools_settings_' . $tab
		);

		foreach ( $settings as $option ) {

			add_settings_field(
				'stagtools_settings[' . $option['id'] . ']',
				'<label for="stagtools_settings_' . $tab . '[' . $option['id'] . ']">'. $option['name'] .'</label>',
				function_exists( 'stagtools_' . $option['type'] . '_callback' ) ? 'stagtools_' . $option['type'] . '_callback' : 'stagtools_missing_callback',
				'stagtools_settings_' . $tab,
				'stagtools_settings_' . $tab,
				array(
					'id'      => $option['id'],
					'desc'    => ! empty( $option['desc'] ) ? $option['desc'] : '',
					'name'    => $option['name'],
					'section' => $tab,
					'size'    => isset( $option['size'] ) ? $option['size'] : null,
					'options' => isset( $option['options'] ) ? $option['options'] : '',
					'std'     => isset( $option['std'] ) ? $option['std'] : '',
				)
			);
		}
	}

	register_setting( 'stag_options', 'stag_options', 'stagtools_settings_sanitize' );
}
add_action( 'admin_init', 'stagtools_register_settings' );

/**
 * Register all settings.
 *
 * @return array An array containing all settings.
 */
function stagtools_get_registered_settings() {
	$stag_settings = array(
		'general' => apply_filters( 'stagtools_general_settings',
			array(
				'twitter_settings' => array(
					'id'   => 'twitter_settings',
					'name' => '<strong>' . __( 'Twitter Settings', 'stag' ) . '</strong>',
					'desc' => __( 'Configure the twitter settings', 'stag' ),
					'type' => 'header',
				),
				'consumer_key' => array(
					'id'   => 'consumer_key',
					'name' => __( 'OAuth Consumer Key', 'stag' ),
					'desc' => __( 'Enter twitter OAuth Consumer Key', 'stag' ),
					'type' => 'text',
				),
				'consumer_secret' => array(
					'id'   => 'consumer_secret',
					'name' => __( 'OAuth Consumer Secret', 'stag' ),
					'desc' => __( 'Enter twitter OAuth Consumer Secret', 'stag' ),
					'type' => 'text',
				),
				'access_key' => array(
					'id'   => 'access_key',
					'name' => __( 'OAuth Access Token', 'stag' ),
					'desc' => __( 'Enter twitter OAuth Access Token', 'stag' ),
					'type' => 'text',
				),
				'access_secret' => array(
					'id'   => 'access_secret',
					'name' => __( 'OAuth Access Secret', 'stag' ),
					'desc' => __( 'Enter twitter OAuth Access Secret', 'stag' ),
					'type' => 'text',
				),
			)
		),
		'social' => apply_filters( 'stagtools_social_settings',
			array(
				'android' => array(
					'id'   => 'android',
					'name' => 'Android',
					'desc' => '',
					'type' => 'url',
				),
				'apple' => array(
					'id'   => 'apple',
					'name' => 'Apple',
					'desc' => '',
					'type' => 'url',
				),
				'behance' => array(
					'id'   => 'behance',
					'name' => 'Behance',
					'desc' => 'e.g. https://www.behance.net/username',
					'type' => 'url',
				),
				'bitbucket' => array(
					'id'   => 'bitbucket',
					'name' => 'Bitbucket',
					'desc' => 'e.g. https://bitbucket.org/username',
					'type' => 'url',
				),
				'codepen' => array(
					'id'   => 'codepen',
					'name' => 'CodePen',
					'desc' => 'e.g. http://codepen.io/username',
					'type' => 'url',
				),
				'deviantart' => array(
					'id'   => 'deviantart',
					'name' => 'Deviant Art',
					'desc' => 'e.g. http://username.deviantart.com',
					'type' => 'url',
				),
				'dribbble' => array(
					'id'   => 'dribbble',
					'name' => 'Dribbble',
					'desc' => 'e.g. http://dribbble.com/username',
					'type' => 'url',
				),
				'dropbox' => array(
					'id'   => 'dropbox',
					'name' => 'Dropbox',
					'desc' => '',
					'type' => 'url',
				),
				'facebook' => array(
					'id'   => 'facebook',
					'name' => 'Facebook',
					'desc' => 'e.g. http://www.facebook.com/username',
					'type' => 'url',
				),
				'flickr' => array(
					'id'   => 'flickr',
					'name' => 'Flickr',
					'desc' => 'e.g. http://www.flickr.com/photos/username',
					'type' => 'url',
				),
				'foursquare' => array(
					'id'   => 'foursquare',
					'name' => 'Foursquare',
					'desc' => 'e.g. https://foursquare.com/username',
					'type' => 'url',
				),
				'github' => array(
					'id'   => 'github',
					'name' => 'GitHub',
					'desc' => 'e.g. https://github.com/username',
					'type' => 'url',
				),
				'google-plus' => array(
					'id'   => 'google-plus',
					'name' => 'Google+',
					'desc' => 'e.g. https://plus.google.com/userID',
					'type' => 'url',
				),
				'instagram' => array(
					'id'   => 'instagram',
					'name' => 'Instagram',
					'desc' => 'e.g. http://instagram.com/username',
					'type' => 'url',
				),
				'linkedin' => array(
					'id'   => 'linkedin',
					'name' => 'LinkedIn',
					'desc' => 'e.g. http://www.linkedin.com/in/username',
					'type' => 'url',
				),
				'mail' => array(
					'id'   => 'mail',
					'name' => 'Mail',
					'desc' => 'e.g. mailto:user@name.com',
					'type' => 'url',
				),
				'pinterest' => array(
					'id'   => 'pinterest',
					'name' => 'Pinterest',
					'desc' => 'e.g. http://pinterest.com/username',
					'type' => 'url',
				),
				'rss' => array(
					'id'   => 'rss',
					'name' => 'RSS',
					'desc' => 'e.g. http://example.com/feed',
					'type' => 'url',
					'std'  => get_bloginfo( 'rss2_url' ),
				),
				'skype' => array(
					'id'   => 'skype',
					'name' => 'Skype',
					'desc' => '',
					'type' => 'url',
				),
				'stack-exchange' => array(
					'id'   => 'stack-exchange',
					'name' => 'Stack Exchange',
					'desc' => 'http://stackexchange.com/users/userID',
					'type' => 'url',
				),
				'stack-overflow' => array(
					'id'   => 'stack-overflow',
					'name' => 'Stack Overflow',
					'desc' => 'e.g. http://stackoverflow.com/users/userID',
					'type' => 'url',
				),
				'trello' => array(
					'id'   => 'trello',
					'name' => 'Trello',
					'desc' => 'e.g. https://trello.com/username',
					'type' => 'url',
				),
				'tumblr' => array(
					'id'   => 'tumblr',
					'name' => 'Tumblr',
					'desc' => 'e.g. http://username.tumblr.com',
					'type' => 'url',
				),
				'twitter' => array(
					'id'   => 'twitter',
					'name' => 'Twitter',
					'desc' => 'e.g. http://twitter.com/username',
					'type' => 'url',
				),
				'vimeo' => array(
					'id'   => 'vimeo',
					'name' => 'Vimeo',
					'desc' => 'e.g. https://vimeo.com/username',
					'type' => 'url',
				),
				'vine' => array(
					'id'   => 'vine',
					'name' => 'Vine',
					'desc' => 'e.g. https://vine.co/username',
					'type' => 'url',
				),
				'windows' => array(
					'id'   => 'windows',
					'name' => 'Windows',
					'desc' => '',
					'type' => 'url',
				),
				'wordpress' => array(
					'id'   => 'wordpress',
					'name' => 'WordPress',
					'desc' => 'e.g. https://profiles.wordpress.org/username',
					'type' => 'url',
				),
				'xing' => array(
					'id'   => 'xing',
					'name' => 'Xing',
					'desc' => '',
					'type' => 'url',
				),
				'youtube' => array(
					'id'   => 'youtube',
					'name' => 'YouTube',
					'desc' => 'e.g. http://www.youtube.com/user/username',
					'type' => 'url',
				),
			)
		),
		'portfolio' => apply_filters( 'stagtools_portfolio_settings',
			array(
				'portfolio_slug' => array(
					'id'   => 'portfolio_slug',
					'name' => __( 'Portfolio Slug', 'stag' ),
					'desc' => __( 'Enter the slug of custom post type <strong>portfolio</strong>.', 'stag' ),
					'type' => 'text',
					'std'  => 'portfolio',
				),
				'skills_slug' => array(
					'id'   => 'skills_slug',
					'name' => __( 'Skills Slug', 'stag' ),
					'desc' => __( 'Enter the slug of custom post taxonomy <strong>skill</strong>.', 'stag' ),
					'type' => 'text',
					'std'  => 'skill',
				)
			)
		)
	);

	return $stag_settings;
}


function stagtools_missing_callback( $args ) {
	printf( __( 'The callback function used for the <strong>%s</strong> setting is missing.', 'stag' ), $args['id'] );
}

/**
 * Text callback.
 *
 * Renders text fields.
 *
 * @param  array $args Arguments passed by the setting
 * @global $stag_options Array of all StagTools options
 * @return void
 */
function stagtools_text_callback( $args ) {
	global $stag_options;

	if ( isset( $stag_options[ $args['id'] ] ) )
		$value = $stag_options[ $args['id'] ];
	else
		$value = isset( $args['std'] ) ? $args['std'] : '';

	$size = isset( $args['size'] ) && ! is_null( $args['size'] ) ? $args['size'] : 'regular';

	$html = '<input type="text" class="' . $size . '-text" id="stagtools_settings_' . $args['section'] . '[' . $args['id'] . ']" name="stagtools_settings_' . $args['section'] . '[' . $args['id'] . ']" value="' . esc_attr( $value ) . '"/>';
	$html .= '<p class="description">'  . $args['desc'] . '</p>';

	echo $html;
}

/**
 * URL callback.
 *
 * Renders URL fields.
 *
 * @param  array $args Arguments passed by the setting
 * @global $stag_options Array of all StagTools options
 * @return void
 */
function stagtools_url_callback( $args ) {
	global $stag_options;

	if ( isset( $stag_options[ $args['id'] ] ) )
		$value = $stag_options[ $args['id'] ];
	else
		$value = isset( $args['std'] ) ? $args['std'] : '';

	$size = isset( $args['size'] ) && ! is_null( $args['size'] ) ? $args['size'] : 'regular';

	$html = '<input type="text" class="' . $size . '-text" id="stagtools_settings_' . $args['section'] . '[' . $args['id'] . ']" name="stagtools_settings_' . $args['section'] . '[' . $args['id'] . ']" value="' . esc_url( $value ) . '"/>';
	$html .= '<p class="description">'  . $args['desc'] . '</p>';

	echo $html;
}

/**
 * Select callback.
 *
 * Renders select fields.
 *
 * @param  array $args Arguments passed by the setting
 * @global $stag_options Array of all StagTools options
 * @return void
 */
function stagtools_select_callback( $args ) {
	global $stag_options;

	if ( isset( $stag_options[ $args['id'] ] ) )
		$value = $stag_options[ $args['id'] ];
	else
		$value = isset( $args['std'] ) ? $args['std'] : '';

	$html = '<select id="stagtools_settings_' . $args['section'] . '[' . $args['id'] . ']" name="stagtools_settings_' . $args['section'] . '[' . $args['id'] . ']"/>';

	foreach ( $args['options'] as $option => $name ) :
		$selected = selected( $option, $value, false );
		$html .= '<option value="' . $option . '" ' . $selected . '>' . $name . '</option>';
	endforeach;

	$html .= '</select>';
	$html .= '<p class="description">'  . $args['desc'] . '</p>';

	echo $html;
}

/**
 * Header callback.
 *
 * Renders the header.
 *
 * @param  array $args Arguments passed by the setting
 * @return void
 */
function stagtools_header_callback( $args ) {
	echo '';
}
