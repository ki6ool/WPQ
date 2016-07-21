<?php
class Common {
	public $site_name;
	private $count_label = array(
			'qiita' => 'ストック',
			'teratail' => 'クリップ',
	);

	function __construct() {
		$this->site_name = get_option('blogname');
	}

	function getCountLabel($s) {
		return isset($this->count_label[$s]) ? $this->count_label[$s] : '';
	}

}

function _v($val) {
	echo "<pre>"; var_dump($val); echo "</pre>";
}

function _h($val) {
	return htmlspecialchars($val, ENT_QUOTES, 'UTF-8');
}

function _startsWith($haystack, $needle) {
	if ( is_array($needle) ) {
		return preg_match('/('.implode('|', $needle ).')/', $haystack);
	}
	return strpos($haystack, $needle, 0) === 0;
}

function _endsWith($haystack, $needle) {
	$length = (strlen($haystack) - strlen($needle));
	if ( $length <0 ) return false;
	return strpos($haystack, $needle, $length) !== false;
}

function _matchesIn($haystack, $needle) {
	if ( is_array($needle) ) {
		return preg_match('/'.implode('|', $needle).'/i', $haystack);
	}
	return strpos($haystack, $needle) !== false;
}

function _shorten_string($str, $length, $add=false) {
	if ( mb_strlen($str) > $length ) {
		$str = trim(mb_substr(strip_tags($str), 0, $length, 'UTF-8'));
		$str = str_replace(array("\n", "\r", "\r\n"), "", $str);
		return ($add) ? $str.$add : $str;
	}
	return str_replace(array("\n", "\r", "\r\n"), "", strip_tags($str));
}

function _get_sample_image($width, $height) {
	return "//placeholdit.imgix.net/~text?txtsize=40&bg=666&txtclr=ffffff&txt={$width}x{$height}&w={$width}&h={$height}&fm=png";
}

function xml2array($target) {
	$xml = @simplexml_load_string($target);
	return json_decode(json_encode($xml), true);
}