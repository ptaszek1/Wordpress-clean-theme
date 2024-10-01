<?php if (!defined('ABSPATH')) exit;

// Dodaj funkcję do pliku functions.php
function estimated_reading_time($post_id = null) {
    // Jeśli ID posta nie zostało przekazane, użyj globalnego obiektu posta
    if (!$post_id) {
        global $post;
        $post_id = $post->ID;
    }
    
    // Pobierz treść posta
    $content = get_post_field('post_content', $post_id);
    
    // Oblicz liczbę słów w treści
    $word_count = str_word_count(strip_tags($content));
    
    // Przyjmij, że przeciętna prędkość czytania to 200 słów na minutę
    $reading_speed = 200;
    
    // Oblicz czas czytania w minutach
    $reading_time = ceil($word_count / $reading_speed);
    
    // Zwróć czas czytania w formacie "XX min"
    return $reading_time . ' min';
}