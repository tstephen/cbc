<?php

function bst_widgets_init() {

  /*
   * Sidebar 1 (one widget area)
   */
  register_sidebar( array(
    'name'            => __( 'Sidebar 1', 'bst' ),
    'id'              => 'sidebar1-widget-area',
    'description'     => __( 'The sidebar widget area', 'bst' ),
    'before_widget'   => '<section class="%1$s %2$s">',
    'after_widget'    => '</section>',
    'before_title'    => '<h4>',
    'after_title'     => '</h4>',
  ) );

  /*
   * Sidebar 2 (one widget area)
   */
  register_sidebar( array(
    'name'            => __( 'Sidebar 2', 'bst' ),
    'id'              => 'sidebar2-widget-area',
    'description'     => __( 'The sidebar widget area', 'bst' ),
    'before_widget'   => '<section class="%1$s %2$s">',
    'after_widget'    => '</section>',
    'before_title'    => '<h4>',
    'after_title'     => '</h4>',
  ) );

  /*
   * Sub-Footer (four widget areas)
   */
  register_sidebar( array(
    'name'            => __( 'Sub-Footer', 'bst' ),
    'id'              => 'sub-footer-widget-area',
    'description'     => __( 'The sub-footer widget area', 'bst' ),
    'before_widget'   => '<div class="%1$s %2$s col-sm-3">',
    'after_widget'    => '</div>',
    'before_title'    => '<h4>',
    'after_title'     => '</h4>',
  ) );

  /*
   * Footer (three widget areas)
   */
  register_sidebar( array(
    'name'            => __( 'Footer', 'bst' ),
    'id'              => 'footer-widget-area',
    'description'     => __( 'The footer widget area', 'bst' ),
    'before_widget'   => '<div class="%1$s %2$s col-sm-4">',
    'after_widget'    => '</div>',
    'before_title'    => '<h4>',
    'after_title'     => '</h4>',
  ) );

}
add_action( 'widgets_init', 'bst_widgets_init' );
