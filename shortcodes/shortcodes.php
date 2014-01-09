<?php

/**
 * All Plugin Shortcodes
 */


/**
 * Columns
 */
if( ! function_exists('stag_one_third' ) ) :
function stag_one_third( $atts, $content = null ) {
	return '<div class="stag-column stag-one-third">' . do_shortcode($content) . '</div>';
}
add_shortcode('stag_one_third', 'stag_one_third');
endif;

if( ! function_exists('stag_one_third_last' ) ) :
function stag_one_third_last( $atts, $content = null ) {
	return '<div class="stag-column stag-one-third stag-column-last">' . do_shortcode($content) . '</div><div class="clear"></div>';
}
add_shortcode('stag_one_third_last', 'stag_one_third_last');
endif;

if( ! function_exists( 'stag_two_third' ) ) :
function stag_two_third( $atts, $content = null) {
	return '<div class="stag-column stag-two-third">' . do_shortcode($content) . '</div>';
}
add_shortcode( 'stag_two_third', 'stag_two_third' );
endif;

if( ! function_exists( 'stag_two_third_last' ) ) :
function stag_two_third_last( $atts, $content = null) {
	return '<div class="stag-column stag-two-third stag-column-last">' . do_shortcode($content) . '</div>';
}
add_shortcode( 'stag_two_third_last', 'stag_two_third_last' );
endif;

if (!function_exists( 'stag_one_half' ) ) :
function stag_one_half( $atts, $content = null ) {
	return '<div class="stag-column stag-one-half">' . do_shortcode($content) . '</div>';
}
add_shortcode( 'stag_one_half', 'stag_one_half' );
endif;

if ( ! function_exists( 'stag_one_half_last' ) ) :
function stag_one_half_last( $atts, $content = null ) {
	return '<div class="stag-column stag-one-half stag-column-last">' . do_shortcode($content) . '</div><div class="clear"></div>';
}
add_shortcode( 'stag_one_half_last', 'stag_one_half_last' );
endif;

if ( ! function_exists( 'stag_one_fourth' ) ) :
function stag_one_fourth( $atts, $content = null ) {
	return '<div class="stag-column stag-one-fourth">' . do_shortcode($content) . '</div>';
}
add_shortcode( 'stag_one_fourth', 'stag_one_fourth' );
endif;

if ( ! function_exists('stag_one_fourth_last' ) ) :
function stag_one_fourth_last( $atts, $content = null ) {
	return '<div class="stag-column stag-one-fourth stag-column-last">' . do_shortcode($content) . '</div><div class="clear"></div>';
}
add_shortcode( 'stag_one_fourth_last', 'stag_one_fourth_last' );
endif;

if ( ! function_exists('stag_three_fourth' ) ) :
function stag_three_fourth( $atts, $content = null ) {
	return '<div class="stag-column stag-three-fourth">' . do_shortcode($content) . '</div>';
}
add_shortcode( 'stag_three_fourth', 'stag_three_fourth' );
endif;

if ( ! function_exists('stag_three_fourth_last' ) ) :
function stag_three_fourth_last( $atts, $content = null ) {
	return '<div class="stag-column stag-three-fourth stag-column-last">' . do_shortcode($content) . '</div><div class="clear"></div>';
}
add_shortcode( 'stag_three_fourth_last', 'stag_three_fourth_last' );
endif;

if ( ! function_exists('stag_one_fifth' ) ) :
function stag_one_fifth( $atts, $content = null ) {
	return '<div class="stag-column stag-one-fifth">' . do_shortcode($content) . '</div>';
}
add_shortcode( 'stag_one_fifth', 'stag_one_fifth' );
endif;

if ( ! function_exists('stag_one_fifth_last' ) ) :
function stag_one_fifth_last( $atts, $content = null ) {
	return '<div class="stag-column stag-one-fifth stag-column-last">' . do_shortcode($content) . '</div><div class="clear"></div>';
}
add_shortcode( 'stag_one_fifth_last', 'stag_one_fifth_last' );
endif;

if ( ! function_exists('stag_two_fifth' ) ) :
function stag_two_fifth( $atts, $content = null ) {
	return '<div class="stag-column stag-two-fifth">' . do_shortcode($content) . '</div>';
}
add_shortcode( 'stag_two_fifth', 'stag_two_fifth' );
endif;

