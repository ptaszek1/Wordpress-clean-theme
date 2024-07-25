<?php if (!defined('ABSPATH')) exit;
/**
 * project-name functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage project-name
 * @since 1.0.0
 */

/**
 * Works in WordPress 5.7 or later.
 */

// Set correct timezone:
date_default_timezone_set('Europe/Warsaw');

// Block Website - Maintenance
// require_once(get_template_directory() . '/includes/maintenance.php');

// Custom scripts/css and remove unused elements:
require_once(get_template_directory() . '/includes/scripts.php');

// Gutenberg blocks connected with ACF: - do not uncomment if you don't use ACF blocks
// require_once(get_template_directory() . '/includes/blocks.php');

// Include custom post types and taxonomies:
// require_once(get_template_directory() . '/includes/custom-types.php');

// Breadcrumb method
require_once(get_template_directory() . '/includes/breadcrumb.php');

// Method to change url in to svg files.
require_once(get_template_directory() . '/includes/get-svg-content.php');