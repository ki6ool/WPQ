<?php
global $C;
date_default_timezone_set('Asia/Tokyo');
remove_filter('the_content', 'wptexturize');
// remove_filter('the_content', 'wpautop');
// remove_action('wp_version_check', 'wp_version_check');
// remove_action('admin_init', '_maybe_update_core');
// add_filter('pre_site_transient_update_core', '__return_zero');
// add_filter('site_option__site_transient_update_plugins', '__return_zero');
// add_theme_support('post-thumbnails');
/**/

add_action('init', function() {
	if ( is_admin() ) return;
	require_once TEMPLATEPATH.'/class/common.php';
	global $C;
	$C = new Common();
});

function go404() {
	header("HTTP/1.1 404 Not Found");
	include_once TEMPLATEPATH."/404.php";
	die;
}

function pagination() {
	global $wp_query;
	$src = "";
	$big = 99999999;
	$current = max(1, get_query_var('paged'));
	$page_format = paginate_links( array(
			'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big)) ),
			'format' => '?paged=%#%',
			'current' => $current,
			'total' => $wp_query->max_num_pages,
			'type'  => 'array',
			'prev_text'    => __('<i class="uk-icon-angle-double-left"></i>'),
			'next_text'    => __('<i class="uk-icon-angle-double-right"></i>'),
	) );
	if( is_array($page_format) ) {
		$paged = ( get_query_var('paged') == 0 ) ? 1 : get_query_var('paged');
		$src .= "<ul class=\"uk-pagination\">\n";
		foreach ($page_format as $page) {
			$src .= "<li>{$page}</li>\n";
		}
		$src .= "</ul>";
	}
	wp_reset_query();
	return $src;
}

add_filter('the_content', function($content) {
	return ( is_singular() && get_post_type() == 'post' ) ? _shorten_string($content, 500) : $content;
});

