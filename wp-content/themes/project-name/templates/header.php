<?php if (!defined('ABSPATH')) exit; 

$menu_args = array(
    'theme_location'    => 'primary',
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
        <div class="header__burger burger-js">
            <div class="header__burger-line"></div>
            <div class="header__burger-line"></div>
            <div class="header__burger-line"></div>
        </div>
    </div>
</header>
<?php

$args['container'] = 'div';
$args['container_class'] = 'burger-menu__menu';
$args['menu_class'] = 'burger-menu__menu';

?>
<div class="burger-menu">
    <div class="burger-menu__top">
        <div class="burger-menu__top-logo">
            Burger LOGO
        </div>
    </div>
    <?= wp_nav_menu($header_menu_args) ?>
</div>