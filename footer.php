<?php
/**
 * @package WordPress
 * @subpackage ideustheme
 */
?>

</div><!--content-->

<footer class="l-siteFooter" role="contentinfo">
  <div class="b-siteFooter">
    <address class="l-siteCopyright vcard" itemscope itemtype="http://schema.org/Organization">
      <div class="b-siteCopyright">© <?php echo date('Y'); ?>,
        <a rel="me" itemprop="name" class="b-siteCopyright__link fn n org url work"
           href="<?php echo "http://" . $_SERVER['HTTP_HOST']; ?>"> <?php echo get_bloginfo(); ?> </a>
      </div>
    </address>
  </div>
</footer>

</div><!--wrapper-->

<?php wp_footer(); ?>

<?php $ideus_uri_scripts = get_template_directory_uri() . '/assets/js/scripts.js'; ?>
<script src="  <?php echo $ideus_uri_scripts . '?' . filemtime($ideus_uri_scripts); ?>  "></script>

<?php/*  $ideus_uri_scripts_extra = get_template_directory_uri() . '/assets/js/scripts-extra.js'; */ ?>
<!--<script src="  <?php echo $ideus_uri_scripts_extra . '?' . filemtime($ideus_uri_scripts_extra); ?> "></script>-->

<!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
<script>
  (function (b, o, i, l, e, r) {
    b.GoogleAnalyticsObject = l;
    b[l] || (b[l] =
      function () {
        (b[l].q = b[l].q || []).push(arguments)
      });
    b[l].l = +new Date;
    e = o.createElement(i);
    r = o.getElementsByTagName(i)[0];
    e.src = 'https://www.google-analytics.com/analytics.js';
    r.parentNode.insertBefore(e, r)
  }(window, document, 'script', 'ga'));
  ga('create', 'UA-XXXXX-X', 'auto');
  ga('send', 'pageview');
</script>
</body>
</html>
