<?php
/**
* Виджет выводит опубликованные статьи из custom post type, который был выбран  в теле виджета из админки
*
*/

class WP_Widget_All_Post_Types extends WP_Widget
{

  public function __construct()
  {
    parent::__construct(
      'WP_Widget_All_Post_Types',
      'Latest News',
      array('description' => __('Displays some posts', 'ideustheme'),)
    );
  }

  public function update($new_instance, $old_instance)
  {
    $instance = array();

    $instance['title'] = sanitize_text_field( $new_instance['title']); // Добавление настройки для заголовка

    $instance['custom_post_type'] = sanitize_text_field( $new_instance['custom_post_type']);  //добавить типов записей в настройки виджета

    return $instance;
  }

  // Добавление настроек в форму в админке
  public function form($instance)
  {

    $defaults = array(
      'title' => 'title',
      'custom_post_type'  => 'lastnews'
     );
    $instance = wp_parse_args( (array) $instance, $defaults );

    ?>
    <p>
      <label for="<?php echo $this->get_field_id('title'); ?>">Заголовок</label>
      <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
             name="<?php echo $this->get_field_name('title'); ?>" type="text"
             value="<?php echo $instance['title']; ?>"/>
    </p>

    <?php
    $args = array(
      'public' => true,
      '_builtin' => false
    );
    $output = 'names'; // names or objects, note names is the default
    $operator = 'and'; // 'and' or 'or'
    $post_types = get_post_types($args,$output,$operator);
    //$post_types = get_post_types();
    ?>

    <p>
      <label for="<?php echo $this->get_field_id('custom_post_type'); ?>">Выберите рубрику</label>
      <select name="<?php echo $this->get_field_name('custom_post_type'); ?>"
              id="<?php echo $this->get_field_id('custom_post_type'); ?>">
        <?php
        foreach ($post_types as $link_type) {
          echo '<option value="' . strip_tags($link_type) . '"'
            . selected($instance['custom_post_type'], $link_type, false)
            . '>' . $link_type . "</option>\n";
        }
        ?>
      </select>
    </p>

  <?php
  }


  //Вывод информации в виджет на сайте
  public function widget($args, $instance)
  {
    wp_reset_query();
    wp_reset_postdata();
    extract( $args );
    ?>

  <div class="b-sidebarBlock -style_news">
    <div class="l-lastNews">
      <ul class="b-lastNews">

    <?php
    $title = apply_filters( 'widget_title', $instance['title'] );
    if( $title )
      echo $args['before_title'] . $title . $args['after_title'];
    ?>



    <?php
    global $wpdb;
    global $post;

    $instance_custom_post_type = $instance['custom_post_type'];

    $query = $wpdb->prepare(
"SELECT po.ID, po.post_date, po.post_content, po.post_title, po.post_type, po.post_status, pm.post_id, pm.meta_key, pm.meta_value
 FROM $wpdb->posts po, $wpdb->postmeta pm WHERE  pm.post_id = po.ID AND  po.post_type=%s AND po.post_status ='publish'  ORDER BY po.post_date  DESC
", $instance_custom_post_type );

     $result = $wpdb->get_results($query, OBJECT_K);

    if (!$result)
      return false;
    else {
      foreach ($result as $post) {
        setup_postdata($post);
    ?>

      <?php $this_external_link = get_post_meta(get_the_ID(), 'lastnews_link', true);?>

      <li class="b-lastNews__item">

        <a class="b-lastNews__thumbLink js-fancybox" href="<?php echo $this_external_link; ?> ">
          <?php the_post_thumbnail('post-thumbnail', 'b-lastNews__thumb"'); ?>
        </a>

        <div class="b-lastNews__content">
          <h3 class="b-lastNews__name">
            <a class="b-lastNews__nameLink js-fancybox" href="<?php  echo $this_external_link ?>"> <?php the_title(); ?>
            </a>
          </h3>

          <div class="b-lastNews__date"><?php the_date("j F Y"); ?>
          </div>

          <div class="b-lastNews__descr b-text">
            <p><?php the_content('...'); ?>
            </p>
          </div>

        </div>
      </li>

    <?php // endwhile; endif;  ?>

    <?php
        wp_reset_postdata();
      }
    }
    ?>

      </ul>
    </div>
  </div><!--.b-sidebarBlock-->

  <?php
  }
}

add_action('widgets_init', function () {
  register_widget('WP_Widget_All_Post_Types');
});