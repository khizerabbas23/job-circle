<?php  

// Register Custom Sectors
function jobcircle_lited_post_type() {

	$labels = array(
		'name'                  => _x( 'Jobs', 'Jobs General Name', 'jobcircle-frame' ),
		'singular_name'         => _x( 'Jobs', 'Jobs Singular Name', 'jobcircle-frame' ),
		'menu_name'             => __( 'Jobs', 'jobcircle-frame' ),
		'name_admin_bar'        => __( 'Jobs', 'jobcircle-frame' ),
		'archives'              => __( 'Item Archives', 'jobcircle-frame' ),
		'attributes'            => __( 'Item Attributes', 'jobcircle-frame' ),
		'parent_item_colon'     => __( 'Parent Item:', 'jobcircle-frame' ),
		'all_items'             => __( 'All Items', 'jobcircle-frame' ),
		'add_new_item'          => __( 'Add New Item', 'jobcircle-frame' ),
		'add_new'               => __( 'Add New', 'jobcircle-frame' ),
		'new_item'              => __( 'New Item', 'jobcircle-frame' ),
		'edit_item'             => __( 'Edit Item', 'jobcircle-frame' ),
		'update_item'           => __( 'Update Item', 'jobcircle-frame' ),
		'view_item'             => __( 'View Item', 'jobcircle-frame' ),
		'view_items'            => __( 'View Items', 'jobcircle-frame' ),
		'search_items'          => __( 'Search Item', 'jobcircle-frame' ),
		'not_found'             => __( 'Not found', 'jobcircle-frame' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'jobcircle-frame' ),
		'featured_image'        => __( 'Featured Image', 'jobcircle-frame' ),
		'set_featured_image'    => __( 'Set featured image', 'jobcircle-frame' ),
		'remove_featured_image' => __( 'Remove featured image', 'jobcircle-frame' ),
		'use_featured_image'    => __( 'Use as featured image', 'jobcircle-frame' ),
		'insert_into_item'      => __( 'Insert into item', 'jobcircle-frame' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'jobcircle-frame' ),
		'items_list'            => __( 'Items list', 'jobcircle-frame' ),
		'items_list_navigation' => __( 'Items list navigation', 'jobcircle-frame' ),
		'filter_items_list'     => __( 'Sectors items list', 'jobcircle-frame' ),
	);
	$args = array(
		'label'                 => __( 'Jobs', 'jobcircle-frame' ),
		'description'           => __( 'Jobs Description', 'jobcircle-frame' ),
		'labels'                => $labels,
		'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'revisions', ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
	);
	register_post_type( 'jobs', $args );

}
add_action( 'init', 'jobcircle_lited_post_type', 0 );

// taxonomy


// Register Custom Filters


