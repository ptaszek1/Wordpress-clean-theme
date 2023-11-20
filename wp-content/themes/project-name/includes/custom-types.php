<?php if (!defined('ABSPATH')) exit;


/**
 * Creates a custom post type called 'name'.
 *
 * This function registers a custom post type with the name 'name' and sets various options for it.
 * The post type supports features like title, thumbnail, revisions, comments, and editor.
 * It can be used publicly, exported to a file, and managed by users with appropriate capabilities.
 * It also enables the Gutenberg editor and assigns the 'dashicons-groups' icon to the post type menu.
 * The post type is associated with the 'category' taxonomy.
 *
 * @since 1.0.0
 */

add_action('init', 'create_custom_post_types', 8);
function create_custom_post_types()
{
    register_post_type('name', [ // name of the post type
        'labels' => [
            'name' => __('name'), // general name for the post type, usually plural
            'singular_name' => __('Name'), // name for one object of this post type
            'add_new' => __('Add new Name'), // the add new text
        ],
        'public' => TRUE, // whether the post type is intended to be used publicly
        'rewrite' => [
            'slug' =>  __('name'), // the slug for permalinks
            'with_front' => FALSE // whether the permalink should be prepended with the front base
        ],
        'supports' => ['title', 'thumbnail', 'revisions', 'comments', 'editor'], // what features are supported in the post editor
        'can_export' => TRUE, // enable export to file
        'map_meta_cap' => TRUE, // enable capability to manage the post type
        'show_in_rest' => TRUE, // enable Gutenberg editor
        'menu_icon' => 'dashicons-groups', // icon for the post type menu
        'taxonomies' => array('category'), // taxonomies assigned to the post type
        'description' => __('Description of the post type'), // description of the post type
        'menu_position' => 5, // position in the menu order
        'publicly_queryable' => true, // whether queries can be performed on the front end
        'has_archive' => true, // whether the post type has an archive page
        'exclude_from_search' => false, // whether to exclude posts with this post type from front end search results
        'capability_type' => 'post', // the string to use to build the read, edit, and delete capabilities
    ]);
}
