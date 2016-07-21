<?php
get_header();

get_template_part('breadcrumb');

if ( have_posts() ):

$ad = true;
while ( have_posts() ) : the_post();

get_template_part('content', 'list');

if ( $ad ) get_template_part('adsense');

$ad = false;
endwhile;

echo pagination();

endif;

get_footer();
?>