if ( ! function_exists('stag_two_fifth_last' ) ) :
function stag_two_fifth_last( $atts, $content = null ) {
	return '<div class="stag-column stag-two-fifth stag-column-last">' . do_shortcode($content) . '</div><div class="clear"></div>';
}
add_shortcode( 'stag_two_fifth_last', 'stag_two_fifth_last' );
endif;

if ( ! function_exists('stag_three_fifth' ) ) :
function stag_three_fifth( $atts, $content = null ) {
	return '<div class="stag-column stag-three-fifth">' . do_shortcode($content) . '</div>';
}
add_shortcode( 'stag_three_fifth', 'stag_three_fifth' );
endif;

if ( ! function_exists('stag_three_fifth_last' ) ) :
function stag_three_fifth_last( $atts, $content = null ) {
	return '<div class="stag-column stag-three-fifth stag-column-last">' . do_shortcode($content) . '</div><div class="clear"></div>';
}
add_shortcode( 'stag_three_fifth_last', 'stag_three_fifth_last' );
endif;

if ( ! function_exists('stag_four_fifth' ) ) :
function stag_four_fifth( $atts, $content = null ) {
	return '<div class="stag-column stag-four-fifth">' . do_shortcode($content) . '</div>';
}
add_shortcode( 'stag_four_fifth', 'stag_four_fifth' );
endif;

if ( ! function_exists( 'stag_four_fifth_last' ) ) :
function stag_four_fifth_last( $atts, $content = null ) {
	return '<div class="stag-column stag-four-fifth stag-column-last">' . do_shortcode($content) . '</div><div class="clear"></div>';
}
add_shortcode( 'stag_four_fifth_last', 'stag_four_fifth_last' );
endif;

if ( ! function_exists( 'stag_one_sixth' ) ) :
function stag_one_sixth( $atts, $content = null ) {
	return '<div class="stag-column stag-one-sixth">' . do_shortcode($content) . '</div>';
}
add_shortcode( 'stag_one_sixth', 'stag_one_sixth' );
endif;

if ( ! function_exists( 'stag_one_sixth_last' ) ) :
function stag_one_sixth_last( $atts, $content = null ) {
	return '<div class="stag-column stag-one-sixth stag-column-last">' . do_shortcode($content) . '</div><div class="clear"></div>';
}
add_shortcode( 'stag_one_sixth_last', 'stag_one_sixth_last' );
endif;

if ( ! function_exists( 'stag_five_sixth' ) ) :
function stag_five_sixth( $atts, $content = null ) {
	return '<div class="stag-column stag-five-sixth">' . do_shortcode($content) . '</div>';
}
add_shortcode( 'stag_five_sixth', 'stag_five_sixth' );
endif;

if ( ! function_exists( 'stag_five_sixth_last' ) ) :
function stag_five_sixth_last( $atts, $content = null ) {
	return '<div class="stag-column stag-five-sixth stag-column-last">' . do_shortcode($content) . '</div><div class="clear"></div>';
}
add_shortcode( 'stag_five_sixth_last', 'stag_five_sixth_last' );
endif;


if( ! function_exists( 'stag_button' ) ) :
/**
 * Buttons
 */
function stag_button( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'url'        => '#',
		'target'     => '_self',
		'style'      => 'grey',
		'size'       => 'small',
		'type'       => 'round',
		'icon'       => '',
		'icon_order' => 'before'
	), $atts ) );
	
	$button_icon = '';
	$class       = " stag-button--{$size}";
	$class       .= " stag-button--{$style}";
	$class       .= " stag-button--{$type}";

	if( ! empty($icon) ) {
		if ( $icon_order == 'before' ) {
			$button_content = stag_icon( array( 'icon' => $icon ) );
			$button_content .= do_shortcode($content);
		} else {
			$button_content = do_shortcode($content);
			$button_content .= stag_icon( array( 'icon' => $icon ) );
		}
		$class .= " stag-icon--{$icon_order}";
	} else {
		$button_content = do_shortcode($content);
	}

	return '<a target="'.$target.'" href="'.$url.'" class="stag-button'. $class .'">'. $button_content .'</a>';
}
add_shortcode( 'stag_button', 'stag_button' );
endif;


if( ! function_exists( 'stag_alert') ) :
/**
 * Alerts
 */
