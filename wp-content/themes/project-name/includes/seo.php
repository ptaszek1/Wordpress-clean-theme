<?php if (!defined('ABSPATH')) exit; 

/**
 * All SEO scripts
*/

// Remove Yoast SEO canonicals
add_filter('wpseo_canonical', '__return_false');

// Insert custom canonicals
function add_canonical_tag() {
    global $wp;
    $current_url = home_url(add_query_arg(array(), $wp->request));

    if (!in_array('zuluna-products', get_body_class())) {
        // Sprawdź, czy w URL znajduje się '/page/' i numer strony
        if (preg_match('/\/page\/\d+/', $current_url)) {
            $current_url = preg_replace('/\/page\/\d+/', '', $current_url);
        }
    }

    echo '<link rel="canonical" href="' . esc_url($current_url) . '" class="yoast-seo-meta-tag">' . "\n";
}
add_action('wp_head', 'add_canonical_tag');