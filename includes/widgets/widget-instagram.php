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
				'title'            => array(
					'type'  => 'text',
					'std'   => __( 'Instagram Photos', 'stag' ),
					'label' => __( 'Title:', 'stag' ),
				),
				'username'         => array(
					'type'        => 'text',
					'std'         => null,
					'placeholder' => 'myusername',
					'label'       => __( 'Instagram Username:', 'stag' ),
				),
				'count'            => array(
					'type'  => 'number',
					'std'   => 9,
					'label' => __( 'Photo Count (max 12):', 'stag' ),
					'step'  => 1,
					'min'   => 1,
					'max'   => 12,
				),
				'size'             => array(
					'type'    => 'select',
					'std'     => 'thumbnail',
					'label'   => __( 'Photo Size:', 'stag' ),
					'options' => array(
						'thumbnail' => __( 'Thumbnail', 'stag' ),
						'small'     => __( 'Small', 'stag' ),
						'large'     => __( 'Large', 'stag' ),
						'original'  => __( 'Original', 'stag' ),
					),
				),
				'cachetime'        => array(
					'type'  => 'number',
					'std'   => 2,
					'label' => __( 'Cache time (in hours):', 'stag' ),
					'step'  => 1,
					'min'   => 1,
					'max'   => 500,
				),
				'follow_link_show' => array(
					'type'  => 'checkbox',
					'std'   => false,
					'label' => __( 'Include link to Instagram page?', 'stag' ),
				),
				'follow_link_text' => array(
					'type'  => 'text',
					'std'   => 'Follow on Instagram',
					'label' => __( 'Link Text:', 'stag' ),
				),
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
		public function widget( $args, $instance ) {
			if ( $this->get_cached_widget( $args ) ) {
				return;
			}

			ob_start();

			extract( $args );

			echo $before_widget; // WPCS: XSS Ok.

			$title     = apply_filters( 'widget_title', $instance['title'] );
			$username  = esc_html( $instance['username'] );
			$count     = absint( $instance['count'] );
			$size      = esc_html( $instance['size'] );
			$cachetime = absint( $instance['cachetime'] );

			$insta = $this->scrape_instagram( $username, $cachetime );

			if ( $title ) {
				echo $before_title . $title . $after_title; // WPCS: XSS Ok.
			}

			// And if we have Instagrams.
			if ( is_array( $insta ) ) :

				// slice list down to required limit.
				$insta = array_slice( $insta, 0, $count );

				?>

				<ul class="instagram-widget stag-instagram-widget stag-instagram-widget--size-<?php echo esc_attr( $size ); ?>">
					<?php
					foreach ( $insta as $image ) {
							echo apply_filters(
								'st_instagram_widget_image_html', sprintf(
									'<li class="stag-instagram-widget__item"><a href="%1$s"><img class="instagram-image" src="%2$s" alt="%3$s" title="%3$s" /></a></li>',
									esc_url( $image['link'] ),
									esc_url( $image[ $size ] ),
									esc_html( $image['description'] )
								), $image
							);
					}
					?>

					</ul>

					<?php if ( $instance['follow_link_show'] && $instance['follow_link_text'] ) : ?>
					<a class="stag-button instagram-follow-link" href="https://instagram.com/<?php echo esc_html( $username ); ?>"><?php echo esc_html( $instance['follow_link_text'] ); ?></a>
					<?php endif; ?>
				<?php
			endif;

			echo $after_widget; // WPCS: XSS Ok.

			$content = ob_get_clean();

			echo $content; // WPCS: XSS Ok.

			$this->cache_widget( $args, $content );
		}

		/**
		 * Register class.
		 *
		 * @return void
		 */
		public static function register() {
			register_widget( __CLASS__ );
		}

		/**
		 * Scrapge Instagram data from webpage.
		 * Based on https://gist.github.com/cosmocatalano/4544576
		 *
		 * @param  string $username Instagram username.
		 * @param  string $cachetime Cache time.
		 * @return mixed
		 */
		protected function scrape_instagram( $username, $cachetime ) {
			$username  = trim( strtolower( $username ) );
			$instagram = get_transient( 'st_instagram_' . sanitize_title_with_dashes( $username ) );

			if ( false === $instagram ) {
				switch ( substr( $username, 0, 1 ) ) {
					case '#':
						$url = 'https://instagram.com/explore/tags/' . str_replace( '#', '', $username );
						break;

					default:
						$url = 'https://instagram.com/' . str_replace( '@', '', $username );
						break;
				}

				$remote = wp_remote_get( $url );

				if ( is_wp_error( $remote ) ) {
					return new WP_Error( 'site_down', esc_html__( 'Unable to communicate with Instagram.', 'stag' ) );
				}

				if ( 200 !== wp_remote_retrieve_response_code( $remote ) ) {
					return new WP_Error( 'invalid_response', esc_html__( 'Instagram did not return a 200.', 'stag' ) );
				}

				$shards      = explode( 'window._sharedData = ', $remote['body'] );
				$insta_json  = explode( ';</script>', $shards[1] );
				$insta_array = json_decode( $insta_json[0], true );

				if ( ! $insta_array ) {
					return new WP_Error( 'bad_json', esc_html__( 'Instagram has returned invalid data.', 'stag' ) );
				}

				if ( isset( $insta_array['entry_data']['ProfilePage'][0]['user']['media']['nodes'] ) ) {
					$images = $insta_array['entry_data']['ProfilePage'][0]['user']['media']['nodes'];
				} elseif ( isset( $insta_array['entry_data']['TagPage'][0]['graphql']['hashtag']['edge_hashtag_to_media']['edges'] ) ) {
					$images = $insta_array['entry_data']['TagPage'][0]['graphql']['hashtag']['edge_hashtag_to_media']['edges'];
				} else {
					return new WP_Error( 'bad_json_2', esc_html__( 'Instagram has returned invalid data.', 'stag' ) );
				}

				if ( ! is_array( $images ) ) {
					return new WP_Error( 'bad_array', esc_html__( 'Instagram has returned invalid data.', 'stag' ) );
				}

				$instagram = array();

				foreach ( $images as $image ) {
					switch ( substr( $username, 0, 1 ) ) {
						case '#':
							if ( true === $image['node']['is_video'] ) {
								$type = 'video';
							} else {
								$type = 'image';
							}

							$caption = __( 'Instagram Image', 'stag' );
							if ( ! empty( $image['node']['edge_media_to_caption']['edges'][0]['node']['text'] ) ) {
								$caption = $image['node']['edge_media_to_caption']['edges'][0]['node']['text'];
							}

							$instagram[] = array(
								'description' => $caption,
								'link'        => trailingslashit( '//instagram.com/p/' . $image['node']['shortcode'] ),
								'time'        => $image['node']['taken_at_timestamp'],
								'comments'    => $image['node']['edge_media_to_comment']['count'],
								'likes'       => $image['node']['edge_liked_by']['count'],
								'thumbnail'   => preg_replace( '/^https?\:/i', '', $image['node']['thumbnail_resources'][0]['src'] ),
								'small'       => preg_replace( '/^https?\:/i', '', $image['node']['thumbnail_resources'][2]['src'] ),
								'large'       => preg_replace( '/^https?\:/i', '', $image['node']['thumbnail_resources'][4]['src'] ),
								'original'    => preg_replace( '/^https?\:/i', '', $image['node']['display_url'] ),
								'type'        => $type,
							);
							break;

						default:
							if ( true === $image['is_video'] ) {
								$type = 'video';
							} else {
								$type = 'image';
							}

							$caption = __( 'Instagram Image', 'wp-instagram-widget' );
							if ( ! empty( $image['caption'] ) ) {
								$caption = $image['caption'];
							}

							$instagram[] = array(
								'description' => $caption,
								'link'        => trailingslashit( '//instagram.com/p/' . $image['code'] ),
								'time'        => $image['date'],
								'comments'    => $image['comments']['count'],
								'likes'       => $image['likes']['count'],
								'thumbnail'   => preg_replace( '/^https?\:/i', '', $image['thumbnail_resources'][0]['src'] ),
								'small'       => preg_replace( '/^https?\:/i', '', $image['thumbnail_resources'][2]['src'] ),
								'large'       => preg_replace( '/^https?\:/i', '', $image['thumbnail_resources'][4]['src'] ),
								'original'    => preg_replace( '/^https?\:/i', '', $image['display_src'] ),
								'type'        => $type,
							);
							break;
					}
				}  // End foreach().

				// Do not set an empty transient - should help catch private or empty accounts.
				if ( ! empty( $instagram ) ) {
					$instagram = base64_encode( serialize( $instagram ) );
					set_transient( 'st_instagram_' . sanitize_title_with_dashes( $username ), $instagram, apply_filters( 'null_instagram_cache_time', HOUR_IN_SECONDS * $cachetime ) );
				}
			}

			if ( ! empty( $instagram ) ) {
				return unserialize( base64_decode( $instagram ) );
			} else {
				return new WP_Error( 'no_images', esc_html__( 'Instagram did not return any images.', 'stag' ) );
			}
		}
	}
endif;

add_action( 'widgets_init', array( 'Stag_Instagram', 'register' ) );
