<?php
add_action( 'wp_enqueue_scripts', 'child_enqueue_styles',99);
function child_enqueue_styles() {
    $parent_style = 'parent-style';
    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/dist/bundle-style.min.css', array( $parent_style ) );
}
if ( get_stylesheet() !== get_template() ) {
    add_filter( 'pre_update_option_theme_mods_' . get_stylesheet(), function ( $value, $old_value ) {
         update_option( 'theme_mods_' . get_template(), $value );
         return $old_value; // prevent update to child theme mods
    }, 10, 2 );
    add_filter( 'pre_option_theme_mods_' . get_stylesheet(), function ( $default ) {
        return get_option( 'theme_mods_' . get_template(), $default );
    } );
}

add_filter( 'nav_menu_link_attributes', 'submenu_attribute_dropdown', 10, 3 );
function submenu_attribute_dropdown( $atts, $item, $args )
{
  // The ID of the target menu item
  $menu_target = 130;
  $menu_target2 = 334;

  // inspect $item
  if ($item->ID == $menu_target) {
    $atts['data-toggle'] = 'dropdown';
  }

  if ($item->ID == $menu_target2) {
    $atts['data-toggle'] = 'dropdown';
  }
  return $atts;
}

add_filter( 'nav_menu_link_attributes', 'wpse156165_menu_add_class', 10, 3 );

function wpse156165_menu_add_class( $atts, $item, $args ) {
    $class = 'dropdown-toggle'; // or something based on $item
    $atts['class'] = $class;
    return $atts;
}

function change_submenu_class($menu) {  
  $menu = preg_replace('/ class="sub-menu"/','/ class="dropdown-menu sub-menu" /',$menu);  
  return $menu;  
}  
add_filter('wp_nav_menu','change_submenu_class');


// Change number or products per row to 3
add_filter('loop_shop_columns', 'loop_columns');
if (!function_exists('loop_columns')) {
	function loop_columns() {
		return 3; // 3 products per row
	}
}

remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );

add_action( 'after_setup_theme', 'remove_pgz_theme_support', 100 );

function remove_pgz_theme_support() { 
	remove_theme_support( 'wc-product-gallery-zoom' );
	//remove_theme_support( 'wc-product-gallery-lightbox' );
}

add_theme_support( 'woocommerce', array(
  'thumbnail_image_width' => 200,
  'single_image_width' => 350,
  ) );
