<?php  if (!defined('ABSPATH')) exit;


// Block users rest api informations
add_filter('rest_endpoints', function ($endpoints) {
    // Sprawdzenie czy istnieje endpoint dla użytkowników
    if (isset($endpoints['/wp/v2/users'])) {
        unset($endpoints['/wp/v2/users']);
    }
    
    // Możesz również usunąć dostęp do szczegółów pojedynczego użytkownika
    if (isset($endpoints['/wp/v2/users/(?P<id>[\d]+)'])) {
        unset($endpoints['/wp/v2/users/(?P<id>[\d]+)']);
    }

    return $endpoints;
});


// Turn off XML-RPC
add_filter('xmlrpc_enabled', '__return_false');

add_action('init', function() {
    if (isset($_SERVER['REQUEST_URI']) && strpos($_SERVER['REQUEST_URI'], 'xmlrpc.php') !== false) {
        wp_die('XML-RPC is disabled on this site.');
    }
});


// Turn off pingbacks
add_filter('xmlrpc_methods', function($methods) {
    unset($methods['pingback.ping']);
    return $methods;
});

// Turn off remote pingbacks
add_filter('wp_headers', function($headers) {
    unset($headers['X-Pingback']);
    return $headers;
}, 10, 2);

// Remove wordpress version
remove_action('wp_head', 'wp_generator');

// Remove wordpress version from RSS
add_filter('the_generator', '__return_empty_string');

// Function to limit login attempts
function limit_login_attempts() {
    session_start();

    // Set the limit of login attempts
    $max_attempts = 5;
    $lockout_time = 30 * 60; // 30 minutes

    // Initialize the login attempts session if it doesn't exist
    if (!isset($_SESSION['login_attempts'])) {
        $_SESSION['login_attempts'] = 0;
    }

    // Initialize the lockout session if it doesn't exist
    if (!isset($_SESSION['lockout'])) {
        $_SESSION['lockout'] = false;
    }

    // Check if the user is still locked out
    if ($_SESSION['lockout'] && time() < $_SESSION['lockout_time']) {
        wp_die('Too many failed login attempts. Please try again in 30 minutes.');
    }

    // Reset the login attempt count after the lockout period has expired
    if ($_SESSION['lockout'] && time() >= $_SESSION['lockout_time']) {
        $_SESSION['login_attempts'] = 0;
        $_SESSION['lockout'] = false;
    }

    // Check if the form was submitted and if attempts exceeded
    if (isset($_POST['wp-submit']) && $_SESSION['login_attempts'] >= $max_attempts) {
        $_SESSION['lockout'] = true;
        $_SESSION['lockout_time'] = time() + $lockout_time;
        wp_die('Too many failed login attempts. Please try again in 30 minutes.');
    } elseif (isset($_POST['wp-submit'])) {
        // Check if the user exists
        $user = get_user_by('login', $_POST['log']);
        if ($user) {
            // Validate password
            if (!wp_check_password($_POST['pwd'], $user->data->user_pass, $user->ID)) {
                $_SESSION['login_attempts']++;
            }
        } else {
            // User does not exist, increment login attempts
            $_SESSION['login_attempts']++;
        }
    }
}

// Add the function to the login form action hook
add_action('login_form', 'limit_login_attempts');

// Turn off edit files in administration
define('DISALLOW_FILE_EDIT', true);