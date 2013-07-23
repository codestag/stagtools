<?php

add_action( 'widgets_init', create_function( '', 'return register_widget( "stag_flickr_widget" );' ) );

class stag_flickr_widget extends WP_Widget{
	
	function stag_flickr_widget() {
		$widget_ops = array( 'classname' => 'stag-flickr', 'description' => __( 'Display your latest Flickr shots', 'stag' ) );
		$control_ops = array( 'width' => 200, 'height' => 350, 'id_base' => 'stag-flickr' );
		$this->WP_Widget( 'stag-flickr', __( 'Stag Flickr Photos', 'stag' ), $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );
		$flickr_id = $instance['flickr_id'];
		$flickr_count = $instance['flickr_count'];
		$new_window = $instance['new_window'];
		echo $before_widget;

?>
	
	<div class='stag-flickr-widget'>
		<?php if ( $title ) echo $before_title . $title . $after_title; ?>
		<ul class="flickr-photos">
			<?php

			if ( $flickr_id != '' ) {
				$images = array();
				$regx = "/<img(.+)\/>/";
				$rss_url = 'http://api.flickr.com/services/feeds/photos_public.gne?ids='.$flickr_id.'&lang=en-us&format=rss_200';

				$flickr_feed = simplexml_load_file( $rss_url );

				$image_count = 0;

				foreach( $flickr_feed->channel->item as $item ) {
					$img_src = $item->children("media", true)->thumbnail->attributes()->url;
					$img_height = $item->children("media", true)->thumbnail->attributes()->height;
					$img_width = $item->children("media", true)->thumbnail->attributes()->width;

					if( $flickr_count == '') $flickr_count = 5;

					if( $image_count < $flickr_count ) {
						echo '<li><a href="' . $item->link . '"><img src="'. $img_src .'" width="'.$img_width.'" height="'.$img_height.'" alt="'.$item->title.'"></a></li>';
					}
					$image_count++;
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
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['flickr_id'] = strip_tags( $new_instance['flickr_id'] );
		$instance['flickr_count'] = strip_tags( $new_instance['flickr_count'] );
		$instance['new_window'] = $new_instance['new_window'];
		return $instance;
	}

	function form( $instance ){
		$defaults = array(
			'title' => '',
			'flickr_id' => '',
			'flickr_count' => 4,
			'new_window' => ''
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

		<p>
			<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('new_window'); ?>" name="<?php echo $this->get_field_name('new_window'); ?>" value="1" <?php checked( $instance['new_window'], 1); ?>>
			<label for="<?php echo $this->get_field_id('new_window'); ?>"><?php _e( 'Open links in new window?', 'stag' ); ?></label>
		</p>

		<?php
	}

}

?>