<?php

$labels = array(
	'name'               => __( 'Team', 'stag' ),
	'singular_name'      => __( 'Team', 'stag' ),
	'add_new'            => __( 'Add New', 'stag' ),
	'add_new_item'       => __( 'Add New Team Member', 'stag' ),
	'edit_item'          => __( 'Edit Team Member', 'stag' ),
	'new_item'           => __( 'New Team Member', 'stag' ),
	'view_item'          => __( 'View Team Member', 'stag' ),
	'search_items'       => __( 'Search Team Member', 'stag' ),
	'not_found'          => __( 'No Team Member found', 'stag' ),
	'not_found_in_trash' => __( 'No Team Member in trash', 'stag' ),
	'parent_item_colon'  => ''
);

$args = array(
	'labels'              => $labels,
	'public'              => false,
	'exclude_from_search' => true,
	'publicly_queryable'  => false,
	'rewrite'             => array('slug' => 'team'),
	'show_ui'             => true,
	'query_var'           => true,
	'capability_type'     => 'post',
	'hierarchical'        => false,
	'menu_position'       => 34,
	'menu_icon'           => 'dashicons-groups',
	'has_archive'         => false,
	'supports'            => array( 'title', 'thumbnail' )
);

register_post_type( 'team', $args );

function stag_team_edit_columns( $columns ) {
	$columns = array(
		"cb" => "<input type=\"checkbox\" />",
		"title" => __( 'Team Member Title', 'stag' ),
		"member_info" => __('Member Info', 'stag'),
		"date" => __( 'Date', 'stag' )
	);
	return $columns;
}

function stag_team_custom_column( $columns ) {
	global $post;
	switch ( $columns ){
		case 'member_info':
		echo get_post_meta( $post->ID, '_stag_team_info', true );
		break;
	}
}

add_filter('manage_edit-team_columns', 'stag_team_edit_columns');
add_action('manage_posts_custom_column',  'stag_team_custom_column');
