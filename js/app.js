var F = F || {};

(function($, d, ns){
    'use strict';

    var app = {

        getCount: function() {
        	var list = $(".uk-comment-meta").map(function(index, el) { return $(this) });
            if (!list) return;
            for (var i = 0; i < list.length; i++) {
            	var url = $(".uk-comment-meta:eq("+i+")").data("link");
            	this.getHatebu(url, i);
            	continue;
            	var ui = $(".uk-comment-meta:eq("+i+")").data("ui");
            	var e = $(".uk-comment-meta:eq("+i+") .uk-icon-paperclip");
            	if ( e.hasClass("qiita") ) {
            		this.getQiita(url, e, ui);
            	} else if ( e.hasClass("teratail") ){
            		this.getTeratail(url, e, ui);
            	}
            }

        },

        getHatebu: function(url, i) {
        	var e = $(".uk-comment-meta:eq("+i+") .uk-icon-star");
            $.ajax({
                url:'http://api.b.st-hatena.com/entry.count',
                dataType:'jsonp',
                data:{ url:url },
                success:function(res){
                	if(typeof(res)=='undefined'||!res) res = 0;
                	e.text(' '+res);
                },error:function(){
                	e.text(' ?');
                }
            });
        },

        getQiita: function(url, e, ui) {
            $.ajax({
                url:'https://qiita.com/api/v1/items/'+ui,
                dataType:'json',
                success:function(res){
                	if(typeof(res)=='undefined'||!res['stock_count']) res['stock_count'] = 0;
                	e.text(' '+res['stock_count']);
                },error:function(){
                	e.text(' ?');
                }
            });
        },

        getTeratail: function(url, e, ui) {
            $.ajax({
                url:'http://teratail.com/api/v1/questions/'+ui,
                dataType:'json',
                success:function(res){
                	if(typeof(res)=='undefined'||!res['question']['count_clip']) res['question']['count_clip'] = 0;
                	e.text(' '+res['question']['count_clip']);
                },error:function(){
                	e.text(' ?');
                }
            });
        },

    };

    ns.app = app;

})(jQuery, document, F);
