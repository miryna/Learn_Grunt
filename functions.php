<?php
/**
 * @package WordPress
 * @subpackage ideustheme
 *
 * functions and definitions
 */

/*------------------------------------*\
	External Modules/Files
\*------------------------------------*/

// Includes
// The $it_includes array determines the code library included in theme.
// Missing files will produce a fatal error.

$it_require = array(

  '/mu-plugins/news-custom_post_type.php',
  '/mu-plugins/ru-translit-urls.php',
  '/mu-plugins/date_to_russian.php',
  /* '/mu-plugins/removing.php',*/

  '/inc/vendor/Mobile_Detect.php',
  '/inc/Class-Walker-Nav-Menu-Custom-LI-A.php',
  '/inc/WP_Widget_All_Post_Types.php',
  '/inc/WP_Widget_Single_Post_or_Page.php',
);

foreach ($it_require as $file) {
  if (!$filepath = locate_template($file)) {
    trigger_error(sprintf(__('Error locating %s for inclusion', 'ideustheme'), $file), E_USER_ERROR);
  }
  require_once $filepath;
}
unset($file, $filepath);

/*------------------------------------*\
	Theme Support
\*------------------------------------*/

if (function_exists('add_theme_support')) {

  // Add Menu Support
  add_theme_support('menus');

  // Add Widgets Support
  add_theme_support('widgets');

  // Add Thumbnail Theme Support
  add_theme_support('post-thumbnails');

  // Set Thumbnail size
  // set_post_thumbnail_size($width, $height, false);

  // add_image_size('large', 700, '', true); // Large Thumbnail
  // add_image_size('medium', 250, '', true); // Medium Thumbnail
  // add_image_size('small', 120, '', true); // Small Thumbnail
  // add_image_size('custom-size', 700, 200, true); // Custom Thumbnail Size call using the_post_thumbnail('custom-size');


  // Localization Support
  load_theme_textdomain(' ideustheme', get_template_directory() . '/languages');
}

/*------------------------------------*\
	Load  scripts, styles and fonts
\*------------------------------------*/

/*
// Load  Modernizr
function  ideustheme_modernizr()
{
    wp_register_script('modernizr',  '//cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js');
    wp_enqueue_script('modernizr');
    wp_add_inline_script('modernizr', "{window.Modernizr || document.write('<script src=assets/js/vendor/modernizr-2.8.3.min.js></script>'}", 'after' );
}
add_action('wp_enqueue_scripts', 'ideustheme_modernizr');


// Conditional script(s)
function scripts_enqueue_lteie8()
{
  wp_register_script('ie8.js', get_template_directory_uri() . 'assets/js/legacy/ie8.js', array('jquery'), '1.0.0'); // Conditional script(s)
  wp_enqueue_script('ie8.js');
  wp_script_add_data('ie8.js', 'conditional', 'lte IE 8');
}
add_action( 'wp_enqueue_scripts', 'scripts_enqueue_lteie8' );
*/

// dequeue the jquery library because it is connected  before wp_head();
function dequeue_gquery()
{

  wp_dequeue_script('jquery');
  wp_deregister_script('jquery');
}

add_action('wp_enqueue_scripts', 'dequeue_gquery', 100);


// Load  styles
function  ideustheme_styles()
{
  wp_register_style('style', get_template_directory_uri() . '/style.css', array(), '1.0', 'all');
  wp_enqueue_style('style');

//  wp_register_style('main.min.css', get_template_directory_uri() . "'/assets/css/main.min.css?' .  filemtime('assets/css/main.min.css'); . '"', array(), '1.0', 'all');
//  wp_enqueue_style('main.min.css');
}

add_action('wp_enqueue_scripts', 'ideustheme_styles');


/*------------------------------------*\
	Register Menus
\*------------------------------------*/

// adds  custom classes for <li> and <a>  HTML tags
class Walker_Nav_Menu_siteNavigation extends Walker_Nav_Menu_Custom_LI_A
{
  public $LI_classes_custom = 'b-mainNavigation__item';
  public $A_classes_custom = 'b-mainNavigation__link';
}

// adds  custom classes for <li> and <a>  HTML tags
class Walker_Nav_Menu_socialMenu extends Walker_Nav_Menu_Custom_LI_A
{
  public $LI_classes_custom = '';
  public $A_classes_custom = 'b-socialMenu__link';
}

// Main Menu
function  ideustheme_siteNavigation()
{
  wp_nav_menu(
    array(
      'theme_location' => 'siteNavigation',
      'menu' => 'siteNavigation',
      'container' => 'nav',
      'container_class' => 'l-siteNavigation',
      'echo' => true,
      'fallback_cb' => 'wp_page_menu',
      'items_wrap' => '<ul class="b-mainNavigation">%3$s</ul>',
      'depth' => 0,
      'walker' => new Walker_Nav_Menu_siteNavigation
    ));
}

