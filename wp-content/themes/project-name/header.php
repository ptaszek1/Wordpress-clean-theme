<?php if (!defined('ABSPATH')) exit; ?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <?php wp_head(); ?>
</head>

<?php
global $wp_query;
$panelClass = (!empty($wp_query->query) && !empty($wp_query->query['pagename']) && strpos($wp_query->query['pagename'], 'panel') !== false) ? 'body-panel' : '';
?>

<body <?php body_class($panelClass); ?>>
    <?php
    get_template_part('templates/header');
    ?>

    <main class="main">