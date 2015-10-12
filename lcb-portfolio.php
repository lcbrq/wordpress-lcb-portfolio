<?php
/*
Plugin Name: LCB Portfolio
Description: Displays image with short description
Version: 1.1.2
Author: LeftCurlyBracket
Author URI: http://leftcurlybracket.com
License: MIT
*/

add_action('plugins_loaded', 'lcb_portfolio_load_textdomain');

function lcb_portfolio_load_textdomain()
{
    load_plugin_textdomain('lcb-portfolio', false, dirname(plugin_basename(__FILE__)) . '/languages');
}

include_once dirname(__FILE__).'/shortcode.php';

add_action( 'wp_enqueue_scripts', 'lcb_portfolio_add_style' );
function lcb_portfolio_add_style(){
     wp_enqueue_style( 'custom-style', plugins_url( '/style.css', __FILE__ ) );
}

add_action('init', 'lcb_portfolio_create_post_type');

function lcb_portfolio_create_post_type()
{
    register_post_type('portfolio', array(
        'labels' => array(
            'name' => __('Portfolio', 'lcb-portfolio'),
            'singular_name' => __('Portfolio', 'lcb-portfolio'),
            'add_new' => __('Add new', 'lcb-portfolio'),
            'add_new_item' => __('Add new portfolio', 'lcb-portfolio')
        ),
        'public' => true,
        'show_in_nav_menus' => true,
        'show_ui' => true,
        'has_archive' => true,
        'supports' => array('title', 'thumbnail', 'editor', 'excerpt' ),
        )
    );
}

include_once dirname(__FILE__).'/portfolio-options.php';

add_action( 'add_meta_boxes', 'lcb_portfolio_meta_box_add' );
function lcb_portfolio_meta_box_add(){
    add_meta_box( 'url-portfolio', __('Potfolio url', 'lcb-portfolio'), 'lcb_portfolio_display_url', 'portfolio' );
}

function lcb_portfolio_display_url($post){ 
    $portfolio_url = get_post_meta( $post->ID, '_url_portfolio', true );
    ?>
<input type="text" name="url-portfolio" placeholder="<?php _e('Enter an external url', 'lcb-portfolio')?>" size="95" value="<?php echo esc_url( $portfolio_url ) ?>"/><br/>
<?php _e('If this field will be empty, portfolio will linked to standard wordpress page.', 'lcb-portfolio'); 
}

add_action( 'save_post', 'lcb_portfolio_meta_boxe_save' );
function lcb_portfolio_meta_boxe_save( $post_id ) {
 
    if ( 'portfolio' != filter_input(INPUT_POST, 'post_type') ) {
        return $post_id;
    }
 
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return $post_id;
    }
 
    $portfolio_url = esc_url_raw( $_POST['url-portfolio'] );
    update_post_meta( $post_id, '_url_portfolio', $portfolio_url );
     
}

function lcb_portfolio_link($url, $post) {
    if($post->post_type == 'portfolio'){
    $uri = get_post_meta( $post->ID, '_url_portfolio', true );
        if(empty($uri)){
            return $url;
        }
        else{
            return esc_url($uri);
        }
    }
}
add_filter('post_type_link', 'lcb_portfolio_link', 10, 2);
