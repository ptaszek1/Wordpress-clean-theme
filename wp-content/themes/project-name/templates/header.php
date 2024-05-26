<?php if (!defined('ABSPATH')) exit; 

$args = array(
    'container'         => 'nav',
    'container_id'      => '',
    'container_class'   => '',
    'menu_class'        => 'header__menu',
    'depth'             => 5,
    'link_before'       => '<span>',
    'link_after'        => '</span>',
    'menu'              => 'header',
    'fallback_cb'       => false
);

?>

<header class="header">
    Header
    <?= wp_nav_menu($args) ?>
</header>