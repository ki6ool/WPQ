<?php
/**
 * Plugin Name: WPQ Teratail
 * Plugin URI: http://6oolab.com/
 * Description:Teratail
 * Version: 1.0.0
 * Author: @ki6ool
 * Author URI: https://github.com/ki6ool
 */

register_activation_hook(__FILE__, 'WPQ_TERATAIL_START');
function WPQ_TERATAIL_START() {
	wp_schedule_event(time(), 'hourly', 'WPQ_TERATAIL_TRIGGER');
}

register_deactivation_hook(__FILE__, 'WPQ_TERATAIL_STOP');
function WPQ_TERATAIL_STOP() {
	wp_clear_scheduled_hook('WPQ_TERATAIL_TRIGGER');
}

class Teratail {
	public  $name = 'teratail';
	public  $category_id = 40;
	private $endpoint = 'https://teratail.com/api';
	private $version = 'v1';

	function __construct() {
		require_once TEMPLATEPATH.'/lib/class-wp_post_helper.php';
	}

	function getData() {//435
		//$url = "http://teratail.com/api/v1/tags/WordPress/questions";
		$url = "{$this->endpoint}/{$this->version}/tags/WordPress/questions?limit=50&page=3";
		//$url = "{$this->endpoint}/{$this->version}/tags/WordPress/questions";
		$json = @file_get_contents($url);
		$data = json_decode($json, true);
		return $data['questions'];
	}

	function run($data) {
		global $wpdb;
		foreach ($data as $d) {
			$link = "https://teratail.com/questions/{$d['id']}";

			$query = "SELECT ID FROM wp_posts WHERE post_excerpt = '{$link}' AND post_status = 'publish'";
			if ( $wpdb->get_col($wpdb->prepare($query, null)) ) continue;

			$url = "{$this->endpoint}/{$this->version}/questions/{$d['id']}";
			$json = @file_get_contents($url);
			$data = json_decode($json, true);
			$content = "";
			if ( !empty($data['question']) ) {
				$content = str_replace(array(' ', '`', "\n", "\r", "\n\r"), '', $data['question']['body']);
			}

			$args = array(
					"post_excerpt" => $link,
					"post_title" => $d['title'],
					"post_content" => $content,
					"post_date" => $d['created'],
					"post_type" => "post",
					"post_status" => "publish",
					'post_category'=> array($this->category_id)
			);
			$save = new wp_post_helper($args);
			if ( isset($d['tags']) && !empty($d['tags']) ) {
				$tags = array();
				foreach ($d['tags'] as $tag) {
					if ( $tag == 'WordPress' ) continue;
					$tags[] = $tag;
				}
				if ( !empty($tags) ) $save->set(array('post_tags' => $tags));
			}
			//$save->add_field('link', "https://teratail.com/questions/{$d['id']}");
			$save->insert();
		}
	}

}

add_action('WPQ_TERATAIL_TRIGGER', 'WPQ_TERATAIL_DO');
function WPQ_TERATAIL_DO() {
	$T = new Teratail();
	if ( !$data = $T->getData() ) die;
	$T->run($data);
}