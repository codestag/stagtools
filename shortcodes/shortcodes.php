<?php
/**
 * All Plugin Shortcodes
 *
 * @package StagTools
 */


/**
 * Columns
 */
if ( ! function_exists( 'stag_one_third' ) ) :
function stag_one_third( $atts, $content = null ) {
	return '<div class="stag-column stag-one-third">' . do_shortcode( $content ) . '</div>';
}
endif;
add_shortcode( 'stag_one_third', 'stag_one_third' );

if ( ! function_exists( 'stag_one_third_last' ) ) :
function stag_one_third_last( $atts, $content = null ) {
	return '<div class="stag-column stag-one-third stag-column-last">' . do_shortcode( $content ) . '</div><div class="clear"></div>';
}
endif;
add_shortcode( 'stag_one_third_last', 'stag_one_third_last' );

if ( ! function_exists( 'stag_two_third' ) ) :
function stag_two_third( $atts, $content = null ) {
	return '<div class="stag-column stag-two-third">' . do_shortcode( $content ) . '</div>';
}
endif;
add_shortcode( 'stag_two_third', 'stag_two_third' );

if ( ! function_exists( 'stag_two_third_last' ) ) :
function stag_two_third_last( $atts, $content = null ) {
	return '<div class="stag-column stag-two-third stag-column-last">' . do_shortcode( $content ) . '</div><div class="clear"></div>';
}
endif;
add_shortcode( 'stag_two_third_last', 'stag_two_third_last' );

if ( ! function_exists( 'stag_one_half' ) ) :
function stag_one_half( $atts, $content = null ) {
	return '<div class="stag-column stag-one-half">' . do_shortcode( $content ) . '</div>';
}
endif;
add_shortcode( 'stag_one_half', 'stag_one_half' );

if ( ! function_exists( 'stag_one_half_last' ) ) :
function stag_one_half_last( $atts, $content = null ) {
	return '<div class="stag-column stag-one-half stag-column-last">' . do_shortcode( $content ) . '</div><div class="clear"></div>';
}
endif;
add_shortcode( 'stag_one_half_last', 'stag_one_half_last' );

if ( ! function_exists( 'stag_one_fourth' ) ) :
function stag_one_fourth( $atts, $content = null ) {
	return '<div class="stag-column stag-one-fourth">' . do_shortcode( $content ) . '</div>';
}
endif;
add_shortcode( 'stag_one_fourth', 'stag_one_fourth' );

if ( ! function_exists( 'stag_one_fourth_last' ) ) :
function stag_one_fourth_last( $atts, $content = null ) {
	return '<div class="stag-column stag-one-fourth stag-column-last">' . do_shortcode( $content ) . '</div><div class="clear"></div>';
}
endif;
add_shortcode( 'stag_one_fourth_last', 'stag_one_fourth_last' );

if ( ! function_exists( 'stag_three_fourth' ) ) :
function stag_three_fourth( $atts, $content = null ) {
	return '<div class="stag-column stag-three-fourth">' . do_shortcode( $content ) . '</div>';
}
endif;
add_shortcode( 'stag_three_fourth', 'stag_three_fourth' );

if ( ! function_exists( 'stag_three_fourth_last' ) ) :
function stag_three_fourth_last( $atts, $content = null ) {
	return '<div class="stag-column stag-three-fourth stag-column-last">' . do_shortcode( $content ) . '</div><div class="clear"></div>';
}
endif;
add_shortcode( 'stag_three_fourth_last', 'stag_three_fourth_last' );

if ( ! function_exists( 'stag_one_fifth' ) ) :
function stag_one_fifth( $atts, $content = null ) {
	return '<div class="stag-column stag-one-fifth">' . do_shortcode( $content ) . '</div>';
}
endif;
add_shortcode( 'stag_one_fifth', 'stag_one_fifth' );

if ( ! function_exists( 'stag_one_fifth_last' ) ) :
function stag_one_fifth_last( $atts, $content = null ) {
	return '<div class="stag-column stag-one-fifth stag-column-last">' . do_shortcode( $content ) . '</div><div class="clear"></div>';
}
add_shortcode( 'stag_one_fifth_last', 'stag_one_fifth_last' );
endif;

