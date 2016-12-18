<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package start
 */

get_header(); ?>
<div id="primary" class="content-area col col-md-8"> 
    <main id="main" class="site-main col-md-12" role="main">  
        <h1>Featured events</h1> 
        <img src="http://www.jonaled.com/images/led_dance_floor-banner2.jpg"> 
        <h1>Featured post</h1> 
        <div class="row"> 
            <div class="col-md-6">  <img src="http://www.jonaled.com/images/led_dance_floor-banner2.jpg">  <h3
                    style=" margin-top: 1%;">Ibiza</h3> 
            </div>
            <div class="col-md-6">  <img src="http://www.jonaled.com/images/led_dance_floor-banner2.jpg">  <h3
                    style=" margin-top: 1%;">Lloret de mar</h3> 
            </div>
        </div>
        <div class="row"> 
            <div class="col-md-6">  <img src="http://www.jonaled.com/images/led_dance_floor-banner2.jpg">  <h3
                    style=" margin-top: 1%;">Ibiza</h3> 
            </div>
            <div class="col-md-6">  <img src="http://www.jonaled.com/images/led_dance_floor-banner2.jpg">  <h3
                    style=" margin-top: 1%;">Lloret de mar</h3> 
            </div>
        </div>
        <div class="row"> 
            <div class="col-md-6">  <img src="http://www.jonaled.com/images/led_dance_floor-banner2.jpg">  <h3
                    style=" margin-top: 1%;">Ibiza</h3>  
            </div>
            <div class="col-md-6">  <img src="http://www.jonaled.com/images/led_dance_floor-banner2.jpg">  <h3
                    style=" margin-top: 1%;">Lloret de mar</h3> 
            </div>
        </div>
          
    </main><!-- #main --> 
</div><!-- #primary -->
  <?php get_sidebar(); ?> <?php get_footer(); ?> 
