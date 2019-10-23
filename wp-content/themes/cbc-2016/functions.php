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
  $thumb = get_the_post_thumbnail($post_id);
  if ( empty($thumb) && in_category( 'notices', $post_id ) ) {
    set_post_thumbnail( $post_id, 6860 );
  } elseif ( empty($thumb) && in_category( 'women', $post_id ) ) {
    set_post_thumbnail( $post_id, 6861 );
  } elseif ( empty($thumb) ) {
    set_post_thumbnail( $post_id, 6964 );
  }
}
add_action( 'save_post', 'add_missing_thumbnail', 20, 2 );

/**
 * Redirect user after successful login.
 *
 * @param string $redirect_to URL to redirect to.
 * @param string $request URL the user is coming from.
 * @param object $user Logged user's data.
 * @return string
 */

function my_login_redirect( $redirect_to, $request, $user ) {
    //is there a user to check?
    if (isset($user->roles) && is_array($user->roles)) {
        //check for subscribers
        //if (in_array('subscriber', $user->roles)) {
            // redirect them to another URL, in this case, the member page
            $redirect_to =  home_url().'/members-area/';
        //}
    }

    return $redirect_to;
}

add_filter( 'login_redirect', 'my_login_redirect', 10, 3 );