if ( ! function_exists( 'stag_two_fifth' ) ) :
function stag_two_fifth( $atts, $content = null ) {
	return '<div class="stag-column stag-two-fifth">' . do_shortcode( $content ) . '</div>';
}
endif;
add_shortcode( 'stag_two_fifth', 'stag_two_fifth' );

if ( ! function_exists( 'stag_two_fifth_last' ) ) :
function stag_two_fifth_last( $atts, $content = null ) {
	return '<div class="stag-column stag-two-fifth stag-column-last">' . do_shortcode( $content ) . '</div><div class="clear"></div>';
}
endif;
add_shortcode( 'stag_two_fifth_last', 'stag_two_fifth_last' );

if ( ! function_exists( 'stag_three_fifth' ) ) :
function stag_three_fifth( $atts, $content = null ) {
	return '<div class="stag-column stag-three-fifth">' . do_shortcode( $content ) . '</div>';
}
endif;
add_shortcode( 'stag_three_fifth', 'stag_three_fifth' );

if ( ! function_exists( 'stag_three_fifth_last' ) ) :
function stag_three_fifth_last( $atts, $content = null ) {
	return '<div class="stag-column stag-three-fifth stag-column-last">' . do_shortcode( $content ) . '</div><div class="clear"></div>';
}
endif;
add_shortcode( 'stag_three_fifth_last', 'stag_three_fifth_last' );

if ( ! function_exists( 'stag_four_fifth' ) ) :
function stag_four_fifth( $atts, $content = null ) {
	return '<div class="stag-column stag-four-fifth">' . do_shortcode( $content ) . '</div>';
}
endif;
add_shortcode( 'stag_four_fifth', 'stag_four_fifth' );

if ( ! function_exists( 'stag_four_fifth_last' ) ) :
function stag_four_fifth_last( $atts, $content = null ) {
	return '<div class="stag-column stag-four-fifth stag-column-last">' . do_shortcode( $content ) . '</div><div class="clear"></div>';
}
endif;
add_shortcode( 'stag_four_fifth_last', 'stag_four_fifth_last' );

if ( ! function_exists( 'stag_one_sixth' ) ) :
function stag_one_sixth( $atts, $content = null ) {
	return '<div class="stag-column stag-one-sixth">' . do_shortcode( $content ) . '</div>';
}
endif;
add_shortcode( 'stag_one_sixth', 'stag_one_sixth' );

if ( ! function_exists( 'stag_one_sixth_last' ) ) :
function stag_one_sixth_last( $atts, $content = null ) {
	return '<div class="stag-column stag-one-sixth stag-column-last">' . do_shortcode( $content ) . '</div><div class="clear"></div>';
}
endif;
add_shortcode( 'stag_one_sixth_last', 'stag_one_sixth_last' );

if ( ! function_exists( 'stag_five_sixth' ) ) :
function stag_five_sixth( $atts, $content = null ) {
	return '<div class="stag-column stag-five-sixth">' . do_shortcode( $content ) . '</div>';
}
endif;
add_shortcode( 'stag_five_sixth', 'stag_five_sixth' );

if ( ! function_exists( 'stag_five_sixth_last' ) ) :
function stag_five_sixth_last( $atts, $content = null ) {
	return '<div class="stag-column stag-five-sixth stag-column-last">' . do_shortcode( $content ) . '</div><div class="clear"></div>';
}
endif;
add_shortcode( 'stag_five_sixth_last', 'stag_five_sixth_last' );


if ( ! function_exists( 'stag_button' ) ) :
/**
 * Buttons
 */
function stag_button( $atts, $content = null ) {
	$args = shortcode_atts( array(
		'url'        => '#',
		'target'     => '_self',
		'style'      => 'grey',
		'size'       => 'small',
		'type'       => 'round',
		'icon'       => '',
		'icon_order' => 'before',
	), $atts, 'purchase_link' );

	$button_icon = '';
	$class       = " stag-button--{$args['size']}";
	$class       .= " stag-button--{$args['style']}";
	$class       .= " stag-button--{$args['type']}";

	if ( ! empty( $args['icon'] ) ) {
		if ( 'before' == $args['icon_order'] ) {
			$button_content = stag_icon( array( 'icon' => $args['icon'] ) );
			$button_content .= do_shortcode( $content );
		} else {
			$button_content = do_shortcode( $content );
			$button_content .= stag_icon( array( 'icon' => $args['icon'] ) );
		}
		$class .= " stag-icon--{$args['icon_order']}";
	} else {
		$button_content = do_shortcode( $content );
	}

	return '<a target="'. esc_attr( $args['target'] ) .'" href="'. esc_url( $args['url'] ) .'" class="stag-button'. esc_attr( $class ) .'">'. $button_content .'</a>';
}
endif;

