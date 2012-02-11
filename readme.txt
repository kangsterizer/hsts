=== Plugin Name ===
Contributors: kang
Donate link: http://insecure.ws/
Tags: security, ssl, tls, hsts
Requires at least: 3.0
Tested up to: 3.0
Stable tag: 2.0

HSTS is HTTP Strict Transport Security, a mean to enforce using SSL even if the user access the site through HTTP and not HTTPS.

Require a browser supporting HSTS such as Firefox.

== Description ==

See http://en.wikipedia.org/wiki/HTTP_Strict_Transport_Security

== Installation ==

1. Upload `plugin-name.php` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Check settings in the General settings section, HSTS
4. Done

== Changelog ==

= 2.0 =

Added option panel in general.
Can set Max-age, and includeSubDomains.
Can tell the plugin to perform the initial HTTPS redirect if required. Remember that this redirect can be spoofed since its in plaintext, so be careful.

= 1.0 =

First release

