<?php
/**
 * @package WordPress
 * @subpackage ideustheme
 */
if (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === 'off') {
  $protocol = 'http://';
} else {
  $protocol = 'https://';
}
$BASE_URL = $protocol . $_SERVER['SERVER_NAME'] . dirname($_SERVER['PHP_SELF']);

require_once 'inc/vendor/Mobile_Detect.php';
$detect = new Mobile_Detect();

$device = (!$detect->isMobile()) ? 'desktop' : ($detect->isTablet() ? 'tablet' : 'mobile');

$device = (isset($_COOKIE['device']) && $_COOKIE['device']) ? $_COOKIE['device'] : $device;

switch ($device) {
  case 'mobile':
    $viewport = '640px';
    $viewportMeta = '640';
    break;
  case 'tablet':
    $viewport = '1200px';
    $viewportMeta = '1200';
    break;
  case 'desktop':
  default:
    $viewport = 'device-width';
    $viewportMeta = 'device-width';
    break;
}
$isHomepage = (basename($_SERVER['PHP_SELF']) == 'index.php');
?>
<!doctype html>
<html class="-device_<?php echo $device; ?> no-js" <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>"/>
  <meta http-equiv="X-UA-Compatible" content="IE=edge"/>

  <title><?php echo wp_get_document_title(); ?></title>
  <meta name="description" content="<?php bloginfo('description'); ?>"/>

  <!-- <meta property="og:image" content="<?php echo $BASE_URL; ?>/img/userfiles/og-image.png" /> -->

  <meta name="viewport" content="width=<?php echo $viewportMeta; ?>"/>
  <style>
    @-ms-viewport {
      width: <?php echo $viewport; ?>;
    }

    @viewport {
      width: <?php echo $viewport; ?>;
    }
  </style>

  <link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/img/favicon.ico"/>
  <link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/img/apple-touch-icon.png">


  <script src="//cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>
  <script>window.Modernizr || document.write('<script src="<?php echo get_template_directory_uri();?>/assets/js/vendor/modernizr-2.8.3.min.js"><\/script>')</script>


  <?php wp_head(); ?>
</head>

<body
  class="<?php echo implode(' ', get_body_class()) . ' -page_' . get_page_uri(); ?><?php echo (!is_front_page()) ? ' -page_inner' : ''; ?>">
<!--[if lt IE 8]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade
  your browser</a> to improve your experience.</p>
<![endif]-->

<div class="l-wrapper">
  <header class="l-siteHeader" role="banner">
    <div class="b-siteHeader">
      <div class="l-siteLogo">
        <div class="b-siteLogo" itemscope itemtype="http://schema.org/Organization">
          <a class="b-siteLogo__link" href="http://ideus.biz" itemprop="url">
            <img class="b-siteLogo__icon" src="<?php echo get_template_directory_uri(); ?>/assets/img/siteLogo__icon.png"
                 alt="iDeus" title="iDeus" itemprop="logo"/>
          </a>
        </div>
      </div>

      <div class="b-siteInfo">
        <a class="b-siteInfo__link"<?php if (!is_front_page()): ?> href="<?php echo home_url(); ?>"<?php endif; ?>>
          <img class="b-siteInfo__logo" src="<?php echo get_template_directory_uri(); ?>/assets/img/siteInfo__logo.png"
               alt="<?php echo get_bloginfo('name'); ?>"/>
        </a>

        <?php if (is_front_page()): ?>
          <h1 class="b-siteInfo__title"><?php bloginfo('name'); ?></h1>
          <div class="b-siteInfo__descr"><?php bloginfo('description'); ?></div>
        <?php endif; ?>
      </div>

      <div class="l-siteSearch">
        <div class="b-siteSearch">
          <a class="b-siteSearch__link js-searchShow" href="#" title="Искать"><i class="fa fa-search"></i></a>

          <div class="b-siteSearch__form js-searchForm">

            <?php echo ideustheme_wpsearch(); ?>

            <div class="b-siteSearch__close js-searchHide"></div>
          </div>
        </div>
      </div>
    </div>

    <div class="l-siteSubHeader">
      <div class="b-siteSubHeader">

        <?php if (!is_single()){ ?>
          <?php $tag = (!is_front_page()) ? 'h1' : 'div'; ?>
          <<?php echo $tag; ?> class="b-siteSubHeader__title">

            <?php if (is_front_page()): ?>
              <?php echo _e('Home', 'ideustheme'); ?>

            <?php  elseif (is_archive()): ?>
              <?php single_term_title('', true); ?>

            <?php else: ?>
              <?php echo wp_title(); ?>

            <?php endif; //inner if ?>

        </<?php echo $tag; ?>>
      <?php } //!is_single() ?>

      <?php ideustheme_socialMenu(); ?>

      <?php ideustheme_siteNavigation(); ?>

    </div>
</div>
</header>

<div class="l-content">