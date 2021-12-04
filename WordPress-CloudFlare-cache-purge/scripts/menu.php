<?php

function wccp_menu_settings() {
	add_menu_page ( 'CloudFlare Cache Purge Settings', 'CloudFlare Purge Settings', 'manage_options', 'cloudflare-cache-purge-settings', 'wccp_options' );
}

add_action( 'admin_menu' , 'wccp_menu_settings');

// function of WordPress settings page
function wccp_options() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( __('You do not have sufficient permissions to access this page') );
	}

	if ( 'save' == $_REQUEST['action'] ) {
		update_option( 'wccpCloudflareEmail', $_REQUEST['wccpCloudflareEmail'] );
		update_option( 'wccpCloudflareAuthKey', $_REQUEST['wccpCloudflareAuthKey'] );
		update_option( 'wccpCloudflareZone', $_REQUEST['wccpCloudflareZone'] );
		?>
		<div class="notice updated">
			<p>All changes have been saved</p>
		</div>
		<?php
	}

	?>

	<div class="wccpOptionsPost">
		<form method="post" class="wccpOptions post">
			<h2>CloudFlare Cache Purge Settings</h2>
			<div class="wccpOptionsHeader postbox">
				<h3>Your CloudFlare e-mail</h3>
				<input type="text" name="wccpCloudflareEmail" value="<?php echo get_option("wccpCloudflareEmail"); ?>">
				<h3>Your CloudFlare Auth Key</h3>
				<input type="text" name="wccpCloudflareAuthKey" value="<?php echo get_option("wccpCloudflareAuthKey"); ?>">
				<h3>Your CloudFlare zone</h3>
				<input type="text" name="wccpCloudflareZone" value="<?php echo get_option("wccpCloudflareZone"); ?>">
			</div>

			<input type="hidden" name="action" value="save">
			<input type="submit" class="button button-primary" value="Save changes">
		</form>
	</div>
<?php
}
?>