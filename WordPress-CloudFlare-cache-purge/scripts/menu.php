<?php

function wccp_menu() {
	add_menu_page ( 'CloudFlare Cache Purge', 'CloudFlare Purge', 'manage_options', 'cloudflare-cache-purge', 'wccp_options' );
}

add_action( 'admin_menu' , 'wccp_menu');