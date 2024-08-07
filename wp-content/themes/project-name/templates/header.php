<?php if (!defined('ABSPATH')) exit; 

$header_menu_args = array(
    'container'         => 'nav',
    'container_id'      => '',
    'container_class'   => '',
    'menu_class'        => 'header__wrapper-menu',
    'depth'             => 5,
    'link_before'       => '<span>',
    'link_after'        => '</span>',
    'menu'              => 'primary',
    'fallback_cb'       => false
);

?>

<header class="header">
    <div class="header__wrapper">
        <a href="<?= get_home_url() ?>" class="header__wprapper-logo" aria-label="<?php esc_attr_e('Strona główna', 'textdomain'); ?>">
            LOGO
        </a>
        <?= wp_nav_menu($header_menu_args) ?>
    </div>
</header>