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
		'title' => 'Tab'
	), $atts ) );
	return '<div id="stag-tab-'. sanitize_title( $title ) .'" class="stag-tab">'. do_shortcode( $content ) .'</div>';
}
add_shortcode( 'stag_tab', 'stag_tab' );
endif;


if( ! function_exists( 'stag_toggle' ) ) :
function stag_toggle( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'title' => 'Title Goes Here',
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
function stag_map($atts){
	extract( shortcode_atts( array(
		'url' => '',
		'width' => '100%',
		'height' => '350'
	), $atts ) );
  	
  	return "<iframe class='google-map' width='{$width}' height='{$height}' frameborder='0' scrolling='no' marginheight='0' marginwidth='0' src='". esc_url($url) ."&amp;output=embed'></iframe>";
}
add_shortcode( 'stag_map', 'stag_map' );
endif;
