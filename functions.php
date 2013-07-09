<?php

/*
 * Toolkit functionalities
 */

require_once(TEMPLATEPATH . '/inc/tutorials.php'); // Tutorials
require_once(TEMPLATEPATH . '/inc/tools.php'); // Tools
require_once(TEMPLATEPATH . '/inc/glossary.php'); // Glossary

/*
 * Toolkit theme setup
 */

function toolkit_setup() {
	// text domain
	//load_theme_textdomain('toolkit', get_template_directory() . '/languages');

	add_theme_support('post-thumbnails');

	register_nav_menus(array(
		'header_menu' => __('Header menu', 'mappress'),
		'footer_menu' => __('Footer menu', 'mappress')
	));

	//sidebars
	register_sidebar(array(
		'name' => __('General sidebar', 'mappress'),
		'id' => 'general',
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>'
	));
}
add_action('after_setup_theme', 'toolkit_setup');

/*
 * Styles
 */

function toolkit_styles() {
	wp_register_style('base', get_template_directory_uri() . '/css/base.css');
	wp_register_style('skeleton', get_template_directory_uri() . '/css/skeleton.css', array('base'));
	wp_register_style('main', get_template_directory_uri() . '/css/main.css', array('base', 'skeleton'));

	wp_enqueue_style('font-dosis', 'http://fonts.googleapis.com/css?family=Dosis:200,300,400,500,600');

	wp_enqueue_style('main');
}
add_action('wp_enqueue_scripts', 'toolkit_styles');

/*
 * Advanced Custom Fields
 */

function toolkit_acf_path() {
	return get_template_directory_uri() . '/inc/acf/';
}
add_filter('acf/helpers/get_dir', 'toolkit_acf_path');

define('ACF_LITE', true);
require_once(TEMPLATEPATH . '/inc/acf/acf.php');

/*
 * Templates
 */

function toolkit_category_nav() {

	$categories = get_terms('category', array('hide_empty' => false));
	if($categories) {
		?>
		<div class="row">
			<nav id="category-nav">
				<ul>
					<?php foreach($categories as $cat) : ?>
						<li class="<?php echo $cat->slug; ?> <?php if(is_category($cat->term_id)) echo 'active'; ?>">
							<a href="<?php echo get_term_link($cat, 'category'); ?>" title="<?php _e('View all content on', 'toolkit'); echo $cat->name; ?>"><?php echo $cat->name; ?></a>
						</li>
					<?php endforeach; ?>
					<li class="all <?php if(is_front_page()) echo 'active'; ?>">
						<a href="<?php echo home_url('/'); ?>" title="<?php _e('View all content', 'toolkit'); ?>"><?php _e('All', 'toolkit'); ?></a>
					</li>
				</ul>
			</nav>
		</div>
		<?php
	}

}