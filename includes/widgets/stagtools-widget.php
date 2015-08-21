<?php
/**
 * Widget base class.
 *
 * @package StagTools
 *
 * @since 2.0.0
 */

class ST_Widget extends WP_Widget {
	public $widget_cssclass;
	public $widget_description;
	public $widget_id;
	public $widget_name;
	public $settings;
	public $control_ops;

	public function __construct() {
		$widget_ops = array(
			'classname'   => $this->widget_cssclass,
			'description' => $this->widget_description,
		);

		parent::__construct( $this->widget_id, $this->widget_name, $widget_ops, $this->control_ops );

		add_action( 'save_post', array( $this, 'flush_widget_cache' ) );
		add_action( 'deleted_post', array( $this, 'flush_widget_cache' ) );
		add_action( 'switch_theme', array( $this, 'flush_widget_cache' ) );
	}

	function get_cached_widget( $args ) {
		$cache = wp_cache_get( $this->widget_id, 'widget' );

		if ( ! is_array( $cache ) )
			$cache = array();

		if ( isset( $cache[ $args[ 'widget_id' ] ] ) ) {
			echo $cache[ $args[ 'widget_id' ] ];
			return true;
		}

		return false;
	}

	public function cache_widget( $args, $content ) {
		$cache[ $args[ 'widget_id' ] ] = $content;

		wp_cache_set( $this->widget_id, $cache, 'widget' );
	}

	public function flush_widget_cache() {
		wp_cache_delete( $this->widget_id, 'widget' );
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		if ( ! $this->settings )
			return $instance;

		foreach ( $this->settings as $key => $setting ) {
			switch ( $setting[ 'type' ] ) {
				case 'textarea' :
					if ( current_user_can( 'unfiltered_html' ) )
						$instance[ $key ] = $new_instance[ $key ];
					else
						$instance[ $key ] = wp_kses_data( $new_instance[ $key ] );
				break;
				case 'number' :
					$instance[ $key ] = absint( $new_instance[ $key ] );
				break;
				default :
					$instance[ $key ] = sanitize_text_field( $new_instance[ $key ] );
				break;
			}
		}

		$this->flush_widget_cache();

		return $instance;
	}

	function form( $instance ) {

		if ( ! $this->settings )
			return;

		foreach ( $this->settings as $key => $setting ) {
			$value = isset( $instance[ $key ] ) ? $instance[ $key ] : $setting[ 'std' ];

			switch ( $setting[ 'type' ] ) {
				case 'description' :
					?>
					<p class="description"><?php echo $setting['std']; ?></p>
					<?php
				break;

				case 'text' :
					?>
					<p>
						<label for="<?php echo $this->get_field_id( $key ); ?>"><?php echo $setting[ 'label' ]; ?></label>
						<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( $key ) ); ?>" name="<?php echo $this->get_field_name( $key ); ?>" type="text" value="<?php echo esc_attr( $value ); ?>" <?php if ( isset( $setting['placeholder'] ) ) echo 'placeholder="'. $setting['placeholder'] .'"'; ?> />
					</p>
					<?php
				break;

				case 'checkbox' :
					?>
					<p>
						<label for="<?php echo $this->get_field_id( $key ); ?>">
							<input type="checkbox" id="<?php echo esc_attr( $this->get_field_id( $key ) ); ?>" name="<?php echo $this->get_field_name( $key ); ?>" type="text" value="1" <?php checked( 1, esc_attr( $value ) ); ?>/>
							<?php echo $setting[ 'label' ]; ?>
						</label>
					</p>
					<?php
				break;

				case 'select' :
					?>
					<p>
						<label for="<?php echo $this->get_field_id( $key ); ?>"><?php echo $setting[ 'label' ]; ?></label>
						<select id="<?php echo esc_attr( $this->get_field_id( $key ) ); ?>" name="<?php echo $this->get_field_name( $key ); ?>">
							<?php foreach ( $setting[ 'options' ] as $key => $label ) : ?>
							<option value="<?php echo esc_attr( $key ); ?>" <?php selected( $key, $value ); ?>><?php echo esc_attr( $label ); ?></option>
							<?php endforeach; ?>
						</select>
					</p>
					<?php
				break;

				case 'page':
					$exclude_ids = implode( ',', array( get_option( 'page_for_posts' ), get_option( 'page_on_front' ) ) );
					$pages       = get_pages( 'sort_order=ASC&sort_column=post_title&post_status=publish&exclude='. $exclude_ids );
					?>
					<p>
						<label for="<?php echo $this->get_field_id( $key ); ?>"><?php echo $setting[ 'label' ]; ?></label>
						<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( $key ) ); ?>" name="<?php echo $this->get_field_name( $key ); ?>">
							<?php foreach ( $pages as $page ) : ?>
								<option value="<?php echo esc_attr( $page->ID ); ?>" <?php selected( $page->ID, $value ); ?>><?php echo esc_attr( $page->post_title ); ?></option>
							<?php endforeach; ?>
						</select>
					</p>
					<?php
				break;

				case 'categories':
					$args = array( 'hide_empty' => 0 );

					if ( isset( $setting['taxonomy'] ) ) $args['taxonomy'] = $setting['taxonomy'];

					$categories = get_categories( $args );
					?>
					<p>
						<label for="<?php echo $this->get_field_id( $key ); ?>"><?php echo $setting[ 'label' ]; ?></label>
						<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( $key ) ); ?>" name="<?php echo $this->get_field_name( $key ); ?>">
							<option value="-1"><?php _e( 'All', 'stag' ); ?></option>
							<?php foreach ( $categories as $cat ) : ?>
								<option value="<?php echo esc_attr( $cat->term_id ); ?>" <?php selected( $cat->term_id, $value ); ?>><?php echo esc_attr( $cat->name ); ?></option>
							<?php endforeach; ?>
						</select>
					</p>
					<?php
				break;

				case 'number' :
					if ( ! isset( $setting['step'] ) ) $setting['step'] = '1';
					if ( ! isset( $setting['min'] ) ) $setting['min'] = '1';
					if ( ! isset( $setting['max'] ) ) $setting['max'] = '100';
					?>
					<p>
						<label for="<?php echo $this->get_field_id( $key ); ?>"><?php echo $setting[ 'label' ]; ?></label>
						<input id="<?php echo esc_attr( $this->get_field_id( $key ) ); ?>" name="<?php echo $this->get_field_name( $key ); ?>" type="number" step="<?php echo esc_attr( $setting[ 'step' ] ); ?>" min="<?php echo esc_attr( $setting[ 'min' ] ); ?>" max="<?php echo esc_attr( $setting[ 'max' ] ); ?>" value="<?php echo esc_attr( $value ); ?>" />
					</p>
					<?php
				break;

				case 'textarea' :
					?>
					<p>
						<label for="<?php echo $this->get_field_id( $key ); ?>"><?php echo $setting[ 'label' ]; ?></label>
						<textarea class="widefat" id="<?php echo esc_attr( $this->get_field_id( $key ) ); ?>" name="<?php echo $this->get_field_name( $key ); ?>" rows="<?php echo $setting[ 'rows' ]; ?>"><?php echo esc_html( $value ); ?></textarea>
					</p>
					<?php
				break;
			}
		}
	}
}
