<?php
/**
 * Display your latest Dribbble shots.
 *
 * @package StagTools
 * @see ST_Widget
 */
class Stag_Flickr extends ST_Widget {
	public function __construct() {
		$this->widget_id          = 'stag-flickr';
		$this->widget_cssclass    = 'stag-flickr';
		$this->widget_description = __( 'Display your latest Flickr photos.', 'stag' );
		$this->widget_name        = __( 'Stag Flickr Photos', 'stag' );
		$this->settings           = array(
			'title' => array(
				'type'  => 'text',
				'std'   => 'Flickr Photos',
				'label' => __( 'Title:', 'stag' ),
			),
			'flickr_id' => array(
				'type'  => 'text',
				'std'   => null,
				'label' => __( 'Your Flickr User ID:', 'stag' ),
			),
			'flickr_id_desc' => array(
				'type'  => 'description',
				'std'   => sprintf( __( 'Head over to %s to find your Flickr user ID.', 'stag' ), '<a href="//idgettr.com" target="_blank" rel="nofollow">idgettr</a>' ),
			),
			'count' => array(
				'type'  => 'number',
				'std'   => 4,
				'label' => __( 'Number of photos to show:', 'stag' ),
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

		$title     = apply_filters( 'widget_title', $instance['title'] );
		$flickr_id = esc_attr( $instance['flickr_id'] );
		$count     = absint( $instance['count'] );

		include_once( ABSPATH . WPINC . '/feed.php' );

		$rss = fetch_feed( 'https://api.flickr.com/services/feeds/photos_public.gne?ids='. $flickr_id .'&lang=en-us&format=rss_200' );

		add_filter( 'wp_feed_cache_transient_lifetime', create_function( '$a', 'return 1800;' ) );

		if ( ! is_wp_error( $rss ) ) {
			$items = $rss->get_items( 0, $rss->get_item_quantity( $count ) );
		}

		echo $before_widget;
		?>

		<div class='stag-flickr-widget'>
			<?php if ( $title ) echo $before_title . $title . $after_title; ?>
			<ul class="flickr-photos">
				<?php

				if ( isset( $items ) ) {
					foreach ( $items as $item ) {

						$image_group = $item->get_item_tags( 'http://search.yahoo.com/mrss/', 'thumbnail' );
						$image_attrs = $image_group[0]['attribs'];

						foreach ( $image_attrs as $image ) {
							echo '<li><a target="_blank" href="' . esc_url( $item->get_permalink() ) . '"><img src="'. esc_url( $image['url'] ) .'" width="' . esc_attr( $image['width'] ) . '" height="' . esc_attr( $image['height'] ) . '" alt="'. esc_attr( $item->get_title() ) .'"></a></li>';
						}
					}
				} else {
					_e( 'Invalid flickr ID', 'stag' );
				}

				?>
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

add_action( 'widgets_init', array( 'Stag_Flickr', 'register' ) );
