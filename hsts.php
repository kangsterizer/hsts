<?php
/**
 * @package HSTS
 * @version 2.0
 */
/*
Plugin Name: HSTS - HTTP Strict Transport Security enforcement plugin
Author: kang@insecure.ws
Version: 2.0
Author URI: https://www.insecure.ws
*/

function hsts_header()
{
	$options = get_option('hsts_settings_section');
	$maxage = 604800;
	$subdomains = '';

	if (is_numeric($options['hsts_maxage_setting']))
		$maxage = $options['hsts_maxage_setting'];
	if ($options['hsts_subdomains_setting'] == 'on')
		$subdomains = 'includeSubDomains';
	if (isset($_SERVER['HTTPS']))
		header("Strict-Transport-Security: max-age=$maxage; $subdomains");
	else if ($options['hsts_redirect_setting']) {
		header('Location: https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], true, 301);
	}
}

add_action('send_headers', 'hsts_header');

/* Settings */

function hsts_settings_api_init()
{
	add_settings_section('hsts_settings_section', 'HSTS', 'hsts_settings_section_cb', 'general');
	add_settings_field('hsts_maxage_setting', 'HSTS max-age setting', 'hsts_maxage_cb', 'general', 'hsts_settings_section');
	add_settings_field('hsts_subdomains_setting', 'HSTS include Sub Domains setting', 'hsts_subdomains_cb', 'general', 'hsts_settings_section');
	add_settings_field('hsts_redirect_setting', 'HSTS redirect setting', 'hsts_redirect_cb', 'general', 'hsts_settings_section');
	register_setting('general', 'hsts_settings_section', 'hsts_settings_validate');
}

add_action('admin_init', 'hsts_settings_api_init');

function hsts_settings_section_cb()
{
	echo '<p>HSTS settings</p>';
}

function hsts_maxage_cb()
{
	$options = get_option('hsts_settings_section');
	echo "<input id='hsts_maxage_setting' name='hsts_settings_section[hsts_maxage_setting]' size='40' type='text' value='{$options['hsts_maxage_setting']}' /> <em>Tell the browser how long you want to enforce HTTPS (timeout), in seconds</em>";
}

function hsts_subdomains_cb()
{
	$options = get_option('hsts_settings_section');
	if($options['hsts_subdomains_setting']) { $checked = ' checked="checked" '; }
		echo "<input ".$checked." id='hsts_subdomains_setting' name='hsts_settings_section[hsts_subdomains_setting]' type='checkbox' /> <em>If set, visiting your blog will enforce HSTS to all your subdomains as well</em>";
}

function hsts_redirect_cb()
{
	$options = get_option('hsts_settings_section');
	if($options['hsts_redirect_setting']) { $checked = ' checked="checked" '; }
		echo "<input ".$checked." id='hsts_redirect_setting' name='hsts_settings_section[hsts_redirect_setting]' type='checkbox' /> <em>If set, redirects users browsing with HTTP to HTTPS (this does not secure the HTTP request of course, but all subsequent requests will be done via HTTPS if the browser has HSTS support.</em>";
}

function hsts_settings_validate($input)
{
	$input['hsts_redirect_setting'] = ( $input['hsts_redirect_setting'] == 1 ? 1 : 0);
	$input['hsts_subdomains_setting'] = ( $input['hsts_subdomains_setting'] == 1 ? 1 : 0);
	if (!is_numeric($input['hsts_maxage_setting']))
		$input['hsts_maxage_setting'] = '';
}
?>
