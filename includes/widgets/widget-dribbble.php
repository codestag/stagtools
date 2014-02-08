<?php

add_action( 'widgets_init', create_function( '', 'return register_widget( "stag_dribbble_widget" );' ) );

class stag_dribbble_widget extends WP_Widget{
	
	function stag_dribbble_widget() {
		$widget_ops = array( 'classname' => 'stag-dribbble', 'description' => __( 'Display your latest Dribbble shots', 'stag' ) );
		$control_ops = array( 'width' => 200, 'height' => 350, 'id_base' => 'stag-dribbble' );
		$this->WP_Widget( 'stag-dribbble', __( 'Stag Dribbble Shots', 'stag' ), $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {

		include_once(ABSPATH . WPINC . '/feed.php');

		$player_name = $instance['dribbble_name'];
		$shots = $instance['dribbble_shots'];

		$rss = fetch_feed( "http://dribbble.com/players/$player_name/shots.rss" );
		add_filter( 'wp_feed_cache_transient_lifetime', create_function( '$a', 'return 1800;' ) );
		if( !is_wp_error( $rss ) ){
			$items = $rss->get_items( 0, $rss->get_item_quantity( $shots ) );
		}

		extract( $args );

		$title          = apply_filters( 'widget_title', $instance['title'] );
		$dribbble_name  = $instance['dribbble_name'];
		$dribbble_shots = $instance['dribbble_shots'];
		$new_window     = $instance['new_window'];
		
		echo $before_widget;

?>
	
	<div class='stag-dribbble-widget'>
		<?php if ( $title ) echo $before_title . $title . $after_title; ?>
		<ul class="dribbbles">
			<?php if( isset( $items ) ) : ?>
			<?php foreach( $items as $item ) :
				$shot_title       = $item->get_title();
				$shot_link        = $item->get_permalink();
				$shot_date        = $item->get_date('F d, Y');
				$shot_description = $item->get_description();

				preg_match("/src=\"(http.*(jpg|jpeg|gif|png))/", $shot_description, $shot_image_url);
				$shot_image = $shot_image_url[1];
			?>
			<li class="dribbble-shot">
				<a href="<?php echo esc_url( $shot_link ); ?>" class="dribbble-link" title="<?php echo $shot_title; ?>" <?php if( $new_window == 1) echo 'target="_blank"'; ?>><img src="<?php echo $shot_image; ?>" alt="<?php echo $shot_title; ?>"></a>
			</li>
			<?php endforeach; ?>
			<?php else: ?>
			<?php _e( 'Please check your dribbble username', 'stag' ); ?>
			<?php endif; ?>
		</ul>
	</div>
	
<?php
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		
		$instance['title']          = strip_tags( $new_instance['title'] );
		$instance['dribbble_name']  = strip_tags( $new_instance['dribbble_name'] );
		$instance['dribbble_shots'] = strip_tags( $new_instance['dribbble_shots'] );
		$instance['new_window']     = $new_instance['new_window'];
		
		return $instance;
	}

	function form( $instance ){
		$defaults = array(
			'title' => __( 'Dribbble Shots', 'stag' ),
			'dribbble_name' => 'codestag',
			'dribbble_shots' => 4,
			'new_window' => ''
		);

		$instance = wp_parse_args( (array) $instance, $defaults );

		?>

		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title:', 'stag' ); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>">
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('dribbble_name'); ?>"><?php _e( 'Username:', 'stag' ); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('dribbble_name'); ?>" name="<?php echo $this->get_field_name('dribbble_name'); ?>" value="<?php echo $instance['dribbble_name']; ?>">
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('dribbble_shots'); ?>"><?php _e( 'Number of shots to show:', 'stag' ); ?></label>
			<input type="text" class="small-text" id="<?php echo $this->get_field_id('dribbble_shots'); ?>" name="<?php echo $this->get_field_name('dribbble_shots'); ?>" value="<?php echo $instance['dribbble_shots']; ?>">
		</p>

		<p>
			<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('new_window'); ?>" name="<?php echo $this->get_field_name('new_window'); ?>" value="1" <?php checked( $instance['new_window'], 1); ?>>
			<label for="<?php echo $this->get_field_id('new_window'); ?>"><?php _e( 'Open links in new window?', 'stag' ); ?></label>
		</p>

		<?php
	}

}

?>
