<?php
/**
 * Template for comments and pingbacks.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 */

if (!function_exists('ideustheme_walker_comment')) :


  function ideustheme_walker_comment($comment, $args, $depth)
  {
    $GLOBALS['comment'] = $comment;

    switch ($comment->comment_type) :
      case 'pingback' :
      case 'trackback' :
        ?>
        <li class="b-pingback">
        <div class="b-pingback__content">
          <span><?php _e('Pingback:', 'ideustheme'); ?></span>
          <?php comment_author_link(); ?>
          <?php edit_comment_link(__('(Edit)', 'ideustheme'), ' '); ?>
        </div>
        <?php
        break;
      default :
        ?>

        <li <?php comment_class('l-comment'); ?> id="comment-<?php comment_ID(); ?>">
          <article class="b-comment" id="div-comment-<?php comment_ID(); ?>">

            <div class="b-comment__header">

              <div class="b-comment__Avatar">
                <?php
                if (get_avatar($comment, 40))
                  $avatar = get_avatar($comment, 40);
                else
                  $avatar = '<span class="b-comment__avatar no-avatar"></span>';
                echo $avatar;   ?>
              </div>

              <div class="b-comment__metaData">

                <div class="b-comment__metaItem -autor">
                  <div class=" b-comment__author -type_author">
                    <?php echo comment_author(); ?>
                  </div>
                </div>
                <!-- __author -->

                <div class="b-comment__metaItem -datetime">
                  <div class="b-comment__datetime -type_date">
                    <time datetime="<?php comment_time('c'); ?>">
                      <?php
                      //  printf(__('%1$s &nbsp;%2$s', 'ideustheme'), get_comment_date("d M Y"), get_comment_time());
                      printf(__('%1$s', 'ideustheme'), get_comment_date("d M Y"));
                      ?>
                    </time>
                  </div>
                </div>
                <!-- __datetime -->

              </div>
              <!-- .b-comment__metaData -->

            </div>
            <!-- .b-comment__header -->

            <div class="b-comment__content"><?php comment_text(); ?></div>

            <div class="b-comment__metaLinks">

              <div class="b-comment__metaItem -reply">
                <div class="b-comment__reply">
                  <?php comment_reply_link(array_merge($args, array('add_below' => 'div-comment', 'depth' => $depth, 'max_depth' => $args['max_depth']))); ?>
                </div>
              </div>
              <!-- __reply -->

              <div class="b-comment__metaItem">
                <?php edit_comment_link(__('Edit', 'ideustheme'), ' '); ?>
              </div>
              <!-- __edit -->

            </div>
            <!-- .b-comment__metaLinks -->

            <?php if ($comment->comment_approved == '0') : ?>
              <em><?php _e('Your comment is awaiting moderation.', 'ideustheme'); ?></em>
              <br/>
            <?php endif; ?>

            <!--<hr class="b-comment__articleSeparator">-->
          </article>

        <?php
        break;
    endswitch;
  }

endif;