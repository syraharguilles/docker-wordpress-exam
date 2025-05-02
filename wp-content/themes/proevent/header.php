<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?> class="dark bg-gray-900 text-white">
<?php wp_body_open(); ?>

<?php
  // Get custom settings
  $company_logo   = get_option( 'company_logo' );
  $brand_color    = sanitize_hex_color( get_option( 'company_color' ) );
  $company_social = json_decode( get_option( 'company_socials' ), true );
?>

<header class="shadow-sm" style="background-color: <?php echo $brand_color ?: '#ffffff'; ?>;">
  <div class="max-w-7xl mx-auto flex items-center justify-between px-4 py-4 sm:px-6 lg:px-8">

    <!-- Logo -->
    <div class="flex items-center gap-3">
      <?php if ( $company_logo ) : ?>
        <a href="<?php echo esc_url( home_url() ); ?>" class="flex items-center">
          <img src="<?php echo esc_url( get_site_url() . $company_logo ); ?>" alt="Company Logo" class="h-10 w-auto max-w-[120px]" />
        </a>
      <?php else : ?>
        <span class="text-lg font-bold text-gray-900 dark:text-white">Company Name</span>
      <?php endif; ?>
    </div>

    <!-- Navigation -->
    <nav class="flex items-center gap-6 text-sm font-medium text-gray-800 dark:text-gray-100">
        <?php
            wp_nav_menu([
                'theme_location' => 'primary',
                'container'      => false,
                'menu_class'     => 'flex gap-6 list-none',
                'fallback_cb'    => false,
                'depth'          => 1,
                'link_before'    => '<span class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">',
                'link_after'     => '</span>',
            ]);
            
        ?>
    </nav>

    <!-- Dark Mode Toggle -->
    <!-- <button id="darkToggle" class="ml-4 px-3 py-1.5 rounded bg-gray-100 dark:bg-gray-700 text-xs text-gray-800 dark:text-white hover:bg-gray-200 dark:hover:bg-gray-600 transition">
      Toggle Dark Mode
    </button> -->

  </div>
</header>
