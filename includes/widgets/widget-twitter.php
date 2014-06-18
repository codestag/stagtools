<?php

add_action( 'widgets_init', create_function( '', 'return register_widget( "stag_twitter_widget" );' ) );

class stag_twitter_widget extends WP_Widget{

	function stag_twitter_widget() {
		$widget_ops = array( 'classname' => 'stag-twitter', 'description' => __( 'Display your latest tweets', 'stag' ) );
		$control_ops = array( 'width' => 200, 'height' => 350, 'id_base' => 'stag-twitter' );
		$this->WP_Widget( 'stag-twitter', __( 'Stag Twitter Feed', 'stag' ), $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
		extract($args);

		$title              = apply_filters('widget_title', $instance['title'] );
		$cache_time         = $instance['cache_time'];
		$twitter_username   = $instance['twitter_username'];
		$tweet_count        = $instance['tweet_count'];
		$show_retweets      = $instance['show_retweets'];
		$show_replies       = $instance['show_replies'];
		$show_follow_button = $instance['show_follow_button'];

		echo $before_widget;

	?>

	<div class="stag-twitter-widget">
		<?php

		if ( $title ) { echo $before_title . $title . $after_title; }

		$stag_options = get_option( 'stag_options' );

		if( empty($stag_options['consumer_key']) || empty($stag_options['consumer_secret']) || empty($stag_options['access_key']) || empty($stag_options['access_secret']) ) {
			echo '<strong>' . __( 'Please fill all widget settings.', 'stag' ) . '</strong></div>' . $after_widget;
			return;
		}

		$tw_helper = new StagTWHelper();
		$transient = 'stag_twitter_widget_' . $twitter_username;
		$timeout = $cache_time * HOUR_IN_SECONDS;

		if ( false === get_transient( $transient ) ) {
			$connection = $tw_helper->getConnectionWithAccessToken( $stag_options['consumer_key'], $stag_options['consumer_secret'], $stag_options['access_key'], $stag_options['access_secret'] );

			$url = add_query_arg( array( 'screen_name' => $instance['twitter_username'], 'count' => $instance['tweet_count'] ), 'https://api.twitter.com/1.1/statuses/user_timeline.json' );

			if( $instance['show_replies'] == 1 ) {
				$url = add_query_arg( array( 'exclude_replies' => "false" ), $url );
			} else {
				$url = add_query_arg( array( 'exclude_replies' => "true" ), $url );
			}

			if( $instance['show_retweets'] == 1) {
				$url = add_query_arg( array( 'include_rts' => "true" ), $url );
			} else {
				$url = add_query_arg( array( 'include_rts' => "false" ), $url );
			}

			$tweets = $connection->get( $url );

			if( !$tweets ) {
				_e( "Couldn't retrieve tweets! Wrong username!", "stag" );
				echo '</div>' . $after_widget;
				return;
			}


			if( !empty( $tweets->errors ) ) {
				if( $tweets->errors[0]->message == 'Invalid or expired token' ) {
					echo '<strong>' . $tweets->errors[0]->message . '!</strong>' . __( 'You will need to regenerate it <a href="//dev.twitter.com/apps">here</a>.', 'stag' ) . $after_widget;
				}else{
					echo '<strong>' . $tweets->errors[0]->message . '</strong>' . $after_widget;
				}
				return;
			}

			for( $i = 0; $i <= count($tweets); $i++) {
				if( !empty($tweets[$i]) ) {
					$tweets_array[$i]['created_at'] = $tweets[$i]->created_at;
					$tweets_array[$i]['text']       = $tweets[$i]->text;
					$tweets_array[$i]['status_id']  = $tweets[$i]->id_str;
				}
			}

			set_transient( $transient, serialize($tweets_array), $timeout );
		}

		$widget_tweets = maybe_unserialize( get_transient( $transient ) );

		if( !empty( $widget_tweets ) ) {
			$output = '<ul>';
			$count = 1;
			$protocol = is_ssl() ? 'https:' : 'http:';

			foreach( $widget_tweets as $tweet ) {
				$output .= '<li><p>';
				$output .= $tw_helper->twitter_widget_convert_links( $tweet['text'] );
				$output .= '</p>';
				$output .= '<p><time datetime="'. $tweet['created_at'] .'" class="time"><a href="'. $protocol .'//twitter.com/'. $twitter_username .'/statuses/'. $tweet['status_id'] .'" target="_blank">'. $tw_helper->twitter_widget_relative_time( $tweet['created_at'] ) .'</a></time></p>';
				$output .= '</li>';

				if( $count == $instance['tweet_count'] ) { break; }
				$count++;
			}

			$output .= '</ul>';

			if ( (bool) $show_follow_button == 1 ) {
				$output .= "<a class='button twitter-follow-button' href='". esc_url( 'https://twitter.com/'. $twitter_username ) ."'>". __( 'Follow', 'stag' ) ."</a>";
			}

			echo $output;
		}

		?>

	</div>

	<?php

	echo $after_widget;

	}

	function update( $new_instance, $old_instance) {
		$instance                       = $old_instance;
		$instance['title']              = strip_tags( $new_instance['title'] );
		$instance['cache_time']         = strip_tags( $new_instance['cache_time'] );
		$instance['twitter_username']   = strip_tags( $new_instance['twitter_username'] );
		$instance['tweet_count']        = strip_tags( $new_instance['tweet_count'] );
		$instance['show_retweets']      = strip_tags( $new_instance['show_retweets'] );
		$instance['show_replies']       = strip_tags( $new_instance['show_replies'] );
		$instance['show_follow_button'] = strip_tags( $new_instance['show_follow_button'] );

		return $instance;
	}

	function form( $instance ) {
		$defaults = array(
			'title'              => __( 'Tweets', 'stag' ),
			'cache_time'         => 2,
			'twitter_username'   => '',
			'tweet_count'        => 3,
			'show_retweets'      => '',
			'show_replies'       => '',
			'show_follow_button' => ''
		);

		$instance = wp_parse_args( (array) $instance, $defaults );
		?>
		<br>
		<p class="description">
			<?php echo sprintf( __( 'Make sure you have filled your twitter oAuth keys under %s.', 'stag' ), '<a href="'.admin_url( 'options-general.php?page=stagtools' ).'">settings</a>' ); ?>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title:', 'stag' ); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>">
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('twitter_username'); ?>"><?php _e( 'Twitter Handle:', 'stag' ); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('twitter_username'); ?>" name="<?php echo $this->get_field_name('twitter_username'); ?>" value="<?php echo $instance['twitter_username']; ?>">
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('cache_time'); ?>"><?php _e( 'Cache tweets in every ', 'stag' ); ?></label>
			<input type="number" class="small-text" id="<?php echo $this->get_field_id('cache_time'); ?>" name="<?php echo $this->get_field_name('cache_time'); ?>" value="<?php echo $instance['cache_time']; ?>">
			<?php _e( 'hours', 'stag' ); ?>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('tweet_count'); ?>"><?php _e( 'Number of tweets to show:', 'stag' ); ?></label>
			<input type="number" class="widefat" id="<?php echo $this->get_field_id('tweet_count'); ?>" name="<?php echo $this->get_field_name('tweet_count'); ?>" value="<?php echo $instance['tweet_count']; ?>">
		</p>

		<p>
			<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('show_retweets'); ?>" name="<?php echo $this->get_field_name('show_retweets'); ?>" value="1" <?php checked( $instance['show_retweets'], 1); ?>>
			<label for="<?php echo $this->get_field_id('show_retweets'); ?>"><?php _e( 'Show retweets?', 'stag' ); ?></label>
		</p>

		<p>
			<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('show_replies'); ?>" name="<?php echo $this->get_field_name('show_replies'); ?>" value="1" <?php checked( $instance['show_replies'], 1); ?>>
			<label for="<?php echo $this->get_field_id('show_replies'); ?>"><?php _e( 'Show replies?', 'stag' ); ?></label>
		</p>

		<p>
			<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('show_follow_button'); ?>" name="<?php echo $this->get_field_name('show_follow_button'); ?>" value="1" <?php checked( $instance['show_follow_button'], 1); ?>>
			<label for="<?php echo $this->get_field_id('show_follow_button'); ?>"><?php _e( 'Show Follow Button?', 'stag' ); ?></label>
		</p>

		<?php
	}
}

include_once('twitteroauth.php');
