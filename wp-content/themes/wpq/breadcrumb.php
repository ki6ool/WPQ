<?php
global $C;
if ( is_home() || ( !is_archive() && !is_singular(array('post')) ) ) return;
?>
<ul class="uk-breadcrumb">
    <li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="/" itemprop="url"><span itemprop="title"><?php echo $C->site_name;?></span></a></li>
<?php if ( is_archive() ): $object = get_queried_object();?>
    <li class="uk-active" itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><span itemprop="title"><?php echo $object->name;?></span></li>
<?php elseif ( is_singular(array('post')) ): $cat = reset(get_the_category($post->ID)); ?>
	<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="/q/category/<?php echo $cat->slug;?>" itemprop="url"><span itemprop="title"><?php echo $cat->name;?></span></a></li>
    <li class="uk-active" itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><span itemprop="title"><?php echo $post->post_title;?></span></li>
<?php endif;?>
</ul>