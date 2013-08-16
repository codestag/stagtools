<?php

$labels = array(
	'name'               => __( 'Testimonials', 'stag' ),
	'singular_name'      => __( 'Testimonial', 'stag' ),
	'add_new'            => __( 'Add New', 'stag' ),
	'add_new_item'       => __( 'Add New Testimonial', 'stag' ),
	'edit_item'          => __( 'Edit Testimonial', 'stag' ),
	'new_item'           => __( 'New Testimonial', 'stag' ),
	'view_item'          => __( 'View Testimonial', 'stag' ),
	'search_items'       => __( 'Search Testimonials', 'stag' ),
	'not_found'          => __( 'No Testimonials found', 'stag' ),
	'not_found_in_trash' => __( 'No Testimonials in trash', 'stag' ),
	'parent_item_colon'  => ''
);

$args = array(
	'labels'              => $labels,
	'public'              => true,
	'exclude_from_search' => true,
	'publicly_queryable'  => true,
	'rewrite'             => array('slug' => 'testimonials'),
	'show_ui'             => true,
	'query_var'           => true,
	'capability_type'     => 'post',
	'hierarchical'        => false,
	'menu_position'       => null,
	'has_archive'         => false,
	'supports'            => array( 'title', 'editor' )
);

register_post_type( 'testimonials', $args );

function stag_testimonials_edit_columns( $columns ) {
	$columns = array(
		"cb" => "<input type=\"checkbox\" />",
		"title" => __( 'Testimonial Title', 'stag' ),
		"date" => __( 'Date', 'stag' )
	);
	return $columns;
}

add_filter('manage_edit-team_columns', 'stag_testimonials_edit_columns');
