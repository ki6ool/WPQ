<?php
if ( false === ( $data = get_transient('hatebu') ) ) {
	$url = "http://b.hatena.ne.jp/search/tag?q=wordpress&users=10&mode=rss";
	$xml = @file_get_contents($url);
	$arr = xml2array($xml);
	$data = $arr['item'];
	set_transient( 'hatebu', $data, 1 * HOUR_IN_SECONDS );
}
if ( empty($data) ) return;
$rand = array_rand($data, 3);
?>
<hr>
<p><span class="uk-badge">新着はてなブックマーク</span></p>
<div class="uk-grid" data-uk-grid-margin="">
<?php foreach ($rand as $r):?>
	<div class="uk-width-1-3">
		<div class="uk-panel uk-panel-box uk-panel-box-secondary">
			<h3 class="uk-panel-title"><a href="<?php echo $data[$r]['link'];?>" target="_blank"><?php echo $data[$r]['title'];?></a></h3>
<?php echo _shorten_string($data[$r]['description'], 60);?>&nbsp;
<a href="http://b.hatena.ne.jp/entry/<?php echo $data[$r]['link'];?>"><img src="http://b.hatena.ne.jp/entry/image/<?php echo $data[$r]['link'];?>"></a>
		</div>
	</div>
<?php endforeach;?>
</div>