// Social links
function  ideustheme_socialMenu()
{
  wp_nav_menu(
    array(
      'theme_location' => 'socialMenu_header',
      'menu' => 'socialMenu_header',
      'container' => '',
      'container_class' => '',
      'container_id' => '',
      'menu_class' => '',
      'menu_id' => '',
      'echo' => true,
      'fallback_cb' => '__return_empty_string',
      'before' => '',
      'after' => '',
      'link_before' => '',
      'link_after' => '',
      'items_wrap' => '<ul class="b-socialMenu -style_header">%3$s</ul>',
      'depth' => 0,
      'walker' => new Walker_Nav_Menu_socialMenu
    ));
}

// Social links
function  ideustheme_socialMenu_sidebar()
{
  wp_nav_menu(
    array(
      'theme_location' => 'socialMenu_sidebar',
      'menu' => 'socialMenu_sidebar',
      'container' => '',
      'container_class' => '',
      'container_id' => '',
      'menu_class' => '',
      'menu_id' => '',
      'echo' => true,
      'fallback_cb' => '__return_empty_string',
      'before' => '',
      'after' => '',
      'link_before' => '',
      'link_after' => '',
      'items_wrap' => '<ul class="b-socialMenu -style_sidebar">%3$s</ul>',
      'depth' => 0,
      'walker' => new Walker_Nav_Menu_socialMenu
    ));
}

// Register  Navigation
function ideustheme_register_menu()
{
  register_nav_menus(
    array(
      'siteNavigation' => __('Header Site Navigation', 'ideustheme'), // Header Site Navigation
      'socialMenu_header' => __('Header Social Menu', 'ideustheme'), // Header Social Menu
      'socialMenu_sidebar' => __('Side Social Menu', 'ideustheme'), // Side Social Menu
     ));
}

add_action('init', 'ideustheme_register_menu');


/*------------------------------------*\
	Register Sidebars
\*------------------------------------*/

// If Dynamic Sidebar Exists
if (function_exists('register_sidebar')) {

  function ideustheme_register_widgets1()
  {
    register_sidebar(array(
      'name' => __('Widget Area1', ' ideustheme'),
      'description' => __('widget area 1 for your site', ' ideustheme'),
      'id' => 'side1',
      'before_widget' => '<div id="%1$s"  class="%2$s">',
      'after_widget' => "</div>",
      'before_title' => '<h2  class="b-sidebarBlock__title">',
      'after_title' => '</h2>'
    ));
  }

  add_action('widgets_init', 'ideustheme_register_widgets1');
}


// If Dynamic Sidebar Exists
if (function_exists('register_sidebar')) {

  function ideustheme_register_widgets2()
  {
    register_sidebar(array(
      'name' =>  __('Widget Area2', ' ideustheme'),
      'id' => 'side2',
      'description' => __('widget area 2 for your site', ' ideustheme'),
      'class' => 'l-sidebar',
      'before_widget' => '<div class="b-sidebarBlock -style_%2$s">',
      'after_widget' => "</div>",
      'before_title' => '<h2  class="b-sidebarBlock__title">',
      'after_title' => "</h2>",
    ));
  }

  add_action('widgets_init', 'ideustheme_register_widgets2');
}

/*------------------------------------*\
	Other functions
\*------------------------------------*/

// Change the separator between the title and the name of the site
add_filter('document_title_separator', function () {
  return ' : ';
});


// Custom excerpt ellipses
function custom_excerpt_more()
{
  return '<a href="' . get_permalink($post->ID) . '" class="read-more">' . '… →' . '</a>';
}

add_filter('excerpt_more', 'custom_excerpt_more');


// link Read more
function ideustheme_read_more()
{


  return '<div class="b-readMore"><a class="b-readMore__link" href="' . get_permalink() . '">' .  __('Continue reading', 'ideustheme') . '</a></div>';
}

add_filter('excerpt_more', 'custom_excerpt_more');



// Search form layout
function ideustheme_wpsearch()
{
  $form =
    '<form role="search" method="get"  action="' . home_url('/') . '">
    <fieldset>
    <input class="b-siteSearch__input" type="search" type="search" name="s" value="' . get_search_query() . '" spellcheck="true" placeholder="' . esc_attr__('Search...', 'ideustheme') . '" />
	  <input class="b-siteSearch__submit" type="submit" value="' . esc_attr__('Search', 'ideustheme') . '" />
	  </fieldset>
	  </form>';
  return $form;
}