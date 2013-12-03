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

		$title = apply_filters( 'widget_title', $instance['title'] );

		if ( $title ) echo $before_title . $title . $after_title;

		$access_token = self::getAccesstoken();

		/** Check settings and die if not set */
		if ( empty( $instance['clientid'] ) || !$access_token || empty( $instance['cachetime'] ) ) {
			_e( '<strong>Please fill all the widget settings and request an access token.</strong>', 'stag' ) . $after_widget;
			return;
		}

		/** Check if needs an update */
		$last_cache_time = self::getLastCacheTime();
		$diff            = time() - $last_cache_time;
		$crt             = $instance['cachetime'] * 3600;

		if ( $diff >= $crt || empty( $last_cache_time ) ) {
			
			/** Set URL endpoint depending on what to show */
			switch( $instance['show'] ) {
				case 'recent':
					$userid = self::getUserID();
					$endpoint_uri = "https://api.instagram.com/v1/users/{$userid}/media/recent/?count=8&access_token={$access_token}";
				break;

				case 'liked':
					$endpoint_uri = "https://api.instagram.com/v1/users/self/media/liked?count=8&access_token={$access_token}";
				break;

				default:
					$endpoint_uri = "https://api.instagram.com/v1/users/self/feed?count=8&access_token={$access_token}";
				break;
			}

			/** Once we have an endpoint URI */
			if ( isset( $endpoint_uri ) && !empty( $endpoint_uri ) ) {
				$ch = curl_init();

				curl_setopt( $ch, CURLOPT_URL, $endpoint_uri );
				curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );

				$result = curl_exec($ch);

				curl_close($ch);

				$result = json_decode($result);

				if ( @isset($result->meta->error_type) ) {
					$cache_error = 1;

					if ( $result->meta->error_type == 'OAuthAccessTokenError' || $result->meta->error_type == 'OAuthAccessTokenException' ) {
						self::deleteAccessToken();

						$cache_error = 2;
					}
				} else {
					$posts_array = array();

					if (@isset($result->data))
						foreach($result->data as $post) {
							$post_entry = array(
								"caption" => $post->caption == "null" ? "" : preg_replace('/[^(\x20-\x7F)]*/','', $post->caption->text),
								"link"    => $post->link,
								"image"   => $post->images->thumbnail->url
							);

							array_push($posts_array, $post_entry);
						}
				}
			}

			if ( @isset($posts_array) ) {
				self::setPostsCache($posts_array);
				self::setLastCacheTime(time());
			}

			echo '<!-- instagram cache has been updated! -->';

		}

		if( @isset( $cache_error ) ) {
			?>

			<p>Error while fetching cache:
			<?php
			switch ($cache_error) {
				case 1:
					_e( 'An undefined error occurred while contacting the Instagram API.', 'stag' );
					break;

				case 2:
					_e( 'The access token seems to be invalid or has expired.', 'stag' );
					break;
			}
			?>
			</p>
			
			<?php
		}

		$instagram_posts = self::getPostsCache();
		$instagram_posts = maybe_unserialize( $instagram_posts );

		if ( !empty( $instagram_posts ) ) {
			?>

			<div class="instragram-widget-wrapper">
				<?php

				$i = 0;

				foreach ( $instagram_posts as $post ) { ?>
					
				<a href="<?php echo $post['link']; ?>" target="_blank" id="instagram_badge_image_<?php echo $i; ?>" class="instagram_badge_image">
					<img src="<?php echo $post['image'] ?>" alt="<?php echo $post['caption']; ?>" />
				</a>

				<?php
					$i++;
				}

				?>
			</div>

			<?php
		} else {
			_e( '<strong>Could not retrieve Instagram posts.', 'stag' );
		}


	?>
		
