<?php
/*------------------------------------*\
	Removing
\*------------------------------------*/
/*
// Remove some widgets from the WordPress dashboard side
function clear_dash(){
  	$side = &$GLOBALS['wp_meta_boxes']['dashboard']['side']['core'];
  	//$normal = &$GLOBALS['wp_meta_boxes']['dashboard']['normal']['core'];

//	unset($side['dashboard_quick_press']); //Быстрая публикация
//  unset($side['dashboard_recent_drafts']); // Последние черновики
  	unset($side['dashboard_primary']); //Блог WordPress
  	unset($side['dashboard_secondary']); //Другие Новости WordPress

//	unset($normal['dashboard_incoming_links']); //Входящие ссылки
//  unset($normal['dashboard_right_now']); //Прямо сейчас
//	unset($normal['dashboard_recent_comments']); //Последние комментарии
// 	unset($normal['dashboard_plugins']); //Последние Плагины
}
//	add_action('wp_dashboard_setup', 'clear_dash' );
*/


// Disable some standard widgets
function unregister_basic_widgets()
 {
//	unregister_widget('WP_Widget_Pages');            // Виджет страниц
//	unregister_widget('WP_Widget_Calendar');         // Календарь
//	unregister_widget('WP_Widget_Archives');         // Архивы
//	unregister_widget('WP_Widget_Links');            // Ссылки
//	unregister_widget('WP_Widget_Meta');             // Мета виджет
//	unregister_widget('WP_Widget_Search');           // Поиск
//	unregister_widget('WP_Widget_Text');             // Текст
//	unregister_widget('WP_Widget_Categories');       // Категории
//	unregister_widget('WP_Widget_Recent_Posts');     // Последние записи
//	unregister_widget('WP_Widget_Recent_Comments');  // Последние комментарии
//	unregister_widget('WP_Widget_RSS');              // RSS
//	unregister_widget('WP_Widget_Tag_Cloud');        // Облако меток
//	unregister_widget('WP_Nav_Menu_Widget');         // Меню
}

// add_action('widgets_init', 'unregister_basic_widgets' );


/**
 * Remove meta boxes from Post and Page Screens
 */
function customize_meta_boxes()
{
  // These remove meta boxes from POSTS
  //remove_post_type_support("post","excerpt"); //Remove Excerpt Support
  //remove_post_type_support("post","author"); //Remove Author Support
  //remove_post_type_support("post","revisions"); //Remove Revision Support
  //remove_post_type_support("post","comments"); //Remove Comments Support
  //remove_post_type_support("post","trackbacks"); //Remove trackbacks Support
  //remove_post_type_support("post","editor"); //Remove Editor Support
  //remove_post_type_support("post","custom-fields"); //Remove custom-fields Support
  //remove_post_type_support("post","title"); //Remove Title Support


  // These remove meta boxes from PAGES
  //remove_post_type_support("page","revisions"); //Remove Revision Support
  //remove_post_type_support("page","comments"); //Remove Comments Support
  //remove_post_type_support("page","author"); //Remove Author Support
  //remove_post_type_support("page","trackbacks"); //Remove trackbacks Support
  //remove_post_type_support("page","custom-fields"); //Remove custom-fields Support

}
//add_action('admin_init','customize_meta_boxes');


// Remove superfluous elements from the admin bar (uncomment as necessary)
function remove_admin_bar_links() {
  //  global $wp_admin_bar;

  //$wp_admin_bar->remove_menu('wp-logo');
  //$wp_admin_bar->remove_menu('updates');
  //$wp_admin_bar->remove_menu('my-account');
  //$wp_admin_bar->remove_menu('site-name');
  //$wp_admin_bar->remove_menu('my-sites');
  //$wp_admin_bar->remove_menu('get-shortlink');
  //$wp_admin_bar->remove_menu('edit');
  //$wp_admin_bar->remove_menu('new-content');
  //$wp_admin_bar->remove_menu('comments');
  //$wp_admin_bar->remove_menu('search');
}
//add_action('wp_before_admin_bar_render', 'remove_admin_bar_links');


// Remove code from the <head>
function unregister_header_links()
{
// Remove Actions
//    remove_action('wp_head', 'feed_links_extra', 3); // Display the links to the extra feeds such as category feeds
//    remove_action('wp_head', 'feed_links', 2); // Display the links to the general feeds: Post and Comment Feed
//    remove_action('wp_head', 'rsd_link'); // Display the link to the Really Simple Discovery service endpoint, EditURI link
//    remove_action('wp_head', 'wlwmanifest_link'); // Display the link to the Windows Live Writer manifest file.
//    remove_action('wp_head', 'index_rel_link'); // Index link
//    remove_action('wp_head', 'parent_post_rel_link', 10, 0); // Prev link
//    remove_action('wp_head', 'start_post_rel_link', 10, 0); // Start link
//    remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0); // Display relational links for the posts adjacent to the current post.
    remove_action('wp_head', 'wp_generator'); // Display the XHTML generator that is generated on the wp_head hook, WP version
//    remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
//    remove_action('wp_head', 'rel_canonical');
//    remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);
      add_filter('the_generator', '__return_empty_string');
}

/* wp-emoji */

remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );

// Disable REST API
add_filter('rest_enabled', '__return_false');

// Disable events REST API
remove_action( 'init', 'rest_api_init' );
remove_action( 'rest_api_init', 'rest_api_default_filters', 10, 1 );
remove_action( 'parse_request', 'rest_api_loaded' );

// Disable Embeds  REST API
remove_action( 'rest_api_init', 'wp_oembed_register_route' );
remove_filter( 'rest_pre_serve_request', '_oembed_rest_pre_serve_request', 10, 4 );

// Disable filters REST API
remove_action( 'xmlrpc_rsd_apis', 'rest_output_rsd' );
remove_action( 'wp_head', 'rest_output_link_wp_head', 10, 0 );
remove_action( 'template_redirect', 'rest_output_link_header', 11, 0 );
remove_action( 'auth_cookie_malformed', 'rest_cookie_collect_status' );
remove_action( 'auth_cookie_expired', 'rest_cookie_collect_status' );
remove_action( 'auth_cookie_bad_username', 'rest_cookie_collect_status' );
remove_action( 'auth_cookie_bad_hash', 'rest_cookie_collect_status' );
remove_action( 'auth_cookie_valid', 'rest_cookie_collect_status' );
remove_filter( 'rest_authentication_errors', 'rest_cookie_check_errors', 100 );

//Disable type="application/json+oembed"
remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
remove_action( 'wp_head', 'rest_output_link_wp_head' );
remove_action( 'template_redirect', 'rest_output_link_header', 11, 0 );

// removes detailed login error information for security
  add_filter('login_errors',create_function('$a', "return null;"));
