<?php

if ( ! class_exists( 'StagShortcodes' ) ) {

class StagShortcodes {

	public function __construct() {
		add_action( 'init', array( &$this, 'shortcodes_init' ) );
		add_action( 'admin_enqueue_scripts', array( &$this, 'admin_menu_styles' ) );
		add_filter( 'mce_external_languages', array( &$this, 'add_tinymce_lang' ), 10, 1 );
	}

	public function admin_menu_styles( $hook ) {
		if( $hook == 'post.php' || $hook == 'post-new.php' ) {
			global $stagtools;
			wp_enqueue_style( 'stag_admin_menu_styles', $stagtools->plugin_url() . '/assets/css/menu.css' );
			wp_enqueue_script( 'jquery-ui-sortable' );
			wp_enqueue_script( 'stag-shortcode-plugins', $stagtools->plugin_url() . '/assets/js/shortcodes_plugins.js', false, $stagtools->version, false );
			wp_localize_script( 'jquery', 'StagShortcodes', array('plugin_folder' => WP_PLUGIN_URL .'/shortcodes') );
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
		global $stagtools;
		$plugin_array['stagShortcodes'] = $stagtools->plugin_url() . '/assets/js/editor_plugin.js';
		return $plugin_array;
	}

	public function register_rich_buttons( $buttons ) {
		array_push( $buttons, "|", 'stag_shortcodes_button' );
		return $buttons;
	}

}

$GLOBALS['stagShortcodes'] = new StagShortcodes();

}