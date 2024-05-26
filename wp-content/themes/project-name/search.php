<?php if (!defined('ABSPATH')) exit;

get_header();

wp_parse_str($query_string, $search_query);
$searchResults = new WP_Query($search_query);

?>

Error page

<?php

get_footer();

?>