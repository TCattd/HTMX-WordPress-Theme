<?php
// No direct access.
defined('ABSPATH') || exit('Direct access not allowed.');

// Secure it.
if (!hm_validate_request($hmvals, 'demo')) {
	hm_die(__('Invalid request.', 'hxtheme'));
}

// Do some server-side processing with the received $hmvals
sleep(3); // Fake it until you make it

// Send our response
hm_send_header_response(
	[
		'status'  => 'success',
		'message' => __('Server-side processing done.', 'hxtheme'),
		'params'  => $hmvals,
	],
	'alert' // action for triggering alert
);
