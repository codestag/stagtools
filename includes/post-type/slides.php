<?php

$labels = array(
	'name'               => __( 'Slides', 'stag' ),
	'singular_name'      => __( 'Slide', 'stag' ),
	'add_new'            => __( 'Add New', 'stag' ),
	'add_new_item'       => __( 'Add New Slide', 'stag' ),
	'edit_item'          => __( 'Edit Slide', 'stag' ),
	'new_item'           => __( 'New Slide', 'stag' ),
	'view_item'          => __( 'View Slide', 'stag' ),
	'search_items'       => __( 'Search Slide', 'stag' ),
	'not_found'          => __( 'No Slides found', 'stag' ),
	'not_found_in_trash' => __( 'No Slides found in trash', 'stag' ),
	'parent_item_colon'  => '',
);

$args = array(
	'labels'              => $labels,
	'public'              => false,
	'exclude_from_search' => true,
	'publicly_queryable'  => true,
	'rewrite'             => array( 'slug' => 'slides' ),
	'show_ui'             => true,
	'query_var'           => true,
	'capability_type'     => 'post',
	'hierarchical'        => false,
	'menu_position'       => 33,
	'menu_icon'           => 'dashicons-images-alt2',
	'has_archive'         => false,
	'supports'            => array( 'title' ),
);

register_post_type( 'slides', $args );

function stag_slide_edit_column( $columns ) {
	$columns = array(
		'cb'    => '<input type="checkbox" />',
		'title' => __( 'Slide Title', 'stag' ),
		'date'  => __( 'Date', 'stag' ),
	);
	return $columns;
}

add_filter( 'manage_edit-slide_columns', 'stag_slide_edit_column' );
