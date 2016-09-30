<?php
header("Cache-Control: no-cache, must-revalidate"); 
function wcpd_product_desingner(){
    $html = '';
    $lables ='<div class="lables-wrapper clearfix"><div class="product-name lables lables-left"></div><div class="lables lables-right">'.__('Елементи').'</div></div>';
    $html.=$lables;
    $html.='<div id="canvas">';    
    $divproductstyles = '<div class="styles-list"></div>';
    $divproducts ='<div id="products">'.product_designer_get_product_list().'</div>';
    $div_playground = '<div id="product-page"><div id="canvas-wrapper"><canvas id="playground" width=465 height=465 "></canvas></div></div>';
    $div_accessoires = '<div id="accessoires">'.'<div id="select-wrapper">'.product_designer_get_size_of_accessoires().''.product_designer_get_color_of_accessoires().'</div><div class="accessoires"></div></div>';
    
    $html.=$divproductstyles.$divproducts.$div_playground.$div_accessoires;
     $html.='</div>';
    $html .= '<div id="product-cart-info-wrapper"><div id="product-cart-info" class="clearfix"><div id="info"><input type="button" class="product-price"></input></div><div id="cart-button"></div></div></div>';
   
    return $html;
}

add_shortcode( 'creating_page', 'wcpd_product_desingner' );

function product_designer_get_product_list()
	{		
		$count = 0;
		$args_prod = array(			
			'post_type' => 'custom_product',
			'post_status' => 'publish',
                        'meta_key' => '_thumbnail_id',
			'meta_value' => '',
			'meta_compare' => '!='			
			);
                
		global $prodict_query;
		$prodict_query = new WP_Query($args_prod);	
        
		$html = '';
		$html.='<div class="product-list">';
                
		if($prodict_query->have_posts()): while($prodict_query->have_posts()): $prodict_query->the_post();                
                $product_url = wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()) );                           
			if(!empty($product_url))
				{
					$html.= '<div class="product-wrapper"><img id="'.get_the_ID().'" src="'.$product_url.'"/></div>';
                                        $count++;
				}                                
                                
		
		endwhile;
                for($i = 0; $i< 4 - $count; $i++){
                                   $html.= '<div class="product-wrapper empty"></div>';               

                                }
		wp_reset_postdata();
		endif;
		$html.='</div>';		

		return $html;
	}

function product_designer_get_products_styles_list_ajax()
	{    
        if (isset($_POST['product_id'])) {
           $id = $_POST['product_id'];
        }
        $args = array(
            'order' => 'ASC',
            'post_mime_type' => 'image',
            'post_parent' => $id,
            'post_status' => null,        
            'post_type' => 'attachment',
            'posts_per_page' => 20,

        );
        $attachments = get_posts( $args );

        $html= '';

        if ( $attachments ) {
        
        foreach ( $attachments as $attachment ) { 
           $url = wp_get_attachment_url( $attachment->ID, 300, 300 );
            if(!(preg_match('/featured/',$url))){
                $image_attributes = wp_get_attachment_image_src( $attachment->ID, 'thumbnail' )  ? wp_get_attachment_image_src( $attachment->ID, 'thumbnail' ) : wp_get_attachment_image_src( $attachment->ID, 'full' );
                $html .=  '<div class="product-syles-item" id="'.$attachment->ID.'" style="background-image: url(' . $url. ');"></div>';

            }

          }
        }
    
    $name = get_the_title($id);
    $price = get_post_meta( $id, 'custom_product_price', true );
    $base_img = get_post_meta( $id, 'wp_custom_attachment', true );
    $result = array($price, $name, $html, $base_img);
    echo json_encode($result);
    exit();
	};
add_action('wp_ajax_product_designer_get_products_styles_list_ajax', 'product_designer_get_products_styles_list_ajax');
add_action('wp_ajax_nopriv_product_designer_get_products_styles_list_ajax', 'product_designer_get_products_styles_list_ajax');

