<?php
// No direct access
if (!defined('ABSPATH')) exit;

get_header();

global $wp_query;

$ds_theme_data = $wp_query->ds_theme_data;
?>
<main id="content" <?php post_class('container content-area'); ?>>
	<section class="datastar-demo-section" 
             data-signals='{"message": "Ready...", "loading": false}'>
		
        <header>
            <h2><?php echo esc_html($ds_theme_data['title']); ?></h2>
            <p><?php echo esc_html($ds_theme_data['description']); ?></p>
        </header>

		<div class="demo-actions">
			<button class="button-primary"
				data-on:click="@get('<?php echo hp_get_endpoint_url('datastar-demo'); ?>?action=datastar_do_something&demo_type=simple_get&timestamp=' + Date.now())"
				data-indicator:loading>
				<span data-show="!$loading"><?php esc_html_e('Click to Load Message', 'datastar-theme'); ?></span>
                <span data-show="$loading">
                    <span class="spinner"></span> <?php esc_html_e('Loading...', 'datastar-theme'); ?>
                </span>
			</button>
		</div>

        <div class="response-container" data-show="$message">
            <ins><strong><?php esc_html_e('Server Response:', 'datastar-theme'); ?></strong></ins>
            <div id="datastar-message" data-text="$message" style="padding: 1rem; border: 1px solid #ccc; margin-top: 1rem; border-radius: 4px;">
                <!-- Content will be updated by Datastar -->
            </div>
        </div>

        <hr>

        <footer>
		    <p>
			    <?php esc_html_e('This page uses Datastar v1.0 exclusively to fetch content from the HyperPress API.', 'datastar-theme'); ?>
		    </p>
        </footer>
	</section>
</main>
<?php
get_footer();
