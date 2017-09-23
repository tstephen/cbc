<?php
/**
 * Plugin Name: Widgets
 * Description: A collection of widgets to compose sites more quickly.
 * Version: 0.1.0
 * Author: Tim Stephenson
 * Author URI: https://github.com/tstephen/
 * License: GPL2
 */
// Block direct requests
ini_set("display_errors",0);
if ( !defined('ABSPATH') )
  die('Not Authorised');

add_action('widgets_init', 'tsw_register_widgets');
function tsw_register_widgets(){
  register_widget('IconStripWidget');
}

function tsw_enqueues() {
  wp_register_style( 'tsw-css', 
      plugins_url( '/css/tsw2.css', __FILE__ ),
      array()
  );
	wp_enqueue_style( 'tsw-css' );
  
  wp_register_script('tsw-js',
      plugins_url( '/js/tsw.js', __FILE__ ),
      array( 'jquery' ),
      null, /* Force no version as query string */
      true /* Force load in footer */);
  wp_enqueue_script('tsw-js');
}
add_action('wp_enqueue_scripts', 'tsw_enqueues', 100);

/**************************/
/****** IconStripWidget   */
/**************************/
class IconStripWidget extends WP_Widget {
    function IconStripWidget() {
        $widget_ops = array('classname' => 'tsw-icon-strip-widget');
        $this->WP_Widget('tsw-icon-strip-widget', 'Icon Strip Widget', $widget_ops);
    }
    function widget($args, $instance) {
        echo $before_widget;

        ?>
          <section class="icon-strip">
            <div class="container">
              <div class="col-sm-12">        
                <div class="col-md-offset-0 col-lg-3 col-md-3 col-sm-3 col-xs-6">
                  <a href="/im-new-here/rudloe-location-and-service-times/">
                    <div class="circle">
                      <!--div class="dashicons dashicons-location"></div-->
                      <img src="<?php echo plugins_url( 'images/location.png', __FILE__ ) ?>" alt="location information"/>
                      <div class="label" style="left:-.25em;position:relative">Rudloe</div>
                    </div>
                  </a>  
                </div>
                <div class="col-md-offset-0 col-lg-3 col-md-3 col-sm-3 col-xs-6">
                  <a href="/im-new-here/corsham-location-service-times/">
                    <div class="circle">
                      <!--div class="dashicons dashicons-location"></div-->
                      <img src="<?php echo plugins_url( 'images/location.png', __FILE__ ) ?>" alt="location information"/>
                      <div class="label" style="left:-.5em;position:relative">Priory St</div>                    
                    </div>
                  </a>
                </div>
                <div class="col-md-offset-0 col-lg-3 col-md-3 col-sm-3 col-xs-6">
                  <a href="https://www.facebook.com/CorshamBaptistChurch/" target="_blank">
                    <div class="circle">
                      <!--div class="dashicons dashicons-facebook"></div-->
                      <img src="<?php echo plugins_url( 'images/facebook.png', __FILE__ ) ?>" alt="Our FaceBook page"/>
                      <div class="label" style="left:-.75em;position:relative">Facebook</div>
                    </div>
                  </a>
                </div>
                <div class="col-md-offset-0 col-lg-3 col-md-3 col-sm-3 col-xs-6">
                  <a href="https://twitter.com/corshambaptist" target="_blank">
                    <div class="circle">
                      <!--div class="dashicons dashicons-twitter"></div-->
                      <img src="<?php echo plugins_url( 'images/twitter.png', __FILE__ ) ?>" alt="Follow us on Twitter"/>
                      <div class="label" style="left:-.25em;position:relative">Twitter</div>
                    </div>
                  </a>
                </div>
              </div>
            </div>
          </section>
        <?php
        echo $after_widget;
    }

    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['schema'] = esc_sql($new_instance['schema']);
        //$instance['title'] = esc_sql($new_instance['title']);
        return $instance;
    }

    function form($instance) { 
    ?>
      <p>
        <label for="<?php echo $this->get_field_id('schema'); ?>">
        <?php _e('Please choose 4 Categories to display','IconStripWidget'); ?></label><br/>
        <select multiple="multiple" name="<?php echo $this->get_field_name('schema') ?>" 
	        id="<?php echo $this->get_field_id('schema') ?>" class="widefat" size="10">
	  <option value="Rudloe" <?php echo in_array( 'Rudloe', $instance['schema']) ? 'selected="selected"' : '' ?>>Rudloe</option>
	  <option value="Priory Street" <?php echo in_array( 'Priory Street', $instance['schema']) ? 'selected="selected"' : '' ?>>Priory Street</option>
	  <option value="Facebook" <?php echo in_array( 'Facebook', $instance['schema']) ? 'selected="selected"' : '' ?>>Facebook</option>
	  <option value="Twitter" <?php echo in_array( 'Twitter', $instance['schema']) ? 'selected="selected"' : '' ?>>Twitter</option>
        </select>
      </p>
    <?php
    }
}

