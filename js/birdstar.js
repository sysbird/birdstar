jQuery(function() {

	jQuery( window ).load(function() {
		// Masonry for Footer
		jQuery( '#widget-area .container' ).masonry({
			itemSelector: '.widget',
			isAnimated: true
		});
	});

	// Navigation dropdown menu for mobile
	jQuery( '#menu-primary-items .menu-item-has-children' ).each(function(){
		jQuery( this ).append( '<span></span>' );
	});

	jQuery( '#menu-primary-items .menu-item-has-children span' ).click( function(){
		jQuery( this ).parent().children( 'ul' ).slideToggle( 'normal', function(){
			jQuery( this ).parent().toggleClass( 'open' );
		});
	});

	// Navigation for mobile
	jQuery( "#small-menu" ).click( function(){
		jQuery( "#menu-primary-items" ).slideToggle();
	});

	// back to pagetop
    var totop = jQuery( '#back-top' );
    totop.hide();
    jQuery( window ).scroll(function () {
        if ( jQuery( this ).scrollTop() > 800 ) totop.fadeIn(); else totop.fadeOut();
    });

	// rakuten
	if(undefined != jQuery("#rakuten").attr("id")){
		okc_rakuten();
	}

    totop.click( function () {
        jQuery( 'body, html' ).animate( { scrollTop: 0 }, 500 ); return false;
    });
});

////////////////////////////////////////////////////////////
// 楽天アフィリエイト
function okc_rakuten() {

	// ジャンル
	//<genreId>201136</genreId><genreName>チョコレート</genreName>
	//<genreId>405018</genreId><genreName>スナック菓子</genreName>
	//<genreId>201123</genreId><genreName>クッキー</genreName>
	//<genreId>214203</genreId><genreName>あめ・キャンディ</genreName>
	//genreId>203236</genreId><genreName>せんべい</genreName>
	var genre = new Array("405018", "201136", "201123", "214203", "203236");
	var slug = new Array("snack", "chocolate", "cookie", "candy", "senbei");

	var genre_id = 100283;
	var current_slug = jQuery("body").attr("id");
	for(i = 0; i <slug.length; i++){
		if( current_slug == slug[i]){
			genre_id = genre[i];
			break;
		}
	}

var category = jQuery('.hentry').attr('class');
	for(i = 0; i <slug.length; i++){
		if(-1 != category.indexOf(slug[i])){
			genre_id = genre[i];
			break;
		}
	}

	// リクエストURL
	var url = 'http://api.rakuten.co.jp/rws/2.0/json?developerId=276d09f5b666edacad50582ef616e777&affiliateId=0ad4cbbe.b046bbec.0ad4cbbf.141f7d6e&operation=ItemSearch&version=2009-04-15&genreId=' + genre_id;

	// キーワード
	var keyword = jQuery(".icon.tag").text();
	if(keyword.length){
		keyword.replace(',' ,' ');
		url += '&keyword=' + encodeURI(keyword);
	}

	url += '&orFlag=1&sort=standard&imageFlag=1&callBack=okc_rakuten_callback';

	// リクエスト
	var target = document.createElement( 'script' );
	target.charset = 'utf-8';
	target.type = 'text/javascript';
	target.src = url;
	document.body.appendChild( target );
}

////////////////////////////////////////////////////////////
// 楽天アフィリエイト コールバック
function okc_rakuten_callback(data, status) {

	var item = data.Body.ItemSearch.Items.Item;
	var html = "";

	var now = new Date();
	var sec = now.getSeconds();
	var index = sec % item.length;
	for( var i = 0; i < item.length; i++ ) {

		if(i == index){
			var url = item[i].affiliateUrl;
			html += '<a href="' + url + '" target="_blank"><img src="' + item[i].smallImageUrl + '" alt="楽天"></a>';
			html += '<p><a href="' + url + ' " target="_blank">' + item[i].itemName + '</a></p>';
			html += '<p class="detail"><a href="' + url + '" target="_blank">【楽天市場】で詳しく見る</a></p>';
		}
	}

	jQuery("#rakuten").html(html);
}

