<?php
/**
 * @package StagTools
 * @since 2.0.0
 */

/**
 * Customizations to the TinyMCE editor.
 *
 * @since 2.0.0
 */
class StagTools_TinyMCE {
	/**
	 * The one instance of StagTools_TinyMCE.
	 * @var StagTools_TinyMCE
	 */
	private static $instance;

	/**
	 * Instantiate or return the one StagTools_TinyMCE instance.
	 *
	 * @since  2.0.0.
	 *
	 * @return StagTools_TinyMCE
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Setup.
	 *
	 * @since  2.0.0.
	 *
	 * @return void
	 */
	public function __construct() {
		// Add the buttons
		add_action( 'admin_init', array( $this, 'add_buttons' ), 11 );
	}

	/**
	 * Implement the TinyMCE button for creating a button.
	 *
	 * @since  2.0.0.
	 *
	 * @return void
	 */
	public function add_buttons() {
		if ( ( ! current_user_can( 'edit_posts' ) && ! current_user_can( 'edit_pages' ) ) ) {
			return;
		}

		// The style formats
		add_filter( 'tiny_mce_before_init', array( $this, 'style_formats' ) );
		add_filter( 'mce_buttons_2', array( $this, 'register_mce_formats' ) );
	}

	/**
	 * Add styles to the Styles dropdown.
	 *
	 * @since  2.0.0.
	 *
	 * @param  array    $settings    TinyMCE settings array.
	 * @return array                 Modified array.
	 */
	public function style_formats( $settings ) {
		$style_formats = array(
			// Big (big)
			array(
				'title'   => __( 'Run In', 'stag' ),
				'block'   => 'p',
				'classes' => 'stag-intro-text run-in',
			),
			array(
				'title' => __( 'Alert', 'stag' ),
				'items' => array(
					array(
						'title'      => __( 'Green', 'stag' ),
						'block'      => 'p',
						'attributes' => array(
							'class' => 'stag-alert stag-alert--green',
						),
					),
					array(
						'title'      => __( 'Red', 'stag' ),
						'block'      => 'p',
						'attributes' => array(
							'class' => 'stag-alert stag-alert--red',
						),
					),
					array(
						'title'      => __( 'Yellow', 'stag' ),
						'block'      => 'p',
						'attributes' => array(
							'class' => 'stag-alert stag-alert--yellow',
						),
					),
					array(
						'title'      => __( 'Blue', 'stag' ),
						'block'      => 'p',
						'attributes' => array(
							'class' => 'stag-alert stag-alert--blue',
						),
					),
					array(
						'title'      => __( 'Grey', 'stag' ),
						'block'      => 'p',
						'attributes' => array(
							'class' => 'stag-alert stag-alert--grey',
						),
					),
				),
			),
		);

		// Combine with existing format definitions
		if ( isset( $settings['style_formats'] ) ) {
			$existing_formats = json_decode( $settings['style_formats'] );
			$style_formats    = array_merge( $existing_formats, $style_formats );
		}

		// Allow styles to be customized
		$style_formats = apply_filters( 'stagtools_style_formats', $style_formats );

		// Encode
		$settings['style_formats'] = json_encode( $style_formats );

		return $settings;
	}

	/**
	 * Add the Styles dropdown for the Visual editor.
	 *
	 * @since  2.0.0.
	 *
	 * @param  array    $buttons    Array of activated buttons.
	 * @return array                The modified array.
	 */
	public function register_mce_formats( $buttons ) {
		// Add the styles dropdown
		array_unshift( $buttons, 'styleselect' );

		return $buttons;
	}
}

/**
 * Instantiate or return the one StagTools_TinyMCE instance.
 *
 * @since  2.0.0.
 *
 * @return StagTools_TinyMCE
 */
function stag_get_tinmyce_styles() {
	return StagTools_TinyMCE::instance();
}

add_action( 'admin_init', 'stag_get_tinmyce_styles' );
