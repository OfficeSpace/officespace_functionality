<?php

class PageTemplater {
  // unique identifier
  protected $plugin_slug;

  //reference to an instance of this class
  private static $instance;

  //array of templates this plugin tracks
  protected $templates;

  //retuns an instance of this class
  public static function get_instance() {
    if( null == self::$instance ) {
      self::$instance = new PageTemplater();
    }

    return self::$instance;
  }

  //constructor
  private function __construct() {
    $this->templates = array();

    //add filter to the attributes to inject template into the cache.
    if ( version_compare(floatval(get_bloginfo( 'version' )), '4.7', '<')) {
      //4.6 and older
      add_filter(
        'page_attributes_dropdown_pages_args',
        array($this, 'register_project_templates')
      );
    } else {
      //add filter to teh 4.7 attributes
      add_filter(
        'theme_page_templates', array($this, 'add_new_template')
      );
    }

    //add a filter to the save post to inject out template into the page cache
    add_filter(
      'wp_insert_post_data', array($this, 'register_project_templates')
    );

    //add a filter to the template include to determine if the page has our template
    // assigned and return it's path
    add_filter(
      'template_include', array($this, 'view_project_template')
    );

    $this->templates = array(
      'templates/no_sidebar.php' => "One Column"
    );

    add_filter('page_template', array($this, 'page_template_ensure'));
  }
  public function page_template_ensure($page_template){
    $post = get_post();
    $template = get_post_meta($post->ID, '_wp_page_template', true );

    foreach($this->templates as $path => $temp ){
      if(strpos($template,$path )) {
        //set template to be used as ours
        return $template;
      }
    }
    return $page_template;
  }
  /**
   * Adds our template to the page dropdown for v4.7+
   *
   */
  public function add_new_template( $posts_templates ) {
    $posts_templates = array_merge( $posts_templates, $this->templates );
    return $posts_templates;
  }

  /**
   * Adds our template to the pages cache in order to trick WordPress
   * into thinking the template file exists where it doens't really exist.
   */
  public function register_project_templates( $atts ) {

    // Create the key used for the themes cache
    $cache_key = 'page_templates-' . md5( get_theme_root() . '/' . get_stylesheet() );

    // Retrieve the cache list.
    // If it doesn't exist, or it's empty prepare an array
    $templates = wp_get_theme()->get_page_templates();
    if ( empty( $templates ) ) {
      $templates = array();
    }

    // New cache, therefore remove the old one
    wp_cache_delete( $cache_key , 'themes');

    // Now add our template to the list of templates by merging our templates
    // with the existing templates array from the cache.
    $templates = array_merge( $templates, $this->templates );

    // Add the modified cache to allow WordPress to pick it up for listing
    // available templates
    wp_cache_add( $cache_key, $templates, 'themes', 1800 );

    return $atts;

  }

  /**
   * Checks if the template is assigned to the page
   */
  public function view_project_template( $template ) {

    // Get global post
    global $post;

    // Return template if post is empty
    if ( ! $post ) {
      return $template;
    }

    // Return default template if we don't have a custom one defined
    if ( ! isset( $this->templates[get_post_meta(
      $post->ID, '_wp_page_template', true
    )] ) ) {
      return $template;
    }

    $file = plugin_dir_path( __FILE__ ). get_post_meta(
      $post->ID, '_wp_page_template', true
    );

    // Just to be safe, we check if the file exist first
    if ( file_exists( $file ) ) {
      return $file;
    } else {
      echo $file;
    }

    // Return template
    return $template;

  }
}
