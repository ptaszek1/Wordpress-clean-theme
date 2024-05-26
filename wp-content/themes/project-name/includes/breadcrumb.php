<?php if (!defined('ABSPATH')) exit;

function custom_breadcrumbs()
{

    // Ustawienia
    $separator          = ' » ';
    $home_title         = 'Strona główna';
    $custom_taxonomy    = 'product_cat'; // Dostosuj dla własnych taksonomii

    // Zainicjuj zmienne
    global $post, $wp_query;
    $home_link = get_home_url();

    // Zaczynamy HTML
    echo '<ul class="breadcrumbs">';

    // Dodaj pozycję "Strona główna"
    echo '<li class="breadcrumbs__item"><a href="' . $home_link . '" class="breadcrumbs__link">' . $home_title . '</a></li>';
    echo '<li class="breadcrumbs__separator">' . $separator . '</li>';

    if (is_home() || is_front_page()) {
        echo '</ul>';
        return;
    }

    // Sprawdzamy różne typy stron
    if (is_archive() && !is_tax() && !is_category() && !is_tag()) {
        echo '<li class="breadcrumbs__item">' . post_type_archive_title('', false) . '</li>';
    } elseif (is_single()) {
        $post_type = get_post_type();

        if ($post_type != 'post') {
            $post_type_object = get_post_type_object($post_type);
            $post_type_archive = get_post_type_archive_link($post_type);

            echo '<li class="breadcrumbs__item"><a href="' . $post_type_archive . '" class="breadcrumbs__link">' . $post_type_object->labels->name . '</a></li>';
            echo '<li class="breadcrumbs__separator">' . $separator . '</li>';
        }

        $category = get_the_category();
        if (!empty($category)) {
            $last_category = end(array_values($category));
            $cat_parents = rtrim(get_category_parents($last_category->term_id, true, ','), ',');
            $cat_parents = explode(',', $cat_parents);

            foreach ($cat_parents as $parent) {
                echo '<li class="breadcrumbs__item">' . $parent . '</li>';
                echo '<li class="breadcrumbs__separator">' . $separator . '</li>';
            }
        }

        echo '<li class="breadcrumbs__item">' . get_the_title() . '</li>';
    } elseif (is_category()) {
        $current_category = get_category(get_query_var('cat'));
        $cat_parents = rtrim(get_category_parents($current_category, true, ','), ',');
        $cat_parents = explode(',', $cat_parents);

        foreach ($cat_parents as $parent) {
            echo '<li class="breadcrumbs__item">' . $parent . '</li>';
            echo '<li class="breadcrumbs__separator">' . $separator . '</li>';
        }
    } elseif (is_page()) {
        if ($post->post_parent) {
            $ancestors = get_post_ancestors($post->ID);
            $ancestors = array_reverse($ancestors);

            foreach ($ancestors as $ancestor) {
                echo '<li class="breadcrumbs__item"><a href="' . get_permalink($ancestor) . '" class="breadcrumbs__link">' . get_the_title($ancestor) . '</a></li>';
                echo '<li class="breadcrumbs__separator">' . $separator . '</li>';
            }
        }

        echo '<li class="breadcrumbs__item">' . get_the_title() . '</li>';
    } elseif (is_tag()) {
        echo '<li class="breadcrumbs__item">' . single_tag_title('', false) . '</li>';
    } elseif (is_day()) {
        echo '<li class="breadcrumbs__item"><a href="' . get_year_link(get_the_time('Y')) . '" class="breadcrumbs__link">' . get_the_time('Y') . '</a></li>';
        echo '<li class="breadcrumbs__separator">' . $separator . '</li>';
        echo '<li class="breadcrumbs__item"><a href="' . get_month_link(get_the_time('Y'), get_the_time('m')) . '" class="breadcrumbs__link">' . get_the_time('F') . '</a></li>';
        echo '<li class="breadcrumbs__separator">' . $separator . '</li>';
        echo '<li class="breadcrumbs__item">' . get_the_time('d') . '</li>';
    } elseif (is_month()) {
        echo '<li class="breadcrumbs__item"><a href="' . get_year_link(get_the_time('Y')) . '" class="breadcrumbs__link">' . get_the_time('Y') . '</a></li>';
        echo '<li class="breadcrumbs__separator">' . $separator . '</li>';
        echo '<li class="breadcrumbs__item">' . get_the_time('F') . '</li>';
    } elseif (is_year()) {
        echo '<li class="breadcrumbs__item">' . get_the_time('Y') . '</li>';
    } elseif (is_author()) {
        $author = get_userdata(get_query_var('author'));
        echo '<li class="breadcrumbs__item">' . $author->display_name . '</li>';
    } elseif (is_search()) {
        echo '<li class="breadcrumbs__item">' . __('Wyniki wyszukiwania dla: ', 'textdomain') . get_search_query() . '</li>';
    } elseif (is_404()) {
        echo '<li class="breadcrumbs__item">' . __('Błąd 404', 'textdomain') . '</li>';
    }

    echo '</ul>';
}
