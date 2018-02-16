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

		$title         = apply_filters( 'widget_title', $instance['title'] );
		$count         = absint( $instance['count'] );
		$index         = 0;

		$stag_options = get_option( 'stag_options' );
		if ( ! isset( $stag_options['dribbble_access_token'] ) || '' === $stag_options['dribbble_access_token'] ) {
			if ( current_user_can( 'edit_theme_options' ) ) :
			?>
			<p class="stag-alert stag-alert--red">
			<?php
				echo sprintf(
					__( 'Please generate an access token from <a href="">StagTools settings</a>', 'stag' ),
					admin_url( 'options-general.php?page=stagtools#stagtools_settings_general[dribbble_access_token]' )
				);
			?>
			</p>
			<?php
			endif;
			return;
		}

		$access_token = $stag_options['dribbble_access_token'];
		$shots = $this->dribbble_shots( $access_token, $count );

		echo $before_widget;

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
	 * @param int    $count Number of posts to return.
	 *
	 * @since 2.2.0.
	 *
	 * @return mixed
	 */
	public function dribbble_shots( $access_token, $count ) {
		if ( '' === $access_token ) return;

		$transient_key = "st_dribble_${access_token}_${count}";
		$shots         = get_transient( $transient_key );

		if ( empty( $shots ) || false === $shots ) {
			$remote_url = add_query_arg( array(
				'access_token' => $access_token,
				'per_page'     => $count,
			), 'https://api.dribbble.com/v2/user/shots' );

			$request    = wp_remote_get( $remote_url, array(
				'sslverify' => false,
			) );

			if ( is_wp_error( $request ) ) {
				return false;
			} else {
				$body  = wp_remote_retrieve_body( $request );
				$shots = json_decode( $body );

				if ( ! empty( $shots ) ) {
					set_transient( $transient_key, $shots, DAY_IN_SECONDS );
				}
			}
		}

		return $shots;
	}
}

add_action( 'widgets_init', array( 'Stag_Dribbble', 'register' ) );
