<?php
// Register Custom Post Type project
function create_project_cpt() {

	$labels = array(
		'name' => _x( 'projects', 'Post Type General Name', 'NuamanTheme' ),
		'singular_name' => _x( 'project', 'Post Type Singular Name', 'NuamanTheme' ),
		'menu_name' => _x( 'projects', 'Admin Menu text', 'NuamanTheme' ),
		'name_admin_bar' => _x( 'project', 'Add New on Toolbar', 'NuamanTheme' ),
		'archives' => __( 'project Archives', 'NuamanTheme' ),
		'attributes' => __( 'project Attributes', 'NuamanTheme' ),
		'parent_item_colon' => __( 'Parent project:', 'NuamanTheme' ),
		'all_items' => __( 'All projects', 'NuamanTheme' ),
		'add_new_item' => __( 'Add New project', 'NuamanTheme' ),
		'add_new' => __( 'Add New', 'NuamanTheme' ),
		'new_item' => __( 'New project', 'NuamanTheme' ),
		'edit_item' => __( 'Edit project', 'NuamanTheme' ),
		'update_item' => __( 'Update project', 'NuamanTheme' ),
		'view_item' => __( 'View project', 'NuamanTheme' ),
		'view_items' => __( 'View projects', 'NuamanTheme' ),
		'search_items' => __( 'Search project', 'NuamanTheme' ),
		'not_found' => __( 'Not found', 'NuamanTheme' ),
		'not_found_in_trash' => __( 'Not found in Trash', 'NuamanTheme' ),
		'featured_image' => __( 'Featured Image', 'NuamanTheme' ),
		'set_featured_image' => __( 'Set featured image', 'NuamanTheme' ),
		'remove_featured_image' => __( 'Remove featured image', 'NuamanTheme' ),
		'use_featured_image' => __( 'Use as featured image', 'NuamanTheme' ),
		'insert_into_item' => __( 'Insert into project', 'NuamanTheme' ),
		'uploaded_to_this_item' => __( 'Uploaded to this project', 'NuamanTheme' ),
		'items_list' => __( 'projects list', 'NuamanTheme' ),
		'items_list_navigation' => __( 'projects list navigation', 'NuamanTheme' ),
		'filter_items_list' => __( 'Filter projects list', 'NuamanTheme' ),
	);
	$args = array(
		'label' => __( 'project', 'NuamanTheme' ),
		'description' => __( 'carousel', 'NuamanTheme' ),
		'labels' => $labels,
		'menu_icon' => 'dashicons-megaphone',
		'supports' => array('title', 'excerpt', 'thumbnail'),
		'taxonomies' => array(),
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
	register_post_type( 'project', $args );

}
add_action( 'init', 'create_project_cpt', 0 );
?>