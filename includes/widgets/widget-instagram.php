<?php
/**
 * (Deprecated Widget)
 * Display your latest Instagrams photos.
 *
 * @package StagTools
 * @see ST_Widget
 */

if ( ! class_exists( 'Stag_Instagram' ) ) :
	class Stag_Instagram extends ST_Widget {
		public function __construct() {
			$this->widget_id          = 'stag-instagram';
			$this->widget_cssclass    = 'stag-instagram';
			$this->widget_description = __( 'Display your latest Instagrams photos.', 'stag' );
			$this->widget_name        = __( '(Deprecated) Stag Instagram Photos', 'stag' );

			parent::__construct();
		}

		/**
		 * Front-end display of widget.
		 *
		 * @see WP_Widget::widget()
		 *
		 * @param array $args     Widget arguments.
		 * @param array $instance Saved values from database.
		 */
		public function widget( $args, $instance ) {
			if ( ! current_user_can( 'manage_options' ) ) {
				return;
			}

			printf(
				__( '<br>Instagram widget has been deprecated due to changes in their API with no alternatives available. We recommend using a third-party plugin for <a href="%1$s" target="_blank">Instagram</a> related features.<br><br> This notice is only visible to admins.', 'stagtools' ),
				esc_url( 'https://wordpress.org/plugins/search/instagram/' ),
			);
		}

		/**
		 * Deprecated message for form.
		 *
		 * @param array $instance  Saved values from database.
		 * @return void
		 */
		public function form( $instance ) {
			printf(
				__( '<br>Instagram widget has been deprecated due to changes in their API with no alternatives available. We recommend using a third-party plugin for <a href="%1$s" target="_blank">Instagram</a> related features.<br><br>', 'stagtools' ),
				esc_url( 'https://wordpress.org/plugins/search/instagram/' ),
			);
		}

		/**
		 * Register class.
		 *
		 * @return void
		 */
		public static function register() {
			register_widget( __CLASS__ );
		}
	}
endif;

add_action( 'widgets_init', array( 'Stag_Instagram', 'register' ) );