function stag_alert( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'style' => 'white'
    ), $atts));
	return '<div class="stag-alert stag-alert--'.$style.'">' . do_shortcode($content) . '</div>';
}
add_shortcode( 'stag_alert', 'stag_alert' );
endif;


if( ! function_exists( 'stag_divider' ) ) :
function stag_divider( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'style' => 'plain'
	), $atts ) );
	return '<hr class="stag-divider stag-divider--'.$style.'">';
}
add_shortcode( 'stag_divider', 'stag_divider' );
endif;


if( ! function_exists( 'stag_intro' ) ):
function stag_intro( $atts, $content = null ) {
	return '<span class="stag-intro-text">' . do_shortcode($content) . '</span>';
}
add_shortcode( 'stag_intro', 'stag_intro' );
endif;


if( ! function_exists( 'stag_tabs' ) ) :
function stag_tabs( $atts, $content = null ) {
	$defaults = array(
		'style' => 'normal'
	);
	extract( shortcode_atts( $defaults, $atts ) );

	preg_match_all( '/tab title="([^\"]+)"/i', $content, $matches, PREG_OFFSET_CAPTURE );

	$tab_titles = array();
    if( isset($matches[1]) ){ $tab_titles = $matches[1]; }

    $output = '';

    if( count( $tab_titles ) ) {
    	$output .= '<div id="stag-tabs-'. rand(1, 100) .'" class="stag-tabs stag-tabs--'. $style .'"><div class="stag-tab-inner">';
    	$output .= '<ul class="stag-nav stag-clearfix">';

    	foreach( $tab_titles as $tab ) {
    		$output .= '<li><a href="#stag-tab-'. sanitize_title( $tab[0] ) .'">' . $tab[0] . '</a></li>';
    	}

    	$output .= '</ul>';
    	$output .= do_shortcode( $content );
    	$output .= '</div></div>';
    } else {
    	$output .= do_shortcode( $content );
    }
    return $output;
}
add_shortcode( 'stag_tabs', 'stag_tabs' );
endif;


if( ! function_exists( 'stag_tab' ) ) :
function stag_tab( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'title' => __( 'Tab', 'stag' )
	), $atts ) );
	return '<div id="stag-tab-'. sanitize_title( $title ) .'" class="stag-tab">'. do_shortcode( $content ) .'</div>';
}
add_shortcode( 'stag_tab', 'stag_tab' );
endif;


if( ! function_exists( 'stag_toggle' ) ) :
function stag_toggle( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'title' => __( 'Title Goes Here', 'stag' ),
		'state' => 'open',
		'style' => 'normal'
	), $atts ) );
	return "<div data-id='".$state."' class=\"stag-toggle stag-toggle--". $style ."\"><span class=\"stag-toggle-title\">". $title ."</span><div class=\"stag-toggle-inner\"><div class=\"stag-toggle-content\">". do_shortcode($content) ."</div></div></div>";
}
add_shortcode( 'stag_toggle', 'stag_toggle' );
endif;

if( ! function_exists( 'stag_dropcap' ) ) :
function stag_dropcap( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'style' => 'normal',
		'font_size' => '50px'
	), $atts ) );

	return "<span class=\"stag-dropcap stag-dropcap--$style\" style=\"font-size: $font_size; line-height: $font_size; width: $font_size; height: $font_size;\">". do_shortcode( $content ) ."</span>";
}
add_shortcode( 'stag_dropcap', 'stag_dropcap' );
endif;

if( ! function_exists( 'stag_image' ) ) :
function stag_image( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'style' => 'grayscale',
		'alignment' => 'none',
		'src' => '',
		'url' => ''
	), $atts ) );

	$output = "<div class=\"stag-image stag-image--$style stag-image--$alignment\" >";

	if($url != ''){
		$output .= "<a href=\"". esc_url($url) ."\"><img src=\"$src\" alt=\"\"></a>";
	}else{
		$output .= "<img src=\"". esc_url($src) ."\" alt=\"\">";
	}

	$output .= "</div>";

	return $output;
}
add_shortcode( 'stag_image', 'stag_image' );
endif;

if( ! function_exists( 'stag_video' ) ) :
function stag_video( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'src' => ''
	), $atts ) );

	return "<div class=\"stag-video\" >". $GLOBALS['wp_embed']->run_shortcode( '[embed]'. esc_url( $src ) .'[/embed]' ) ."</div>";
}
add_shortcode( 'stag_video', 'stag_video' );
endif;