add_shortcode( 'stag_button', 'stag_button' );


if ( ! function_exists( 'stag_alert' ) ) :
/**
 * Alerts
 *
 * @deprecated 2.0.0.
 */
function stag_alert( $atts, $content = null ) {
	$args = shortcode_atts( array(
		'style' => 'white',
	), $atts, 'stag_alert' );

	return '<div class="stag-section stag-alert stag-alert--'. esc_attr( $args['style'] ) .'">' . do_shortcode( $content ) . '</div>';
}
endif;

add_shortcode( 'stag_alert', 'stag_alert' );

if ( ! function_exists( 'stag_divider' ) ) :
/**
 * Horizontal divider shortcode.
 *
 * @deprecated 2.0.0.
 *
 * @param  array  $atts Shortcode attributes.
 * @param  string $content
 * @return string Custom Horizontal divider HTML.
 */
function stag_divider( $atts, $content = null ) {
	$args = shortcode_atts( array(
		'style' => 'plain',
	), $atts, 'stag_divider' );

	return '<hr class="stag-section stag-divider stag-divider--'. esc_attr( $args['style'] ) .'">';
}
endif;

add_shortcode( 'stag_divider', 'stag_divider' );

if ( ! function_exists( 'stag_intro' ) ):
/**
 * Intro Text shortcode.
 *
 * @deprecated 2.0.0.
 */
function stag_intro( $atts, $content = null ) {
	return '<section class="stag-section stag-intro-text">' . wpautop( do_shortcode( $content ) ) . '</section>';
}
endif;
add_shortcode( 'stag_intro', 'stag_intro' );


if ( ! function_exists( 'stag_tabs' ) ) :
/**
 * Shortcode for tabs.
 *
 * @return void
 */
function stag_tabs( $atts, $content = null ) {
	$args = shortcode_atts( array(
		'style' => 'normal',
	), $atts, 'stag_tabs' );

	wp_enqueue_script( 'stag-shortcode-scripts' );

	preg_match_all( '/tab title="([^\"]+)"/i', $content, $matches, PREG_OFFSET_CAPTURE );

	$tab_titles = array();
	if ( isset($matches[1]) ) {
		$tab_titles = $matches[1];
	}

	$output = '';

	if ( count( $tab_titles ) ) {
		$output .= '<section id="stag-tabs-'. rand( 1, 100 ) .'" class="stag-section stag-tabs stag-tabs--'. esc_attr( $args['style'] ) .'"><div class="stag-tab-inner">';
		$output .= '<ul class="stag-nav stag-clearfix">';

		foreach ( $tab_titles as $tab ) {
			$output .= '<li><a href="#stag-tab-'. sanitize_title( $tab[0] ) .'">' . $tab[0] . '</a></li>';
		}

		$output .= '</ul>';
		$output .= do_shortcode( $content );
		$output .= '</div></section>';
	} else {
		$output .= do_shortcode( $content );
	}
	return $output;
}
endif;

add_shortcode( 'stag_tabs', 'stag_tabs' );


if ( ! function_exists( 'stag_tab' ) ) :
function stag_tab( $atts, $content = null ) {
	$args = shortcode_atts( array(
		'title' => __( 'Tab', 'stag' )
	), $atts, 'stag_tab' );

	return '<div id="stag-tab-'. sanitize_title( $args['title'] ) .'" class="stag-tab">'. do_shortcode( $content ) .'</div>';
}
endif;

add_shortcode( 'stag_tab', 'stag_tab' );


