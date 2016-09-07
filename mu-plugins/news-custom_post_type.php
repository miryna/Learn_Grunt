<?php
/**
 * Adds the custom_post_type 'lastnews'
 *
 */

function create_custom_post_type_lastnews()
{
  $labels = array(
    'name' => __(' Last News', 'ideustheme'), // Rename these to suit
    'singular_name' => __(' Last News', 'ideustheme'),
    'add_new' => __('Add New', 'ideustheme'),
    'add_new_item' => __('Add New  News', 'ideustheme'),
    'edit' => __('Edit', 'ideustheme'),
    'edit_item' => __('Edit  News', 'ideustheme'),
    'new_item' => __('New  News', 'ideustheme'),
    'view' => __('View', 'ideustheme'),
    'view_item' => __('View  News', 'ideustheme'),
    'search_items' => __('Search  News', 'ideustheme'),
    'not_found' => __('No Last News found', 'ideustheme'),
    'not_found_in_trash' => __('No  News found in Trash', 'ideustheme')
  );

  $args = array(
    'labels' => $labels,
    'description' => 'Allows to display last news',
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true,
    'show_in_menu' => true,
    'query_var' => true,
    'capability_type' => 'post',
    'rewrite' => array('slug' => 'lastnews'),
    'menu_position' => 5,
    'supports' => array('title', 'editor', 'author', 'custom-fields', 'comments', 'revisions', 'thumbnail', 'excerpt',),
    'has_archive' => true,
  );

  register_post_type('lastnews', $args);

  // register_taxonomy_for_object_type('category', 'ideustheme');
  // register_taxonomy_for_object_type('post_tag', 'ideustheme');

}

add_action('init', 'create_custom_post_type_lastnews');


/**
 * shows the updated messages for custom_post_type lastnews
 *-------------------------------------------------
 */
function lastnews_updated_messages($messages)
{

  global $post, $post_ID;
  $messages['lastnews'] = array(
    0 => '',
    1 => sprintf(__('News updated. <a href="%s">View News</a>'), esc_url(get_permalink($post_ID))),
    2 => __('News updated.'),
    3 => __('News deleted.'),
    4 => __('News updated.'),
    5 => isset($_GET['revision']) ? sprintf(__('News restored to revision from %s'), wp_post_revision_title((int)$_GET['revision'], false)) : false,
    6 => sprintf(__('News published. <a href="%s">View News</a>'), esc_url(get_permalink($post_ID))),
    7 => __('News saved.'),
    8 => sprintf(__('News submitted. <a target="_blank" href="%s">Preview News</a>'), esc_url(add_query_arg('preview', 'true', get_permalink($post_ID)))),
    9 => sprintf(__('News scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview News</a>'), date_i18n(__('M j, Y @ G:i'), strtotime($post->post_date)), esc_url(get_permalink($post_ID))),
    10 => sprintf(__('News draft updated. <a target="_blank" href="%s">Preview News</a>'), esc_url(add_query_arg('preview', 'true', get_permalink($post_ID)))),
  );
  return $messages;
}

add_filter('post_updated_messages', 'lastnews_updated_messages');

/**
 * Adds  the metabox 'News link'
 *-------------------------------------------------
 */
function lastnews_link_box()
{
  add_meta_box('lastnews_link',
    __('News link'),
    'lastnews_link_callback',
    'lastnews',
    'advanced',
    'default');
}

add_action('add_meta_boxes', 'lastnews_link_box');

/**
 *  Describes the metabox 'News link'
 */
function lastnews_link_callback($post)
{
  wp_nonce_field(basename(__FILE__), 'lastnews_link_nonce');
  $lastnews_link_stored = get_post_meta($post->ID);
  ?>
  <p>
    <label for="lastnews_link" class="news_link">
      <?php _e('<i>Link:</i>', 'textdomain') ?>
    </label><br>
    <input type="text" size="67" name="lastnews_link" id="lastnews_link"
           value="<?php if (isset ($lastnews_link_stored['lastnews_link'])) echo $lastnews_link_stored['lastnews_link'][0]; ?>"/>
  </p>
<?php
}

/**
 * Saves the metabox (custom field 'n_link')
 */
function lastnews_link_save($post_id)
{

  // Checks save status
  $is_autosave = wp_is_post_autosave($post_id);
  $is_revision = wp_is_post_revision($post_id);
  $is_valid_nonce = (isset($_POST['lastnews_link_nonce']) && wp_verify_nonce($_POST['lastnews_link_nonce'], basename(__FILE__))) ? 'true' : 'false';

  // Exits script depending on save status
  if ($is_autosave || $is_revision || !$is_valid_nonce) {
    return;
  }

  // Checks for input and sanitizes/saves if needed
  if (isset($_POST['lastnews_link'])) {
    update_post_meta($post_id, 'lastnews_link', sanitize_text_field($_POST['lastnews_link']));
  }
}

add_action('save_post', 'lastnews_link_save');














