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
	Theme Support, thumbnail sizes
\*------------------------------------*/

if (function_exists('add_theme_support')) {

  // Add Menu Support
  add_theme_support('menus');

  // Add Widgets Support
  add_theme_support('widgets');

  // Add Thumbnail Theme Support
  add_theme_support('post-thumbnails');

  // Set Thumbnail size
  set_post_thumbnail_size(770, 425); // default post thumbnail size

  // Localization Support
  load_theme_textdomain(' ideustheme', get_template_directory() . '/languages');
}


if (function_exists('add_image_size')) {
  add_image_size('large', 770, '425', true); // Large Thumbnail
  add_image_size('medium', 370, '203', true); // Medium Thumbnail
  add_image_size('small', 123, '86', true); // Small Thumbnail
}


add_filter('image_size_names_choose', 'ideustheme_custom_sizes');

function ideustheme_custom_sizes($sizes)
{
  return array_merge($sizes, array(
    'large' => 'Large',
    'medium' => 'Medium',
    'small' => 'Small'
  ));
}


/*------------------------------------*\
	Load  scripts
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
*/


// Deregister Wordpress JQuery
// Register googleapis JQuery that will be placed within conditional tags
function ideustheme_scripts_gte9_noie()
{
  wp_dequeue_script('jquery');
  wp_deregister_script('jquery');

  wp_enqueue_script('jquery', '//ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js', array(), false, false);
}

add_action('wp_enqueue_scripts', 'ideustheme_scripts_gte9_noie', 2);

// Allows us to add conditional tags in output script
add_filter('script_loader_tag', function ($tag, $handle) {
  if ($handle === 'jquery') {
    $tag = "<!--[if gte IE 9]><!-->$tag<!--<![endif]-->";
  }
  return $tag;
}, 10, 2);


// Register googleapis JQuery that will be placed within conditional tags
function ideustheme_scripts_lteie8()
{
  wp_enqueue_script('jquery-lteie8', '//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js', array(), false, false);
}

add_action('wp_enqueue_scripts', 'ideustheme_scripts_lteie8', 3);

// Allows us to add conditional tags in output script
add_filter('script_loader_tag', function ($tag, $handle) {
  if ($handle === 'jquery-lteie8') {
    $tag = "<!--[if lte IE 8]>$tag<![endif]-->";
  }
  return $tag;
}, 10, 2);

/*---------------------------------------------------------------------------------*/

// Conditional script(s) lteie8
function ideustheme_scripts2_lteie8()
{
  wp_register_script('ie8', get_template_directory_uri() . '/assets/js/legacy/ie8.js', array(), false, false);
  wp_enqueue_script('ie8');
  wp_script_add_data('ie8', 'conditional', 'lte IE 8');
}

add_action('wp_enqueue_scripts', 'ideustheme_scripts2_lteie8');


function scripts_enqueue_js_main()
{
  $filemtime_js_main = filemtime(get_template_directory() . '/assets/js/scripts.js');

  wp_register_script('js-main', get_template_directory_uri() . '/assets/js/scripts.js?', false, $filemtime_js_main, true);
  wp_enqueue_script('js-main');
}

add_action('wp_enqueue_scripts', 'scripts_enqueue_js_main');


/*
function scripts_enqueue_js_main_extra()
{
  $filemtime_js_main_extra = filemtime(get_template_directory() . '/assets/js/scripts-extra.js');

  wp_register_script('js-main-extra', get_template_directory_uri() . '/assets/js/scripts-extra.js?', false, $filemtime_js_main_extra, true);
  wp_enqueue_script('js-main-extra');
}
add_action('wp_enqueue_scripts', 'scripts_enqueue_js_main_extra');
*/


/*------------------------------------*\
	Load styles and fonts
\*------------------------------------*/

// Load  styles
function  ideustheme_styles()
{
  wp_register_style('style', get_template_directory_uri() . '/style.css', false, false, false);
  wp_enqueue_style('style');

  $version_filemtime = filemtime(get_template_directory() . '/assets/css/main.min.css');

  wp_register_style('main-min', get_template_directory_uri() . '/assets/css/main.min.css?', array('style'), $version_filemtime, false);
  wp_enqueue_style('main-min');
}

add_action('wp_enqueue_scripts', 'ideustheme_styles');


//Load fonts
function ideustheme_fonts()
{
  $protocol = is_ssl() ? 'https' : 'http';
  wp_enqueue_style('googlefonts', $protocol . '://fonts.googleapis.com/css?family=Roboto:400,400italic|Roboto+Slab&subset=latin,cyrillic');
}

add_action('wp_enqueue_scripts', 'ideustheme_fonts');


/*------------------------------------*\
	Register Menus
\*------------------------------------*/

// adds  custom classes for <li> and <a>  HTML tags for site Navigation
class Walker_Nav_Menu_siteNavigation extends Walker_Nav_Menu_Custom_LI_A
{
  public $LI_classes_custom = 'b-mainNavigation__item';
  public $A_classes_custom = 'b-mainNavigation__link';
}

// adds  custom classes for <li> and <a>  HTML tags for SosialMenu
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
      'before_title' => '<h2  class="b-about__title">',
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
      'name' => __('Widget Area2', ' ideustheme'),
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
  return '… →';
}

add_filter('excerpt_more', 'custom_excerpt_more');


// link Read more
function ideustheme_read_more()
{


  return '<div class="b-readMore"><a class="b-readMore__link" href="' . get_permalink() . '">' . __('Continue reading', 'ideustheme') . '</a></div>';
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