<?php
function xxxx_add_edit_form_multipart_encoding() {

    echo ' enctype="multipart/form-data"';

}
add_action('post_edit_form_tag', 'xxxx_add_edit_form_multipart_encoding');

function custom_cp_meta_box_markup () {
  	global $post;
    $post_ID = $post->ID; // global used by get_upload_iframe_src
  	printf( "<iframe frameborder='0'  src=' %s ' style='width: 100%%; height: 400px;'> </iframe>", get_upload_iframe_src('media') );
  }


function add_pc_custom_meta_box()
{
    add_meta_box("pc-meta-box", "Additional styles", "custom_cp_meta_box_markup", "custom_product", "normal", "high", null);
}

add_action("add_meta_boxes", "add_pc_custom_meta_box");

 
function wcpc_add_custom_metabox() {

	add_meta_box(
		'wcpc_meta',
		__( 'Product price' ),
		'wcpc_meta_callback',
		'custom_product',
		'normal',
		'core'
	);
    

}

add_action( 'add_meta_boxes', 'wcpc_add_custom_metabox' );

function wcpc_meta_callback( $post ) {
	wp_nonce_field( basename( __FILE__ ), 'wcpc_custom_products_nonce' );
    
	$wcpc_stored_meta = get_post_meta( $post->ID ); ?>

	<div>
		<div class="meta-row">
			<div class="meta-th">
				<label for="custom-product-price" class="wcpc-row-title"><?php _e( 'Enter price', 'product-creator' ); ?></label>
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
}


function wcpc_meta_save( $post_id ) {
	// Checks save status
    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
    $is_valid_nonce = ( isset( $_POST[ 'wcpc_custom_products_nonce' ] ) && wp_verify_nonce( $_POST[ 'wcpc_custom_products_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';

    // Exits script depending on save status
    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return;
    }

    if ( isset( $_POST[ 'custom_product_price' ] ) ) {
    	update_post_meta( $post_id, 'custom_product_price', sanitize_text_field( $_POST[ 'custom_product_price' ] ) );
    }
    
    
    
}
add_action( 'save_post', 'wcpc_meta_save' );



    