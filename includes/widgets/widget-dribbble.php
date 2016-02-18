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

	function widget( $args, $instance ) {
		if ( $this->get_cached_widget( $args ) )
			return;

		ob_start();

		extract( $args );

		echo $before_widget;

		$title         = apply_filters( 'widget_title', $instance['title'] );
		$dribbble_name = esc_html( $instance['dribbble_name'] );
		$count         = absint( $instance['count'] );

		// Includes feed function
		include_once( ABSPATH . WPINC . '/feed.php' );

		$rss = fetch_feed( "https://dribbble.com/$dribbble_name/shots.rss" );

		add_filter( 'wp_feed_cache_transient_lifetime', create_function( '$a', 'return 1800;' ) );

		if ( ! is_wp_error( $rss ) ) {
			$items = $rss->get_items( 0, $rss->get_item_quantity( $count ) );
		}

		?>

		<div class='stag-dribbble-widget'>
			<?php if ( $title ) echo $before_title . $title . $after_title; ?>
			<ul class="dribbbles">
				<?php if ( isset( $items ) ) : ?>
				<?php foreach ( $items as $item ) :
					$shot_title       = $item->get_title();
					$shot_link        = $item->get_permalink();
					$shot_date        = $item->get_date( 'F d, Y' );
					$shot_description = $item->get_description();

					preg_match( '/src=\"(http.*(jpg|jpeg|gif|png))/', $shot_description, $shot_image_url );
					$shot_image = $shot_image_url[1];
				?>
				<li class="dribbble-shot">
					<a href="<?php echo esc_url( $shot_link ); ?>" class="dribbble-link" title="<?php echo $shot_title; ?>"><img src="<?php echo esc_url( $shot_image ); ?>" alt="<?php echo esc_attr( $shot_title ); ?>"></a>
				</li>
				<?php endforeach; ?>
				<?php else : ?>
				<?php _x( 'Please check your dribbble username', 'Dribbble username error message', 'stag' ); ?>
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
}

add_action( 'widgets_init', array( 'Stag_Dribbble', 'register' ) );
