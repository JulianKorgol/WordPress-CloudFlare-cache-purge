<?php

function wccp_menu()
{
    add_menu_page('CloudFlare Cache Purge', 'CloudFlare Purge', 'manage_options', 'cloudflare-cache-purge', 'wccp_purge');
}

add_action('admin_menu', 'wccp_menu');

// function of WordPress settings page
function wccp_purge()
{
    if (!current_user_can('manage_options')) {
        wp_die(__('You do not have sufficient permissions to access this page'));
    }

    if ('save' == $_REQUEST['action']) {
        $result = wccp_remove_cache();
        if ($result->success == true) {
            echo '<div class="notice updated">
			      <p>The cache has been removed.</p>
		           </div>';
        } else {
            echo '<div class="notice notice-error">
			      <p>There was an error while cache removing' . $result->errorStr . '</p>
		          </div>';
        }

        ?>

        <?php
    }

    ?>
    <form method="post" class="wccpDeleteCache post">
        <input type="hidden" name="action" value="save">
        <input type="submit" class="button button-primary" value="Delete Cache">
    </form>
    <?php
}

?>