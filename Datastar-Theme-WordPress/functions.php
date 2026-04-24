<?php
// No direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Get datastar-theme options with proper translation loading
 *
 * @return array
 */
function ds_theme_get_options()
{
    static $ds_theme_options = null;

    if ($ds_theme_options === null) {
        $ds_theme_options = [
            'demos' => [
                'datastar-demo' => [
                    'title'       => __('Datastar Demo', 'datastar-theme'),
                    'description' => __('Real-time Datastar v1.0 demonstration.', 'datastar-theme'),
                    'path'        => '/datastar-demo',
                ],
            ],
        ];
    }

    return $ds_theme_options;
}

/**
 * Theme activation
 *
 * Check if HyperPress plugin is installed and activated
 */
add_action('after_switch_theme', 'ds_theme_activation');
function ds_theme_activation()
{
    // Check if HyperPress plugin is present and activated
    if (!function_exists('hp_get_endpoint_url')) {
        // Deactivate theme, go back to default
        switch_theme(WP_DEFAULT_THEME);

        // Output error message
        wp_die(__('This theme requires <a href="https://wordpress.org/plugins/api-for-htmx/" target="_blank">HyperPress plugin</a> to work. Please install and activate it first.', 'datastar-theme'));
    }
}

/**
 * Setup theme
 *
 * @return void
 */
add_action('after_setup_theme', 'ds_theme_setup');
function ds_theme_setup()
{
    // Load theme textdomain
    load_theme_textdomain('datastar-theme', get_template_directory() . '/languages');

    add_theme_support('custom-logo');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', ['comment-list', 'comment-form', 'search-form', 'gallery', 'caption', 'style', 'script']);
    add_theme_support('title-tag');

    do_action('ds_theme/setup/end');
}

/**
 * Register and enqueue styles and scripts
 *
 * @return void
 */
add_action('wp_enqueue_scripts', 'ds_theme_scripts_styles');
function ds_theme_scripts_styles()
{
    do_action('ds_theme/scripts_styles/start');

    $theme_version  = wp_get_theme()->get('Version');
    $style_picocss  = get_template_directory_uri() . '/assets/css/pico.min.css';
    $style_ds_theme  = get_template_directory_uri() . '/assets/css/datastar-theme.css';
    $script_ds_theme = get_template_directory_uri() . '/assets/js/datastar-theme.js';

    do_action('ds_theme/scripts_styles/before_enqueue');

    wp_enqueue_style('picocss-style', $style_picocss, [], $theme_version);
    wp_enqueue_style('datastar-theme-style', $style_ds_theme, ['picocss-style'], $theme_version);
    wp_enqueue_script('datastar-theme-script', $script_ds_theme, [], $theme_version, true);

    do_action('ds_theme/scripts_styles/end');
}

/**
 * Render header nav
 */
if (!function_exists('ds_theme_header_nav')) {
    function ds_theme_header_nav()
    {
        $ds_theme_options = ds_theme_get_options();

        do_action('ds_theme/header_nav/start');
        ?>
<ul>
	<li><a
			href="<?php echo esc_url(home_url('/')); ?>"><?php _e('Home', 'datastar-theme'); ?></a>
	</li>
	<?php
        if (isset($ds_theme_options['demos']) && is_array($ds_theme_options['demos'])) {
            foreach ($ds_theme_options['demos'] as $slug => $demo) {
                $url = esc_url(home_url('/' . $slug . '/'));

                echo '<li><a href="' . $url . '">' . $demo['title'] . '</a></li>';
            }
        }
        ?>
</ul>
<?php
        do_action('ds_theme/header_nav/end');
    }
}

/**
 * Datastar demos
 * Add some Datastar demos, using HyperPress
 *
 * @return void
 */
if (!function_exists('ds_theme_demos')) {
    function ds_theme_demos($template)
    {
        global $wp_query;

        $ds_theme_options = ds_theme_get_options();
        $ds_theme_demo_slugs = [];
        $current_slug       = isset($wp_query->query_vars['name']) ? $wp_query->query_vars['name'] : '';

        if (isset($ds_theme_options['demos']) && is_array($ds_theme_options['demos'])) {
            $ds_theme_demo_slugs = $ds_theme_options['demos'];
        }

        if (in_array($current_slug, array_keys($ds_theme_demo_slugs))) {
            $ds_theme_template  = locate_template(['page-' . $current_slug . '.php']);

            if (!empty($ds_theme_template)) {
                status_header(200);

                $wp_query->is_404  = false;
                $wp_query->is_page = true;
                $wp_query->ds_theme_data = $ds_theme_options['demos'][$current_slug];

                return $ds_theme_template;
            }
        }

        return $template;
    }
    add_filter('template_include', 'ds_theme_demos');
}
