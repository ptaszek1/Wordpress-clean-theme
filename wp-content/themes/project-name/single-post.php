<?php if (!defined('ABSPATH')) exit; 

get_header();

// Author:
$author_id  = get_post_field('post_author', $post->ID); // Author ID
$author     = get_the_author_meta('nickname', $author_id); // Author Name
$author_url = get_author_posts_url($author_id); // Author url

// Category:
$single_category = get_the_category();
$another_posts   = '';

if ($single_category) {
    $category_id = $single_category[0]->term_id;

    $args = array(
        'cat' => $category_id, // Get posts from category
        'posts_per_page' => 3,
        'post__not_in' => array(get_the_ID()), // Remove post we are in now
        'ignore_sticky_posts' => 1
    );

    $another_posts = new WP_Query($args);
}

// Dates:
$publish_date = get_the_date('F j, Y');

// Images:
$image = get_post_thumbnail_id($post->ID);



?>

<article class="single-post">
    <div class="single-post__breadcrumb">
        <?=custom_breadcrumbs(); ?>
    </div>
    <?php if(!empty($author)): ?>
        <?php if(!empty($author_url)): ?>
            <a href="<?=$author_url ?>" class="single-post__author">
                <?=$author; ?>
            </a>
        <?php else: ?>
            <div class="single-post__author">
                <?=$author; ?>
            </div>
        <?php endif; ?>
    <?php endif; ?>
    <?php if(!empty($post->post_title)): ?>
        <div class="single-post__title">
            <?=$post->post_title; ?>
        </div>
    <?php endif; ?>
    <?php if(!empty($post->post_excerpt)): ?>
        <div class="single-post__short-description">
            <?=$post->post_excerpt ?>
        </div>
    <?php endif; ?>
    <?php if(!empty($image)): ?>
        <div class="single-post__image">
            <img src="<?=wp_get_attachment_url($image); ?>" alt="<?=$post->post_title; ?>">
        </div>
    <?php endif; ?>
    <div class="single-post__fulltext">
        <?=the_content(); ?>
    </div>
</article>




<?php

get_footer();

?>