if ( ! function_exists( 'stag_toggle' ) ) :
function stag_toggle( $atts, $content = null ) {
	$args = shortcode_atts( array(
		'title' => __( 'Title Goes Here', 'stag' ),
		'state' => 'open',
		'style' => 'normal',
	), $atts, 'stag_toggle' );

	wp_enqueue_script( 'stag-shortcode-scripts' );

	return '<div data-id="' . esc_attr( $args['state'] ) . '" class="stag-section stag-toggle stag-toggle--' . esc_attr( $args['style'] ) . '"><span class="stag-toggle-title">' . esc_html( $args['title'] ) . '</span><div class="stag-toggle-inner"><div class="stag-toggle-content">' . do_shortcode( $content ) . '</div></div></div>';
}
endif;

add_shortcode( 'stag_toggle', 'stag_toggle' );

if ( ! function_exists( 'stag_dropcap' ) ) :
function stag_dropcap( $atts, $content = null ) {
	$args = shortcode_atts( array(
		'style'     => 'normal',
		'font_size' => '50px',
	), $atts, 'stag_dropcap' );

	return '<span class="stag-dropcap stag-dropcap--' . esc_attr( $args['style'] ) . '" style="font-size:' . esc_attr( $args['font_size'] ) . ';line-height:' . esc_attr( $args['font_size'] ) . ';width:' . esc_attr( $args['font_size'] ) . ';height:' . esc_attr( $args['font_size'] ) . ';">' . do_shortcode( $content ) . '</span>';
}
endif;

add_shortcode( 'stag_dropcap', 'stag_dropcap' );

if ( ! function_exists( 'stag_image' ) ) :
function stag_image( $atts, $content = null ) {
	$args = shortcode_atts( array(
		'style'     => 'grayscale',
		'alignment' => 'none',
		'src'       => '',
		'url'       => '',
	), $atts, 'stag_image' );

	$output = '<figure class="stag-section stag-image stag-image--' . esc_attr( $args['style'] ) . ' stag-image--' . esc_attr( $args['alignment'] ) . '">';

	if ( $args['url'] != '' ) {
		$output .= '<a href="' . esc_url( $args['url'] ) . '"><img src="' . esc_url( $args['src'] ) . '" alt=""></a>';
	} else {
		$output .= '<img src="' . esc_url( $args['src'] ) . '" alt="">';
	}

	$output .= '</figure>';

	return $output;
}
endif;

add_shortcode( 'stag_image', 'stag_image' );

if ( ! function_exists( 'stag_video' ) ) :
function stag_video( $atts, $content = null ) {
	$args = shortcode_atts( array(
		'src' => '',
	), $atts, 'stag_video' );

	return '<div class="stag-section stag-video">' . $GLOBALS['wp_embed']->run_shortcode( '[embed]'. esc_url( $args['src'] ) .'[/embed]' ) . '</div>';
}
endif;

add_shortcode( 'stag_video', 'stag_video' );

if ( ! function_exists( 'stag_icon' ) ) :
/**
 * FontAwesome Icon shortcode.
 */
function stag_icon( $atts, $content = null ) {
	$args = shortcode_atts( array(
		'icon'       => '',
		'url'        => '',
		'size'       => '',
		'new_window' => 'no',
	), $atts, 'stag_icon' );

	$new_window = ( $args['new_window'] == 'no' ) ? '_self' : '_blank';

	$size = esc_attr( $args['size'] );

	$output = '';
	$attrs  = '';

	if ( ! empty( $args['url'] ) ) {
		$a_attrs = ' href="'. esc_url( $args['url'] ) .'" target="'. esc_attr( $new_window ) .'"';
	}

	if ( ! empty( $size ) ) {
		$attrs .= ' style="font-size:'. $size .';line-height:'. $size .'"';
	}

	if ( $args['url'] != '' ){
		$output .= '<a class="stag-icon-link" '. $a_attrs .'><i class="fa fa-'. esc_attr( $args['icon'] ) .'" '. $attrs .'></i></a>';
	} else {
		$output .= '<i class="fa fa-'. esc_attr( $args['icon'] ) .'" '. $attrs .'></i>';
	}

	return $output;
}
endif;

add_shortcode( 'stag_icon', 'stag_icon' );

if ( ! function_exists( 'stag_map' ) ) :
/**
 * Google Map Shortcode
 *
 * @since 1.0.4
 */
