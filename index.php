<?php
// No direct access
if (!defined('ABSPATH')) exit;

get_header();
?>
<main id="content" <?php post_class('container content-area'); ?>>
	<section class="page-content post-content" role="main">
		<?php
		if (have_posts()) {
			while (have_posts()) {
				the_post();
				the_title('<h2 class="page-title entry-title">', '</h2>');
				if (is_front_page() || is_home()) {
					the_excerpt();
		?>
					<p><a href="<?php the_permalink(); ?>" class="button"><?php _e('Read more', 'hxtheme'); ?></a></p>
			<?php
				} else {
					the_content();
				}
			}
		} else {
			?>
			<p><?php _e('Sorry, no posts matched your criteria.', 'hxtheme'); ?></p>
		<?php
		}
		?>
	</section>
</main>
<?php
get_footer();
