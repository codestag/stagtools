<?php
/**
 * Plugin Name: StagTools
 * Plugin URI: http://wordpress.org/plugins/stagtools/
 * Description: A poweful plugin to extend functionality to your WordPress themes offering shortcodes, font icons and useful widgets.
 * Version: 1.0.3
 * Author: Ram Ratan Maurya
 * Author URI: http://mauryaratan.me
 * License: GPL2
 * Requires at least: 3.5
 * Tested up to: 3.6
 * 
 * Text Domain: stag
 * Domain Path: /languages/
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'StagTools' ) ) {

/**
 * Main StagTools Class
 *
 * @package WordPress
 * @subpackage StagTools
 * @version 1.0
 * @author Ram Ratan Maurya
 * @link http://mauryaratan.me
 * @link http://codestag.com
 */

class StagTools {

	/**
	* @var string
	*/
	public $version = '1.0.3';
	
	/**
	* @var string
	*/
	public $plugin_url;
	
	/**
	* @var string
	*/
	public $plugin_path;
	
	/**
	* @var string
	*/
	public $template_url;

	/**
	 * StagTools Constructor.
	 *
	 * @access public
	 * @return void
	 */
	public function __construct() {

		// Define version constant
		define( 'STAGTOOLS_VERSION', $this->version );

		// Hooks
		add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), array( $this, 'action_links' ) );
		add_action( 'init', array( &$this, 'init' ) );
		add_action( 'admin_init', array( &$this, 'admin_init' ) );
		add_action( 'admin_menu', array( &$this, 'stag_add_options_page' ) );
		add_action( 'admin_enqueue_scripts', array( &$this, 'admin_menu_styles' ) );
		add_action( 'admin_head', array( &$this, 'widget_styles' ) );

		// Include required files
		$this->includes();

	}

	/**
	 * action_links function.
	 *
	 * @access public
	 * @param mixed $links
	 * @return void
	 */
	public function action_links( $links ) {
		$plugin_links = array(
			'<a href="' . admin_url( 'options-general.php?page=stagtools' ) . '">' . __( 'Settings', 'stag' ) . '</a>'
		);

		return array_merge( $plugin_links, $links );
	}

	function init() {
		$this->stag_load_textdomain();

		add_action( 'wp_enqueue_scripts', array( &$this, 'frontend_style' ) );
		add_filter( 'body_class', array( &$this, 'body_class' ) );


		if( current_theme_supports( 'stag-portfolio' ) ) include_once( 'cpt/cpt-portfolio.php' );
		if( current_theme_supports( 'stag-slides' ) ) include_once( 'cpt/cpt-slides.php' );
		if( current_theme_supports( 'stag-team' ) ) include_once( 'cpt/cpt-team.php' );
		if( current_theme_supports( 'stag-testimonials' ) ) include_once( 'cpt/cpt-testimonials.php' );
	}

	function admin_init() {
		register_setting( 'stag_plugin_options', 'stag_options', array($this, 'stag_validate_options') );
	}

	function stag_add_options_page() {
		global $stag_options;
		$stag_options = add_options_page('StagTools Options', 'StagTools', 'manage_options', 'stagtools', array($this, 'settings_page') );
	}

	function stag_load_textdomain() {
		load_plugin_textdomain( 'stag', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}

	public function includes() {
		if ( is_admin() ){
			$this->admin_includes();
		}
		if( !is_admin() ){
			$this->frontend_includes();
		}

		// Other includes
		

		// Widgets
		include_once( 'widgets/widget-dribbble.php' );
		include_once( 'widgets/widget-flickr.php' );
		include_once( 'widgets/widget-twitter.php' );
	}

	/**
	* Admin Includes
	*/
	public function admin_includes(){
		include_once( 'shortcodes/stag-shortcodes.php' );
	}

	public function frontend_includes(){
		include_once( plugin_dir_path( __FILE__ ) .'shortcodes/shortcodes.php' );
	}

	public function frontend_style() {
		wp_register_style( 'stag-shortcode-styles', plugin_dir_url( __FILE__ )  . 'assets/css/stag-shortcodes.css' , '', $this->version, 'all' );
		wp_register_style( 'font-awesome', plugin_dir_url( __FILE__ )  . 'assets/css/font-awesome.css' , '', '3.2.1', 'all' );

		wp_register_script( 'stag-shortcode-scripts', plugin_dir_url( __FILE__ ) . 'assets/js/stag-shortcode-scripts.js', array( 'jquery', 'jquery-ui-accordion', 'jquery-ui-tabs' ), $this->version, true );

		wp_enqueue_style( 'stag-shortcode-styles' );
		wp_enqueue_style( 'font-awesome' );

		wp_enqueue_script( 'jquery-ui-accordion' );
		wp_enqueue_script( 'jquery-ui-tabs' );
		wp_enqueue_script( 'stag-shortcode-scripts' );
	}

	public function admin_menu_styles( $hook ) {
		global $stag_options;

		if( $hook != $stag_options ) return;

		wp_enqueue_style( 'stag-admin-options-styles', plugin_dir_url( __FILE__ ) . 'assets/css/stag-admin-options.css', false, $this->version );
	}

	public function plugin_path() {
		if ( $this->plugin_path ) return $this->plugin_path;

		return $this->plugin_path = untrailingslashit( plugin_dir_path( __FILE__ ) );
	}

	public function plugin_url() {
		if ( $this->plugin_url ) return $this->plugin_url;
		return $this->plugin_url = untrailingslashit( plugins_url( '/', __FILE__ ) );
	}

	public function body_class( $classes ) {
		$classes[] = 'stag';
		return $classes;
	}

	public function stag_validate_options( $input ) {
		return $input;
	}

	/**
	* StagTools Settings Page
	*
	* @return void
	*/
	public function settings_page(){
	?>

	<div class="wrap">
		<?php echo screen_icon('tools'); ?>
		<h2><?php _e( 'StagTools', 'okay' ); ?></h2>

		<form method="post" action="options.php">
			<?php settings_fields('stag_plugin_options'); ?>
			<?php $stag_options = get_option('stag_options'); ?>
			
			<table class="form-table">
				<tbody>
					<tr valign="top">
						<th scope="row"><label for="twitter-api-consumer-key"><?php _e( 'OAuth Consumer Key', 'stag' ); ?></label></th>
						<td>
							<input type="text" class="regular-text" name="stag_options[consumer_key]" id="twitter-api-consumer-key" value="<?php echo esc_html($stag_options['consumer_key']); ?>" />
						</td>
					</tr>

					<tr valign="top">
						<th scope="row"><label for="twitter-api-consumer-secret"><?php _e( 'OAuth Consumer Secret', 'stag' ); ?></label></th>
						<td>
							<input type="text" class="regular-text" name="stag_options[consumer_secret]" id="twitter-api-consumer-secret" value="<?php echo esc_html($stag_options['consumer_secret']); ?>" />
						</td>
					</tr>

					<tr valign="top">
						<th scope="row"><label for="twitter-api-access-key"><?php _e( 'OAuth Access Token', 'stag' ); ?></label></th>
						<td>
							<input type="text" class="regular-text" name="stag_options[access_key]" id="twitter-api-access-key" value="<?php echo esc_html($stag_options['access_key']); ?>" />
						</td>
					</tr>

					<tr valign="top">
						<th scope="row"><label for="twitter-api-access-secret"><?php _e( 'OAuth Access Secret', 'stag' ); ?></label></th>
						<td>
							<input type="text" class="regular-text" name="stag_options[access_secret]" id="twitter-api-access-secret" value="<?php echo esc_html($stag_options['access_secret']); ?>" />
						</td>
					</tr>

				</tbody>
			</table>

			<?php echo submit_button('Save Changes'); ?>
		</form>

		<div class="stag-help">
			<h2><?php _e( 'FAQ', 'stag' ); ?></h2>
			<p><?php _e( 'Few resources to help you getting started.', 'stag' ); ?></p>

			<div class="s-help-row">
				<h3><?php _e( 'Where do I find these keys?', 'stag' ); ?></h3>
				<p><?php echo sprintf( __( 'In order to use the new Twitter widget, you must first register a Twitter app, which will provide you with the keys you see above. Start by %s to the Twitter developer dashboard.', 'stag' ), '<a target="_blank" href="//dev.twitter.com/apps">signing-in</a>' ); ?></p>
			</div>

			<div class="s-help-row">
				<h3><?php _e( 'Where are my widgets?', 'stag' ); ?></h3>
				<p><?php echo sprintf( __( 'In order to use the new Twitter widget, you must first register a Twitter app, which will provide you with the keys you see above. Start by %s to the Twitter developer dashboard.', 'stag' ), '<a target="_blank" href="//cl.ly/image/1H1U1i1T3u0h">creating a new application</a>' ); ?></p>
			</div>

			<div class="s-help-row">
				<h3><?php _e( 'Can I insert shortcodes manually instead of using shortcode generator?', 'stag' ); ?></h3>
				<p><?php echo sprintf( __( 'Yes; although we have a shortcode builder you can also see a list of %s and use it manually in any supported area.', 'stag' ), '<a target="_blank" href="//gist.github.com/mauryaratan/6071262">all available shortcodes</a>' ); ?></p>
			</div>
		</div>

	</div>

	<?php
	}

	/**
	* Widget styles
	* 
	* @access public 
	* @return void 
	*/
	public function widget_styles() {
		global $pagenow;
		if( $pagenow != 'widgets.php' ) return;
		?>
		<style type="text/css">
		div[id*="stag"] .widget-top{
		  background: #C8E5F3 !important;
		  border-color: #B4D0DD !important;
		  box-shadow: inset 0 1px 0 white !important;
		  -webkit-box-shadow: inset 0 1px 0 white !important;
		  -moz-box-shadow: inset 0 1px 0 white !important;
		  -ms-box-shadow: inset 0 1px 0 white !important;
		  -o-box-shadow: inset 0 1px 0 white !important;
		  background: -moz-linear-gradient(top,  #EAF8FF 0%, #C8E5F3 100%) !important;
		  background: -webkit-linear-gradient(top, #EAF8FF 0%,#C8E5F3 100%) !important;
		  background: linear-gradient(to bottom, #EAF8FF 0%,#C8E5F3 100%) !important;
		  border-bottom: 1px solid #98B3C0 !important;
		  margin-top: 0px;
		}
		</style>
		<?php
	}

}

$GLOBALS['stagtools'] = new StagTools();

}
