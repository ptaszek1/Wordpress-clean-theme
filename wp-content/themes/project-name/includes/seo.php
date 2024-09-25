<?php if (!defined('ABSPATH')) exit; 

function my_seo_meta_box() {
    add_meta_box(
        'seo_meta_box_id',           // Unikalny ID Meta Boxa
        'SEO Meta Informacje',       // Tytuł Meta Boxa
        'my_seo_meta_box_html',      // Funkcja wyświetlająca zawartość
        'page',                      // Ekran, na którym ma się pojawić (np. 'post', 'page')
        'side',                    // Pozycja ('normal', 'side', 'advanced')
        'high'                       // Priorytet
    );
}
add_action('admin_init', 'my_seo_meta_box');


function my_seo_meta_box_html($post) {
    $meta_title = get_post_meta($post->ID, '_seo_meta_title', true);
    $meta_description = get_post_meta($post->ID, '_seo_meta_description', true);
    $meta_image = get_post_meta($post->ID, '_seo_meta_image', true);
    ?>
    <p>
        <label for="seo_meta_title">Meta Title:</label><br>
        <input type="text" id="seo_meta_title" name="seo_meta_title" value="<?php echo esc_attr($meta_title); ?>" size="50" />
    </p>
    <p>
        <label for="seo_meta_description">Meta Description:</label><br>
        <textarea id="seo_meta_description" name="seo_meta_description" rows="4" cols="50"><?php echo esc_textarea($meta_description); ?></textarea>
    </p>
    <p>
        <label for="seo_meta_image">Meta Image URL:</label><br>
        <input type="text" id="seo_meta_image" name="seo_meta_image" value="<?php echo esc_attr($meta_image); ?>" size="50" />
    </p>
    <?php
}

function my_save_seo_meta_box_data($post_id) {
    if (array_key_exists('seo_meta_title', $_POST)) {
        update_post_meta(
            $post_id,
            '_seo_meta_title',
            sanitize_text_field($_POST['seo_meta_title'])
        );
    }
    
    if (array_key_exists('seo_meta_description', $_POST)) {
        update_post_meta(
            $post_id,
            '_seo_meta_description',
            sanitize_textarea_field($_POST['seo_meta_description'])
        );
    }

    if (array_key_exists('seo_meta_image', $_POST)) {
        update_post_meta(
            $post_id,
            '_seo_meta_image',
            esc_url_raw($_POST['seo_meta_image'])
        );
    }
}
add_action('save_post', 'my_save_seo_meta_box_data');