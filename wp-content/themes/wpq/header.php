<?php global $C;?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title><?php wp_title('|', true, 'right');?></title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="http://<?php echo $_SERVER['SERVER_NAME'];?>/feed" />
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/uikit/2.23.0/css/uikit.min.css">
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/uikit/2.23.0/css/components/search.css">
<link rel="stylesheet" href="/css/style.css">
<link href='//fonts.googleapis.com/css?family=Raleway:400,300,600' rel='stylesheet' type='text/css' id='gwf'>
<script>!function(){var e=document.getElementById("gwf");e.rel="stylesheet"}();</script>
<?php
wp_deregister_script('jquery');
wp_head();
?>
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
</head>
<body>
<nav class="uk-navbar uk-navbar-attached">
	<div class="uk-container uk-clearfix uk-container-center">
		<div class="uk-float-right">
			<a href="#search" class="uk-icon-hover uk-icon-search uk-icon-small" style="margin-top: 10px;" data-uk-offcanvas></a>
		</div>
		<div class="uk-float-left"><div class="uk-navbar-brand"><a href="/"><?php echo $C->site_name;?></a></div></div>
	</div>
</nav>

<div id="search" class="uk-offcanvas">
    <div class="uk-offcanvas-bar uk-offcanvas-bar-flip"><?php get_search_form();?></div>
</div>



<div class="uk-container uk-container-center uk-margin-top uk-margin-bottom">
