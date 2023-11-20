<?php if (!defined('ABSPATH')) exit;

/**
 * Registers a new category for projectname templates.
 *
 * This function is used to add a new category called "projectname Templates" to the block editor.
 * It is hooked into the 'block_categories_all' filter to modify the list of available block categories.
 *
 * @param array    $categories An array of existing block categories.
 * @param WP_Post  $post       The current post object.
 * @return array               The modified array of block categories.
 */
function projectname_block_categories($categories, $post)
{
    $new_category = array(
        array(
            'slug' => 'projectname-templates',
            'title' => __('projectname Templates', 'projectname'),
        ),
    );

    return array_merge($new_category, $categories);
}
add_filter('block_categories_all', 'projectname_block_categories', 10, 2);


/**
 * Registers ACF block types.
 *
 * This function registers custom ACF block types for the WordPress theme.
 * Each block type is defined with its name, title, description, template file path,
 * icon, keywords, and other properties.
 *
 * @since 1.0.0
 */
function register_acf_block_types()
{
    // Array of block types
    $block_types = [
        [
            'name'            => 'BLOCKNAME',
            'title'           => __('Hero Bar'),
            'description'     => __('Open section with subtitle, title, button, and 2 images.'),
            'render_template' => 'blocks/BLOCKNAME/BLOCKNAME.php',
            'icon'            => 'admin-comments',
            'keywords'        => ['BLOCKNAME', 'BLOCKNAME'],
            'enqueue_style'   => 'blocks/BLOCKNAME/BLOCKNAME.css',
        ],
    ];

    // Register each block type
    foreach ($block_types as $block) {
        acf_register_block_type(array(
            'name'            => $block['name'],
            'title'           => $block['title'],
            'description'     => $block['description'],
            'render_template' => $block['render_template'],
            'render_callback' => 'my_acf_block_render_callback',
            'category'        => 'projectname-templates',
            'icon'            => $block['icon'],
            'keywords'        => $block['keywords'],
            'mode'            => 'false',
            'supports'        => [
                'align'           => false,
                'anchor'          => true,
                'customClassName' => true,
                'jsx'             => true,
            ],
            'example'  => array(
                'attributes' => array(
                    'mode' => 'preview',
                    'data' => array(
                        'is_preview' => true,
                    ),
                ),
            ),
            'enqueue_assets'  => function () use ($block) {
                if (is_admin()) {
                    wp_enqueue_style('block-' . $block['name'], get_template_directory_uri() . '/' . $block['enqueue_style']);
                    wp_enqueue_script('block-' . $block['name'], get_template_directory_uri() . '/' . $block['enqueue_script'], [], false, true);
                }
            },
        ));
    }
}

// Hook into ACF initialization
add_action('acf/init', 'register_acf_block_types');

/**
 * Callback function for rendering ACF blocks.
 *
 * @param array $block The ACF block data.
 * @return void
 */
function my_acf_block_render_callback($block)
{
    $slug = str_replace('acf/', '', $block['name']);
    if (file_exists(get_theme_file_path("/blocks/{$slug}/{$slug}.php"))) {
        include(get_theme_file_path("/blocks/{$slug}/{$slug}.php"));
    }
}
