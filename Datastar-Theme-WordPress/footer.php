<?php
// No direct access
if (!defined('ABSPATH')) exit;
?>

<footer class="container">
	<p><?php
		printf(
			esc_html__('Powered by %s', 'datastar-theme'),
			'<a href="https://github.com/EstebanForge/HyperPress" target="_blank">' .
			esc_html__('HyperPress', 'datastar-theme') .
			'</a>'
		);
	?></p>
</footer>

<?php wp_footer(); ?>
</body>

</html>