function product_designer_get_product_style_ajax()
	{    
    if (isset($_POST['product_id'])) {
       $id = $_POST['product_id'];

    }
    
    $product_style = get_post($id);
    $url = wp_get_attachment_url( $product_style->ID );
	echo  $url;
    die();
	};
add_action('wp_ajax_product_designer_get_product_style_ajax', 'product_designer_get_product_style_ajax');
add_action('wp_ajax_nopriv_product_designer_get_product_style_ajax', 'product_designer_get_product_style_ajax');
    
        
function product_designer_get_accessoires_list_by_cat(){
    $count = 0;
    if (isset($_POST['size'])) {
       $term1 = $_POST['size'];
    }
    if (isset($_POST['color'])) {
       $term2 = $_POST['color'];
    }
		$args_access = array(
			
			'post_type' => 'knob',
			'post_status' => 'publish',
                        'posts_per_page' => 10,
                        'tax_query' => array(
                                        array(
                                                'taxonomy' => 'knob_size',
                                                'field'    => 'slug',
                                                'terms'    =>array($term1),
                                                'operator' => 'AND'
                    ),
                            array(
                                                'taxonomy' => 'knob_category',
                                                'field'    => 'slug',
                                                'terms'    =>array($term2),
                                                'operator' => 'AND'
                    ),
                          ));
                
		global $prodict_query;
		$prodict_query = new WP_Query($args_access);
               
		$html = '';
                
		if($prodict_query->have_posts()){
                    while($prodict_query->have_posts()){
                        
                        $prodict_query->the_post();                        
                        $sticker_url = wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()) );
                             
			if(!empty($sticker_url))
				{
					$html.= '<div class="img-wrapper"><img class="full_knob" id="'.get_the_ID().'" src="'.$sticker_url.'"/></div>';
                                         $count++;
				}
                                
                    }
                    for($i = 0; $i< 10 - $count; $i++){
                                   $html.= '<div class="img-wrapper"><img class="empty_knob" src="'."http://".$_SERVER[HTTP_HOST].'/wp-content/plugins/product-designer/images/Button_empty.png'.'"/></div>';              

                                }
                }  else {
                    for($i = 0; $i< 10; $i++){
                                   $html.= '<div class="img-wrapper"><img class="empty_knob" src="'."http://".$_SERVER[HTTP_HOST].'/wp-content/plugins/product-designer/images/Button_empty.png'.'"/></div>';              

                                }
                }
                 
                 
                                
		wp_reset_postdata();
		
               
		echo $html;
                die();
	}
add_action('wp_ajax_product_designer_get_accessoires_list_by_cat', 'product_designer_get_accessoires_list_by_cat');
add_action('wp_ajax_nopriv_product_designer_get_accessoires_list_by_cat', 'product_designer_get_accessoires_list_by_cat');

function product_designer_get_size_of_accessoires()
	{

        $categories = get_terms( array(
        'taxonomy' => 'knob_size',
        'hide_empty' => false,
                ) );
		$html = '';       
		$html .= '<select class="accessoires-size" name="categories">';   
		
		foreach($categories as $category){
            if ($category === reset($categories)){
                $html .= '<option selected class='.$category->term_id.'>'.$category->name.'</option>';	
              }else{
                $html .= '<option class='.$category->term_id.'>'.$category->name.'</option>';	
                
            }	
		
		}
				
		$html .= '</select>';     
		return $html;
	
	}
function product_designer_get_color_of_accessoires()
	{

        $categories = get_terms( array(
        'taxonomy' => 'knob_category',
        'hide_empty' => false,
                ) );
		$html = '';       
		$html .= '<select class="accessoires-color" name="categories">';   
		
		foreach($categories as $category){
            if ($category === reset($categories)){
                $html .= '<option class="'.$category->term_id.'" selected="selected">'.$category->name.'</option>';	
              }else{
			
			$html .= '<option class='.$category->term_id.'>'.$category->name.'</option>';
            }
		
		}
				
		$html .= '</select>';     
		return $html;
	
	}

