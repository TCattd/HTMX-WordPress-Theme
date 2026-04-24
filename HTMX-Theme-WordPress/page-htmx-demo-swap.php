<?php
// No direct access
if (!defined('ABSPATH')) exit;

get_header();

global $wp_query;

$hxtheme_data = $wp_query->hxtheme_data;
?>
<main id="content" <?php post_class('container content-area'); ?>>
	<section class="page-content post-content" role="main">
		<h3><?php echo esc_html__($hxtheme_data['title'], 'hxtheme'); ?></h3>
		<p><?php echo esc_html__($hxtheme_data['description'], 'hxtheme'); ?></p>

		<p>
			<button id="trigger-demo"
					hx-get="<?php echo hm_get_endpoint_url($hxtheme_data['path']); ?>"
					hx-vals='{"action": "demo"}'
					hx-headers='{"X-WP-Nonce": "<?php echo wp_create_nonce('hmapi_nonce'); ?>"}'
					hx-swap="innerHTML"
					hx-target="#hxtheme-demo-swap"
					hx-disabled-elt="this">
				<?php esc_html_e('Click to swap with response', 'hxtheme'); ?>
			</button>
		</p>
		<p>
		<div id="hxtheme-demo-swap">
			<code><?php esc_html_e('Kansas is going bye-bye', 'hxtheme'); ?></code>
		</div>
		</p>
	</section>
</main>
<?php
get_footer();