function stag_map( $atts ) {
	$args = shortcode_atts( array(
		'lat'    => '37.42200',
		'long'   => '-122.08395',
		'width'  => '100%',
		'height' => '350px',
		'zoom'   => 15,
		'style'  => 'none',
		'type'   => 'roadmap',
	), $atts, 'stag_map' );

	$map_styles = array(
		'none'             => '[]',
		'mixed'            => '[{"featureType":"landscape","stylers":[{"hue":"#00dd00"}]},{"featureType":"road","stylers":[{"hue":"#dd0000"}]},{"featureType":"water","stylers":[{"hue":"#000040"}]},{"featureType":"poi.park","stylers":[{"visibility":"off"}]},{"featureType":"road.arterial","stylers":[{"hue":"#ffff00"}]},{"featureType":"road.local","stylers":[{"visibility":"off"}]}]',
		'pale_dawn'        => '[{"featureType":"landscape","stylers":[{"saturation":-100},{"lightness":65},{"visibility":"on"}]},{"featureType":"poi","stylers":[{"saturation":-100},{"lightness":51},{"visibility":"simplified"}]},{"featureType":"road.highway","stylers":[{"saturation":-100},{"visibility":"simplified"}]},{"featureType":"road.arterial","stylers":[{"saturation":-100},{"lightness":30},{"visibility":"on"}]},{"featureType":"road.local","stylers":[{"saturation":-100},{"lightness":40},{"visibility":"on"}]},{"featureType":"transit","stylers":[{"saturation":-100},{"visibility":"simplified"}]},{"featureType":"administrative.province","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"labels","stylers":[{"visibility":"on"},{"lightness":-25},{"saturation":-100}]},{"featureType":"water","elementType":"geometry","stylers":[{"hue":"#ffff00"},{"lightness":-25},{"saturation":-97}]}]',
		'greyscale'        => '[{"featureType":"all","stylers":[{"saturation":-100},{"gamma":0.5}]}]',
		'bright_bubbly'    => '[{"featureType":"water","stylers":[{"color":"#19a0d8"}]},{"featureType":"administrative","elementType":"labels.text.stroke","stylers":[{"color":"#ffffff"},{"weight":6}]},{"featureType":"administrative","elementType":"labels.text.fill","stylers":[{"color":"#e85113"}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#efe9e4"},{"lightness":-40}]},{"featureType":"road.arterial","elementType":"geometry.stroke","stylers":[{"color":"#efe9e4"},{"lightness":-20}]},{"featureType":"road","elementType":"labels.text.stroke","stylers":[{"lightness":100}]},{"featureType":"road","elementType":"labels.text.fill","stylers":[{"lightness":-100}]},{"featureType":"road.highway","elementType":"labels.icon"},{"featureType":"landscape","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"landscape","stylers":[{"lightness":20},{"color":"#efe9e4"}]},{"featureType":"landscape.man_made","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"labels.text.stroke","stylers":[{"lightness":100}]},{"featureType":"water","elementType":"labels.text.fill","stylers":[{"lightness":-100}]},{"featureType":"poi","elementType":"labels.text.fill","stylers":[{"hue":"#11ff00"}]},{"featureType":"poi","elementType":"labels.text.stroke","stylers":[{"lightness":100}]},{"featureType":"poi","elementType":"labels.icon","stylers":[{"hue":"#4cff00"},{"saturation":58}]},{"featureType":"poi","elementType":"geometry","stylers":[{"visibility":"on"},{"color":"#f0e4d3"}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#efe9e4"},{"lightness":-25}]},{"featureType":"road.arterial","elementType":"geometry.fill","stylers":[{"color":"#efe9e4"},{"lightness":-10}]},{"featureType":"poi","elementType":"labels","stylers":[{"visibility":"simplified"}]}]',
		'subtle_grayscale' => '[{"featureType":"landscape","stylers":[{"saturation":-100},{"lightness":65},{"visibility":"on"}]},{"featureType":"poi","stylers":[{"saturation":-100},{"lightness":51},{"visibility":"simplified"}]},{"featureType":"road.highway","stylers":[{"saturation":-100},{"visibility":"simplified"}]},{"featureType":"road.arterial","stylers":[{"saturation":-100},{"lightness":30},{"visibility":"on"}]},{"featureType":"road.local","stylers":[{"saturation":-100},{"lightness":40},{"visibility":"on"}]},{"featureType":"transit","stylers":[{"saturation":-100},{"visibility":"simplified"}]},{"featureType":"administrative.province","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"labels","stylers":[{"visibility":"on"},{"lightness":-25},{"saturation":-100}]},{"featureType":"water","elementType":"geometry","stylers":[{"hue":"#ffff00"},{"lightness":-25},{"saturation":-97}]}]',
	);

	$map_id = 'map-'. rand( 0, 99 );

	wp_enqueue_script( 'google-maps', ( is_ssl() ? 'https' : 'http' ) . '://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false' );

	?>

	<script type="text/javascript">
		jQuery(window).load(function(){
			var Stagtools = {};

			Stagtools.Map = ( function($) {
				function setupMap(options) {
					var mapOptions, mapElement, map, marker;

					if ( typeof google === 'undefined' ) return;

					mapOptions = {
						zoom: parseFloat(options.zoom),
						center: new google.maps.LatLng(options.center.lat, options.center.long),
						scrollwheel: false,
						mapTypeId: options.mapTypeId,
						styles: options.styles
					};

					mapElement = document.getElementById(options.id);
					map = new google.maps.Map(mapElement, mapOptions);

					marker = new google.maps.Marker({
						position: new google.maps.LatLng(options.center.lat, options.center.long),
						map: map
					});
				}
				return {
					init: function(options) {
						setupMap(options);
					}
				}
			} )(jQuery);

			var options = {
				id: "<?php echo esc_js( $map_id ); ?>",
				styles: <?php echo $map_styles[$args['style']]; ?>,
				zoom: <?php echo esc_js( $args['zoom'] ); ?>,
				mapTypeId: google.maps.MapTypeId.<?php echo esc_js( strtoupper( $args['type'] ) ); ?>,
				center: {
					lat: "<?php echo esc_js( $args['lat'] ); ?>",
					long: "<?php echo esc_js( $args['long'] ); ?>"
				}
			};

			Stagtools.Map.init(options);
		});
	</script>

	<?php

	return '<section id="'. esc_attr( $map_id ) .'" class="stag-section google-map" style="width:'. esc_attr( $args['width'] ) .';height:'. esc_attr( $args['height'] ) .'"></section>';
}
endif;

