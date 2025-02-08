<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?php echo esc_url( get_template_directory_uri() . '/assets/bootstrap/css/bootstrap.min.css' ); ?>">
    <!-- Bootstrap Icons CSS (Locally hosted) -->
    <link rel="stylesheet" href="<?php echo esc_url( get_template_directory_uri() . '/assets/bootstrap-icons/font/bootstrap-icons.css' ); ?>">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?php echo esc_url( get_template_directory_uri() . '/assets/css/main.css' ); ?>">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"   />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo esc_url( get_template_directory_uri() .'/assets/favicon/apple-touch-icon.png' ); ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo esc_url( get_template_directory_uri() .'/assets/favicon/favicon-32x32.png' ); ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo esc_url( get_template_directory_uri() .'/assets/favicon/favicon-16x16.png' ); ?>">
    <link rel="manifest" href="<?php echo esc_url( get_template_directory_uri() .'/assets/favicon/site.webmanifest' ); ?>">
    <!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-M3VTHJ5H');</script>
<!-- End Google Tag Manager -->
    <!-- WordPress Head -->
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-M3VTHJ5H"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
    <a class="skip-link screen-reader-text" href="#main"><?php esc_html_e('Skip to content', 'textdomain'); ?></a>
    <div class="notice-bar">
    <div class="marquee">
        <p class="text-small-normal">We are upgrading the website! If you find any bug or error, <a class="text-white" href="">contact us</a> immediately. </p>
    </div>
</div>
    <header id="masthead" class="site-header bg-white py-1 shadow-small" role="banner">
        <div class="container-header ml-5 mr-5">
            <div class="d-flex align-items-center justify-content-between">
                <!-- Logo -->
                <div class="site-branding d-flex align-items-center">
                    <div class="site-logo">
                            <?php 
                                if (has_custom_logo()) {
                                    // Display the logo with the custom size
                                    the_custom_logo();
                                } else {
                                    // Fallback logo if no custom logo is set
                                    echo '<img src="' . get_template_directory_uri() . '/assets/images/default-logo.png" alt="Site Logo">';
                                }
                            ?>
                            </div>

                    <div class="site-title-description d-none d-lg-block">
                        <h1 class="site-title mb-0">
                            <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                                <?php bloginfo('name'); ?>
                            </a>
                        </h1>
                        <p class="site-description mb-0">
                            <?php bloginfo('description'); ?>
                        </p>
                    </div>
                </div>

               <!-- Navigation -->
                    <nav id="site-navigation" class="navbar navbar-expand-lg" role="navigation" aria-label="<?php esc_attr_e('Primary Menu', 'textdomain'); ?>">
                        <div class="container-fluid d-flex align-items-center justify-content-between">
                            <!-- Toggle Button -->
                            <button class="navbar-toggler" id="navbar-toggler" type="button" data-bs-toggle="collapse" data-target="#primary-menu" aria-controls="primary-menu" aria-expanded="false" aria-label="<?php esc_attr_e('Toggle navigation', 'textdomain'); ?>">
                                <i class="bi bi-list text-dark fs-3" id="navbar-toggler-icon"></i>
                            </button>

                            <!-- Navigation Menu -->
                            <div class="collapse navbar-collapse" id="primary-menu">
                                <?php
                               wp_nav_menu(array(
                                    'theme_location'  => 'primary',  // The location of your menu
                                    'menu_class'      => 'navbar-nav mx-auto',  // Main nav class
                                    'container'       => false,  // No container wrapping
                                    'fallback_cb'     => 'wp_page_menu',  // Fallback menu if none exists
                                    'walker'           => new Bootstrap_Nav_Walker(),  // Use the custom walker
                                    'menu_id'          => 'navbarNav',  // Optional ID for the menu container
                                    'depth'            => 2,  // Limit the depth of the menu to 2 levels
                                ));
                                ?>

                                <!-- CTA Button for Mobile -->
                                <div class="nav-item d-lg-none text-center mt-3">
                                    <a href="<?php echo esc_url(get_theme_mod('cta_button_url', '#')); ?>" class="btn text-white text-regular-bold border-25 bg-color-secordary-light pl-2 pr-2 w-100">
                                        <?php echo esc_html(get_theme_mod('cta_button_text', __('Call to Action', 'textdomain'))); ?>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </nav>





                <!-- CTA Button -->
                <div class="nav-item d-none d-lg-block text-center ">
            <a href="<?php echo esc_url(get_theme_mod('cta_button_url', '#')); ?>" class="btn text-white text-regular-bold border-25 bg-color-secordary-light pl-2 pr-2">
                <?php echo esc_html(get_theme_mod('cta_button_text', __('Call to Action', 'textdomain'))); ?>
            </a>
        </div>

               


            </div>
        </div>
    </header>

    <div id="content" class="site-content">


