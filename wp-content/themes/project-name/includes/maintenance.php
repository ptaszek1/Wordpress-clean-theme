<?php if (!defined('ABSPATH')) exit;

function maintenance_mode()
{
    if (!is_user_logged_in()) {
        echo '<div style="position:fixed;top:0;left:0;width:100%;height:100%;display:flex;justify-content:center;background-color:#f2f2f2;">
                <img src="IMAGE" alt="Site Under Construction" style="max-width:350px;">
              </div>';
        exit();
    }
}
add_action('get_header', 'maintenance_mode');
