<?php

add_action( 'widgets_init', create_function( '', 'return register_widget( "stag_instagram_widget" );' ) );

class stag_instagram_widget extends WP_Widget{

	function stag_instagram_widget() {
		$widget_ops = array( 'classname' => 'stag-instagram', 'description' => __( 'A widget that displays your Instagram feed, posts, or likes.', 'stag' ) );
		$control_ops = array( 'width' => 200, 'height' => 350, 'id_base' => 'stag-instagram' );
		$this->WP_Widget( 'stag-instagram', __( 'Stag Instagram Photos', 'stag' ), $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );

		echo $before_widget;

		$title     = apply_filters( 'widget_title', $instance['title'] );
		$username  = strtolower( $instance['username'] );
		$cachetime = empty($instance['cachetime']) ? 9 : $instance['cachetime'];
		$count     = empty($instance['count']) ? 9 : $instance['count'];
		$size      = empty($instance['size']) ? 'thumbnail' : $instance['size'];

		if ( $title ) echo $before_title . $title . $after_title;

		if( $username != '' ) {
			$images = $this->scrape_instagram( $username, $count, $cachetime );

			if( is_wp_error( $images ) ) {
				echo $images->get_error_message();
			} else {
				?>

				<div class="instragram-widget-wrapper size-<?php echo $size; ?>">
					<?php foreach( $images as $image ) : ?>
					<a href="<?php echo esc_url( $image['link'] ); ?>" title="<?php echo esc_attr( $image['description'] ); ?>" class="instagram_badge_image">
						<img src="<?php echo esc_url( str_replace( 'http:', '', $image[$size]['url']) ); ?>" alt="<?php echo esc_attr( $image['description'] ); ?>">
					</a>
					<?php endforeach; ?>
				</div>

				<?php
			}
		}

		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['title']     = esc_attr( $new_instance['title'] );
		$instance['username']  = esc_attr( $new_instance['username'] );
		$instance['size']      = esc_attr( $new_instance['size'] );
		$instance['cachetime'] = absint( $new_instance['cachetime'] );
		$instance['count']     = absint( $new_instance['count'] );

		return $instance;
	}

	function form( $instance ){
		$defaults = array(
			'title'     => __( 'Instagram Photos', 'stag' ),
			'username'  => '',
			'cachetime' => '5',
			'size'      => 'thumbnail',
			'count'     => 9,
		);

		$instance = wp_parse_args( (array) $instance, $defaults );

		?>

		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title:', 'stag' ); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>">
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('username'); ?>"><?php _e( 'Username:', 'stag' ); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('username'); ?>" name="<?php echo $this->get_field_name('username'); ?>" value="<?php echo $instance['username']; ?>">
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('count'); ?>"><?php _e( 'Number of Photos:', 'stag' ); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" value="<?php echo $instance['count']; ?>">
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('size'); ?>"><?php _e( 'Photo Size:', 'stag' ); ?></label>
			<select id="<?php echo $this->get_field_id('size'); ?>" name="<?php echo $this->get_field_name('size'); ?>" class="widefat">
				<option value="thumbnail" <?php selected('thumbnail', $instance['size']) ?>><?php _e('Thumbnail', 'stag'); ?></option>
				<option value="large" <?php selected('large', $instance['size']) ?>><?php _e('Large', 'stag'); ?></option>
			</select>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('cachetime'); ?>"><?php _e( 'Cache every:', 'stag' ); ?></label>
			<input type="text" class="small-text" id="<?php echo $this->get_field_id('cachetime'); ?>" name="<?php echo $this->get_field_name('cachetime'); ?>" value="<?php echo $instance['cachetime']; ?>"> hours
		</p>

		<?php
	}

	/**
	 * Instagram web scrape.
	 *
	 * @param  string  $username Instagram username.
	 * @param  integer $slice    Number of photos to display.
	 * @return array An array containing instagram photos.
	 */
	function scrape_instagram( $username, $slice = 9, $cachetime = 5 ) {
		if ( false === ( $instagram = get_transient( 'stag-instagram-photos-' . sanitize_title_with_dashes($username) ) ) ) {
			$remote = wp_remote_get( 'http://instagram.com/' . trim($username) );

			if (is_wp_error($remote)) {
	  			return new WP_Error( 'site_down', __('Unable to communicate with Instagram.', 'stag') );
			}

			if ( 200 != wp_remote_retrieve_response_code( $remote ) ) {
  				return new WP_Error( 'invalid_response', __('Instagram did not return a 200.', 'stag') );
			}

			$shards      = explode('window._sharedData = ', $remote['body']);
			$insta_json  = explode(';</script>', $shards[1]);
			$insta_array = json_decode($insta_json[0], TRUE);

			if (!$insta_array) {
	  			return new WP_Error( 'bad_json', __('Instagram has returned invalid data.', 'stag') );
			}

			$images = $insta_array['entry_data']['UserProfile'][0]['userMedia'];

			$instagram = array();
			foreach ($images as $image) {

				if ( $image['type'] == 'image' || $image['type'] == 'video' && $image['user']['username'] == $username ) {

					$instagram[] = array(
						'description' 	=> $image['caption']['text'],
						'link' 			=> $image['link'],
						'thumbnail' 	=> $image['images']['thumbnail'],
						'large' 		=> $image['images']['standard_resolution']
					);
				}
			}

			$instagram = base64_encode( serialize( $instagram ) );
			set_transient('stag-instagram-photos-'.sanitize_title_with_dashes($username), $instagram, apply_filters('null_instagram_cache_time', HOUR_IN_SECONDS * $cachetime ) );
		}

		$instagram = unserialize( base64_decode( $instagram ) );

		return array_slice( $instagram, 0, $slice );
	}
}