function product_designer_get_product_cat()
	{
    

        $categories = get_terms( array(
        'taxonomy' => 'product_category',
        'hide_empty' => false,
                ) );
		$html = '';       
		$html.='<div class="product-list">';
		foreach($categories as $category){
			$url=  get_option('z_taxonomy_image'.$category->term_id);
			$html .='<img id="'.$category->term_id.'" class="product-img" src="'.$url.'"/>';
		
		}				
		 
        $html.='</div>';
		return $html;  
	}

function product_designer_get_image_by_id(){

    if (isset($_POST['image_id'])) {
       $id = $_POST['image_id'];

    }
                
		$html = '';
                        
        $img_url = wp_get_attachment_url( get_post_thumbnail_id($id) );
         
		$html.= $img_url;
		
		wp_reset_postdata();
		

		echo $html;
        die();
	}
add_action('wp_ajax_product_designer_get_image_by_id', 'product_designer_get_image_by_id');
add_action('wp_ajax_nopriv_product_designer_get_image_by_id', 'product_designer_get_image_by_id');

function add_product_to_cart($id) {
    
        global $woocommerce;
        $product_id = $id;
        $found = false;
        //check if product already in cart
       if ( sizeof( $woocommerce->cart->get_cart() ) > 0 ) {
            foreach ( $woocommerce->cart->get_cart() as $cart_item_key => $values ) {
                $_product = $values['data'];
                if ( $_product->id == $product_id )
                    $found = true;
            }
            // if product not found, add it
            if ( ! $found )
                $woocommerce->cart->add_to_cart( $product_id );
        } else {
            // if no products in cart, add it
            $woocommerce->cart->add_to_cart( $product_id );
        }  
}

function generate_featured_image($imageURL, $post_id){
        
    $upload_dir = wp_upload_dir();
    $image_data = file_get_contents($imageURL);
    $filename = 'image'.$post_id.'.jpg';
    if(wp_mkdir_p($upload_dir['path']))     $file = $upload_dir['path'] . '/' . $filename;
    else                                    $file = $upload_dir['basedir'] . '/' . $filename;
    file_put_contents($file, $image_data);

    $wp_filetype = wp_check_filetype($filename, null );
    $attachment = array(
        'post_mime_type' => $wp_filetype['type'],
        'post_title' => sanitize_file_name($filename),
        'post_content' => '',
        'post_status' => 'inherit'
    );
    $attach_id = wp_insert_attachment( $attachment, $file, $post_id );    
    $attach_data = wp_generate_attachment_metadata( $attach_id, $file );
    $res1= wp_update_attachment_metadata( $attach_id, $attach_data );
    $res2= set_post_thumbnail( $post_id, $attach_id );
   }

function product_designer_sent_product_to_cart_ajax(){
    if (isset($_POST['id'])) {
       $id = $_POST['id'];
    }
    if (isset($_POST['name'])) {
       $name = $_POST['name'];
    }
    if (isset($_POST['price'])) {
       $price = $_POST['price'];
    }
    if (isset($_POST['knob_names'])) {
       $knob_names = $_POST['knob_names'];
    }
    
    if (isset($_POST['imageURL'])) {
       $imageURL = $_POST['imageURL'];
    }
    
$post_id = wp_insert_post(
            array(
                'comment_status'    =>  'closed',
                'ping_status'       =>  'closed',
                'post_content' =>  $knob_names,
                'post_author'       =>  $user_id,
                'post_name'     =>  $name,
                'post_title'        =>  $name,
                'post_status'       =>  'publish',
                'post_type'     =>  'product',
            )
        );
    
    generate_featured_image($imageURL, $post_id);
    update_post_meta( $post_id, '_price', $price );
    add_product_to_cart($post_id);
   
}
add_action('wp_ajax_product_designer_sent_product_to_cart_ajax', 'product_designer_sent_product_to_cart_ajax');
add_action('wp_ajax_nopriv_product_designer_sent_product_to_cart_ajax', 'product_designer_sent_product_to_cart_ajax');


            
        