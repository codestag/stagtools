<?php
/**
 * Display your latest Dribbble shots.
 *
 * @package StagTools
 * @see ST_Widget
 */
class Stag_Dribbble extends ST_Widget {
	public function __construct() {
		$this->widget_id          = 'stag-dribbble';
		$this->widget_cssclass    = 'stag-dribbble';
		$this->widget_description = __( 'Display your latest Dribbble shots.', 'stag' );
		$this->widget_name        = __( 'Stag Dribbble Shots', 'stag' );
		$this->settings           = array(
			'title' => array(
				'type'  => 'text',
				'std'   => 'Latest Shots',
				'label' => __( 'Title:', 'stag' ),
			),
			'dribbble_name' => array(
				'type'  => 'text',
				'std'   => 'Codestag',
				'label' => __( 'Dribbble Username:', 'stag' ),
			),
			'access_token' => array(
				'type'  => 'text',
				'std'   => '',
				'label' => __( 'Client Access Token:', 'stag' ),
				'description' => sprintf(
					/* translators: %s: Dribbble API application URL. */
					__( 'You need a client access token from Dribbble in order to access their API. Create an <a href="%s" target="_blank">application</a> and enter the access token.', 'stag' ),
					'https://dribbble.com/account/applications'
				),
			),
			'count' => array(
				'type'  => 'number',
				'std'   => 4,
				'label' => __( 'Number of shots to show:', 'stag' ),
				'step'  => 1,
				'min'   => 1,
				'max'   => 10,
			),
		);

		parent::__construct();
	}

	public function widget( $args, $instance ) {
		if ( $this->get_cached_widget( $args ) )
			return;

		ob_start();

		extract( $args );

		echo $before_widget;

		$title         = apply_filters( 'widget_title', $instance['title'] );
		$dribbble_name = esc_html( $instance['dribbble_name'] );
		$access_token  = esc_html( $instance['access_token'] );
		$count         = absint( $instance['count'] );
		$index         = 0;

		if ( '' === $access_token ) {
			?>
			<p class="stag-alert stag-alert--red">
				<?php esc_html_e( 'Please fill-in all widget settings.', 'stag' ); ?>
			</p>
			<?php
			return;
		}

		$shots = $this->dribbble_shots( $dribbble_name, $access_token );
		?>


		<div class='stag-dribbble-widget'>
			<?php if ( $title ) echo $before_title . $title . $after_title; ?>

			<ul class="dribbbles">
				<?php if ( ! empty( $shots ) ) : ?>
					<?php foreach ( $shots as $shot ) : ?>
					<li class="dribbble-shot">
						<a href="<?php echo esc_url( $shot->html_url ); ?>" class="dribbble-link" title="<?php echo esc_attr( $shot->title ); ?>">
							<img src="<?php echo esc_url( $shot->images->normal ); ?>" srcset="<?php echo esc_url( $shot->images->normal ); ?> 1x, <?php echo esc_url( $shot->images->hidpi ); ?> 2x" alt="<?php echo esc_attr( $shot->title ); ?>" width="<?php echo esc_attr( $shot->width ); ?>" height="<?php echo esc_attr( $shot->height ); ?>">
						</a>
					</li>
					<?php
					$index++;
					if ( $index === $count ) break;
					?>
					<?php endforeach; ?>
				<?php endif; ?>
			</ul>
		</div>

		<?php
		echo $after_widget;

		$content = ob_get_clean();

		echo $content;

		$this->cache_widget( $args, $content );
	}

	public static function register() {
		register_widget( __CLASS__ );
	}

	/**
	 * Get Dribbble shots.
	 *
	 * @param string $username Dribbble username.
	 * @param string $access_token Client access token.
	 *
	 * @since 2.2.0.
	 *
	 * @return mixed
	 */
	public function dribbble_shots( $username, $access_token ) {
		if ( '' === ( $username || $access_token ) ) return;

		$shots = get_transient( 'st_dribbble_' . sanitize_title_with_dashes( $username ) );

		if ( empty( $shots ) || false === $shots ) {
			$remote_url = "https://api.dribbble.com/v1/users/{$username}/shots?access_token={$access_token}";
			$request    = wp_remote_get( $remote_url, array(
				'sslverify' => false,
			) );

			if ( is_wp_error( $request ) ) {
				return false;
			} else {
				$body  = wp_remote_retrieve_body( $request );
				$shots = json_decode( $body );

				if ( ! empty( $shots ) ) {
					set_transient( 'st_dribbble_' . sanitize_title_with_dashes( $username ), $shots, DAY_IN_SECONDS );
				}
			}
		}

		return $shots;
	}
}

add_action( 'widgets_init', array( 'Stag_Dribbble', 'register' ) );
