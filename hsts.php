<?php
/**
 * @package HSTS
 * @version 1.0
 */
/*
Plugin Name: HSTS - HTTP Strict Transport Security enforcement plugin
Author: kang@insecure.ws
Version: 1.0
Author URI: https://www.insecure.ws
*/

function hsts_header()
{
	isset($_SERVER['HTTPS']) && header('Strict-Transport-Security: max-age=15768000; includeSubDomains');
}

add_action( 'send_headers', 'hsts_header' );

?>
