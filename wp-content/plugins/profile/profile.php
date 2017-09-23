<?php
/**
 * Plugin Name: Profile
 * Description: A profile page for the frontend not WordPress dash
 * Version: 0.1.0
 * Author: Tim Stephenson
 * Author URI: https://github.com/tstephen/
 * License: GPL2
 */
// Block direct requests
ini_set("display_errors",0);
if ( !defined('ABSPATH') )
  die('Not Authorised');

define('TSP_DEBUG', true);
define('S2_SUBSCRIBED', 's2_subscribed');

function tsp_enqueues() {
  wp_register_style( 'tsp-css',
      plugins_url( '/css/tsp.css', __FILE__ ),
      array()
  );
  wp_enqueue_style( 'tsp-css' );

  wp_register_script('tsp-js',
      plugins_url( '/js/tsp.js', __FILE__ ),
      array( 'jquery' ),
      null, /* Force no version as query string */
      true /* Force load in footer */);
  wp_enqueue_script('tsp-js');
}
add_action('wp_enqueue_scripts', 'tsp_enqueues', 100);

/** 
 * Shortcode function to render S2 plugin's subscriptions in frontend
 */
function tsp_s2_subscriptions() {
    $s2_cats = explode(',',   get_user_meta(get_current_user_id(), S2_SUBSCRIBED, true));

    ob_start();
  ?>
     <h3>Category subscriptions</h3>
     <p>We will email you each time there is a new post for any of the categories ticked below:</p>
     <ul class="tspS2Subscriptions">
       <?php
         $categories=get_categories();
         foreach($categories as $category) {  
           echo '<li><input '
             .(in_array($category->term_id,$s2_cats) ? 'checked ' : '')
             .'type="checkbox" value="'.$category->term_id.'"/>'
             .$category->name.'</li>';
         }
       ?>
     </ul>
     <button class="btn" id="tspUpdateSubscriptions">Update Subscriptions</button>
  <?php
    return ob_get_clean();
}
add_shortcode( 's2_subscriptions', 'tsp_s2_subscriptions' );

/**
 * AJAX handler to update S2 subscriptions.
 */
function tsp_update_s2_subscriptions() {
  $user_id = get_current_user_id();

  // Now store any user info we have received
  $s2_cats = $_POST['s2Cats'];
  if(TSP_DEBUG) error_log( "Storing s2 subscriptions: ".$s2_cats );
  update_user_meta( $user_id, S2_SUBSCRIBED, $s2_cats);

}
add_action( 'wp_ajax_update_subscriptions', 'tsp_update_s2_subscriptions' );

