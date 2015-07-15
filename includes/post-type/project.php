<?php
/**
 * Register a stag-portfolio post type.
 *
 * @package StagTools
 * @since 1.3
 * @link https://codex.wordpress.org/Function_Reference/register_post_type
 */
$portfolio_labels = apply_filters( 'stag_portfolio_labels', array(
	'name'               => _x( 'Projects', 'post type general name', 'stag' ),
	'singular_name'      => _x( 'Project', 'post type singular name', 'stag' ),
	'menu_name'          => _x( 'Portfolio', 'admin menu', 'stag' ),
	'name_admin_bar'     => _x( 'Project', 'add new on admin bar', 'stag' ),
	'add_new'            => _x( 'Add New', 'Project', 'stag' ),
	'add_new_item'       => __( 'Add New Project', 'stag' ),
	'new_item'           => __( 'New Project', 'stag' ),
	'edit_item'          => __( 'Edit Project', 'stag' ),
	'view_item'          => __( 'View Project', 'stag' ),
	'all_items'          => __( 'All Projects', 'stag' ),
	'search_items'       => __( 'Search Projects', 'stag' ),
	'parent_item_colon'  => __( 'Parent Projects:', 'stag' ),
	'not_found'          => __( 'No Projects found.', 'stag' ),
	'not_found_in_trash' => __( 'No Projects found in Trash.', 'stag' ),
) );

$portfolio_args = array(
	'labels'             => $portfolio_labels,
	'public'             => true,
	'publicly_queryable' => true,
	'show_ui'            => true,
	'show_in_menu'       => true,
	'menu_position'      => 100,
	'menu_icon'          => 'dashicons-portfolio',
	'query_var'          => true,
	'rewrite'            => array( 'slug' => 'portfolio' ),
	'capability_type'    => 'post',
	'has_archive'        => true,
	'hierarchical'       => false,
	'menu_position'      => null,
	'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'revisions' ),
);

register_post_type( 'stag-portfolio', $portfolio_args );

register_taxonomy( 'stag-portfolio-type', 'stag-portfolio', array(
	'label'             => __( 'Project Types', 'stag' ),
	'singular_label'    => __( 'Project Type', 'stag' ),
	'public'            => true,
	'hierarchical'      => true,
	'show_ui'           => true,
	'show_in_nav_menus' => true,
	'args'              => array( 'orderby' => 'term_order' ),
	'query_var'         => true,
	'rewrite'           => array( 'slug' => 'project-type' ),
) );

register_taxonomy( 'stag-portfolio-tag', 'stag-portfolio', array(
	'label'             => __( 'Project Tags', 'stag' ),
	'singular_label'    => __( 'Project Tag', 'stag' ),
	'public'            => true,
	'hierarchical'      => false,
	'show_ui'           => true,
	'show_in_nav_menus' => true,
	'args'              => array( 'orderby' => 'term_order' ),
	'query_var'         => true,
	'rewrite'           => array( 'slug' => 'project-tag' ),
) );

/**
 * Modify Article columns
 *
 * @param  array $old_columns Old columns
 * @return $columns Return new columns
 */
function stag_portfolio_columns( $old_columns ) {
	$columns = array();

	$columns['cb']                  = '<input type="checkbox" />';
	$columns['thumbnail']           = '<i class="dashicons dashicons-format-image"></i>';
	$columns['title']               = __( 'Project', 'stag' );
	$columns['stag-portfolio-type'] = __( 'Project Types', 'stag' );
	$columns['stag-portfolio-tag']  = __( 'Project Tags', 'stag' );
	$columns['date']                = __( 'Date', 'stag' );

	return $columns;
}
add_filter( 'manage_edit-stag-portfolio_columns', 'stag_portfolio_columns' );

/**
 * Custom post type article column.
 *
 * @param array $column
 * @return void
 */
function stag_portfolio_custom_columns( $column ) {
	global $post;

	switch ( $column ) {
		case 'stag-portfolio-type':
		case 'stag-portfolio-tag':
			if ( ! $terms = get_the_terms( $post->ID, $column ) ) {
				echo '<span class="na">&mdash;</span>';
			} else {
				foreach ( $terms as $term ) {
					$termlist[] = '<a href="' . esc_url( add_query_arg( $column, $term->slug, admin_url( 'edit.php?post_type=stag-portfolio' ) ) ) . ' ">' . ucfirst( $term->name ) . '</a>';
				}

				echo implode( ', ', $termlist );
			}
			break;

		case 'thumbnail':
			echo get_the_post_thumbnail( $post->ID, array( 100, 100 ) );
			break;
	}
}
add_action( 'manage_stag-portfolio_posts_custom_column', 'stag_portfolio_custom_columns', 2 );

function stag_portfolio_admin_css() {
	global $pagenow;

	if ( 'edit.php' != $pagenow && 'stag-portfolio' != get_post_type() )
		return;

	?>

	<style type="text/css">
		.manage-column.column-thumbnail { width: 50px; text-align: center; color: #bbb; }
		.column-thumbnail img { max-width: 50px; height: auto; }
	</style>

	<?php
}
add_action( 'admin_head', 'stag_portfolio_admin_css' );
