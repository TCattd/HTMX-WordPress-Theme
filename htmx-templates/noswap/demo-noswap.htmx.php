<?php
// No direct access.
defined('ABSPATH') || exit('Direct access not allowed.');

// Secure it.
$hxwp_nonce = sanitize_key($_SERVER['HTTP_X_WP_NONCE']);

// Check if nonce is valid.
if (!isset($hxwp_nonce) || !wp_verify_nonce(sanitize_text_field(wp_unslash($hxwp_nonce)), 'hxwp_nonce')) {
	hxwp_die('Nonce verification failed.');
}

// Action = demo
if (!isset($hxvals['action']) || $hxvals['action'] != 'demo') {
	hxwp_die('Invalid action.');
}

// Do some server-side processing with the received $hxvals
sleep(5); // Fake it until you make it

// Send our response
hxwp_send_header_response(
	'success', // status: success|error|silent-sucess
	[
		'message' => 'Server-side processing done.',
		'params'  => $hxvals,
	],
	'alert' // optional
);
