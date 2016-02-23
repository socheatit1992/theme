<?php 

// The register_post_type() function is not to be used before the 'init'.
add_action( 'init', 'banners_custom_init' );

/* Here's how to create your customized labels */
function banners_custom_init() {
	$labels = array(
		'name' => _x( 'Banners', 'post type general name' ), 
		'singular_name' => _x( 'banners', 'post type singular name' ),
		'add_new' => _x( 'Add new', 'book' ),
		'add_new_item' => lang::_( 'Add new banner' ),
		'edit_item' => lang::_( 'Edit' ),
		'new_item' => lang::_( 'New banner' ),
		'view_item' => lang::_( 'Read' ),
		'search_items' => lang::_( 'Search banner' ),
		'not_found' =>  lang::_( 'Banners not found' ),
		'not_found_in_trash' => lang::_( 'Banners not found in Trash' ),
		'parent_item_colon' => ''
	);

	// Create an array for the $args
	$args = array( 'labels' => $labels, 
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'menu_position' => null,
		'supports' => array( 'title', 'editor', 'thumbnail' )
	); 

	register_post_type( 'banners', $args );
}


?>