<?php

if ( ! class_exists( 'StagShortcodes' ) ) {

class StagShortcodes {

	public function __construct() {
		add_action( 'init', array( &$this, 'shortcodes_init' ) );
		add_action( 'admin_enqueue_scripts', array( &$this, 'admin_menu_styles' ) );
		add_filter( 'mce_external_languages', array( &$this, 'add_tinymce_lang' ), 10, 1 );
		add_action( 'wp_ajax_popup', array( &$this, 'shortcode_popup_callback') );
	}

	public function admin_menu_styles( $hook ) {
		if( $hook == 'post.php' || $hook == 'post-new.php' ) {
			global $stagtools;

			wp_enqueue_style( 'stag_admin_menu_styles', $stagtools->plugin_url() . '/assets/css/menu.css' );
			wp_enqueue_style( 'stag_admin_menu_font_styles', $stagtools->plugin_url() . '/assets/css/font-awesome.css', '', '4.0.3' );

			wp_enqueue_script( 'jquery-ui-sortable' );
			wp_enqueue_script( 'stag-shortcode-plugins', $stagtools->plugin_url() . '/assets/js/shortcodes_plugins.js', false, $stagtools->version, false );

			wp_localize_script( 'jquery', 'StagShortcodes', array(
				'plugin_folder'           => WP_PLUGIN_URL .'/shortcodes',
				/** Check if Stag Custom Sidebars plugin is active {@link http://wordpress.org/plugins/stag-custom-sidebars/} */
				'is_scs_active'           => $stagtools->is_scs_active(),
				'media_frame_video_title' => __( 'Upload or Choose Your Custom Video File', 'stag' ),
				'media_frame_image_title' => __( 'Upload or Choose Your Custom Image File', 'stag' )
			) );
		}
	}

	public function shortcodes_init() {
		if( ( current_user_can('edit_posts') || current_user_can('edit_pages') ) && get_user_option('rich_editing') ){
			add_filter( 'mce_external_plugins', array( &$this, 'add_rich_plugins' ) );
			add_filter( 'mce_buttons', array( &$this, 'register_rich_buttons' ) );
		}
	}

	public function add_tinymce_lang( $arr ) {
		global $stagtools;
		$arr['stagShortcodes'] = $stagtools->plugin_path() . '/assets/js/plugin-lang.php';
		return $arr;
	}

	public function add_rich_plugins( $plugin_array ) {
		global $stagtools, $tinymce_version;

		if( version_compare( $tinymce_version , '400', '<' ) ) {
			$plugin_array['stagShortcodes'] = $stagtools->plugin_url() . '/assets/js/editor_plugin.js';
		} else {
			$plugin_array['stagShortcodes'] = $stagtools->plugin_url() . '/assets/js/plugin.js';
		}

		return $plugin_array;
	}

	public function register_rich_buttons( $buttons ) {
		array_push( $buttons, 'stagShortcodes' );
		return $buttons;
	}

	public function shortcode_popup_callback(){
		require_once( 'shortcode-class.php' );
		$shortcode = new stag_shortcodes( $_REQUEST['popup'] );

		?>
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
		<head></head>
		<body>

		<div id="stag-popup">

			<div id="stag-sc-wrap">

				<div id="stag-sc-form-wrap">
					<h2 id="stag-sc-form-head"><?php echo $shortcode->popup_title; ?></h2>
					<span id="close-popup"></span>
				</div><!-- /#stag-sc-form-wrap -->

				<form method="post" id="stag-sc-form">

					<table id="stag-sc-form-table">

						<?php echo $shortcode->output; ?>

						<tbody>
							<tr class="form-row">
								<?php if( ! $shortcode->has_child ) : ?><td class="label">&nbsp;</td><?php endif; ?>
								<!-- <td class="field insert-field"> -->

								<!-- </td> -->
							</tr>
						</tbody>

					</table><!-- /#stag-sc-form-table -->

					<div class="insert-field">
						<a href="#" class="button button-primary button-large stag-insert"><?php _e('Insert Shortcode', 'stag'); ?></a>
					</div>

				</form><!-- /#stag-sc-form -->

			</div><!-- /#stag-sc-wrap -->

			<div class="clear"></div>

		</div><!-- /#popup -->

		</body>
		</html>
		<?php

		die();
	}

}

$GLOBALS['stagShortcodes'] = new StagShortcodes();

}
