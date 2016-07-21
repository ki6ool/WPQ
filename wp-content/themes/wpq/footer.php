<?php get_template_part('hatebu');?>

</div>

<div id="footer">
<div class="uk-container uk-container-center uk-margin-top uk-text-center">
	<ul class="uk-subnav uk-subnav-line uk-flex-center">
<?php foreach ($cats = get_categories() as $v):?>
		<li><a href="<?php echo $v->description;?>" target="_blank"><?php echo $v->name;?></a></li>
<?php endforeach;?>
	</ul>
	<ul class="uk-subnav uk-subnav-line uk-flex-center">
<?php foreach ($pages = get_pages() as $v):?>
		<li><a href="/<?php echo $v->post_name;?>"><?php echo $v->post_title;?></a></li>
<?php endforeach;?>
	</ul>
	<ul class="uk-subnav uk-flex-center">
		<li><a href="http://b.hatena.ne.jp/entry/http://wordpress.information.jp/" class="hatena-bookmark-button" data-hatena-bookmark-layout="standard-noballoon" data-hatena-bookmark-lang="ja" title="このエントリーをはてなブックマークに追加"><img src="https://b.st-hatena.com/images/entry-button/button-only@2x.png" alt="このエントリーをはてなブックマークに追加" width="20" height="20" style="border: none;" /></a></li>
		<li style="border: 0;"><a href="https://twitter.com/share" class="twitter-share-button" data-lang="ja" data-count="none">ツイート</a></li>
	</ul>
	<div class="uk-panel">
		<p><a href="http://6oolab.com/">&copy;6oolab</a></p>
	</div>
</div>
</div>

<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="/js/app.js"></script>
<script type="text/javascript">
var ns = F;
$(function() {
	ns.app.getCount();
});
</script>
<script src="//cdnjs.cloudflare.com/ajax/libs/uikit/2.23.0/js/uikit.min.js"></script>
<?php wp_footer();?>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
  ga('create', 'UA-69662681-1', 'auto');
  ga('send', 'pageview');
</script>
<script>
(function(w,d){
    w.___gcfg={lang:"ja"};
    var s,e = d.getElementsByTagName("script")[0],
    a=function(u,f){if(!d.getElementById(f)){s=d.createElement("script");
    s.src=u;if(f){s.id=f;}e.parentNode.insertBefore(s,e);}};
    a("//b.st-hatena.com/js/bookmark_button.js");
    a("//platform.twitter.com/widgets.js","twitter-wjs");
})(this, document);
</script>
</body>
</html>