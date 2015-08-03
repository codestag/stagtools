<?php
/**
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
		$this->widget_name        = __( 'Stag Instagram Photos', 'stag' );
		$this->settings           = array(
			'title' => array(
				'type'  => 'text',
				'std'   => __( 'Instagram Photos', 'stag' ),
				'label' => __( 'Title:', 'stag' ),
			),
			'username' => array(
				'type'        => 'text',
				'std'         => null,
				'placeholder' => 'myusername',
				'label'       => __( 'Instagram Username:', 'stag' ),
			),
			'user_id' => array(
				'type'        => 'text',
				'std'         => null,
				'placeholder' => '476220644',
				'label'       => __( 'User ID:', 'stag' ),
			),
			'user_id_desc' => array(
				'type' => 'description',
				'std'  => sprintf( __( 'Lookup your User ID <a href="%1$s" target="_blank">here</a>', 'stag' ), 'http://jelled.com/instagram/lookup-user-id' )
			),
			'client_id' => array(
				'type'        => 'text',
				'std'         => null,
				'placeholder' => '943c89932b2a47e6ae341d3d1943e73f',
				'label'       => __( 'Client ID:', 'stag' ),
			),
			'client_id_desc' => array(
				'type' => 'description',
				'std'  => sprintf( __( 'Register a new client <a href="%1$s" target="_blank">here</a>', 'stag' ), 'http://instagram.com/developer/clients/manage/' )
			),
			'count' => array(
				'type'  => 'number',
				'std'   => 9,
				'label' => __( 'Photo Count:', 'stag' ),
				'step'  => 1,
				'min'   => 1,
				'max'   => 20,
			),
			'size' => array(
				'type' => 'select',
				'std' => 'thumbnail',
				'label' => __( 'Photo Size', 'stag' ),
				'options' => array(
					'thumbnail'           => __( 'Thumbnail', 'stag' ),
					'low_resolution'      => __( 'Low Resolution', 'stag' ),
					'standard_resolution' => __( 'High Resolution', 'stag' ),
				)
			),
			'cachetime' => array(
				'type'  => 'number',
				'std'   => 2,
				'label' => __( 'Cache time (in hours):', 'stag' ),
				'step'  => 1,
				'min'   => 1,
				'max'   => 500,
			)
		);

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
	function widget( $args, $instance ) {
		if ( $this->get_cached_widget( $args ) )
			return;

		ob_start();

		extract( $args );

		echo $before_widget;

		$title     = apply_filters( 'widget_title', $instance['title'] );
		$username  = esc_html( $instance['username'] );
		$user_id   = absint( $instance['user_id'] );
		$client_id = esc_html( $instance['client_id'] );
		$count     = absint( $instance['count'] );
		$image_res = esc_html( $instance['size'] );
		$cachetime = absint( $instance['cachetime'] );

		// Get Instagrams
		$instagram = $this->get_instagrams( array(
			'user_id'   => $user_id,
			'client_id' => $client_id,
			'count'     => $count,
			'cachetime' => $cachetime,
		) );

		if ( $title ) echo $before_title . $title . $after_title;

		// And if we have Instagrams
		if ( false !== $instagram ) :

		?>

			<ul class="instagram-widget <?php echo esc_attr( $image_res ); ?>">
				<?php
					foreach ( $instagram['data'] as $key => $image ) {
						echo apply_filters( 'st_instagram_widget_image_html', sprintf( '<li><a href="%1$s"><img class="instagram-image" src="%2$s" alt="%3$s" title="%3$s" /></a></li>',
							$image['link'],
							str_replace( 'http:', '', $image['images'][ $image_res ]['url'] ),
							$image['caption']['text']
						), $image );
					}
				?>

			</ul>

			<a class="instagram-follow-link" href="https://instagram.com/<?php echo esc_html( $username ); ?>"><?php printf( __( 'Follow %1$s on Instagram', 'stag' ), esc_html( $username ) ); ?></a>

		<?php elseif ( ( defined( 'WP_DEBUG' ) && true === WP_DEBUG ) && ( defined( 'WP_DEBUG_DISPLAY' ) && false !== WP_DEBUG_DISPLAY ) ) : ?>
			<div id="message" class="error"><p><?php _e( 'Error: We were unable to fetch your instagram feed.', 'stag' ); ?></p></div>
		<?php endif;

		echo $after_widget;

		$content = ob_get_clean();

		echo $content;

		$this->cache_widget( $args, $content );
	}

	/**
	 * Get relevant data from Instagram API.
	 *
	 * @param	array $args Argument to passed to Instagram API.
	 * @return  array 		An array returning Instagram API data.
	 */
	public function get_instagrams( $args = array() ) {
		// Get args
		$user_id   = ( ! empty( $args['user_id'] ) ) ? $args['user_id'] : '';
		$client_id = ( ! empty( $args['client_id'] ) ) ? $args['client_id'] : '';
		$count     = ( ! empty( $args['count'] ) ) ? $args['count'] : 9;
		$cachetime = ( ! empty( $args['cachetime'] ) ) ? $args['cachetime'] : 2;

		// If no client id or user id, bail
		if ( empty( $client_id ) || empty( $user_id ) ) {
			return false;
		}

		$key = 'st_instagram_widget_' . $user_id;

		if ( false === ( $instagrams = get_transient( $key ) ) ) {
			// Ping Instagram's API
			$api_url = 'https://api.instagram.com/v1/users/' . esc_html( $user_id ) . '/media/recent/';
			$response = wp_remote_get( add_query_arg( array(
				'client_id' => esc_html( $client_id ),
				'count'     => absint( $count )
			), $api_url ) );

			// Check if the API is up.
			if ( ! 200 == wp_remote_retrieve_response_code( $response ) ) {
				return false;
			}

			// Parse the API data and place into an array
			$instagrams = json_decode( wp_remote_retrieve_body( $response ), true );

			// Are the results in an array?
			if ( ! is_array( $instagrams ) ) {
				return false;
			}

			$instagrams = maybe_unserialize( $instagrams );

			// Store Instagrams in a transient, and expire every hour
			set_transient( $key, $instagrams, $cachetime * HOUR_IN_SECONDS );
		}

		return $instagrams;
	}

	public static function register() {
	    register_widget( __CLASS__ );
	}
}
endif;

add_action( 'widgets_init', array( 'Stag_Instagram', 'register' ) );