function popular_listed_job_taxonomy() {

	$labels = array(
		'name'                       => _x( 'Skills', 'Filters General Name', 'jobcircle-frame' ),
		'singular_name'              => _x( 'Skills', 'Filters Singular Name', 'jobcircle-frame' ),
		'menu_name'                  => __( 'Skills', 'jobcircle-frame' ),
		'all_items'                  => __( 'All Items', 'jobcircle-frame' ),
		'parent_item'                => __( 'Parent Item', 'jobcircle-frame' ),
		'parent_item_colon'          => __( 'Parent Item:', 'jobcircle-frame' ),
		'new_item_name'              => __( 'New Item Name', 'jobcircle-frame' ),
		'add_new_item'               => __( 'Add New Item', 'jobcircle-frame' ),
		'edit_item'                  => __( 'Edit Item', 'jobcircle-frame' ),
		'update_item'                => __( 'Update Item', 'jobcircle-frame' ),
		'view_item'                  => __( 'View Item', 'jobcircle-frame' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'jobcircle-frame' ),
		'add_or_remove_items'        => __( 'Add or remove items', 'jobcircle-frame' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'jobcircle-frame' ),
		'popular_items'              => __( 'Popular Items', 'jobcircle-frame' ),
		'search_items'               => __( 'Search Items', 'jobcircle-frame' ),
		'not_found'                  => __( 'Not Found', 'jobcircle-frame' ),
		'no_terms'                   => __( 'No items', 'jobcircle-frame' ),
		'items_list'                 => __( 'Items list', 'jobcircle-frame' ),
		'items_list_navigation'      => __( 'Items list navigation', 'jobcircle-frame' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => false,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => false,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'job_skill', array( 'jobs' ), $args );

}
add_action( 'init', 'popular_listed_job_taxonomy', 0 );

// Pop Top Categories Taxonomy

function popular_top_categories_taxonomy() {

	$labels = array(
		'name'                       => _x( 'Job Categories', 'Category General Name', 'jobcircle-frame' ),
		'singular_name'              => _x( 'Job Categories', 'Category Singular Name', 'jobcircle-frame' ),
		'menu_name'                  => __( 'Job Categories', 'jobcircle-frame' ),
		'all_items'                  => __( 'All Items', 'jobcircle-frame' ),
		'parent_item'                => __( 'Parent Item', 'jobcircle-frame' ),
		'parent_item_colon'          => __( 'Parent Item:', 'jobcircle-frame' ),
		'new_item_name'              => __( 'New Item Name', 'jobcircle-frame' ),
		'add_new_item'               => __( 'Add New Item', 'jobcircle-frame' ),
		'edit_item'                  => __( 'Edit Item', 'jobcircle-frame' ),
		'update_item'                => __( 'Update Item', 'jobcircle-frame' ),
		'view_item'                  => __( 'View Item', 'jobcircle-frame' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'jobcircle-frame' ),
		'add_or_remove_items'        => __( 'Add or remove items', 'jobcircle-frame' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'jobcircle-frame' ),
		'popular_items'              => __( 'Popular Items', 'jobcircle-frame' ),
		'search_items'               => __( 'Search Items', 'jobcircle-frame' ),
		'not_found'                  => __( 'Not Found', 'jobcircle-frame' ),
		'no_terms'                   => __( 'No items', 'jobcircle-frame' ),
		'items_list'                 => __( 'Items list', 'jobcircle-frame' ),
		'items_list_navigation'      => __( 'Items list navigation', 'jobcircle-frame' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'job_category', array( 'jobs' ), $args );

}
add_action( 'init', 'popular_top_categories_taxonomy', 0 );

// //Featured Jobs 

// function featured_job_taxonomy() {

// 	$labels = array(
// 		'name'                       => _x( 'Featured Job', 'Category General Name', 'jobcircle-frame' ),
// 		'singular_name'              => _x( 'Featured Job', 'Category Singular Name', 'jobcircle-frame' ),
// 		'menu_name'                  => __( 'Featured Job', 'jobcircle-frame' ),
// 		'all_items'                  => __( 'All Items', 'jobcircle-frame' ),
// 		'parent_item'                => __( 'Parent Item', 'jobcircle-frame' ),
// 		'parent_item_colon'          => __( 'Parent Item:', 'jobcircle-frame' ),
// 		'new_item_name'              => __( 'New Item Name', 'jobcircle-frame' ),
// 		'add_new_item'               => __( 'Add New Item', 'jobcircle-frame' ),
// 		'edit_item'                  => __( 'Edit Item', 'jobcircle-frame' ),
// 		'update_item'                => __( 'Update Item', 'jobcircle-frame' ),
// 		'view_item'                  => __( 'View Item', 'jobcircle-frame' ),
// 		'separate_items_with_commas' => __( 'Separate items with commas', 'jobcircle-frame' ),
// 		'add_or_remove_items'        => __( 'Add or remove items', 'jobcircle-frame' ),
// 		'choose_from_most_used'      => __( 'Choose from the most used', 'jobcircle-frame' ),
// 		'popular_items'              => __( 'Popular Items', 'jobcircle-frame' ),
// 		'search_items'               => __( 'Search Items', 'jobcircle-frame' ),
// 		'not_found'                  => __( 'Not Found', 'jobcircle-frame' ),
// 		'no_terms'                   => __( 'No items', 'jobcircle-frame' ),
// 		'items_list'                 => __( 'Items list', 'jobcircle-frame' ),
// 		'items_list_navigation'      => __( 'Items list navigation', 'jobcircle-frame' ),
// 	);
// 	$args = array(
// 		'labels'                     => $labels,
// 		'hierarchical'               => true,
// 		'public'                     => true,
// 		'show_ui'                    => true,
// 		'show_admin_column'          => true,
// 		'show_in_nav_menus'          => true,
// 		'show_tagcloud'              => true,
// 	);
// 	register_taxonomy( 'featured_jobs', array( 'jobs' ), $args );

// }
// add_action( 'init', 'featured_job_taxonomy', 0 );


//Job Alert
function register_job_alert_post() {

    $labels = array(
        'name' => _x('Job Alerts', 'post type general name', 'jobcircle-frame'),
        'singular_name' => _x('Job Alert', 'post type singular name', 'jobcircle-frame'),
        'menu_name' => _x('Job Alerts', 'admin menu', 'jobcircle-frame'),
        'name_admin_bar' => _x('Job Alert', 'add new on admin bar', 'jobcircle-frame'),
        'add_new' => _x('Add New', 'book', 'jobcircle-frame'),
        'add_new_item' => esc_html__('Add New Job Alert', 'jobcircle-frame'),
        'new_item' => esc_html__('New Job Alert', 'jobcircle-frame'),
        'edit_item' => esc_html__('Edit Job Alert', 'jobcircle-frame'),
        'view_item' => esc_html__('View Job Alert', 'jobcircle-frame'),
        'all_items' => esc_html__('Job Alerts', 'jobcircle-frame'),
        'search_items' => esc_html__('Search Job Alerts', 'jobcircle-frame'),
        'parent_item_colon' => esc_html__('Parent Job Alerts:', 'jobcircle-frame'),
        'not_found' => esc_html__('No Job Alerts found.', 'jobcircle-frame'),
        'not_found_in_trash' => esc_html__('No Job Alerts found in Trash.', 'jobcircle-frame'),
    );

    $args = array(
        'labels' => $labels,
        'description' => esc_html__('This allows the user to manage job alerts.', 'jobcircle-frame'),
        'public' => false,
        'show_ui' => true,
        'show_in_menu' => 'edit.php?post_type=jobs',
        'query_var' => true,
        'capability_type' => 'post',
        'publicly_queryable' => false,
        'exclude_from_search' => true,
        'hierarchical' => false,
        'supports' => false,
        'has_archive' => false,
    );
    // Register custom post type.
    register_post_type("job-alert", $args);
}
add_action( 'init', 'register_job_alert_post', 0 );


// Our Team 
function talented_team() {

	$labels = array(
		'name'                  => _x( 'Talented Team', 'Talented Team General Name', 'jobcircle' ),
		'singular_name'         => _x( 'Talented Team', 'Talented Team Singular Name', 'jobcircle' ),
		'menu_name'             => __( 'Talented Team', 'jobcircle' ),
		'name_admin_bar'        => __( 'Talented Team', 'jobcircle' ),
		'archives'              => __( 'Item Archives', 'jobcircle' ),
		'attributes'            => __( 'Item Attributes', 'jobcircle' ),
		'parent_item_colon'     => __( 'Parent Item:', 'jobcircle' ),
		'all_items'             => __( 'All Items', 'jobcircle' ),
		'add_new_item'          => __( 'Add New Item', 'jobcircle' ),
		'add_new'               => __( 'Add New', 'jobcircle' ),
		'new_item'              => __( 'New Item', 'jobcircle' ),
		'edit_item'             => __( 'Edit Item', 'jobcircle' ),
		'update_item'           => __( 'Update Item', 'jobcircle' ),
		'view_item'             => __( 'View Item', 'jobcircle' ),
		'view_items'            => __( 'View Items', 'jobcircle' ),
		'search_items'          => __( 'Search Item', 'jobcircle' ),
		'not_found'             => __( 'Not found', 'jobcircle' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'jobcircle' ),
		'featured_image'        => __( 'Featured Image', 'jobcircle' ),
		'set_featured_image'    => __( 'Set featured image', 'jobcircle' ),
		'remove_featured_image' => __( 'Remove featured image', 'jobcircle' ),
		'use_featured_image'    => __( 'Use as featured image', 'jobcircle' ),
		'insert_into_item'      => __( 'Insert into item', 'jobcircle' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'jobcircle' ),
		'items_list'            => __( 'Items list', 'jobcircle' ),
		'items_list_navigation' => __( 'Items list navigation', 'jobcircle' ),
		'filter_items_list'     => __( 'Sectors items list', 'jobcircle' ),
	);
	$args = array(
		'label'                 => __( 'Talented Team', 'jobcircle' ),
		'description'           => __( 'Talented Team Description', 'jobcircle' ),
		'labels'                => $labels,
		'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
	);
	register_post_type( 'talented_team', $args );

}
add_action( 'init', 'talented_team', 0 );

// taxonomy


// Register Custom Filters


function team_texanomy() {

	$labels = array(
		'name'                       => _x( 'Our Team', 'Filters General Name', 'jobcircle' ),
		'singular_name'              => _x( 'Our Team', 'Filters Singular Name', 'jobcircle' ),
		'menu_name'                  => __( 'Our Team', 'jobcircle' ),
		'all_items'                  => __( 'All Items', 'jobcircle' ),
		'parent_item'                => __( 'Parent Item', 'jobcircle' ),
		'parent_item_colon'          => __( 'Parent Item:', 'jobcircle' ),
		'new_item_name'              => __( 'New Item Name', 'jobcircle' ),
		'add_new_item'               => __( 'Add New Item', 'jobcircle' ),
		'edit_item'                  => __( 'Edit Item', 'jobcircle' ),
		'update_item'                => __( 'Update Item', 'jobcircle' ),
		'view_item'                  => __( 'View Item', 'jobcircle' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'jobcircle' ),
		'add_or_remove_items'        => __( 'Add or remove items', 'jobcircle' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'jobcircle' ),
		'popular_items'              => __( 'Popular Items', 'jobcircle' ),
		'search_items'               => __( 'Search Items', 'jobcircle' ),
		'not_found'                  => __( 'Not Found', 'jobcircle' ),
		'no_terms'                   => __( 'No items', 'jobcircle' ),
		'items_list'                 => __( 'Items list', 'jobcircle' ),
		'items_list_navigation'      => __( 'Items list navigation', 'jobcircle' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'our_team', array( 'talented_team' ), $args );

}
add_action( 'init', 'team_texanomy', 0 );

// top cvandidaTESA

function jobcircle_candidates_post_type() {

	$labels = array(
		'name'                  => _x( 'Candidate', 'Candidate General Name', 'jobcircle-frame' ),
		'singular_name'         => _x( 'Candidate', 'Candidate Singular Name', 'jobcircle-frame' ),
		'menu_name'             => __( 'Candidate', 'jobcircle-frame' ),
		'name_admin_bar'        => __( 'Candidate', 'jobcircle-frame' ),
		'archives'              => __( 'Item Archives', 'jobcircle-frame' ),
		'attributes'            => __( 'Item Attributes', 'jobcircle-frame' ),
		'parent_item_colon'     => __( 'Parent Item:', 'jobcircle-frame' ),
		'all_items'             => __( 'All Items', 'jobcircle-frame' ),
		'add_new_item'          => __( 'Add New Item', 'jobcircle-frame' ),
		'add_new'               => __( 'Add New', 'jobcircle-frame' ),
		'new_item'              => __( 'New Item', 'jobcircle-frame' ),
		'edit_item'             => __( 'Edit Item', 'jobcircle-frame' ),
		'update_item'           => __( 'Update Item', 'jobcircle-frame' ),
		'view_item'             => __( 'View Item', 'jobcircle-frame' ),
		'view_items'            => __( 'View Items', 'jobcircle-frame' ),
		'search_items'          => __( 'Search Item', 'jobcircle-frame' ),
		'not_found'             => __( 'Not found', 'jobcircle-frame' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'jobcircle-frame' ),
		'featured_image'        => __( 'Featured Image', 'jobcircle-frame' ),
		'set_featured_image'    => __( 'Set featured image', 'jobcircle-frame' ),
		'remove_featured_image' => __( 'Remove featured image', 'jobcircle-frame' ),
		'use_featured_image'    => __( 'Use as featured image', 'jobcircle-frame' ),
		'insert_into_item'      => __( 'Insert into item', 'jobcircle-frame' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'jobcircle-frame' ),
		'items_list'            => __( 'Items list', 'jobcircle-frame' ),
		'items_list_navigation' => __( 'Items list navigation', 'jobcircle-frame' ),
		'filter_items_list'     => __( 'Sectors items list', 'jobcircle-frame' ),
	);
	$args = array(
		'label'                 => __( 'Candidate', 'jobcircle-frame' ),
		'description'           => __( 'Candidate Description', 'jobcircle-frame' ),
		'labels'                => $labels,
		'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'revisions', ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
	);
	register_post_type( 'candidates', $args );

}
add_action( 'init', 'jobcircle_candidates_post_type', 0 );

// taxonomy
 // taxonomy Condidate 

function candidate_taxonomy() {

	$labels = array(
		'name'                       => _x( 'Categories', 'Categories General Name', 'jobcircle-frame' ),
		'singular_name'              => _x( 'Categories', 'Categories Singular Name', 'jobcircle-frame' ),
		'menu_name'                  => __( 'Categories', 'jobcircle-frame' ),
		'all_items'                  => __( 'All Items', 'jobcircle-frame' ),
		'parent_item'                => __( 'Parent Item', 'jobcircle-frame' ),
		'parent_item_colon'          => __( 'Parent Item:', 'jobcircle-frame' ),
		'new_item_name'              => __( 'New Item Name', 'jobcircle-frame' ),
		'add_new_item'               => __( 'Add New Item', 'jobcircle-frame' ),
		'edit_item'                  => __( 'Edit Item', 'jobcircle-frame' ),
		'update_item'                => __( 'Update Item', 'jobcircle-frame' ),
		'view_item'                  => __( 'View Item', 'jobcircle-frame' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'jobcircle-frame' ),
		'add_or_remove_items'        => __( 'Add or remove items', 'jobcircle-frame' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'jobcircle-frame' ),
		'popular_items'              => __( 'Popular Items', 'jobcircle-frame' ),
		'search_items'               => __( 'Search Items', 'jobcircle-frame' ),
		'not_found'                  => __( 'Not Found', 'jobcircle-frame' ),
		'no_terms'                   => __( 'No items', 'jobcircle-frame' ),
		'items_list'                 => __( 'Items list', 'jobcircle-frame' ),
		'items_list_navigation'      => __( 'Items list navigation', 'jobcircle-frame' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'candidate_cat', array( 'candidates' ), $args );

	//
	$labels = array(
		'name'                       => _x( 'Categories', 'Categories General Name', 'jobcircle-frame' ),
		'singular_name'              => _x( 'Categories', 'Categories Singular Name', 'jobcircle-frame' ),
		'menu_name'                  => __( 'Categories', 'jobcircle-frame' ),
		'all_items'                  => __( 'All Items', 'jobcircle-frame' ),
		'parent_item'                => __( 'Parent Item', 'jobcircle-frame' ),
		'parent_item_colon'          => __( 'Parent Item:', 'jobcircle-frame' ),
		'new_item_name'              => __( 'New Item Name', 'jobcircle-frame' ),
		'add_new_item'               => __( 'Add New Item', 'jobcircle-frame' ),
		'edit_item'                  => __( 'Edit Item', 'jobcircle-frame' ),
		'update_item'                => __( 'Update Item', 'jobcircle-frame' ),
		'view_item'                  => __( 'View Item', 'jobcircle-frame' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'jobcircle-frame' ),
		'add_or_remove_items'        => __( 'Add or remove items', 'jobcircle-frame' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'jobcircle-frame' ),
		'popular_items'              => __( 'Popular Items', 'jobcircle-frame' ),
		'search_items'               => __( 'Search Items', 'jobcircle-frame' ),
		'not_found'                  => __( 'Not Found', 'jobcircle-frame' ),
		'no_terms'                   => __( 'No items', 'jobcircle-frame' ),
		'items_list'                 => __( 'Items list', 'jobcircle-frame' ),
		'items_list_navigation'      => __( 'Items list navigation', 'jobcircle-frame' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'employer_cat', array( 'employer' ), $args );

	//
	$labels = array(
		'name'                       => _x( 'Skills', 'Skills General Name', 'jobcircle-frame' ),
		'singular_name'              => _x( 'Skills', 'Skills Singular Name', 'jobcircle-frame' ),
		'menu_name'                  => __( 'Skills', 'jobcircle-frame' ),
		'all_items'                  => __( 'All Items', 'jobcircle-frame' ),
		'parent_item'                => __( 'Parent Item', 'jobcircle-frame' ),
		'parent_item_colon'          => __( 'Parent Item:', 'jobcircle-frame' ),
		'new_item_name'              => __( 'New Item Name', 'jobcircle-frame' ),
		'add_new_item'               => __( 'Add New Item', 'jobcircle-frame' ),
		'edit_item'                  => __( 'Edit Item', 'jobcircle-frame' ),
		'update_item'                => __( 'Update Item', 'jobcircle-frame' ),
		'view_item'                  => __( 'View Item', 'jobcircle-frame' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'jobcircle-frame' ),
		'add_or_remove_items'        => __( 'Add or remove items', 'jobcircle-frame' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'jobcircle-frame' ),
		'popular_items'              => __( 'Popular Items', 'jobcircle-frame' ),
		'search_items'               => __( 'Search Items', 'jobcircle-frame' ),
		'not_found'                  => __( 'Not Found', 'jobcircle-frame' ),
		'no_terms'                   => __( 'No items', 'jobcircle-frame' ),
		'items_list'                 => __( 'Items list', 'jobcircle-frame' ),
		'items_list_navigation'      => __( 'Items list navigation', 'jobcircle-frame' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => false,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => false,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'candidate_skill', array( 'candidates' ), $args );

}
add_action( 'init', 'candidate_taxonomy', 0 );



// Employee  Post Type 
function jobcircle_employee_type() {

	$labels = array(
		'name'                  => _x( 'Employer', 'Employers General Name', 'jobcircle-frame' ),
		'singular_name'         => _x( 'Employer', 'Employers Singular Name', 'jobcircle-frame' ),
		'menu_name'             => __( 'Employer', 'jobcircle-frame' ),
		'name_admin_bar'        => __( 'Employer', 'jobcircle-frame' ),
		'archives'              => __( 'Item Archives', 'jobcircle-frame' ),
		'attributes'            => __( 'Item Attributes', 'jobcircle-frame' ),
		'parent_item_colon'     => __( 'Parent Item:', 'jobcircle-frame' ),
		'all_items'             => __( 'All Items', 'jobcircle-frame' ),
		'add_new_item'          => __( 'Add New Item', 'jobcircle-frame' ),
		'add_new'               => __( 'Add New', 'jobcircle-frame' ),
		'new_item'              => __( 'New Item', 'jobcircle-frame' ),
		'edit_item'             => __( 'Edit Item', 'jobcircle-frame' ),
		'update_item'           => __( 'Update Item', 'jobcircle-frame' ),
		'view_item'             => __( 'View Item', 'jobcircle-frame' ),
		'view_items'            => __( 'View Items', 'jobcircle-frame' ),
		'search_items'          => __( 'Search Item', 'jobcircle-frame' ),
		'not_found'             => __( 'Not found', 'jobcircle-frame' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'jobcircle-frame' ),
		'featured_image'        => __( 'Featured Image', 'jobcircle-frame' ),
		'set_featured_image'    => __( 'Set featured image', 'jobcircle-frame' ),
		'remove_featured_image' => __( 'Remove featured image', 'jobcircle-frame' ),
		'use_featured_image'    => __( 'Use as featured image', 'jobcircle-frame' ),
		'insert_into_item'      => __( 'Insert into item', 'jobcircle-frame' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'jobcircle-frame' ),
		'items_list'            => __( 'Items list', 'jobcircle-frame' ),
		'items_list_navigation' => __( 'Items list navigation', 'jobcircle-frame' ),
		'filter_items_list'     => __( 'Sectors items list', 'jobcircle-frame' ),
	);
	$args = array(
		'label'                 => __( 'Employers', 'jobcircle-frame' ),
		'description'           => __( 'Employers Description', 'jobcircle-frame' ),
		'labels'                => $labels,
		'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'revisions', ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
	);
	register_post_type( 'employer', $args );

}
add_action( 'init', 'jobcircle_employee_type', 0 );


// company list by qurban
function Company() {

	$labels = array(
		'name'                  => _x( 'Company', 'Company General Name', 'jobcircle' ),
		'singular_name'         => _x( 'Company', 'Company Singular Name', 'jobcircle' ),
		'menu_name'             => __( 'Company', 'jobcircle' ),
		'name_admin_bar'        => __( 'Company', 'jobcircle' ),
		'archives'              => __( 'Item Archives', 'jobcircle' ),
		'attributes'            => __( 'Item Attributes', 'jobcircle' ),
		'parent_item_colon'     => __( 'Parent Item:', 'jobcircle' ),
		'all_items'             => __( 'All Items', 'jobcircle' ),
		'add_new_item'          => __( 'Add New Item', 'jobcircle' ),
		'add_new'               => __( 'Add New', 'jobcircle' ),
		'new_item'              => __( 'New Item', 'jobcircle' ),
		'edit_item'             => __( 'Edit Item', 'jobcircle' ),
		'update_item'           => __( 'Update Item', 'jobcircle' ),
		'view_item'             => __( 'View Item', 'jobcircle' ),
		'view_items'            => __( 'View Items', 'jobcircle' ),
		'search_items'          => __( 'Search Item', 'jobcircle' ),
		'not_found'             => __( 'Not found', 'jobcircle' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'jobcircle' ),
		'featured_image'        => __( 'Featured Image', 'jobcircle' ),
		'set_featured_image'    => __( 'Set featured image', 'jobcircle' ),
		'remove_featured_image' => __( 'Remove featured image', 'jobcircle' ),
		'use_featured_image'    => __( 'Use as featured image', 'jobcircle' ),
		'insert_into_item'      => __( 'Insert into item', 'jobcircle' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'jobcircle' ),
		'items_list'            => __( 'Items list', 'jobcircle' ),
		'items_list_navigation' => __( 'Items list navigation', 'jobcircle' ),
		'filter_items_list'     => __( 'Sectors items list', 'jobcircle' ),
	);
	$args = array(
		'label'                 => __( 'Candidate', 'jobcircle' ),
		'description'           => __( 'Candidate Description', 'jobcircle' ),
		'labels'                => $labels,
		'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
	);
	register_post_type( 'company', $args );

}
add_action( 'init', 'Company', 0 );

// taxonomy