<?php
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		
		$instance['title']        = strip_tags( $new_instance['title'] );
		$instance['clientid']     = strip_tags( $new_instance['clientid'] );
		$instance['clientsecret'] = strip_tags( $new_instance['clientsecret'] );
		$instance['cachetime']    = strip_tags( $new_instance['cachetime'] );
		$instance['show']         = strip_tags( $new_instance['show'] );

		if ( $old_instance['clientid'] != $new_instance['clientid']
		  || $old_instance['clientsecret'] != $new_instance['clientsecret']
		  || $old_instance['show'] != $new_instance['show']
		  || $old_instance['cachetime'] != $new_instance['cachetime']
		) {
			self::setLastCacheTime(0);

			if ( $old_instance['clientid'] != $new_instance['clientid'] || $old_instance['clientsecret'] != $new_instance['clientsecret'] ) {
				self::deleteAccessToken();
			}
		}
		
		return $instance;
	}

	function form( $instance ){
		$defaults = array(
			'title'        => __( 'Instagram Photos', 'stag' ),
			'clientid'     => '',
			'clientsecret' => '',
			'cachetime'    => '',
			'show'         => '5',
		);

		$instance = wp_parse_args( (array) $instance, $defaults );

		$prefix = (!empty($_SERVER['HTTPS']) ? "https://" : "http://");
		$uri_parts = explode('?', $_SERVER['REQUEST_URI'], 2);
		$redirectURI = $prefix . $_SERVER['HTTP_HOST'] . $uri_parts[0];

		$code = @$_GET['code'];

		// Check if code parameter (from Instagram oauth) was passed and if so, get the access token from the Instagram API
		$code_valid = @$_GET['code'];

		// Check if the code was sent for this object of the widget
		$widget_id_valid = @$_GET['widget_id'] == $this->id;

		if ( $code_valid && !self::getAccessToken() && $widget_id_valid ) {
			$ch = curl_init();

			curl_setopt( $ch, CURLOPT_URL, "https://api.instagram.com/oauth/access_token" );
			curl_setopt( $ch, CURLOPT_POSTFIELDS, 	"client_id=" . $instance['clientid'] .
													"&client_secret=" . $instance['clientsecret'] .
													"&grant_type=authorization_code" .
													"&redirect_uri=" . urlencode($redirectURI . "?widget_id=" . $this->id) .
													"&code=" . $code );

			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

			$result = curl_exec($ch);

			curl_close($ch);

			// JSON decode the result
			$result = json_decode($result);

			if (isset($result->access_token)) {
				self::setAccessToken($result->access_token);
				self::setUserID($result->user->id);
			}
		}

		// Retrieve the accesstoken
		$accesstoken = self::getAccessToken();

		?>

		<p>
			<span class="description">
				<?php echo sprintf( __( 'This widget requires that you register an application on the <a href="%s" target="_blank">Instagram Developer</a> page in order to access feed.', 'stag' ), 'http://instagram.com/developer' ) ?>

			</span>
				<?php if ( !isset( $accesstoken ) || empty( $accesstoken ) ) : ?>
					<br><br>
					<?php _e( 'Redirect URI:', 'stag' ); ?><br>
					<span style="color: #797979;"><?php echo sprintf( __( 'When registering your app, set the Redirect URI field to the following: &lsquo;%swidgets.php&rsquo;', 'stag' ), get_admin_url() ) ?></span>
				<?php endif; ?>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title:', 'stag' ); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>">
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('clientid'); ?>"><?php _e( 'Client ID:', 'stag' ); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('clientid'); ?>" name="<?php echo $this->get_field_name('clientid'); ?>" value="<?php echo $instance['clientid']; ?>">
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('clientsecret'); ?>"><?php _e( 'Client Secret:', 'stag' ); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('clientsecret'); ?>" name="<?php echo $this->get_field_name('clientsecret'); ?>" value="<?php echo $instance['clientsecret']; ?>">
		</p>
		
		<p>
			<label><?php _e( 'Access Token:', 'stag' ); ?></label>
			<?php
			$button_id = "getaccesstoken_" . rand();
			if ( empty( $accesstoken ) ) {
				echo '<span style="color: red;">'. __( 'Not available.', 'stag' ) .'</span>';
				echo "<br>";
				echo "<br>";

				if ( empty($instance['clientid']) || empty($instance['clientsecret'] ) ) {
					?>
					<span style="color: #797979;"><?php _e( 'Please set the "Client ID" and "Client Secret" fields and press save to retrieve the access token.', 'stag' ); ?></span>
					<br><br>
					<?php
				} else {
					
					?>

					<label><a href="javascript:void(0)" id="<?php echo $button_id; ?>"><?php _e( 'Get Access Token', 'stag' ); ?></a></label>
					<br>
					<span style="color: #797979;"><?php _e( 'Click to retrieve your access token.', 'stag' ); ?></span>

					<?php
				}
			} else {
				?>
				<label><span style="color: green;"><?php _e( 'Available', 'stag' ); ?></span></label>
				<?php
			}


			?>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'show' ); ?>"><?php _e('Show:', 'stag'); ?></label>
			<select id="<?php echo $this->get_field_id( 'show' ); ?>" name="<?php echo $this->get_field_name( 'show' ); ?>" class="widefat">
				<option value='recent' <?php if ( 'recent' == $instance['show'] ) echo 'selected="selected"'; ?>><?php _e( 'Recent Uploads', 'stag' ); ?></option>
				<option value='feed' <?php if ( 'feed' == $instance['show'] ) echo 'selected="selected"'; ?>><?php _e( 'Following', 'stag' ); ?></option>
				<option value='liked' <?php if ( 'liked' == $instance['show'] ) echo 'selected="selected"'; ?>><?php _e( 'Liked Posts', 'stag' ); ?></option>
			</select>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('cachetime'); ?>"><?php _e( 'Cache every:', 'stag' ); ?></label>
			<input type="text" class="small-text" id="<?php echo $this->get_field_id('cachetime'); ?>" name="<?php echo $this->get_field_name('cachetime'); ?>" value="<?php echo $instance['cachetime']; ?>"> hours
		</p>

		<script type="text/javascript">
			(function($){
				$(document).ready(function(){
					
					var getAccessTokenButton = $('#<?php echo $button_id; ?>');
					var newWindow = null;
					var timer = null;

					if( getAccessTokenButton ){
						getAccessTokenButton.on('click', function(e){
							var clientid = "<?php echo $instance['clientid']; ?>";
							var redirect_uri = window.location.href;
							redirect_uri = redirect_uri.indexOf('?') > -1 ? redirect_uri.split('?')[0] : redirect_uri;
							redirect_uri += "?widget_id=<?php echo $this->id; ?>";

							var form = document.createElement("form");
							form.setAttribute('id', 'instagram_auth');
							form.setAttribute('name', 'instagram_auth');
							form.setAttribute('action', 'https://api.instagram.com/oauth/authorize/');
							form.setAttribute('method', 'GET');

							var responseType = document.createElement('input');
							responseType.setAttribute('type', 'hidden');
							responseType.setAttribute('name', 'response_type');
							responseType.setAttribute('value', 'code');
							responseType.setAttribute('id', 'instagram_auth_response_type');

							var redirectURI = document.createElement('input');
							redirectURI.setAttribute('type', 'hidden');
							redirectURI.setAttribute('name', 'redirect_uri');
							redirectURI.setAttribute('value', redirect_uri);
							redirectURI.setAttribute('id', 'instagram_auth_redirect_uri');

							var clientID = document.createElement('input');
							clientID.setAttribute('type', 'hidden');
							clientID.setAttribute('name', 'client_id');
							clientID.setAttribute('value', clientid);
							clientID.setAttribute('id', 'instagram_auth_client_id');

							form.appendChild(responseType);
							form.appendChild(redirectURI);
							form.appendChild(clientID);

							form.submit();

							e.preventDefault();
							return false;
						});
					}

					function instagram_authentication_timer() {
						try {
							if (typeof newWindow.closeWindow == "function") {
								newWindow.closeWindow();
								clearInterval(timer);
								self.location.reload(true);
							}
						} catch(e) {}

						if (newWindow.closed) {
							clearInterval(timer);
							self.location.reload(true);
						}
					}

				});
			})(jQuery);
		</script>

		<?php
	}

	private function getAccesstoken() {
		$access_token = get_option( 'stag_instagram_accesstoken_' . $this->id );

		if ( isset( $access_token ) && !empty( $access_token ) )
			return $access_token;

		return false;
	}

	private function setAccessToken( $access_token ) {
		update_option( 'stag_instagram_accesstoken_' . $this->id, $access_token );
	}

	private function deleteAccessToken( $access_token ) {
		delete_option( 'stag_instagram_accesstoken_' . $this->id, $access_token );
	}

	private function getUserID() {
		return get_option( 'stag_instagram_userid_' . $this->id );
	}

	private function setUserID( $userid ) {
		update_option( 'stag_instagram_userid_' .$this->id, $userid );
	}

	private function getPostsCache() {
		return get_option( 'stag_instagram_posts_' . $this->id );
	}

	private function setPostsCache( $cache ) {
		update_option( 'stag_instagram_posts_' . $this->id, $cache );
	}

	private function getLastCacheTime() {
		return get_option( 'stag_instagram_last_cache_time_' . $this->id );
	}

	private function setLastCacheTime( $time ) {
		update_option( 'stag_instagram_last_cache_time_' . $this->id, $time );
	}

}

function stag_instagram_widget_admin_setup() {
	if ( 'post' == strtolower( $_SERVER['REQUEST_METHOD'] ) ) {
		$widget_id = $_POST['widget-id'];

		if ( isset( $_POST['delete_widget'] ) ) {
			if ( 1 == (int) $_POST['delete_widget'] ) {
				if ( strpos( $widget_id, 'stag-instagram' ) !== false ) {
					delete_option( 'stag_instagram_accesstoken_' . $widget_id );
					delete_option( 'stag_instagram_userid_' . $widget_id );
					delete_option( 'stag_instagram_posts_' . $widget_id );
					delete_option( 'stag_instagram_last_cache_time_' . $widget_id );
				}
			}
		}
	}
}
add_action( 'sidebar_admin_setup', 'stag_instagram_widget_admin_setup' );
