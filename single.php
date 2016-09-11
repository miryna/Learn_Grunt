<?php
/**
 * @package WordPress
 * @subpackage ideustheme
 */

get_header(); ?>

<main class="l-contentText" role="main">

<?php while (have_posts()) : the_post(); ?>

  <section  class="l-post">
    <div id="post-<?php the_ID(); ?>" <?php post_class('b-post'); ?> >


      <?php if ( has_post_thumbnail()) { ?>
           <?php the_post_thumbnail('post-thumbnail', 'class=b-post__thumb'); ?>
      <?php } ?>

      <h1 class="b-post__title"><?php the_title(); ?></h1>


      <div class="b-post__content b-text">
        <p><?php the_content(); ?></p>
      </div>

      <ul class="b-postMeta">
        <?php
        printf(  '<li class="b-postMeta__item -type_date">%1$s</li>
                     <li class="b-postMeta__item -type_author">%2$s</li>
                  <li class="b-postMeta__item -type_comments">
                        <a class="b-postMeta__link" href="%3$s#comments">%4$s</a>
                  </li>',

          get_the_date("j F Y"),
          get_the_author(),
          get_permalink(),
          get_comments_number( $post->ID )
        );
        ?>
      </ul>

      <div class="b-share">
        <div class="b-share__title">Поделиться:</div>
        <div class="b-share__content">
          <img src="<?php echo get_template_directory_uri();?>/assets/img/temp-share.png" alt="" />
        </div>
      </div>


    </div><!-- #post-<?php the_ID(); ?> -->
  </section>


    <?php
      // If comments are open or we have at least one comment, load up the comment template.
      if ( comments_open() || get_comments_number() ) :
         comments_template( '/comments.php', true );
      endif;
    ?>


<?php endwhile; ?>

</main>


<?php get_sidebar(); ?>

<?php get_footer(); ?>