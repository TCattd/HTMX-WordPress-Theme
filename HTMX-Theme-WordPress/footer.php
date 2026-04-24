<?php
// No direct access
if (!defined('ABSPATH')) exit;
?>

<footer class="container">
	<p><?php
		printf(
			esc_html__('Powered by %s', 'hxtheme'),
			'<a href="https://github.com/EstebanForge/HyperPress" target="_blank">' .
			esc_html__('HyperPress', 'hxtheme') .
			'</a>'
		);
	?></p>
</footer>

<?php wp_footer(); ?>
</body>

</html>
