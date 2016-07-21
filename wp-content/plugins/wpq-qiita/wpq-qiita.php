<?php
/**
 * Plugin Name: WPQ Qiita
 * Plugin URI: http://6oolab.com/
 * Description:Qiita
 * Version: 1.0.0
 * Author: @ki6ool
 * Author URI: https://github.com/ki6ool
 */

register_activation_hook(__FILE__, 'WPQ_QIITA_START');
function WPQ_QIITA_START() {
	wp_schedule_event(time(), 'hourly', 'WPQ_QIITA_TRIGGER');
}

register_deactivation_hook(__FILE__, 'WPQ_QIITA_STOP');
function WPQ_QIITA_STOP() {
	wp_clear_scheduled_hook('WPQ_QIITA_TRIGGER');
}

class Qiita {
	public  $name = 'qiita';
	public  $category_id = 39;
	private $endpoint = 'http://qiita.com/api';
	private $version = 'v2';

	function __construct() {
		require_once TEMPLATEPATH.'/lib/class-wp_post_helper.php';
	}

	function getData() {//701
		//$url = "http://qiita.com/api/v2/items?query=tag:WordPress&per_page=1";
		//$url = "{$this->endpoint}/{$this->version}/items?query=tag:WordPress&per_page=100&page=8";
		$url = "{$this->endpoint}/{$this->version}/items?query=tag:WordPress&per_page=10";
		$json = @file_get_contents($url);
		$data = json_decode($json, true);
		return $data;
	}

	function run($data) {
		global $wpdb;
		foreach ($data as $d) {
			$query = "SELECT ID FROM wp_posts WHERE post_excerpt = '{$d['url']}' AND post_status = 'publish'";
			if ( $wpdb->get_col($wpdb->prepare($query, null)) ) continue;

			$args = array(
					"post_excerpt" => $d['url'],
					"post_title" => $d['title'],
					"post_content" => str_replace(array(' ', '`', "\n"), '', $d['body']),
					"post_date" => date('Y-m-d H:i:s', strtotime($d['created_at'])),
					"post_type" => "post",
					"post_status" => "publish",
					'post_category'=> array($this->category_id)
			);
			$save = new wp_post_helper($args);
			if ( isset($d['tags']) && !empty($d['tags']) ) {
				$tags = array();
				foreach ($d['tags'] as $tag) {
					if ( $tag['name'] == 'WordPress' ) continue;
					$tags[] = $tag['name'];
				}
				if ( !empty($tags) ) $save->set(array('post_tags' => $tags));
			}
			//$save->add_field('link', $d['url']);
			$save->insert();
		}
	}

}

add_action('WPQ_QIITA_TRIGGER', 'WPQ_QIITA_DO');
function WPQ_QIITA_DO() {
	$Q = new Qiita();
	if ( !$data = $Q->getData() ) die;
	$Q->run($data);
}