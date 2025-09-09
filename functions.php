<?php

/*
Prio auf 20, damit das Child-Theme nach dem Parent-Theme geladen wird. Parent Theme wird mit Prio 10 geladen.
https://developer.wordpress.org/reference/functions/add_action/
*/
add_action( 'wp_enqueue_scripts', 'bundesweit_enqueue_child_scripts', 20);

require_once "osticket-handler.php";

function bundesweit_enqueue_child_scripts() {
    // Get modification time.
    $modified = date( 'YmdHis', filemtime( get_stylesheet_directory() . '/style.css' ) );
    wp_register_style('child-style', get_stylesheet_directory_uri() . '/style.css', array(), $modified, 'all');
    wp_enqueue_style('child-style');

    $modified = date( 'YmdHis', filemtime( get_stylesheet_directory() . '/style2.css' ) );
    wp_register_style('child-style2', get_stylesheet_directory_uri() . '/style2.css', array(), $modified, 'all');
    wp_enqueue_style('child-style2');

    //wp_enqueue_script('jquery');
    $modified = date( 'YmdHis', filemtime( get_stylesheet_directory() . '/js/custom.js' ) );
    wp_enqueue_script('custom', get_stylesheet_directory_uri() . '/js/custom.js', array(), $modified, 'all');

}



/*
Shortcodes Ordner durchsuchen und PHP Dateien inkludieren
*/
define('BUDI_CHILD_SHORTCODES_DIR', __DIR__ . "/shortcodes");

$indir = scandir(BUDI_CHILD_SHORTCODES_DIR);

foreach($indir as $file){
    $fileinfo = pathinfo( BUDI_CHILD_SHORTCODES_DIR . '/' . $file );

    if( is_dir( BUDI_CHILD_SHORTCODES_DIR . '/' . $file ) ){
        if( $file == "." || $file == ".." ){ continue; }
        if( file_exists(BUDI_CHILD_SHORTCODES_DIR . "/$file/$file.php") ){
            require BUDI_CHILD_SHORTCODES_DIR . "/$file/$file.php" ;
        }
    }else{
        if( isset($fileinfo["extension"]) && $fileinfo["extension"] == 'php'){
            require BUDI_CHILD_SHORTCODES_DIR . '/' . $file;
        }
    }
}



add_filter( 'wpcf7_form_elements', 'mycustom_wpcf7_form_elements' );
function mycustom_wpcf7_form_elements( $form ) {
    $form = do_shortcode( $form );
    return $form;
}








