<?php get_header(); the_post();?>

<?php get_template_part('breadcrumb');?>

<article class="uk-article">

<?php get_template_part('content', 'list');?>

<blockquote>
    <p><?php the_content();?></p>
</blockquote>

<?php get_template_part('adsense');?>

<a href="<?php echo $post->post_excerpt;?>" target="_blank" class="uk-button uk-width-1-1 uk-margin">続きを見る</a>

<?php get_template_part('relate');?>

</article>

<?php get_footer();?>