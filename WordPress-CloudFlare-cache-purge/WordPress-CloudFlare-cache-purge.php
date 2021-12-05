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
    $email = get_option('wccpCloudflareEmail');
    $authKey = get_option('wccpCloudflareAuthKey');
    $zone = get_option('wccpCloudflareZone');
    $json =  shell_exec('curl -X POST "https://api.cloudflare.com/client/v4/zones/'.$zone.'/purge_cache" -H "X-Auth-Email: '.$email.'" -H "X-Auth-Key: '.$authKey.'" -H "Content-Type: application/json" --data '."'".'{"purge_everything":true}'."'");
    $obj = json_decode($json);
    if($obj->success){
        return $obj;
    }
    else{
        $msg = new stdClass();
        $msg->success = false;
        $errStr = "";
        foreach($obj->errors as $err){
            $errStr .= "<br><strong>".$err->code."</strong>: ".$err->message;
            $errStr .= $errStr;
        }
        $msg->errorStr = $errStr;
        return $msg;
    }
}