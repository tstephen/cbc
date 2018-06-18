<?php
/*
All the functions are in the PHP pages in the functions/ folder.
*/

require_once locate_template('/functions/cleanup.php');
require_once locate_template('/functions/setup.php');
require_once locate_template('/functions/enqueues.php');
require_once locate_template('/functions/navbar.php');
require_once locate_template('/functions/widgets.php');
require_once locate_template('/functions/search.php');
require_once locate_template('/functions/feedback.php');

add_action('after_setup_theme', 'true_load_theme_textdomain');

function true_load_theme_textdomain(){
    load_theme_textdomain( 'bst', get_template_directory() . '/languages' );
}

//Enqueue the Dashicons script
function load_dashicons_front_end() {
  wp_enqueue_style( 'dashicons' );
}
add_action( 'wp_enqueue_scripts', 'load_dashicons_front_end' );

function inject_grace_place_integrator( $content ) {
  if ( is_single() && get_the_author()=='kathylarkman' ) {

    wp_register_script('graceplace', get_template_directory_uri() . '/js/grace-place-integrator.js', false, null, true);
    wp_enqueue_script('graceplace');

  }
  return $content;
}
add_filter( 'the_content', 'inject_grace_place_integrator' ); 

function add_missing_thumbnail( $post_id, $post ) {
  if ( $thumb=='' && in_category( 'notices', $post_id ) ) {
    set_post_thumbnail( $post_id, 2382 );
  }
  if ( $thumb=='' && in_category( 'women', $post_id ) ) {
    set_post_thumbnail( $post_id, 2456 );
  }
}
add_action( 'save_post', 'add_missing_thumbnail', 20, 2 );

