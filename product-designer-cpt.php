<?php
function wcpd_knobs_register_post_type(){
    
    $singular = 'Knob';
    $plural = 'Knobs';
    
    $labels = array(
      'name' => $plural,
      'singular_name' => $singular,
      'add_name' => 'Add Name',
      'add_new_item' => 'Add New '.$singular,
      'edit' => 'Edit',  
      'edit_item' => 'Edit '.$singular,
      'new_item' => 'New '.$singular,
      'search_term' => 'Search '.$singular,
      'view' => 'View '.$singular,
      'view_item' => 'View '.$singular,
      'parent' => 'Parent '.$singular,
      'not_found' => 'No '.$plural. ' found',
      'not_found_in_trash' => 'No '.$plural. ' in Trash',
        'parent_item_colon' => ''
    );
    
    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'exclude_from_search' => true,
        'show_ui'            => true,
        'menu_position'       => 10,
      'menu_icon' => 'dashicons-smiley',
      'can_export'       => true,
        'query_var'          => true,
       'delete_with_user' => false,
      'pam_meta_cap' => true,
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => true, 
      'rewrite'            => array( 
        'slug' => 'knobs',
        'with_front' => true,
        'pages' => true,
        'feeds'=>true,
        ),
      'supports'           => array( 
        'title',
        'thumbnail'
        )
    );
    register_post_type('knob', $args);
}
add_action('init', 'wcpd_knobs_register_post_type');

function  wcpd_knob_register_taxonomy(){
    $singular = 'Knob category';
    $plural = 'Knob categories';
    
    $lables = array(
      'name' => $plural,
      'singular_name'  => $singular,
      'all_items' => 'All '. $plural,
      'edit_item' => 'Edit '.$singular,
      'update_item' => 'Update '.$singular,
      'add_new_item' => 'Add New '.$singular,
      'new_item_name' => 'New '.$singular.'Name',
      'search_items' => 'Search' .$singular,
      'popular_items' =>'Popular'.$singular,
      'separate_items_with_commas' => 'Separate '.$plural.' with commas',
      'add_or_remove_items' => 'Add or remove '.$singular,
      'choose_from_most_used' => 'Choose from the most used ' .$plural,
      'not_found' => 'No '.$plural. ' found',
      'menu_name' => $plural
   );

    $args = array(
      'hierarchical'       => true,
      'labels'             => $lables,
      'show_ui'           => true,
      'show_admin_column'  => true,
      'update_count_callback' => '_update_post_term_count',
      'query_var'          => true,      
       'rewrite'            => array( 
         'slug' => 'knob category',
         
         ),
    );
    register_taxonomy('knob_category', 'knob', $args);
}
add_action('init', 'wcpd_knob_register_taxonomy',0);

function  wcpd_knob_size_register_taxonomy(){
    $singular = 'Knob size';
    $plural = 'Knob sizes';
    
    $lables = array(
      'name' => $plural,
      'singular_name'  => $singular,
      'all_items' => 'All '. $plural,
      'edit_item' => 'Edit '.$singular,
      'update_item' => 'Update '.$singular,
      'add_new_item' => 'Add New '.$singular,
      'new_item_name' => 'New '.$singular.'Name',
      'search_items' => 'Search' .$singular,
      'popular_items' =>'Popular'.$singular,
      'separate_items_with_commas' => 'Separate '.$plural.' with commas',
      'add_or_remove_items' => 'Add or remove '.$singular,
      'choose_from_most_used' => 'Choose from the most used ' .$plural,
      'not_found' => 'No '.$plural. ' found',
      'menu_name' => $plural
   );

    $args = array(
      'hierarchical'       => true,
      'labels'             => $lables,
      'show_ui'           => true,
      'show_admin_column'  => true,
      'update_count_callback' => '_update_post_term_count',
      'query_var'          => true,
       'rewrite'            => array( 
         'slug' => 'knob size',
         
         ),
    );
    register_taxonomy('knob_size', 'knob', $args);
}
add_action('init', 'wcpd_knob_size_register_taxonomy',0);

function wcpd_custom_product_register_post_type(){
    
    $singular = 'Custom product';
    $plural = 'Custom products';
    
    $labels = array(
      'name' => $plural,
      'singular_name' => $singular,
      'add_name' => 'Add Name',
      'add_new_item' => 'Add New '.$singular,
      'edit' => 'Edit',  
      'edit_item' => 'Edit '.$singular,
      'new_item' => 'New '.$singular,
      'search_term' => 'Search '.$singular,
      'view' => 'View '.$singular,
      'view_item' => 'View '.$singular,
      'parent' => 'Parent '.$singular,
      'not_found' => 'No '.$plural. ' found',
      'not_found_in_trash' => 'No '.$plural. ' in Trash'
    );
    
    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'exclude_from_search' => true,
        'show_in_nav_menu'       => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
         'show_in_admin_bar'       => true,
        'menu_position'       => 10,
      'menu_icon' => 'dashicons-nametag',
      'can_export'       => true,
        'query_var'          => true,
       'delete_with_user' => false,
      'pam_meta_cap' => true,
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false, 
      'rewrite'            => true,
      'supports'           => array( 
        'title',
        'thumbnail'
        )
    );
    register_post_type('custom_product', $args);
}
add_action('init', 'wcpd_custom_product_register_post_type');

//function  wcpd_custom_product_register_taxonomy(){
//    $singular = 'Product category';
//    $plural = 'Product categories';
//    
//    $lables = array(
//      'name' => $plural,
//      'singular_name'  => $singular,
//      'all_items' => 'All '. $plural,
//      'edit_item' => 'Edit '.$singular,
//      'update_item' => 'Update '.$singular,
//      'add_new_item' => 'Add New '.$singular,
//      'new_item_name' => 'New '.$singular.'Name',
//      'search_items' => 'Search' .$singular,
//      'popular_items' =>'Popular'.$singular,
//      'separate_items_with_commas' => 'Separate '.$plural.' with commas',
//      'add_or_remove_items' => 'Add or remove '.$singular,
//      'choose_from_most_used' => 'Choose from the most used ' .$plural,
//      'not_found' => 'No '.$plural. ' found',
//      'menu_name' => $plural
//   );
//
//    $args = array(
//      'hierarchical'       => true,
//      'labels'             => $lables,
//     // 'show_ui'           => true,
//      'show_admin_column'  => true,
//    //'show_in_quick_edit' => true,
//      //'update_count_callback' => '_update_post_term_count',
//       //'query_var'          => true,      
//       'rewrite'            => array( 
//         'slug' => 'product category', 
//         
//         ),
//    );
//    register_taxonomy('product_category', 'custom_product', $args);
//}
//add_action('init', 'wcpd_custom_product_register_taxonomy',0);

function wcpd_install_page() {
	// Check if page already exists
	$mix_page = get_page_by_title( __( 'Product Designer' ) );	// check if builder page already exists
	if ( null === $mix_page ) {
		// Prepare page
		$arr_page_data = array(
			'post_status' 		=> 'publish',
			'post_type' 		=> 'page',
			'post_author' 		=> 1,
			'post_name' 		=> 'product-designer',
			'post_title' 		=> __( 'Product Designer' ),
			'post_content' 		=> '[creating_page]',
			'post_parent' 		=> '',
			'comment_status' 	=> 'closed'
		);
		// Create page
		$int_page_id = wp_insert_post( $arr_page_data );
	}
}
add_action('init', 'wcpd_install_page');