<?php if (!defined('ABSPATH')) exit;

get_header();

global $query_string;

wp_parse_str($query_string, $search_query);
$searchResults  = new WP_Query($search_query);
$searchValue    = '';
$results        = 0;


if (!empty($searchResults->query['s'])) {
    $searchValue = $searchResults->query['s'];
}

if(!empty($searchResults)) {
    if(!empty($searchResults->posts)) {
        $results = count($searchResults->posts);
    }
}

if (empty($search_query['s'])) {
    $results = 0;
}

?>

<div class="search-results">
    <div class="search-results__top">
        <div class="search-results__top-form">
            <div class="search-not-found no-results">
                <div class="no-results-content">
                    <form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" class="search-form">
                        <input type="search" class="search-field" placeholder="<?=$inputText ?>" value="<?php if(!empty($searchValue)): ?><?=$searchValue ?><?php endif; ?>" name="s" title="Search for:">
                        <button type="submit" class="search-submit" title="Search"></button>
                    </form>
                </div>
            </div>
        </div>
        <?php if(!empty($searchValue)): ?>
            <div class="search-results__top-title">
                Search results for a phrase: <span><?=$searchValue ?></span>
            </div>
        <?php endif; ?>
    </div>
    <?php if($results > 0): ?>
        <div class="search-results__items">
            <?php foreach($searchResults->posts as $searchItem): ?>
                Results Item
            <?php endforeach; ?>
        </div>
        <div class="search-results__pagination">
            
        </div>
    <?php else: ?>
        <div class="search-results__no-results">
            <?php if($searchValue === ''): ?>
                Use the search form above to find the content you are interested in.
            <?php else: ?>
                Sorry, but nothing matches your search terms. Please try again with other keywords.
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>

<?php

get_footer();

?>