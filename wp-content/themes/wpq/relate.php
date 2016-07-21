<?php
global $post;
$transient = "relate-{$post->ID}";
if ( false === ( $data = get_transient($transient) ) ) {
	$cats = get_the_category($post->ID);
	$args = array(
			'exclude' => $post->ID,
			'numberposts' => 20,
			'post_status' => 'publish',
			'tax_query' => array(array('terms' => $cats[0]->slug, 'taxonomy' => 'category', 'field' => 'slug'))
	);
	$data = get_posts($args);
	set_transient($transient, $data, 1 * HOUR_IN_SECONDS );
}
if ( empty($data) ) return;
$rand = array_rand($data, 3);
?>
<p><span class="uk-badge">関連記事</span></p>
<div class="uk-grid" data-uk-grid-margin="">
<?php foreach ($rand as $r):?>
	<div class="uk-width-1-3">
		<div class="uk-panel uk-panel-box uk-panel-box-secondary">
			<h3 class="uk-panel-title"><a href="<?php echo get_permalink($data[$r]->ID);?>" target="_blank"><?php echo $data[$r]->post_title;?></a></h3>
<?php echo _shorten_string($data[$r]->post_content, 60);?>&nbsp;
		</div>
	</div>
<?php endforeach;?>
</div>