add_shortcode( 'stag_map', 'stag_map' );

if ( ! function_exists( 'stag_social' ) ) :
/**
 * Social shortcode.
 *
 * Display links to social profiles.
 *
 * @since 1.2
 */
function stag_social( $atts ) {
	$args = shortcode_atts( array(
		'id'    => 'all',
		'style' => 'normal',
	), $atts, 'stag_social' );

	$registered_settings = stagtools_get_registered_settings();
	$social_urls         = array_keys( $registered_settings['social'] );
	$settings            = get_option( 'stag_options' );
	$output              = '<p class="stag-social-icons '. esc_attr( $args['style'] ) .'">';

	if ( '' == $args['id'] || 'all' == $args['id'] ) {
		$social_ids = $social_urls;
	} else {
		$social_ids = explode( ',', $args['id'] );
	}

	foreach ( $social_ids as $slug ) {
		$slug = trim( $slug );
		if ( isset( $settings[$slug] ) && $settings[$slug] != '' ) {
			$class = $slug;

			if ( 'mail' == $slug ) $class = 'envelope';

			if ( 'skype' == $slug ) {
				$output .= "<a href='". $settings[$slug] ."' target='_blank'><i class='fa fa-". esc_attr( $class ) ."'></i></a>";
			} else {
				$output .= "<a href='". esc_url( $settings[$slug] ) ."' target='_blank'><i class='fa fa-". esc_attr( $class ) ."'></i></a>";
			}
		}
	}
	$output .= '</p>';

	return $output;

}
endif;
add_shortcode( 'stag_social', 'stag_social' );

if ( ! function_exists( 'stag_columns' ) ) :
/**
 * Stag Columns shortcodes.
 *
 * Wrapper for stag_column shortcodes.
 *
 * @since 1.2.4
 *
 * @param  array $atts Shortcode attributes.
 * @param  string $content Shortcode content.
 *
 * @return mixed
 */
function stag_columns( $atts, $content = null ) {
	return '<section class="stag-section stag-columns">' . do_shortcode( $content ) . '</section>';
}
endif;
add_shortcode( 'stag_columns', 'stag_columns' );
