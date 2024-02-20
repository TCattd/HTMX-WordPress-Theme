<?php
// No direct access.
defined('ABSPATH') || exit('Direct access not allowed.');

// Check if nonce is valid.
if (!isset($_SERVER['HTTP_X_WP_NONCE']) || !wp_verify_nonce($_SERVER['HTTP_X_WP_NONCE'], 'hxwp_nonce')) {
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
