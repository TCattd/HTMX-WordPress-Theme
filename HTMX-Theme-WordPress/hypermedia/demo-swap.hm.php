<?php
// No direct access.
defined('ABSPATH') || exit('Direct access not allowed.');

// Secure it.
if (!hm_validate_request($hmvals, 'demo')) {
    hm_die(__('Invalid request.', 'hxtheme'));
}

// Loaded file
$hm_template = '/' . wp_get_theme()->get_stylesheet() . strstr(__FILE__, '/' . HMAPI_TEMPLATE_DIR);
?>

<article>
	<header>
		<h5><?php esc_html_e('Hello HTMX!', 'hxtheme'); ?></h5>
	</header>
	<p><?php esc_html_e('Non consequat aliquip, lorem duis exercitation. Laborum ad culpa voluptate duis occaecat dolore.', 'hxtheme'); ?></p>
	<footer>
		<?php esc_html_e('End of template', 'hxtheme'); ?>
	</footer>
</article>

<hr>

<p><?php esc_html_e('Template loaded from', 'hxtheme'); ?> <code><?php echo esc_html($hm_template); ?></code></p>

<p><?php esc_html_e('Received params ($hmvals):', 'hxtheme'); ?></p>

<pre>
<?php var_dump($hmvals); ?>
</pre>
