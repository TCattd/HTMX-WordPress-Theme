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
			<button id="trigger-demo" hx-get="<?php echo hxwp_api_url($hxtheme_data['path']); ?>" hx-vals='{"action": "demo"}' hx-swap="innerHTML" hx-target="#hxtheme-demo-swap" hx-disabled-elt="this">Click to swap with response</button>
		</p>
		<p>
		<div id="hxtheme-demo-swap">
			<code><?php _e('Kansas is going bye-bye', 'hxtheme'); ?></code>
		</div>
		</p>
</main>
<?php
get_footer();
