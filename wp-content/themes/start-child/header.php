<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package start
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
    <script src="https://use.fontawesome.com/d5fc326d42.js"></script>
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
    <a class="skip-link screen-reader-text" href="#content"><?php esc_html_e('Skip to content', 'start'); ?></a>

    <header id="masthead" class="site-header" role="banner">
        <div class="container">
            <div class="site-branding col-md-8">
                <h1 class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>"
                                          rel="home"><?php bloginfo('name'); ?></a></h1>
                <h2 class="site-description"><?php bloginfo('description'); ?></h2>
            </div><!-- .site-branding -->
            <div class="col-md-4 socialIconContainer">
                <a href="https://www.facebook.com/xiorway"><i class="fa fa-facebook socialIcon"></i></a>
                <a href="https://www.twitter.com/xiorway"><i class="fa fa-twitter socialIcon"></i></a>
                <a href="https://www.instagram.com/xiorway"><i class="fa fa-instagram socialIcon"></i></a>
                <a href="https://www.youtube.com/xiorway"><i class="fa fa-youtube-play socialIcon"></i></a>
                <a href="https://www.mixcloud.com/xiorway"><i class="fa fa-mixcloud socialIcon"></i></a>
            </div>

            <nav id="site-navigation" class="main-navigation" role="navigation">
                <button class="menu-toggle" aria-controls="primary-menu"
                        aria-expanded="false"><?php esc_html_e('Primary Menu', 'start'); ?></button>
                <?php wp_nav_menu(array('theme_location' => 'primary', 'menu_id' => 'primary-menu')); ?>
            </nav><!-- #site-navigation -->
        </div><!-- .container -->
    </header><!-- #masthead -->

    <div id="content" class="site-content container">
