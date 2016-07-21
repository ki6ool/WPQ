<?php
/**
 * Plugin Name: WPQ Qait
 * Plugin URI: http://6oolab.com/
 * Description:Qait
 * Version: 1.0.0
 * Author: @ki6ool
 * Author URI: https://github.com/ki6ool
 */

register_activation_hook(__FILE__, 'WPQ_QAIT_START');
function WPQ_QAIT_START() {
	wp_schedule_event(time(), 'hourly', 'WPQ_QAIT_TRIGGER');
}

register_deactivation_hook(__FILE__, 'WPQ_QAIT_STOP');
function WPQ_QAIT_STOP() {
	wp_clear_scheduled_hook('WPQ_QAIT_TRIGGER');
}

class Qait {
	public  $name = 'qait';
	public  $category_id = 42;
	private $endpoint = 'http://qa.atmarkit.co.jp/feed/questions';
	private $version = '';

	function __construct() {
		require_once TEMPLATEPATH.'/lib/class-wp_post_helper.php';
		require_once TEMPLATEPATH.'/lib/simplehtmldom/simple_html_dom.php';
	}

	function getData() {
		//$url = "http://qa.atmarkit.co.jp/feed/questions/tagged/wordpress.atom";
		$url = "{$this->endpoint}/tagged/wordpress.atom";
		$xml = @file_get_contents($url);
		$data = xml2array($xml);
		if ( !$data || !isset($data['entry']) ) die;
		return $data['entry'];
	}

	function run($data) {
		set_time_limit(60);
		global $wpdb;
		foreach ($data as $d) {
			$query = "SELECT ID FROM wp_posts WHERE post_excerpt = '{$d['link']['@attributes']['href']}' AND post_status = 'publish'";
			if ( $wpdb->get_col($wpdb->prepare($query, null)) ) continue;

			$html = file_get_html($d['link']['@attributes']['href']);
			$dom = $html->find('[itemprop=articleBody]', 0);
			$body = ( empty($dom) ) ? '' : $dom->plaintext;
			$html->clear();

			$args = array(
					"post_excerpt" => $d['link']['@attributes']['href'],
					"post_title" => $d['title'],
					"post_content" => str_replace(array(' ', '`', "\n", "\r", "\n\r"), '', $body),
					"post_date" => date('Y-m-d H:i:s', strtotime($d['published'])),
					"post_type" => "post",
					"post_status" => "publish",
					'post_category'=> array($this->category_id)
			);
			$save = new wp_post_helper($args);
			if ( isset($d['category']) && !empty($d['category']) ) {
				$tags = array();
				foreach ($d['category'] as $tag) {
					if ( strcasecmp($tag['@attributes']['term'], 'WordPress') == 0 ) continue;
					$tags[] = $tag['@attributes']['term'];
				}
				if ( !empty($tags) ) $save->set(array('post_tags' => $tags));
			}
			$save->insert();
		}
	}

}

add_action('WPQ_QAIT_TRIGGER', 'WPQ_QAIT_DO');
function WPQ_QAIT_DO() {
	$Q = new Qait();
	if ( !$data = $Q->getData() ) die;
	$Q->run($data);
}