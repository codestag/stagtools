<?php

add_action( 'widgets_init', create_function( '', 'return register_widget( "stag_flickr_widget" );' ) );

class stag_flickr_widget extends WP_Widget{
	
	function stag_flickr_widget() {
		$widget_ops = array( 'classname' => 'stag-flickr', 'description' => __( 'Display your latest Flickr photos', 'stag' ) );
		$control_ops = array( 'width' => 200, 'height' => 350, 'id_base' => 'stag-flickr' );
		$this->WP_Widget( 'stag-flickr', __( 'Stag Flickr Photos', 'stag' ), $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );
		
		$title        = apply_filters( 'widget_title', $instance['title'] );
		$flickr_id    = $instance['flickr_id'];
		$flickr_count = $instance['flickr_count'];
		
		include_once(ABSPATH . WPINC . '/feed.php');
		if( $flickr_count == '') $flickr_count = 5;

		$rss = fetch_feed('http://api.flickr.com/services/feeds/photos_public.gne?ids='.$flickr_id.'&lang=en-us&format=rss_200');
		add_filter( 'wp_feed_cache_transient_lifetime', create_function( '$a', 'return 1800;' ) );

		if( !is_wp_error( $rss ) ){
			$items = $rss->get_items( 0, $rss->get_item_quantity( $flickr_count ) );
		}

		echo $before_widget;

?>
	
	<div class='stag-flickr-widget'>
		<?php if ( $title ) echo $before_title . $title . $after_title; ?>
		<ul class="flickr-photos">
			<?php

			foreach( $items as $item ) {
				$image_group = $item->get_item_tags('http://search.yahoo.com/mrss/', 'thumbnail');
				$image_attrs = $image_group[0]['attribs'];
				foreach( $image_attrs as $image ) {
					$url = $image['url'];
					$width = $image['width'];
					$height = $image['height'];
					echo '<li><a target="_blank" href="' . $item->get_permalink() . '"><img src="'. $url .'" width="' . $width . '" height="' . $height . '" alt="'. $item->get_title() .'"></a></li>';
				}
			}

			?>
		</ul>
	</div>

<?php
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		
		$instance['title']        = strip_tags( $new_instance['title'] );
		$instance['flickr_id']    = strip_tags( $new_instance['flickr_id'] );
		$instance['flickr_count'] = strip_tags( $new_instance['flickr_count'] );

		return $instance;
	}

	function form( $instance ){
		$defaults = array(
			'title'        => __( 'Flickr Photos', 'stag' ),
			'flickr_id'    => '',
			'flickr_count' => 4,
		);

		$instance = wp_parse_args( (array) $instance, $defaults );

		?>

		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title:', 'stag' ); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>">
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('flickr_id'); ?>"><?php _e( 'Your Flickr User ID:', 'stag' ); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('flickr_id'); ?>" name="<?php echo $this->get_field_name('flickr_id'); ?>" value="<?php echo $instance['flickr_id']; ?>">
			<span class="description"><?php echo sprintf( __( 'Head over to %s to find your Flickr user ID.', 'stag' ), '<a href="//idgettr.com" target="_blank" rel="nofollow">idgettr</a>' ); ?></span>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('flickr_count'); ?>"><?php _e( 'Number of photos to show:', 'stag' ); ?></label>
			<input type="text" class="small-text" id="<?php echo $this->get_field_id('flickr_count'); ?>" name="<?php echo $this->get_field_name('flickr_count'); ?>" value="<?php echo $instance['flickr_count']; ?>">
		</p>


		<?php
	}

}
