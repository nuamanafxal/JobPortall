<?php
function create_service_cpt() {

	$labels = array(
		'name' => _x( 'Services', 'Post Type General Name', 'NuamanTheme' ),
		'singular_name' => _x( 'Service', 'Post Type Singular Name', 'NuamanTheme' ),
		'menu_name' => _x( 'Services', 'Admin Menu text', 'NuamanTheme' ),
		'name_admin_bar' => _x( 'Service', 'Add New on Toolbar', 'NuamanTheme' ),
		'archives' => __( 'Service Archives', 'NuamanTheme' ),
		'attributes' => __( 'Service Attributes', 'NuamanTheme' ),
		'parent_item_colon' => __( 'Parent Service:', 'NuamanTheme' ),
		'all_items' => __( 'All Services', 'NuamanTheme' ),
		'add_new_item' => __( 'Add New Service', 'NuamanTheme' ),
		'add_new' => __( 'Add New', 'NuamanTheme' ),
		'new_item' => __( 'New Service', 'NuamanTheme' ),
		'edit_item' => __( 'Edit Service', 'NuamanTheme' ),
		'update_item' => __( 'Update Service', 'NuamanTheme' ),
		'view_item' => __( 'View Service', 'NuamanTheme' ),
		'view_items' => __( 'View Services', 'NuamanTheme' ),
		'search_items' => __( 'Search Service', 'NuamanTheme' ),
		'not_found' => __( 'Not found', 'NuamanTheme' ),
		'not_found_in_trash' => __( 'Not found in Trash', 'NuamanTheme' ),
		'featured_image' => __( 'Featured Image', 'NuamanTheme' ),
		'set_featured_image' => __( 'Set featured image', 'NuamanTheme' ),
		'remove_featured_image' => __( 'Remove featured image', 'NuamanTheme' ),
		'use_featured_image' => __( 'Use as featured image', 'NuamanTheme' ),
		'insert_into_item' => __( 'Insert into Service', 'NuamanTheme' ),
		'uploaded_to_this_item' => __( 'Uploaded to this Service', 'NuamanTheme' ),
		'items_list' => __( 'Services list', 'NuamanTheme' ),
		'items_list_navigation' => __( 'Services list navigation', 'NuamanTheme' ),
		'filter_items_list' => __( 'Filter Services list', 'NuamanTheme' ),
	);
	$args = array(
		'label' => __( 'Service', 'NuamanTheme' ),
		'description' => __( 'Custom post type for services', 'NuamanTheme' ),
		'labels' => $labels,
		'menu_icon' => 'dashicons-networking',
		'supports' => array('title', 'editor', 'excerpt', 'thumbnail', 'post-formats'),
		'taxonomies' => array('category', 'post_tag'),
		'public' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'menu_position' => 5,
		'show_in_admin_bar' => true,
		'show_in_nav_menus' => true,
		'can_export' => true,
		'has_archive' => true,
		'hierarchical' => false,
		'exclude_from_search' => false,
		'show_in_rest' => true,
		'publicly_queryable' => true,
		'capability_type' => 'post',
	);
	register_post_type( 'service', $args );

}
add_action( 'init', 'create_service_cpt', 0 );
?>