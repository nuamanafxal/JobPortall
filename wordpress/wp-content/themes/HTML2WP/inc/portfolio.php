<?php 

// Register Custom Post Type portfolio
function create_portfolio_cpt() {

	$labels = array(
		'name' => _x( 'portfolios', 'Post Type General Name', 'html2wp' ),
		'singular_name' => _x( 'portfolio', 'Post Type Singular Name', 'html2wp' ),
		'menu_name' => _x( 'portfolios', 'Admin Menu text', 'html2wp' ),
		'name_admin_bar' => _x( 'portfolio', 'Add New on Toolbar', 'html2wp' ),
		'archives' => __( 'portfolio Archives', 'html2wp' ),
		'attributes' => __( 'portfolio Attributes', 'html2wp' ),
		'parent_item_colon' => __( 'Parent portfolio:', 'html2wp' ),
		'all_items' => __( 'All portfolios', 'html2wp' ),
		'add_new_item' => __( 'Add New portfolio', 'html2wp' ),
		'add_new' => __( 'Add New', 'html2wp' ),
		'new_item' => __( 'New portfolio', 'html2wp' ),
		'edit_item' => __( 'Edit portfolio', 'html2wp' ),
		'update_item' => __( 'Update portfolio', 'html2wp' ),
		'view_item' => __( 'View portfolio', 'html2wp' ),
		'view_items' => __( 'View portfolios', 'html2wp' ),
		'search_items' => __( 'Search portfolio', 'html2wp' ),
		'not_found' => __( 'Not found', 'html2wp' ),
		'not_found_in_trash' => __( 'Not found in Trash', 'html2wp' ),
		'featured_image' => __( 'Featured Image', 'html2wp' ),
		'set_featured_image' => __( 'Set featured image', 'html2wp' ),
		'remove_featured_image' => __( 'Remove featured image', 'html2wp' ),
		'use_featured_image' => __( 'Use as featured image', 'html2wp' ),
		'insert_into_item' => __( 'Insert into portfolio', 'html2wp' ),
		'uploaded_to_this_item' => __( 'Uploaded to this portfolio', 'html2wp' ),
		'items_list' => __( 'portfolios list', 'html2wp' ),
		'items_list_navigation' => __( 'portfolios list navigation', 'html2wp' ),
		'filter_items_list' => __( 'Filter portfolios list', 'html2wp' ),
	);
	$args = array(
		'label' => __( 'portfolio', 'html2wp' ),
		'description' => __( '', 'html2wp' ),
		'labels' => $labels,
		'menu_icon' => 'dashicons-paperclip',
		'supports' => array('title', 'editor', 'excerpt', 'thumbnail', 'author'),
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
	register_post_type( 'portfolio', $args );

}
add_action( 'init', 'create_portfolio_cpt', 0 );
?>