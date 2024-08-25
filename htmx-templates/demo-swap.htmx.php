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

// Loaded file
$htmx_template = '/' . wp_get_theme()->get_stylesheet() . strstr(__FILE__, '/htmx-templates');
?>

<article>
	<header>
		<h5>Hello HTMX!</h5>
	</header>
	<p>Non consequat aliquip, lorem duis exercitation. Laborum ad culpa voluptate duis occaecat dolore.</p>
	<footer>
		End of template
	</footer>
</article>

<hr>

<p>Template loaded from <code><?php echo $htmx_template; ?></code></p>

<p>Received params ($hxvals):</p>

<pre>
<?php var_dump($hxvals); ?>
</pre>
