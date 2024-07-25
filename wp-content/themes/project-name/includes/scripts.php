<?php if (!defined('ABSPATH')) exit;


/**
 * Enqueues the custom styles for the theme.
 */

add_action('wp_enqueue_scripts', 'ncmy_styles');
function ncmy_styles()
{
    wp_enqueue_style('custom', get_template_directory_uri() . '/style.css', false, '1.0.0');
    wp_deregister_style('wp-block-library');
}

/**
 * Enqueues the custom scripts for the theme.
 */

add_action('wp_enqueue_scripts', 'ncmy_scripts');
function ncmy_scripts()
{
    wp_enqueue_script('my-script', get_template_directory_uri() . '/assets/js/app.min.js', [], '0.0.3', true);
    wp_localize_script('my-script', 'myScript', [
        'ajaxurl'    => admin_url('admin-ajax.php'),
    ]);
}

/**
 * Removes default jQuery and other scripts from the frontend.
 *
 * This function is used as a filter for the 'wp_default_scripts' hook.
 * It removes the default jQuery script, wp-embed script, and wp-emoji-release script
 * from the frontend of the WordPress site.
 *
 * @param WP_Scripts $scripts The WP_Scripts object.
 * @return void
 */

add_filter('wp_default_scripts', 'change_default_jquery');

function change_default_jquery(&$scripts)
{
    if (!is_admin()) {
        $scripts->remove('jquery');
        $scripts->remove('wp-embed');
        $scripts->remove('wp-emoji-release');
    }
}

/**
 * This code snippet removes the emoji scripts and styles from the front-end of the WordPress website.
 * It checks if the current user is not in the admin area using the `is_admin()` function.
 * If the user is not in the admin area, it removes the action hooks responsible for printing the emoji detection script and styles.
 * This helps to optimize the website's performance by reducing unnecessary scripts and styles.
 */

if (!is_admin()) {
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');
}

/**
 * Disable automatic paragraph tags for Contact Form 7.
 *
 * This code snippet adds a filter to disable the automatic insertion of paragraph tags
 * around Contact Form 7 form elements. By returning false, it prevents Contact Form 7
 * from adding unnecessary paragraph tags to the form output.
 *
 * @since 1.0.0
 * @filter wpcf7_autop_or_not
 *
 * @return bool Whether to enable automatic paragraph tags for Contact Form 7 or not.
 */

add_filter('wpcf7_autop_or_not', '__return_false');

/**
 * Registers the navigation menus for the theme.
 *
 * This function registers two navigation menus: 'Primary Menu' and 'Footer Menu'.
 * These menus can be used in the theme templates to display navigation menus.
 *
 * @return void
 */

function custom_theme_setup()
{
    register_nav_menus(array(
        'primary' => esc_html__('Primary Menu'),
        'footer'  => esc_html__('Footer Menu'),
    ));
}
add_action('after_setup_theme', 'custom_theme_setup');

/**
 * Adds support for the title tag in the theme.
 *
 * This function enables the theme to generate the title tag dynamically,
 * which is important for SEO and accessibility purposes.
 *
 * @since 1.0.0
 */
add_theme_support('title-tag');



/**
 * Adds options pages and sub-pages using the Advanced Custom Fields plugin.
 * If the function 'acf_add_options_sub_page' exists, it adds a sub-page called 'Header & footer' under the main options page.
 * If the function 'acf_add_options_page' exists, it adds the main options page.
 * This is necessary for version 5 of the Advanced Custom Fields plugin.
 */

if (function_exists('acf_add_options_sub_page')) {
    if (function_exists('acf_add_options_page')) {
        acf_add_options_page(); // necessary for v.5 :-/
    }
    acf_add_options_sub_page('Header & footer');
}

/**
 * Enable SVG upload by adding SVG and SVGZ mime types to the allowed upload mimes.
 *
 * @param array $upload_mimes The array of allowed upload mimes.
 * @return array The modified array of allowed upload mimes.
 */

function enable_svg_upload($upload_mimes)
{
    $upload_mimes['svg'] = 'image/svg+xml';
    $upload_mimes['svgz'] = 'image/svg+xml';

    return $upload_mimes;
}
add_filter('upload_mimes', 'enable_svg_upload', 10, 1);

/**
 * Sets up image sizes for the theme.
 */
function wpis_image_sizes()
{
    add_theme_support('post-thumbnails');
    add_image_size('custom-size', 511, 446, true);
}

add_action('after_setup_theme', 'wpis_image_sizes');


// Hidden ACF fields in the administration - protect from customers accidentally destroying the website
function my_custom_admin_styles()
{
    echo '<style>
        #toplevel_page_edit-post_type-acf-field-group { display: none; }
    </style>';
}
add_action('admin_head', 'my_custom_admin_styles');