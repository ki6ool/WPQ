<?php
$row = ( $post->post_name == "category" )
	? get_categories(array('orderby' => 'count', 'order' => 'desc'))
	: get_tags(array('orderby' => 'count', 'order' => 'desc'));


get_header();
?>
<p class="uk-article-lead"><?php echo $post->post_title;?></p>

<ul class="uk-grid uk-grid-width-1-5">

<?php if ( !empty($row) ): foreach ($row as $r):?>
<li><a href="/q/<?php echo "{$post->post_name}/{$r->slug}";?>"><i class="uk-icon-tag"></i> <?php echo "{$r->name} ({$r->count})";?></a></li>
<?php endforeach; endif;?>

</ul>



<?php get_footer();?>