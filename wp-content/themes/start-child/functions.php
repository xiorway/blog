<?php
function my_theme_enqueue_styles()
{

    $parent_style = 'parent-style'; // This is 'twentyfifteen-style' for the Twenty Fifteen theme.

    wp_enqueue_style('bootstrap', get_stylesheet_directory_uri() . '/bootstrap3.3.7/css/bootstrap.min.css');
    wp_enqueue_style($parent_style, get_template_directory_uri() . '/style.css');
}

function add_bootstrap_js()
{
    $url = "https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js";
    wp_enqueue_script( 'bootstrap-js', $url, array('jquery'), '3.3.4', true );
}

function add_jquery_datepicker()
{
    /* add jquery ui datepicker and theme */
    global $wp_scripts;
    wp_enqueue_script('jquery-ui-datepicker');
    $ui = $wp_scripts->query('jquery-ui-core');
    //$url = "http://ajax.googleapis.com/ajax/libs/jqueryui/{$ui->ver}/themes/redmond/jquery.ui.all.css";
    $url = "http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.21/themes/flick/jquery.ui.all.css";
    wp_enqueue_style('jquery-ui-flick', $url, false, $ui->ver);
}

add_action('wp_enqueue_scripts', 'add_bootstrap_js');
add_action('wp_enqueue_scripts', 'add_jquery_datepicker');
//add_action('wp_enqueue_scripts', 'italystrap_add_jquery'); // not needed if loaded datepicker, because of dependencies
add_action('wp_enqueue_scripts', 'my_theme_enqueue_styles');