if( ! function_exists( 'stag_icon') ) :
/**
 * FontAwesome Icon shortcode.
 */
function stag_icon( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'icon'       => '',
		'url'        => '',
		'size'       => '',
		'new_window' => 'no'
	), $atts ) );

	$new_window = ( $new_window == "no") ? '_self' : '_blank';

	$output = '';
	$attrs = '';

	if( ! empty($url) ){
		$a_attrs = ' href="'. esc_url($url) .'" target="'. esc_attr($new_window) .'"';
	}

	if( !empty($size) ) {
		$attrs .= ' style="font-size:'. esc_attr($size) .';line-height:'. esc_attr($size) .'"';
	}

	if( $url != '' ){
		$output .= '<a class="stag-icon-link" '. $a_attrs .'><i class="stag-icon icon-'. $icon .'" style="font-size: '. $size .'; line-height: '. $size .';"></i></a>';
	}else{
		$output .= '<i class="stag-icon icon-'. $icon .'" '. $attrs .'></i>';
	}

	return $output;
}
add_shortcode( 'stag_icon', 'stag_icon' );
endif;

if( ! function_exists( 'stag_map') ) :
/**
 * Google Map Shortcode
 * 
 * @since 1.0.4
 */
function stag_map( $atts ) {
	extract( shortcode_atts( array(
		'lat'    => '37.42200',
		'long'   => '-122.08395',
		'width'  => '100%',
		'height' => '350px',
		'zoom'   => 15,
		'style'  => 'none'
	), $atts ) );

	$map_styles = array(
		'pale_dawn' => '[{"featureType":"landscape","stylers":[{"saturation":-100},{"lightness":65},{"visibility":"on"}]},{"featureType":"poi","stylers":[{"saturation":-100},{"lightness":51},{"visibility":"simplified"}]},{"featureType":"road.highway","stylers":[{"saturation":-100},{"visibility":"simplified"}]},{"featureType":"road.arterial","stylers":[{"saturation":-100},{"lightness":30},{"visibility":"on"}]},{"featureType":"road.local","stylers":[{"saturation":-100},{"lightness":40},{"visibility":"on"}]},{"featureType":"transit","stylers":[{"saturation":-100},{"visibility":"simplified"}]},{"featureType":"administrative.province","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"labels","stylers":[{"visibility":"on"},{"lightness":-25},{"saturation":-100}]},{"featureType":"water","elementType":"geometry","stylers":[{"hue":"#ffff00"},{"lightness":-25},{"saturation":-97}]}]',
		'subtle_grayscale' => '[{"featureType":"landscape","stylers":[{"saturation":-100},{"lightness":65},{"visibility":"on"}]},{"featureType":"poi","stylers":[{"saturation":-100},{"lightness":51},{"visibility":"simplified"}]},{"featureType":"road.highway","stylers":[{"saturation":-100},{"visibility":"simplified"}]},{"featureType":"road.arterial","stylers":[{"saturation":-100},{"lightness":30},{"visibility":"on"}]},{"featureType":"road.local","stylers":[{"saturation":-100},{"lightness":40},{"visibility":"on"}]},{"featureType":"transit","stylers":[{"saturation":-100},{"visibility":"simplified"}]},{"featureType":"administrative.province","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"labels","stylers":[{"visibility":"on"},{"lightness":-25},{"saturation":-100}]},{"featureType":"water","elementType":"geometry","stylers":[{"hue":"#ffff00"},{"lightness":-25},{"saturation":-97}]}]',
		'bright_bubbly' => '[{"featureType":"water","stylers":[{"color":"#19a0d8"}]},{"featureType":"administrative","elementType":"labels.text.stroke","stylers":[{"color":"#ffffff"},{"weight":6}]},{"featureType":"administrative","elementType":"labels.text.fill","stylers":[{"color":"#e85113"}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#efe9e4"},{"lightness":-40}]},{"featureType":"road.arterial","elementType":"geometry.stroke","stylers":[{"color":"#efe9e4"},{"lightness":-20}]},{"featureType":"road","elementType":"labels.text.stroke","stylers":[{"lightness":100}]},{"featureType":"road","elementType":"labels.text.fill","stylers":[{"lightness":-100}]},{"featureType":"road.highway","elementType":"labels.icon"},{"featureType":"landscape","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"landscape","stylers":[{"lightness":20},{"color":"#efe9e4"}]},{"featureType":"landscape.man_made","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"labels.text.stroke","stylers":[{"lightness":100}]},{"featureType":"water","elementType":"labels.text.fill","stylers":[{"lightness":-100}]},{"featureType":"poi","elementType":"labels.text.fill","stylers":[{"hue":"#11ff00"}]},{"featureType":"poi","elementType":"labels.text.stroke","stylers":[{"lightness":100}]},{"featureType":"poi","elementType":"labels.icon","stylers":[{"hue":"#4cff00"},{"saturation":58}]},{"featureType":"poi","elementType":"geometry","stylers":[{"visibility":"on"},{"color":"#f0e4d3"}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#efe9e4"},{"lightness":-25}]},{"featureType":"road.arterial","elementType":"geometry.fill","stylers":[{"color":"#efe9e4"},{"lightness":-10}]},{"featureType":"poi","elementType":"labels","stylers":[{"visibility":"simplified"}]}]',
		'greyscale' => '[{"featureType":"all","stylers":[{"saturation":-100},{"gamma":0.5}]}]',
		'mixed' => '[{"featureType":"landscape","stylers":[{"hue":"#00dd00"}]},{"featureType":"road","stylers":[{"hue":"#dd0000"}]},{"featureType":"water","stylers":[{"hue":"#000040"}]},{"featureType":"poi.park","stylers":[{"visibility":"off"}]},{"featureType":"road.arterial","stylers":[{"hue":"#ffff00"}]},{"featureType":"road.local","stylers":[{"visibility":"off"}]}]',
		'none' => '[]'
	);

	$map_id = 'map'. rand(0, 99);
  	
	?>
	
	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyASm3CwaK9qtcZEWYa-iQwHaGi3gcosAJc&sensor=false"></script>
	
	<script type="text/javascript">
	    // When the window has finished loading create our google map below
	    google.maps.event.addDomListener(window, 'load', init);
	
	    function init() {

	    	var userLatLang = new google.maps.LatLng(<?php echo $lat; ?>, <?php echo $long; ?>);

	    	var mapStyle = <?php echo $map_styles[$style]; ?>;

	        // Basic options for a simple Google Map
	        // For more options see: https://developers.google.com/maps/documentation/javascript/reference#MapOptions
	        var mapOptions = {
	            zoom: <?php echo $zoom; ?>,
	            center: userLatLang,
	            styles: mapStyle
	        };

	        var mapElement = document.getElementById('<?php echo $map_id; ?>');
	        
	        var map = new google.maps.Map(mapElement, mapOptions);

			var marker = new google.maps.Marker({
				position: userLatLang,
				map: map
			});
	    }
	</script>

	<style type="text/css"> .gm-style img { max-width: none; } </style>

	<?php

	return "<div id='{$map_id}' style='width:{$width};height:{$height};'></div>";
}
add_shortcode( 'stag_map', 'stag_map' );
endif;

if ( ! function_exists( 'stag_social' ) ) :
/**
 * Social shortcode.
 *
 * Display links to social profiles.
 *
 * @since 1.2
 */
function stag_social( $atts ) {
	extract( shortcode_atts( array(
		'id'    => 'all',
		'style' => 'normal'
	), $atts ) );

	$registered_settings = stagtools_get_registered_settings();
	$social_urls         = array_keys($registered_settings['social']);
	$settings            = get_option('stag_options');
	
	$output              = '<div class="stag-social-icons '. $style .'">';

	if ( $id == '' || $id == "all" ) {
		$id = $social_urls;
	} else {
		$id = explode(',', $id);
	}

	foreach( $id as $slug ) {
		$slug = trim($slug);
		if( isset( $settings[$slug] ) && $settings[$slug] != '' ) {
			$class = $slug;

			if( 'mail'  == $slug ) $class = 'envelope';
			if( 'vimeo' == $slug ) $class = 'vimeo-square';

			$output .= "<a href='". esc_url( $settings[$slug] ) ."' target='_blank'><i class='stag-icon icon-{$class}'></i></a>";
		}
	}
	$output .= "</div>";

	return $output;

}
add_shortcode( 'stag_social', 'stag_social' );
endif;
