<?php if (!defined('ABSPATH')) exit;

get_header();
?>

<section class="page-error__section error-404 not-found">
    <div class="page-error__header">
        <h1 class="page-error__code"><?php _e('404', 'textdomain'); ?></h1>
        <h2 class="page-error__title"><?php _e('Ups! Nie możemy znaleźć tej strony.', 'textdomain'); ?></h2>
    </div>

    <div class="page-error__content">
        <p class="page-error__message">
            <?php _e('Podana strona nie istnieje, przejdź na', 'textdomain'); ?>
            <a href="<?php echo esc_url(home_url('/')); ?>" class="page-error__link"><?php _e('stronę główną', 'textdomain'); ?></a>
            <?php _e('lub skorzystaj z formularza poniżej.', 'textdomain'); ?>
        </p>

        <div class="page-error__search">
            <?php get_search_form(); ?>
        </div>
    </div>
</section>

<?php
get_footer();
?>