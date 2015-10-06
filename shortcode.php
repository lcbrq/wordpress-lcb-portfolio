<?php

function lcb_portfolio_display()
{
    $return_string = '<div class="portfolio">';
    query_posts(array('post_type' => 'portfolio', 'orderby' => 'date', 'order' => 'DESC'));
    if (have_posts()) :
        while (have_posts()) : the_post();
            $attr = array(
                'title' => get_the_title()
            );
        $column_nr = get_option('column_number');
        $return_string .= '<div class="column'.$column_nr.' portfolio-box">'
                            . '<a href='.get_permalink().'>'
                            .get_the_post_thumbnail(get_the_id(), 'post-thumbnail')
                            .'</a>'
                            .'<h3>'
                            .'<a href='.get_permalink().'>'
                            .get_the_title()
                            .'</a>'
                            .'</h3>'
                            .'<p>'
                            .get_the_excerpt()
                            .'</p>'
                            .'</div>';
      endwhile;
   endif;
   $return_string .= '</div>';

   wp_reset_query();
   return $return_string;
    }
add_shortcode( 'portfolio', 'lcb_portfolio_display' );
