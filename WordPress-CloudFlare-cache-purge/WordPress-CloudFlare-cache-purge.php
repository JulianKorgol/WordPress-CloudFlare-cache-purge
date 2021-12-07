<?php
/**
 * Plugin Name: CloudFlare cache purge
 * Plugin URI: https://github.com/JulianKorgol/WordPress-CloudFlare-cache-purge
 * Description: This plugin allow you to purge CloudFlare Cache by API.
 * Version: 1.1
 * Author: Julian Korgol, Mikołaj Mroczkowski
 * Author URI: https://github.com/JulianKorgol/WordPress-CloudFlare-cache-purge
 * License:     Apache License 2.0
 * License URI: https://github.com/JulianKorgol/WordPress-CloudFlare-cache-purge/blob/main/LICENSE
 */

include_once('scripts/menu.php');
include_once('scripts/menu-removecache.php');

function wccp_remove_cache() {
    $extensions = get_loaded_extensions();
    if(!in_array('curl',$extensions)){
        die("<div class='notice notice-error'><b>You need to install php-curl!</b></div>");
    }
    $authKey = get_option('wccpCloudflareAuthKey');
    $zone = get_option('wccpCloudflareZone');
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://api.cloudflare.com/client/v4/zones/'.$zone.'/purge_cache');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"purge_everything\":true}");
    $headers = array();
    $headers[] = 'Authorization: Bearer '.$authKey;
    $headers[] = 'Content-Type: application/json';
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $json = curl_exec($ch);
    curl_close($ch);
    $obj = json_decode($json);
    $msg = new stdClass();
    if($obj->success==true){
        $msg->success = true;
    }
    else{
        $msg->success = false;
        $errStr = "";
        foreach($obj->errors as $err){
            $errStr .= "<br><strong>".$err->code."</strong>: ".$err->message;
            $errStr .= $errStr;
        }
        $msg->errorStr = $errStr;
    }
    return $msg;
}