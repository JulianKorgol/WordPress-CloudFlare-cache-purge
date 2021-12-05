<?php
/**
 * Plugin Name: CloudFlare cache purge
 * Plugin URI: https://github.com/JulianKorgol/WordPress-CloudFlare-cache-purge
 * Description: This plugin allow you to purge CloudFlare Cache by API.
 * Version: 1.0
 * Author: Julian Korgol, Mikołaj Mroczkowski
 * Author URI: https://github.com/JulianKorgol/WordPress-CloudFlare-cache-purge
 * License:     Apache License 2.0
 * License URI: https://github.com/JulianKorgol/WordPress-CloudFlare-cache-purge/blob/main/LICENSE
 */

include_once('scripts/menu.php');
include_once('scripts/menu-removecache.php');

function wccp_remove_cache() {
    $authKey = get_option('wccpCloudflareAuthKey');
    $zone = get_option('wccpCloudflareZone');
    $json =  shell_exec('curl -X POST "https://api.cloudflare.com/client/v4/zones/'.$zone.'/purge_cache" -H "Authorization: Bearer '.$authKey.'" -H "Content-Type: application/json" --data '."'".'{"purge_everything":true}'."'");
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