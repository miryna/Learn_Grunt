<?php
/**
 * @package WordPress
 * @subpackage ideustheme
 */
?>


<?php /* Start the Loop */ ?>
<?php
if (have_posts()): while (have_posts()) : the_post(); ?>

  <section class="l-post">
    <div id="post-<?php the_ID(); ?>" <?php post_class('b-post -type_archive'); ?> >


      <?php if (has_post_thumbnail() && !is_search() ) { ?>
        <a class="b-post__thumbLink" href="<?php the_permalink(); ?>" alt="<?php the_title_attribute(); ?>">
          <?php the_post_thumbnail('post-thumbnail', 'class=b-post__thumb'); ?>
        </a>
      <?php } ?>

      <h2 class="b-post__title"><?php the_title(); ?></h2>

      <?php if (is_singular()) { ?>

        <div class="b-post__content b-text js-fancybox ">
          <?php the_content(); ?>
        </div>

      <?php } else { ?>

        <div class="b-post__content b-text">
          <?php the_content('… →'); ?>
        </div>

        <?php echo ideustheme_read_more(); ?>

      <?php } ?>

      <ul class="b-postMeta">
        <?php
        printf('<li class="b-postMeta__item -type_date">%1$s</li>
                     <li class="b-postMeta__item -type_author">%2$s</li>
                  <li class="b-postMeta__item -type_comments">
                        <a class="b-postMeta__link" href="%3$s#comments">%4$s</a>
                  </li>',

          get_the_date("j F Y"),
          get_the_author(),
          get_permalink(),
          get_comments_number($post->ID)
        );
        ?>
      </ul>

      <div class="b-share">
        <div class="b-share__title">Поделиться:</div>
        <div class="b-share__content">
          <img src="<?php echo get_template_directory_uri(); ?>/assets/img/temp-share.png" alt=""/>
        </div>
      </div>

    </div>
  </section>

  <?php comments_template('', true); ?>

  <?php wp_link_pages(array('before' => '<div class="page-link">' . __('Pages:', 'ideustheme'), 'after' => '</div>')); ?>

<?php endwhile; ?>

<?php else: ?>

  <section class="l-post">
    <div class="b-post__content b-text">
      <p><?php _e('Sorry, nothing to display.', 'ideustheme'); ?></p>
    </div>
  </section>


<?php endif; ?>