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
					hx-swap="none"
					hx-vals='{"action": "demo", "crash": "dummy"}'
					hx-headers='{"X-WP-Nonce": "<?php echo wp_create_nonce('hyperpress_nonce'); ?>"}'
					hx-disable="this"
					hx-indicator=".spinner">
				<?php esc_html_e('Click to send data', 'hxtheme'); ?>
			</button>
		<div class="spinner htmx-indicator"></div>
		</p>
		<p>
			<?php esc_html_e('We will receive a response as a Header Response at "HX-Trigger". Open the browser console to see the response (Network tab).', 'hxtheme'); ?>
		</p>
		<p>
			<?php esc_html_e('Response should look like this:', 'hxtheme'); ?>
			<code>
				HX-Trigger:
				{"hyperpressResponse":{"action":"alert","status":"success","data":{"message":"<?php esc_attr_e('Server-side processing done.', 'hxtheme'); ?>","params":{"action":"demo","crash":"dummy"}}}}
			</code>
		</p>
		<p>
			<?php esc_html_e('We can access the response in the browser console with:', 'hxtheme'); ?>
			<code>
				document.addEventListener('hyperpressResponse', (event) => {
				console.log(event.detail);
				}, true);
			</code>
			<script>
				document.addEventListener('hyperpressResponse', (event) => {
					if (event.detail.action === 'alert') {
						alert(event.detail.data.message);
					}
				}, true);
			</script>
		</p>
		<p>
			<?php esc_html_e('htmx 4 events do not bubble to the body: listen on document with capture.', 'hxtheme'); ?>
		</p>
	</section>
</main>
<?php
get_footer();
