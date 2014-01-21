<?php
/**
 * Portfolio post type functions.
 * 
 * @package StagTools
 */
$portfolio_labels = apply_filters( 'stag_portfolio_labels', array(
	'name'               => __( 'Portfolio', 'stag' ),
	'singular_name'      => __( 'Portfolio', 'stag' ),
	'add_new'            => __( 'Add New', 'stag' ),
	'add_new_item'       => __( 'Add New Portfolio', 'stag' ),
	'edit_item'          => __( 'Edit Portfolio', 'stag' ),
	'new_item'           => __( 'New Portfolio', 'stag' ),
	'view_item'          => __( 'View Portfolio', 'stag' ),
	'search_items'       => __( 'Search Portfolio', 'stag' ),
	'not_found'          => __( 'No Portfolios found', 'stag' ),
	'not_found_in_trash' => __( 'No Portfolios found in trash', 'stag' ),
	'parent_item_colon'  => ''
) );

$stag_options    = get_option('stag_options');
@$portfolio_slug = $stag_options['portfolio_slug'];
@$skills_slug    = $stag_options['skills_slug'];
$rewrite         = defined( 'STAG_PORTFOLIO_DISABLE_REWRITE' ) && STAG_PORTFOLIO_DISABLE_REWRITE ? false : array('slug' => $portfolio_slug, 'with_front' => false);

$portfolio_args = array(
	'labels'            => $portfolio_labels,
	'public'            => true,
	'show_ui'           => true,
	'show_in_menu'      => true,
	'show_in_nav_menus' => false,
	'menu_position'     => 32,
	'menu_icon'         => 'dashicons-portfolio',
	'rewrite'           => $rewrite,
	'supports'          => apply_filters( 'stag_portfolio_supports', array( 'title', 'editor', 'thumbnail', 'revisions' ) ),
	'taxonomies'        => array( 'skill' )
);

register_post_type( 'portfolio', apply_filters( 'stag_portfolio_post_type_args', $portfolio_args ) );

register_taxonomy( 'skill', 'portfolio', array(
	'label'             => __( 'Skills', 'stag' ),
	'singular_label'    => __( 'Skill', 'stag' ),
	'public'            => true,
	'hierarchical'      => true,
	'show_ui'           => true,
	'show_in_nav_menus' => true,
	'args'              => array( 'orderby' => 'term_order' ),
	'query_var'         => true,
	'rewrite'           => array( 'slug' => $skills_slug, 'hierarchical' => true)
) );

/**
 * Modify Portfolio columns
 *
 * @param  array $old_columns Old columns
 * @return $columns Return new columns
 */
function stag_portfolio_edit_columns( $columns ) {
	$columns = array(
		"cb"    => "<input type=\"checkbox\">",
		"title" => __( 'Portfolio Title', 'stag' ),
		"skill" => __( 'Skills', 'stag' ),
		"date"  => __( 'Date', 'stag' )
	);
	return $columns;
}
add_filter("manage_edit-portfolio_columns", "stag_portfolio_edit_columns");

/**
 * Custom post type Portfolio column.
 *
 * @param array $column
 * @return void
 */
function stag_portfolio_custom_column( $column ) {
	global $post;
	switch ( $column ) {
		case 'skill':
			if ( ! $terms = get_the_terms( $post->ID, $column ) ) {
				echo '<span class="na">&mdash;</span>';
			} else {
				foreach ( $terms as $term ) {
					$termlist[] = '<a href="' . esc_url( add_query_arg( $column, $term->slug, admin_url( 'edit.php?post_type=portfolio' ) ) ) . ' ">' . ucfirst( $term->name ) . '</a>';
				}

				echo implode( ', ', $termlist );
			}
		break;
	}
}
add_action("manage_posts_custom_column",  "stag_portfolio_custom_column");
