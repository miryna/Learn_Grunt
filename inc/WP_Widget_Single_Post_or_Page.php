<?php
/**
* Виджет выводит Content, Thumbnail поста по заданному id поста.
*
**/
class WP_Widget_Single_Post_or_Page extends WP_Widget
{

  public function __construct()
  {
    parent::__construct(
      'WP_Widget_Single_Post_or_Page',
      'Some post or page',
      array('description' => __('Display some post or page', 'ideustheme'),)
    );
  }

  public function update($new_instance, $old_instance)
  {
    $instance = array();
    $instance['title'] = strip_tags($new_instance['title']); // Добавление настройки для заголовка
    $instance['id'] = strip_tags($new_instance['id']);  //добавить выбор рубрики в настройки виджета
    return $instance;
  }

  // Добавление настроек в форму в админке
  public function form($instance)
  {

    $defaults = array(
      'title' => 'title',
      'id' => 'id');
    $instance = wp_parse_args((array)$instance, $defaults);

    ?>
    <p>
      <label for="<?php echo $this->get_field_id('title'); ?>">Заголовок</label>
      <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
             name="<?php echo $this->get_field_name('title'); ?>" type="text"
             value="<?php echo $instance['title']; ?>"/>
    </p>

    <p>
      <label for="<?php echo $this->get_field_id('id'); ?>">Укажите id поста</label>
      <input class="widefat" id="<?php echo $this->get_field_id('id'); ?>"
             name="<?php echo $this->get_field_name('id'); ?>" type="text"
             value="<?php echo $instance['id']; ?>"/>
    </p>

  <?php
  }

  //Вывод информации на сайт
  public function widget($args, $instance)
  {

    ?>

    <div class="b-about">

      <?php
      $title = apply_filters('widget_title', $instance['title']);
      if ($title)
        echo $args['before_title'] . $title . $args['after_title'];
      ?>

      <?php

      global $wpdb;
      global $post;

      $instance_id = intval($instance['id']);

      $query = $wpdb->prepare(
        "SELECT po.ID, po.post_content, po.post_title, pm.post_id, pm.meta_key, pm.meta_value FROM $wpdb->posts po, $wpdb->postmeta pm WHERE  pm.post_id = po.ID  AND  po.ID=%d   AND po.post_status =%s AND pm.post_id=%d ",
        $instance_id, 'publish', $instance_id);

      $result = $wpdb->get_results($query, OBJECT_K);

      if (!$result)
        return false;
      else {
        foreach ($result as $post) {
          setup_postdata($post);
          ?>

          <?php the_post_thumbnail('post-thumbnail', 'class="b-about__thumb"'); ?>
          <div class="b-about__content b-text">
            <p> <?php the_content(); ?> </p>
          </div>


        <?php
        }
      }
      wp_reset_postdata();
      ?>
    </div>
  <?php
  }
}


add_action('widgets_init', function () {
  register_widget('WP_Widget_Single_Post_or_Page');
});
