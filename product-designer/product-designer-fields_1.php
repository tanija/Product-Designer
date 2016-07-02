<?php
function xxxx_add_edit_form_multipart_encoding() {

    echo ' enctype="multipart/form-data"';

}
add_action('post_edit_form_tag', 'xxxx_add_edit_form_multipart_encoding');

//function custom_cp_meta_box_markup () {
//  	global $post;
//    $post_ID = $post->ID; // global used by get_upload_iframe_src
//  	printf( "<iframe frameborder='0'  src=' %s ' style='width: 100%%; height: 400px;'> </iframe>", get_upload_iframe_src('media') );
//  }


//function add_pc_custom_meta_box()
//{
//    add_meta_box("pc-meta-box", "Additional styles", "custom_cp_meta_box_markup", "custom_product", "normal", "high", null);
//}

//add_action("add_meta_boxes", "add_pc_custom_meta_box");

 
function wcpc_add_custom_metabox() {

	add_meta_box(
		'wcpc_meta',
		__( 'Additional' ),
		'wcpc_meta_callback',
		'custom_product',
		'normal',
		'core'
	);
//    add_meta_box(
//        'wcpc_base_image_attachment',
//        __( 'Product base image' ),
//        'wp_custom_attachment',
//        'custom_product',
//		'side',
//		'core'
//    );

}

add_action( 'add_meta_boxes', 'wcpc_add_custom_metabox' );

function wcpc_meta_callback( $post ) {
	wp_nonce_field( basename( __FILE__ ), 'wcpc_custom_products_nonce' );
    
    global $post;
    $post_ID = $post->ID; // global used by get_upload_iframe_src
  	printf( "<iframe frameborder='0'  src=' %s ' style='width: 100%%; height: 400px;'> </iframe>", get_upload_iframe_src('media') );
    
	$wcpc_stored_meta = get_post_meta( $post->ID ); ?>

	<div>
		<div class="meta-row">
			<div class="meta-th">
				<label for="custom-product-price" class="wcpc-row-title"><?php _e( 'Enter price', 'product-designer' ); ?></label>
			</div>
			<div class="meta-td">
				<input type="text" class="wcpc-row-content" name="custom_product_price" id="custom-product-price"
				value="<?php if ( ! empty ( $wcpc_stored_meta['custom_product_price'] ) ) {
					echo esc_attr( $wcpc_stored_meta['custom_product_price'][0] );
				} ?>"/>
			</div>
		</div>		
		
</div>	   
	    
	<?php
    
    $html = '<p class="description">';
        $html .= 'Upload your base_product image here.';
    $html .= '</p>';
    if ( ! empty ( $wcpc_stored_meta["wp_custom_attachment"] ) ) {
	   $attach_val = esc_attr( $wcpc_stored_meta["wp_custom_attachment"]);
    };
    $html .= '<input type="file" id="wp_custom_attachment" name="wp_custom_attachment" value="'.$attach_val.' " size="25" />';
     
    echo $html;
}
//function wp_custom_attachment() {
// 
//    wp_nonce_field(plugin_basename(__FILE__), 'wp_custom_attachment_nonce');
//     $wcpc_stored_meta = get_post_meta( $post->ID );
//    
//    $html = '<p class="description">';
//        $html .= 'Upload your image here.';
//    $html .= '</p>';
//    $html .= '<input type="file" id="wp_custom_attachment" name="wp_custom_attachment" value="" size="25" />';
//     
//    echo $html;
// 
//}
//function send_base_img_meta_to_form(){
//    if ( ! empty ( $wcpc_stored_meta['wp_custom_attachment'] ) ) {
//	   echo esc_attr( $wcpc_stored_meta['wp_custom_attachment']);
//    }
//}
function wcpc_meta_save( $post_id ) {
	// Checks save status
    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
    $is_valid_nonce = ( isset( $_POST[ 'wcpc_custom_products_nonce' ] ) && wp_verify_nonce( $_POST[ 'wcpc_custom_products_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';  
    
    wp_nonce_field(plugin_basename(__FILE__), 'wp_custom_attachment_nonce');
    // Exits script depending on save status
    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return;
    }

    if ( isset( $_POST[ 'custom_product_price' ] ) ) {
    	update_post_meta( $post_id, 'custom_product_price', sanitize_text_field( $_POST[ 'custom_product_price' ] ) );
    }
    
    
    /* --- security verification --- */
    if(!wp_verify_nonce($_POST['wp_custom_attachment_nonce'], plugin_basename(__FILE__))) {
      return $post_id;
    } // end if
       
    if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
      return $post_id;
    } // end if
       
    if('custom_product' == $_POST['post_type']) {
      if(!current_user_can('edit_page', $post_id)) {
        return $post_id;
      } // end if
    } else {
        if(!current_user_can('edit_page', $post_id)) {
            return $post_id;
        } // end if
    } // end if
    /* - end security verification - */
     
    // Make sure the file array isn't empty
    if(!empty($_FILES['wp_custom_attachment']['name'])) {
         
        // Setup the array of supported file types. In this case, it's just PNG.
        $supported_types = array('image/png');
         
        // Get the file type of the upload
        $arr_file_type = wp_check_filetype(basename($_FILES['wp_custom_attachment']['name']));
        $uploaded_type = $arr_file_type['type'];
         
        // Check if the type is supported. If not, throw an error.
        if(in_array($uploaded_type, $supported_types)) {
 
            // Use the WordPress API to upload the file
            $upload = wp_upload_bits($_FILES['wp_custom_attachment']['name'], null, file_get_contents($_FILES['wp_custom_attachment']['tmp_name']));
     
            if(isset($upload['error']) && $upload['error'] != 0) {
                wp_die('There was an error uploading your file. The error is: ' . $upload['error']);
            } else {
                add_post_meta($post_id, 'wp_custom_attachment', $upload);
                update_post_meta($post_id, 'wp_custom_attachment', $upload);     
            } // end if/else
 
        } else {
            wp_die("The file type that you've uploaded is not a PNG.");
        } // end if/else
         
    } // end if
    
}
add_action( 'save_post', 'wcpc_meta_save' );

get_template_part( 'content', 'single' );
 echo get_post_meta($post->ID , 'wp_custom_attachment', true);

function update_edit_form() {
    echo ' enctype="multipart/form-data"';
} // end update_edit_form
add_action('post_edit_form_tag', 'update_edit_form');

<?php get_template_part( 'content', 'single' ); ?>
<?php $img = get_post_meta(get_the_ID(), 'wp_custom_attachment', true); ?>

<a href="<?php echo $img['url']; ?>">
    Download PDF Here
</a>