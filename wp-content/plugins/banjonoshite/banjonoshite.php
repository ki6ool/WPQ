<?php
/**
 * Plugin Name:万条の仕手
 * Plugin URI: http://6oolab.com/
 * Description:カスタマイズ設定を反映します。
 * Version: 1.0.0
 * Author: @ki6ool
 * Author URI: https://github.com/ki6ool
 */

remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'wp_shortlink_wp_head');
remove_action('wp_head', 'feed_links_extra', 3);
remove_action('wp_head', 'feed_links', 2);
remove_action('wp_head', 'index_rel_link');
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head');
remove_action('wp_head', 'parent_post_rel_link', 10, 0);
remove_action('wp_head', 'start_post_rel_link', 10, 0);
remove_action('wp_head', 'rel_canonical');
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');
add_filter('show_admin_bar', '__return_false');

/**
 * ページタイトルをカスタマイズ
 */
add_filter('wp_title', function($title) {
	$title .= get_bloginfo('name');
	$site_description = get_bloginfo('description', 'display');
	if ( $site_description && ( is_home() ) ) {
		$title = "{$title} | {$site_description}";
	}
	return $title;
});

/**
 * 日付・月別・著者のアーカイブページをエラーに
 */
add_action('parse_query', function() {
	if ( is_date() || is_month() || is_author() ) {
		wp_die(
			'<a href="'.esc_url(home_url('/')).'">'.get_option('blogname').'</a>',
			get_option('blogname'),
			array('response' => 404, "back_link" => true)
		);
	}
});

/**
 * ダッシュボードの項目を削除
 */
add_action('wp_dashboard_setup', function() {
	global $wp_meta_boxes;
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);//最近のコメント
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);//被リンク
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);//プラグイン
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);//クイック投稿
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts']);//最近の下書き
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);//WordPressブログ
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);//WordPressフォーラム
});

/**
 * 投稿から項目を削除
 */
add_action('admin_menu', function() {
	remove_meta_box('postcustom', 'post', 'normal');//カスタムフィールド
	//remove_meta_box('postexcerpt', 'post', 'normal');//抜粋
	remove_meta_box('commentstatusdiv', 'post', 'normal');//ディスカッション
	remove_meta_box('commentsdiv', 'post', 'normal');//コメント設定
	remove_meta_box('trackbacksdiv', 'post', 'normal');//トラックバック設定
	remove_meta_box('revisionsdiv', 'post', 'normal');//リビジョン表示
	remove_meta_box('formatdiv', 'post', 'normal');//フォーマット設定
	remove_meta_box('slugdiv', 'post', 'normal');//スラッグ設定
	remove_meta_box('authordiv', 'post', 'normal');//投稿者
	//remove_meta_box('categorydiv', 'post', 'normal');//カテゴリー
	//remove_meta_box('tagsdiv-post_tag', 'post', 'normal');//タグ
	remove_meta_box('dashboard_activity', 'dashboard', 'normal');//アクティビティー
	remove_action('welcome_panel', 'wp_welcome_panel');//ようこそ
});

/**
 * 管理画面の投稿一覧から該当列を削除
 */
add_filter('manage_posts_columns', function($columns) {
	global $post;
	if ( $post->post_type == 'post' ) {
		unset($columns['author']);
		unset($columns['comments']);
	}
	return $columns;
});

/**
 * ヘルプを非表示
 */
add_action('admin_head', function() {
	echo '<style type="text/css">#contextual-help-link-wrap {display: none !important;}</style>';
});

/**
 * フッターの表示を変更
 */
add_filter('admin_footer_text', function() {
	echo 'Developed by <a href="http://www.6oolab.com/" target="_blank">6oolab.com</a>';
});

/**
 * フィードで著者名を出力しない
 */
add_filter('the_author', function($name) {
	if ( is_feed() ) return false;
	return $name;
});

/**
 * NULLをインサートできるようにする
 * @link http://wordpress.stackexchange.com/questions/143405/wpdb-wont-insert-null-into-table-column
 */
//add_filter('query', 'wpse_143405_query');
//remove_filter('query', 'wpse_143405_query');
function wpse_143405_query($query) {
	return str_ireplace("'NULL'", "NULL", $query);
}