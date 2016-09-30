<?php

/**
 * Plugin Name: Product Designer
 * Plugin URI: 
 * Description: This is woocommerce plugin for your clients to design their own products.
 * Author URI: 
 * Version: 1.0
 * 
 */

if (!defined('ABSPATH')) {
    exit;
}

require_once(ABSPATH . 'wp-admin/includes/image.php');
require_once ( plugin_dir_path(__FILE__) . 'product-designer-cpt.php' );
require_once ( plugin_dir_path(__FILE__) . 'product-designer-shortcode.php' );
require_once ( plugin_dir_path(__FILE__) . 'product-designer-fields.php' );



function wcpd_admin_enqueue_scripts() {
        wp_enqueue_script('jquery');		
    	wp_enqueue_script( 'jquery-ui-core' );
        wp_enqueue_script( 'jquery-ui-widget' );
        wp_enqueue_script( 'jquery-ui-mouse' );		
    	wp_enqueue_script( 'jquery-ui-draggable' );
        wp_enqueue_script( 'jquery-ui-resizable' );
        wp_enqueue_script( 'jquery-ui',"//code.jquery.com/ui/1.11.4/jquery-ui.js" );        
        wp_enqueue_script( 'render-accessoires-js', plugins_url( '/js/render-accessoires.js', __FILE__ ), array('jquery'));
        wp_enqueue_script( 'jcanvas-js', plugins_url( '/js/jcanvas.min.js', __FILE__ ), array('jquery'));
        wp_enqueue_script( 'canvas-render-js', plugins_url( '/js/canvas-render.js', __FILE__ ), array('jquery', 'jcanvas-js'));    
   
                
        wp_localize_script( 'render-accessoires-js', 'woo_product_designer_ajax', array( 'woo_product_designer_ajaxurl' => admin_url( 'admin-ajax.php')));
        
        wp_enqueue_style('wpd_stylesheet', plugins_url( '/css/stylesheet.css', __FILE__ ));
         wp_enqueue_style('wpd_stylesheet', plugins_url( '/css/bootstrap.css', __FILE__ ));
       // wp_enqueue_style('jquery-ui-css', plugins_url( '/css/jquery-ui.css', __FILE__ ));
       // wp_enqueue_style('jquery-ui.css', woo_product_designer_plugin_url.'css/jquery-ui.css');      
        
       
}

add_action( 'init', 'wcpd_admin_enqueue_scripts' );