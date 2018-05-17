<?php
/**
 * Codestag themes list.
 *
 * @package StagTools
 */

/**
 * Displays Codestag themes admin page.
 */
class StagTools_Themes {
	public function __construct() {
		$this->get_codestag_themes();
	}

	public function admin_page() {
		$themes = json_decode( $this->get_codestag_themes() );

		$browse_all_link = add_query_arg( [
			'utm_source'   => 'stagtools-plugin-page',
			'utm_medium'   => 'stagtools',
			'utm_campaign' => 'StagTools',
			'utm_content'  => 'All themes',
		], 'https://codestag.com/themes/' );

		?>
		<div class="wrap">
			<h3 class="codestag-themes-title">
				<?php esc_html_e( 'Codestag Themes', 'stag' ); ?>
				<span>
					<a href="<?php echo esc_url( $browse_all_link ); ?>" target="_blank" class="button-primary"><?php esc_html_e( 'Browse all themes', 'stag' ); ?></a>
				</span>
			</h3>
			<p><?php esc_html_e( 'Browse our theme collection and discover beautiful, handcrafted themes that are easy to use and flexible for your content.', 'stag' ); ?></p>

			<?php if ( is_array( $themes ) ) : ?>
			<div id="tab_container" class="codestag-themes">
			<?php
				foreach ( $themes as $theme ) :
					$link = add_query_arg( [
						'utm_source'   => 'stagtools-plugin-page',
						'utm_medium'   => 'stagtools',
						'utm_campaign' => 'StagTools',
						'utm_content'  => $theme->title,
					], $theme->link );
				?>

				<div class="codestag-theme">
					<?php if ( $theme->is_new ) : ?>
					<div class="new-badge">New</div>
					<?php endif; ?>

					<h3 class="codestag-theme__title"><?php echo esc_html( $theme->title ); ?></h3>
					<a href="<?php echo esc_url( $link ); ?>" class="codestag-theme__cover">
						<img src="<?php echo esc_url( $theme->featured ); ?>" alt="<?php echo esc_attr( $theme->title ); ?>">
					</a>
					<p><?php echo esc_html( $theme->subtitle ); ?>.</p>

					<a href="<?php echo esc_url( $link ); ?>" class="button-secondary"><?php esc_html_e( 'Get this Theme', 'stag' ); ?></a>
				</div>
			<?php endforeach; ?>

			</div>
			<a href="<?php echo esc_url( $browse_all_link ); ?>" target="_blank" class="button-primary"><?php esc_html_e( 'Browse all themes', 'stag' ); ?></a>
			<?php endif; ?>
		</div>

		<style>
			.codestag-themes {
				margin-bottom: 20px;
			}
			.new-badge {
				position: absolute;
				top: 20px;
				right: 20px;
				width: 50px;
				height: 50px;
				background-color: #8aca8a;
				border-radius: 50%;
				display: flex;
				align-items: center;
				justify-content: center;
				text-align: center;
				text-transform: uppercase;
				font-size: 14px;
				font-weight: 500;
				color: #fff;
				pointer-events: none;
				box-shadow: 2px 2px 6px rgba(0, 0, 0, .15);
			}
			.codestag-theme {
				float: left;
				width: 360px;
				margin-right: 20px;
				margin-bottom: 20px;
				position: relative;
			}

			@supports (display:grid) {
				.codestag-themes {
					display: grid;
					grid-template-columns: 1fr 1fr 1fr;
					grid-gap: 20px;
				}
				.codestag-theme {
					margin-right: 0;
					margin-bottom: 0;
					width: auto;
				}
			}

			.codestag-themes-title {
				margin-bottom: -5px;
			}

			.codestag-themes img {
				max-width: 100%;
				max-width: calc(100% + 28px);
				margin: 0 -14px;
			}
			.codestag-theme__title { margin: 0 0 12px; font-size: 13px; }

			.codestag-theme {
				background: #fff;
				padding: 14px;
				border: 1px solid #ccc;
			}
		</style>
		<?php
	}

	public function get_codestag_themes() {
		$themes = get_transient( 'codestag_themes_list' );
		if ( false === $themes ) {
			$response = wp_remote_get( 'https://codestag.com/wp-json/codestag/v1/themes' );

			if ( ! is_wp_error( $response ) ) {
				$cache = wp_remote_retrieve_body( $response );

				$themes = set_transient( 'codestag_themes_list', $cache, WEEK_IN_SECONDS );
			} else {
				return new WP_Error( 'error', __( 'Unable to retrieve themes data.', 'stag' ) );
			}
		}

		return $themes;
	}
}

new StagTools_Themes();
