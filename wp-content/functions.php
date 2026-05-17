<?php
/**
 * functions.php – Funciones del tema WebFusion
 *
 * @package WebFusion
 */

// Soporte básico del tema
function webfusion_setup() {
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'html5', array(
        'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
    ) );

    // Menú de navegación principal
    register_nav_menus( array(
        'primary' => __( 'Menú Principal', 'webfusion' ),
    ) );
}
add_action( 'after_setup_theme', 'webfusion_setup' );

// Encolar estilos y scripts
function webfusion_scripts() {
    wp_enqueue_style( 'webfusion-style', get_stylesheet_uri(), array(), '1.0.0' );
}
add_action( 'wp_enqueue_scripts', 'webfusion_scripts' );
