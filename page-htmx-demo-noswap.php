<?php
// No direct access
if (!defined('ABSPATH')) exit;

get_header();

global $wp_query;

$hxtheme_data = $wp_query->hxtheme_data;
?>
<main id="content" <?php post_class('container content-area'); ?>>
	<section class="page-content post-content" role="main">
		<h3><?php _e($hxtheme_data['title'], 'hxtheme'); ?></h3>
		<p><?php _e($hxtheme_data['description'], 'hxtheme'); ?></p>

		<p>
			<button id="trigger-demo" hx-get="<?php echo hxwp_api_url($hxtheme_data['path']); ?>" hx-swap="none" hx-vals='{"action": "demo", "crash": "dummy"}' hx-disabled-elt="this" hx-indicator=".spinner">Click to send data</button>
		<div class="spinner htmx-indicator"></div>
		</p>
		<p>
			<?php _e('We will receive a response as a Header Response at "Hx-Trigger". Open the browser console to see the response (Network tab).', 'hxtheme'); ?>
		</p>
		<p>
			<?php _e('Response should look like this:', 'hxtheme'); ?>
			<code>
				Hx-Trigger:
				{"hxwpResponse":{"action":"none","status":"success","data":{"message":"Server-side processing done.","params":{"action":"demo","crash":"dummy"}}}}
			</code>
		</p>
		<p>
			<?php _e('We can access the response in the browser console with:', 'hxtheme'); ?>
			<code>
				document.body.addEventListener('hxwpResponse', (event) => {
				console.log(event.detail);
				});
			</code>
			<script>
				document.body.addEventListener('hxwpResponse', (event) => {
					if (event.detail.action === 'alert') {
						alert(event.detail.data.message);
					}
				});
			</script>
		</p>
		<p>
			<?php _e('In this example, a browser alert will show the message from the response.', 'hxtheme'); ?>
		</p>
	</section>
</main>
<?php
get_footer();
