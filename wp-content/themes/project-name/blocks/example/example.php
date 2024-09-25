<?php if (!defined('ABSPATH')) exit; 

$anchor         = isset($block['anchor']) ? $block['anchor'] : '';
$className      = isset($block['className']) ? $block['className'] : '';
$wp_classes     = '';

if(!empty($className)) {
    $wp_classes = ' ' . $className;
}
?>

<section class="block-class-name<?=$wp_classes ?>" <?php if(!empty($anchor)): ?>id="<?=$anchor; ?>"<?php endif; ?>>

</section>