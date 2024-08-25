<?php
// No direct access
if (!defined('ABSPATH')) exit;

$hxtheme_options = [
	'demos' => [
		'htmx-demo-swap' => [
			'title'       => __('HTMX Swap', 'hxtheme'),
			'description' => __('Example of HTMX swap response.', 'hxtheme'),
			'path'        => '/demo-swap',
		],
		'htmx-demo-noswap' => [
			'title'          => __('HTMX No Swap', 'hxtheme'),
			'description'    => __('Example of HTMX no swap response.', 'hxtheme'),
			'path'           => '/noswap/demo-noswap',
		],
	],
];

/**
 * Theme activation
 *
 * Check if HTMX-API-WP plugin is installed and activated
 */
add_action('after_switch_theme', 'hxtheme_activation');
function hxtheme_activation()
{
	// Check if HTMX-API-WP plugin is present and activated
	if (!function_exists('hxwp_api_url')) {
		// Deactivate theme, go back to default
		switch_theme(WP_DEFAULT_THEME);

		// Output error message
		wp_die(__('This theme requires <a href="https://github.com/TCattd/HTMX-API-WP" target="_blank">HTMX-API-WP plugin</a> to work. Please install and activate it first.', 'hxtheme'));
	}
}

/**
 * Setup theme
 *
 * @return void
 */
add_action('after_setup_theme', 'hxtheme_setup');
function hxtheme_setup()
{
	add_theme_support('custom-logo');
	add_theme_support('post-thumbnails');
	add_theme_support('html5', ['comment-list', 'comment-form', 'search-form', 'gallery', 'caption', 'style', 'script']);
	add_theme_support('title-tag');

	do_action('hxtheme/setup/end');
}

/**
 * Register and enqueue styles and scripts
 *
 * @return void
 */
add_action('wp_enqueue_scripts', 'htmx_scripts_styles');
function htmx_scripts_styles()
{
	do_action('hxtheme/scripts_styles/start');

	$theme_version  = wp_get_theme()->get('Version');
	$style_picocss  = get_template_directory_uri() . '/assets/css/pico.min.css';
	$style_hxtheme  = get_template_directory_uri() . '/assets/css/hxtheme.css';
	$script_hxtheme = get_template_directory_uri() . '/assets/js/hxtheme.js';

	do_action('hxtheme/scripts_styles/before_enqueue');

	wp_enqueue_style('picocss-style', $style_picocss, [], $theme_version);
	wp_enqueue_style('hxtheme-style', $style_hxtheme, ['picocss-style'], $theme_version);
	wp_enqueue_script('hxtheme-script', $script_hxtheme, [], $theme_version, true);

	do_action('hxtheme/scripts_styles/end');
}

/**
 * HTMX configuration meta
 *
 * @return void
 */
add_action('wp_head', 'hxtheme_header_meta');
function hxtheme_header_meta()
{
	do_action('hxtheme/header_meta/start');

	$htmx_timeout           = apply_filters('hxtheme/meta/timeout', 60000);
	$htmx_globalTransitions = apply_filters('hxtheme/meta/globalTransitions', 'true'); // we need a string here

	$htmx_config = apply_filters('hxtheme/meta/config', [
		'timeout'               => $htmx_timeout,
		'globalViewTransitions' => $htmx_globalTransitions,
	]);

	do_action('hxtheme/header_meta/before_render');
?>
	<meta name="color-scheme" content="light dark" />
	<meta name="htmx-config" content='<?php echo json_encode($htmx_config); ?>' />
	<?php
	do_action('hxtheme/header_meta/end');
}

/**
 * HTMX global extensions
 *
 * @return void
 */
function hxtheme_global_extensions()
{
	do_action('hxtheme/global_extensions/start');

	$htmx_ext = [
		//'head-support',
		//'method-override',
		//'morphdom-swap',
		//'multi-swap',
		//'preload',
		//'remove-me',
		//'path-params',
	];

	// Check if WP DEBUG is enabled
	if (defined('WP_DEBUG') && WP_DEBUG) {
		$htmx_ext[] = 'debug';
	}

	apply_filters('hxtheme/global_extensions/array', $htmx_ext);

	do_action('hxtheme/global_extensions/end', $htmx_ext);

	if (empty($htmx_ext) || !is_array($htmx_ext)) {
		return;
	}

	// comma separated list of extensions
	echo ' hx-ext="' . implode(',', $htmx_ext) . '" ';
}

/**
 * HTMX global boost
 * Enables HTMX boost feature. See https://htmx.org/attributes/hx-boost/
 *
 * @return void
 */
function hxtheme_global_boost()
{
	do_action('hxtheme/global_boost/start');

	$boost = apply_filters('hxtheme/global_boost', true);

	// Debug
	//$boost = false;

	if ($boost === true) {
		echo ' hx-boost="true" ';
	}
}

/**
 * Render header nav
 */
if (!function_exists('hxtheme_header_nav')) {
	function hxtheme_header_nav()
	{
		global $hxtheme_options;

		do_action('hxtheme/header_nav/start');
	?>
		<ul>
			<li><a href="<?php echo esc_url(home_url('/')); ?>"><?php _e('Home', 'hxtheme'); ?></a></li>
			<?php
			// If WooCommerce is activated, add a link to the shop
			if (class_exists('WooCommerce')) {
				echo '<li><a href="' . esc_url(wc_get_page_permalink('shop')) . '">' . __('Shop', 'hxtheme') . '</a></li>';
			}

			if (isset($hxtheme_options['demos']) && is_array($hxtheme_options['demos'])) {
				foreach ($hxtheme_options['demos'] as $slug => $demo) {
					$url = esc_url(home_url('/' . $slug . '/'));

					echo '<li><a href="' . $url . '">' . $demo['title'] . '</a></li>';
				}
			}
			?>
		</ul>
<?php
		do_action('hxtheme/header_nav/end');
	}
}

/**
 * HTMX demos
 * Add some HTMX demos, using HTMX-API-WP
 *
 * @return void
 */
if (!function_exists('hxtheme_demos')) {
	function hxtheme_demos($template)
	{
		global $wp_query, $hxtheme_options;

		$hxtheme_demo_slugs = [];
		$current_slug       = isset($wp_query->query_vars['name']) ? $wp_query->query_vars['name'] : '';

		if (isset($hxtheme_options['demos']) && is_array($hxtheme_options['demos'])) {
			$hxtheme_demo_slugs = $hxtheme_options['demos'];
		}

		if (in_array($current_slug, array_keys($hxtheme_demo_slugs))) {
			$hxtheme_template  = locate_template(['page-' . $current_slug . '.php']);

			if (!empty($hxtheme_template)) {
				status_header(200);

				$wp_query->is_404  = false;
				$wp_query->is_page = true;
				$wp_query->hxtheme_data = $hxtheme_options['demos'][$current_slug];

				return $hxtheme_template;
			}
		}

		return $template;
	}
	add_filter('template_include', 'hxtheme_demos');
}
