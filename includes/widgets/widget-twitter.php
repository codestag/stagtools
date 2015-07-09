<?php
/**
 * Display your latest Dribbble shots.
 *
 * @package StagTools
 * @see ST_Widget
 * @since 2.0.0
 */
class Stag_Twitter extends ST_Widget {
	public function __construct() {
		$this->widget_id          = 'stag-twitter';
		$this->widget_cssclass    = 'stag-twitter';
		$this->widget_description = __( 'Display a list of a user&rsquo;s latest tweets.', 'stag' );
		$this->widget_name        = __( 'Stag Twitter Feed', 'stag' );
		$this->settings           = array(
			'title' => array(
				'type'  => 'text',
				'std'   => 'Tweets',
				'label' => __( 'Title:', 'stag' ),
			),
			'twitter_id' => array(
				'type'  => 'text',
				'std'   => null,
				'label' => __( 'Twitter Username:', 'stag' ),
			),
			'count' => array(
				'type'  => 'number',
				'std'   => 5,
				'label' => __( 'Number of Tweets to show:', 'stag' ),
				'step'  => 1,
				'min'   => 1,
				'max'   => 50,
			),
			'twitter_hide_replies' => array(
				'type'  => 'checkbox',
				'std'   => false,
				'label' => __( 'Hide @ Replies', 'stag' ),
			),
			'twitter_hide_retweets' => array(
				'type'  => 'checkbox',
				'std'   => false,
				'label' => __( 'Hide Retweets', 'stag' ),
			),
			'show_time_stamp' => array(
				'type'  => 'checkbox',
				'std'   => true,
				'label' => __( 'Show Tweet Timestamp', 'stag' ),
			),
			'twitter_duration' => array(
				'type'    => 'select',
				'std'     => '60',
				'label'   => __( 'Load new Tweets every:', 'stag' ),
				'options' => array(
					'5'    => __( '5 Minutes', 'stag' ),
					'15'   => __( '15 Minutes', 'stag' ),
					'30'   => __( '30 Minutes', 'stag' ),
					'60'   => __( '1 Hour', 'stag' ),
					'120'  => __( '2 Hours', 'stag' ),
					'240'  => __( '4 Hours', 'stag' ),
					'720'  => __( '12 Hours', 'stag' ),
					'1440' => __( '24 Hours', 'stag' ),
				),
			),
			'follow_link_show' => array(
				'type'  => 'checkbox',
				'std'   => false,
				'label' => __( 'Include link to twitter page?', 'stag' ),
			),
			'follow_link_text' => array(
				'type'  => 'text',
				'std'   => 'Follow on twitter',
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
	function widget( $args, $instance ) {
		if ( $this->get_cached_widget( $args ) )
			return;

		ob_start();

		echo $args['before_widget'];

		$title = apply_filters( 'widget_title', $instance['title'] );

		if ( $title ) echo $args['before_title'] . $title . $args['after_title'];

		self::tweets_list( $instance );

		if ( $instance['follow_link_show'] && $instance['follow_link_text'] ) {
			echo '<a href="' . esc_url( 'https://twitter.com/'. $instance['twitter_id'] ) .'" class="stag-button twitter-follow-button" target="_blank">'. esc_html( $instance['follow_link_text'] ) .'</a>';
		}

		echo $args['after_widget'];

		$content = ob_get_clean();

		echo $content;

		$this->cache_widget( $args, $content );
	}

	/**
	 * Gets and displays an html list of formatted tweets
	 *
	 * @param  array $settings Settings for grabbing tweets
	 */
	public static function tweets_list( $settings ) {
		echo self::get_tweets_list( $settings );
	}

	/**
	 * Gets an html list of formatted tweets
	 *
	 * @param  array  $settings Settings for grabbing tweets
	 * @return string           Html list of formatted tweets
	 */
	public static function get_tweets_list( $settings ) {
		$list_format  = apply_filters( 'stag_twitter_tweet_list_format', "<ul class=\"stag-latest-tweets\">\n%s</ul>\n", $settings );
		$tweet_format = apply_filters( 'stag_twitter_tweet_format', "\t<li>%s</li>\n", $settings );

		$list   = '';
		$tweets = self::get_tweets( $settings );

		foreach ( (array) $tweets as $tweet ) {
			$list .= sprintf( $tweet_format, $tweet );
		}

		return sprintf( $list_format, $list );
	}

	/**
	 * Gets array of formatted tweets (cached in a transient).
	 *
	 * @param  array  $settings Settings for grabbing tweets.
	 * @return array            Array of formatted tweets.
	 */
	public static function get_tweets( $settings ) {
		$twitter_id       = $settings['twitter_id'];

		if ( ! trim( $twitter_id ) ) {
			return self::do_error( __( 'Please provide a Twitter Username.', 'codestag' ) );
		}

		$twitter_num      = (int) $settings['count'];
		$twitter_duration = absint( $settings['twitter_duration'] ) < 1 ? 60 : absint( $settings['twitter_duration'] );

		// create our transient ID
		$trans_id = $twitter_id .'-'. $twitter_num .'-'. $twitter_duration;

		// Should we reset our data?
		$reset_trans = isset( $_GET['delete-trans'] ) && $_GET['delete-trans'] == true;

		// If we're resetting the transient, or our transient is expired
		if ( $reset_trans || ! ( $tweets = get_transient( $trans_id ) ) ) {
			$hide_replies  = $settings['twitter_hide_replies'];
			$hide_retweets = $settings['twitter_hide_retweets'];
			$show_time     = $settings['show_time_stamp'];
			$number        = ( $hide_replies || $hide_retweets ) ? $twitter_num + 80 : $twitter_num;
			$tweets        = array();

			// Make sure we have our Twitter class
			if ( ! class_exists( 'TwitterWP' ) ) {
				require_once( 'lib/TwitterWP/lib/TwitterWP.php' );
			}

			$stag_options = get_option( 'stag_options' );

			if ( empty( $stag_options['consumer_key'] ) || empty( $stag_options['consumer_secret'] ) || empty( $stag_options['access_key'] ) || empty( $stag_options['access_secret'] ) ) {
				return self::do_error( sprintf( __( 'Please fill in the <a href="%s">Twitter oAuth settings</a>', 'stag' ), admin_url( 'options-general.php?page=stagtools' ) ) );
			}

			// Initiate our Twitter app
			$tw = TwitterWP::start( array(
				$stag_options['consumer_key'],
				$stag_options['consumer_secret'],
				$stag_options['access_key'],
				$stag_options['access_secret'],
			) );

			if ( is_wp_error( $tw ) ) {
				return self::do_error( is_user_logged_in() ? $tw->show_wp_error( $tw, false ) : '' );
			}

			// Retrieve tweets from the api
			$twitter = $tw->get_tweets( $twitter_id, $number );

			if ( ! $twitter ) {
				return array( __( 'The Twitter API is taking too long to respond. Please try again later.', 'stag' ) );
			} elseif ( is_wp_error( $twitter ) ) {
				return self::do_error( is_user_logged_in() ? $tw->show_wp_error( $twitter, false ) : '' );
			}

			$count = 1;

			// Build the tweets array
			foreach ( (array) $twitter as $tweet ) {

				if ( $hide_retweets && property_exists( $tweet, 'retweeted_status' ) )
					continue;

				// Don't include @ replies (if applicable)
				if ( $hide_replies && $tweet->in_reply_to_user_id )
					continue;

				// Format tweet (hashtags, links, etc)
				$content = self::twitter_linkify( $tweet->text );

				if ( $show_time ) {
					// Calculate time difference
					$timeago = sprintf( __( '%s ago', 'stag' ), human_time_diff( strtotime( $tweet->created_at ) ) );
					$timeago_link = sprintf( '<a href="%s" rel="nofollow">%s</a>', esc_url( sprintf( 'https://twitter.com/%s/status/%s', $twitter_id, $tweet->id_str ) ), esc_html( $timeago ) );
					// Include timestamp
					$content .= '<time class="time time-ago" datetime="' . $tweet->created_at . '">'. $timeago_link .'</time>'."\n";
				}

				// Add tweet to array
				$tweets[] = apply_filters( 'stag_twitter_tweet_content', $content, $tweet, $settings );

				// Stop the loop if we've got enough tweets
				if ( $hide_replies && $count >= $twitter_num ) {
					break;
				}

				$count++;
			}

			// Just in case
			$tweets = array_slice( (array) $tweets, 0, $twitter_num );

			$time = ( $twitter_duration * 60 );

			// Save tweets to a transient
			set_transient( $trans_id, $tweets, $time );
		}

		return $tweets;
	}

	/**
	 * Parses tweets and generates HTML anchor tags around URLs, usernames,
	 * username/list pairs and hashtags.
	 *
	 * @link https://github.com/mzsanford/twitter-text-php
	 *
	 * @param  string $content Tweet content
 	 * @return string          Modified tweet content
	 */
	public static function twitter_linkify( $content ) {
		if ( ! class_exists( 'Twitter_Regex' ) ) {
			require_once( 'lib/TwitterText/lib/Twitter/Autolink.php' );
		}

		return Twitter_Autolink::create( $content, true )
				->setNoFollow( false )->setExternal( true )->setTarget( '_blank' )
				->setUsernameClass( 'tweet-url username' )
				->setListClass( 'tweet-url list-slug' )
				->setHashtagClass( 'tweet-url hashtag' )
				->setURLClass( 'tweet-url tweek-link' )
				->addLinks();
	}

	public static function register() {
		register_widget( __CLASS__ );
	}

	/**
	 * Return error message in an array.
	 *
	 * @param  string $msg Error message (optional).
	 * @return array       Error message in an array.
	 */
	public static function do_error( $msg = '' ) {
		$msg = $msg ? $msg : self::$error;
		return array( apply_filters( 'stag_twitter_error', $msg ) );
	}
}

add_action( 'widgets_init', array( 'Stag_Twitter', 'register' ) );
