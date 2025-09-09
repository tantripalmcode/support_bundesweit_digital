<?php
/**
 * Voucher Popup Shortcode
 * 
 * Usage: [voucher_popup]
 * This shortcode displays the voucher motives popup
 */

add_shortcode( 'voucher_popup', 'voucher_popup_shortcode' );

function voucher_popup_shortcode( $atts ) {
    // Only show on frontend
    if ( is_admin() ) {
        return '';
    }
    
    // Enqueue required assets
    voucher_popup_enqueue_assets();
    
    // Include the popup template
    $template_path = get_stylesheet_directory() . '/template-parts/voucher-popup.php';
    if ( file_exists( $template_path ) ) {
        ob_start();
        include $template_path;
        return ob_get_clean();
    }
    
    return '';
}

/**
 * Enqueue voucher popup assets
 */
function voucher_popup_enqueue_assets() {
    // Swiper CSS
    wp_enqueue_style('swiper-css', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css', array(), '11.0.0');
    
    // Voucher popup styles
    $modified = date( 'YmdHis', filemtime( get_stylesheet_directory() . '/shortcodes/voucher-popup/voucher-popup.css' ) );
    wp_register_style('voucher-popup-style', get_stylesheet_directory_uri() . '/shortcodes/voucher-popup/voucher-popup.css', array('swiper-css'), $modified, 'all');
    wp_enqueue_style('voucher-popup-style');
    
    // Swiper JS
    wp_enqueue_script('swiper-js', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js', array(), '11.0.0', array('in_footer' => true));
    
    // Voucher popup script
    $modified = date( 'YmdHis', filemtime( get_stylesheet_directory() . '/shortcodes/voucher-popup/voucher-popup.js' ) );
    wp_enqueue_script('voucher-popup-script', get_stylesheet_directory_uri() . '/shortcodes/voucher-popup/voucher-popup.js', array('jquery', 'swiper-js'), $modified, array('in_footer' => true));
}
