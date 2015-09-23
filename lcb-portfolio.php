<?php
/*
Plugin Name: LCB portfolio
Description: Displays image with short description
Version: 1.0
Author: LeftCurlyBracket
Author URI: http://leftcurlybracket.com
License: MIT
*/

add_action('plugins_loaded', 'portfolio_load_textdomain');

function portfolio_load_textdomain()
{
    load_plugin_textdomain('lcb-portfolio', false, dirname(plugin_basename(__FILE__)) . '/languages');
}

include_once 'shortcode.php';

add_action( 'wp_enqueue_scripts', 'add_lcb_portfolio_style' );
function add_lcb_portfolio_style(){
     wp_enqueue_style( 'custom-style', plugins_url( '/style.css', __FILE__ ) );
}

add_action('init', 'create_post_type');

function create_post_type()
{
    register_post_type('portfolio', array(
        'labels' => array(
            'name' => __('Portfolio', 'lcb-portfolio'),
            'singular_name' => __('Portfolio', 'lcb-portfolio'),
            'add_new' => __('Add new', 'lcb-portfolio')
        ),
        'public' => true,
        'show_in_nav_menus' => true,
        'show_ui' => true,
        'has_archive' => true,
        'supports' => array('title', 'thumbnail', 'editor', 'excerpt' ),
        )
    );
}

include_once 'portfolio-options.php';
