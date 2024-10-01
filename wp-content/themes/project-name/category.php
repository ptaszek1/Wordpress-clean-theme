<?php if (!defined('ABSPATH')) exit;

get_header();

$blog = new WP_Query(array(
    'post_type' => 'post',
    'posts_per_page' => 10,
    'paged' => get_query_var('paged') ? get_query_var('paged') : 1,
    'cat' => $current_category_id
));

$args = array(
    'orderby'       => 'name',
    'order'         => 'ASC',
    'hide_empty'    => false,
    'hierarchical'  => true,
    'taxonomy'      => 'category',
    'pad_counts'    => true,
    'exclude'       => array($current_category_id,19)
);

$categories = get_categories($args);

?>







<?php 

get_footer();

?>