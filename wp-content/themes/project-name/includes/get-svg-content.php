<?php if (!defined('ABSPATH')) exit;

// Transform file link in to svg or return img tag if not svg
function getSvgContent($url)
{
    // Sprawdź, czy plik jest SVG
    if (pathinfo($url, PATHINFO_EXTENSION) !== 'svg') {
        // Zwróć tag img
        return '<img src="' . esc_url($url) . '" alt="Image">';
    }

    // Pobierz lokalną ścieżkę pliku z URL
    $upload_dir = wp_upload_dir();
    $base_url = $upload_dir['baseurl'];
    $base_dir = $upload_dir['basedir'];
    $file_path = str_replace($base_url, $base_dir, $url);

    if (!file_exists($file_path)) {
        return; // Error: The file does not exist.
    }

    $doc = new DOMDocument();
    libxml_use_internal_errors(true); // Umożliwia przechwytywanie błędów XML
    if (!$doc->load($file_path)) {
        $errors = libxml_get_errors();
        libxml_clear_errors();
        return 'Error: Failed to load SVG file. ' . print_r($errors, true);
    }

    // Pobierz zawartość elementu SVG
    $svg = $doc->getElementsByTagName('svg')->item(0);
    if ($svg === null) {
        return; // Error: No SVG element found in the file.
    }

    // Zwróć zmodyfikowane SVG bez deklaracji XML
    return $doc->saveXML($svg);
}