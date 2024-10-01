<?php if (!defined('ABSPATH')) exit; 

$footer_menu_args = array(
    'theme_location'    => 'footer',
    'container'         => 'div',
    'container_id'      => '',
    'container_class'   => '',
    'menu_class'        => 'footer-menu',
    'depth'             => 5,
    'link_before'       => '<span>',
    'link_after'        => '</span>',
    'menu'              => 'footer',
    'fallback_cb'       => false
);

// Use method below if need menu on footer:
// wp_nav_menu($footer_menu_args)

?>

<footer class="footer">
    Footer
</footer>