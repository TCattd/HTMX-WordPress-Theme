<?php
// No direct access
if (!defined('ABSPATH')) exit;

if (has_custom_logo()) {
	$custom_logo_id = get_theme_mod('custom_logo');
	$logo           = wp_get_attachment_image_src($custom_logo_id, 'full');
}
?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?> <?php hxtheme_global_extensions(); ?> <?php hxtheme_global_boost(); ?>>
	<?php wp_body_open(); ?>

	<header class="container">
		<nav>
			<ul>
				<li>
					<a href="<?php echo esc_url(home_url('/')); ?>">
						<?php
						if (has_custom_logo()) {
							echo '<img src="' . esc_url($logo[0]) . '" alt="' . get_bloginfo('name') . '">';
						} else {
							echo '<h1>' . get_bloginfo('name') . '</h1>';
						}
						?>
					</a>
				</li>
			</ul>
			<?php hxtheme_header_nav(); ?>
		</nav>
	</header>
