<?php
/**
 * header template
 *
 * @package MeineLeberUndIch
 */
?>
<!doctype html>
  <html <?php language_attributes(); ?>>
  <head>
  	<meta charset="<?php bloginfo( 'charset' ); ?>" />
  	<meta name="viewport" content="width=device-width, initial-scale=1" />
  	<link rel="profile" href="https://gmpg.org/xfn/11" />
    <link rel="shortcut icon" type="image/png" href="<?php echo get_template_directory_uri(); ?>/favicon.png" />
  	<?php wp_head(); ?>
  	<script src="https://player.vimeo.com/api/player.js"></script>
      <!-- OneTrust Cookies Consent Notice start for meine-leber-und-ich.de -->
      <script type="text/javascript" src="https://cdn.cookielaw.org/consent/8c02d81b-7b7f-43f0-bfff-1186354a6a21/OtAutoBlock.js" ></script>
      <script src="https://cdn.cookielaw.org/scripttemplates/otSDKStub.js"  type="text/javascript" charset="UTF-8" data-domain-script="8c02d81b-7b7f-43f0-bfff-1186354a6a21" ></script>
      <script type="text/javascript">
          function OptanonWrapper() { }
      </script>
      <!-- OneTrust Cookies Consent Notice end for meine-leber-und-ich.de -->
  	<!-- Google Tag Manager -->
          <script type="text/plain" class="optanon-category-C0002">(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
          new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
          j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
          'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
          })(window,document,'script','dataLayer','GTM-WSKLVZM');</script>
          <!-- End Google Tag Manager -->
  </head>
  <!--[if !IE]><!-->
  <!--<![endif]-->
  <!--[if IE]>
      <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/dist/all-ie-only.css" />
  <![endif]-->
<body <?php body_class(); ?>><?php if(function_exists('wp_body_open')){
      	wp_body_open();
      }
?><!-- Google Tag Manager (noscript) -->
  <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WSKLVZM"
  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
  <!-- End Google Tag Manager (noscript) -->
<header class="text-gray-700 body-font shadow-xl">
<div class="container mx-auto flex p-4 flex-row justify-between">
    <span class="flex title-font font-medium items-center text-gray-900">
      <?php
      echo get_custom_logo();
       ?>
    </span>
    <nav id="header-nav" class="hidden md:me-auto md:ms-4 md:py-1 md:ps-4 md:border-l md:border-gray-400 md:flex flex-wrap items-center text-base justify-center">
    <ul><?php
            wp_nav_menu(
              [
                'container'      => '',
                'items_wrap'     => '%3$s',
                'theme_location' => 'header-menu',
                'menu_class'     => 'nav-item'
              ]
            );
     ?>
     </ul>
    </nav>
    <?php do_action('wpml_add_language_selector'); ?>
  </div>
</header>