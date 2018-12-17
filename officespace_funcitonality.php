<?php
/**
 * Plugin Name: Officespace Functionality
 * Plugin URI: https://www.officespace.com/weblog
 * Description: Adds javascript and templating functionality to Officespace.com blog
 * Version: 1.0
 * Author: Kirk Johnson
 */

$include_array = [
  'inc/class.page_templater.php'
];

foreach( $include_array as $file ){
  include_once($file);
}

function officespace_add_js(){
  wp_enqueue_script( 'officespace_accordion', plugins_url( 'js/accordion.js', __FILE__ ), ['jquery'] );
  wp_enqueue_script( 'officespace_pie_icon', plugins_url( 'js/pie_icon_make.js', __FILE__ ), ['jquery'] );
}

add_action('wp_enqueue_scripts', 'officespace_add_js');

function officespace_styles(){
  wp_enqueue_style('officespace_style', plugins_url('css/style.css', __FILE__) );
}

add_action( 'wp_enqueue_scripts', 'officespace_styles' );

//add templates from plugin
add_action( 'plugins_loaded', array( 'PageTemplater', 'get_instance' ) );
