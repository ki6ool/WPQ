<?php global $post;?>
<article class="uk-comment">
    <header class="uk-comment-header">
        <h4 class="uk-comment-title"><a href="<?php echo $post->post_excerpt;?>" target="_blank"><?php echo $post->post_title;?></a></h4>
        <div class="uk-comment-meta" data-link="<?php echo $post->post_excerpt;?>" data-ui="<?php //echo $post->post_excerpt;?>">
        <?php the_category('|');?>&nbsp;|&nbsp;
		<a href="<?php echo get_permalink($post->ID);?>"><?php echo get_the_time('Y-m-d H:i:s');?></a>&nbsp;|&nbsp;
        <i class="uk-icon-justify uk-icon-star count" title="はてブ">&nbsp;0</i>
        <?php the_tags('<i class="uk-icon-justify uk-icon-tags"></i>&nbsp;', ',&nbsp;');?>
        </div>
    </header>
</article>
