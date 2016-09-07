<?php
/**
 * @package WordPress
 * @subpackage ideustheme
 */
?>
<aside class="l-sidebar">

  <?php if (is_active_sidebar('side1')) : ?>
    <?php dynamic_sidebar('side1'); ?>
  <?php endif; ?>

  <?php if (is_active_sidebar('side2')) : ?>
    <?php dynamic_sidebar('side2'); ?>
  <?php endif; ?>

  <div class="b-sidebarBlock -style_social">
    <h2 class="b-sidebarBlock__title"><?php echo  __('Join us!', 'ideustheme' ); ?></h2>
    <?php ideustheme_socialMenu_sidebar(); ?>
  </div>

</aside>




