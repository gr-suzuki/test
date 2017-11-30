<?php

//概要（抜粋）の文字数
function my_length($length) {
	return 50;
}
add_filter('excerpt_mblength','my_length');

//概要（抜粋）の省略記号
function my_more($more) {
	return '…';
}
add_filter('excerpt_more', 'my_more');


//コンテンツの最大幅
if ( !isset( $content_width ) ) {
	$content_width = 747;
}


//YouTubeのビデオ：<div>でマークアップ
function ytwrapper($return, $data, $url) {
	if ($data->provider_name == 'YouTube') {
		return '<div class="ytvideo">'.$return.'</div>';
	} else {
		return $return;
	}
}
add_filter('oembed_dataparse','ytwrapper',10,3);


//YouTubeのビデオ：キャッシュをクリア
//function clear_ytwrapper($post_id) {
//	global $wp_embed;
//	$wp_embed->delete_oembed_caches($post_id);
//}
//add_action('pre_post_update', 'clear_ytwrapper');



//アイキャッチ画像
add_theme_support( 'post-thumbnails' );



//編集画面の設定
function editor_setting($init) {
	$init['block_formats'] = 'Paragraph=p;Heading 2=h2;Heading 3=h3;Heading 4=h4;Heading 5=h5;Heading 6=h6;Preformatted=pre';

	$style_formats = array(
		array(
			'title' => '補足情報',
			'block' => 'div',
			'classes' => 'point'
		),
		array(
			'title' => '注意書き',
			'block' => 'div',
			'classes' => 'attention'
		)
	);

	$init['style_formats'] = json_encode( $style_formats );


	return $init;
}
add_filter('tiny_mce_before_init', 'editor_setting');



//スタイルメニューを有効化
function add_stylemenu( $buttons ){
	array_splice( $buttons, 1, 0, 'styleselect' );
	return $buttons;
}
add_filter( 'mce_buttons_2', 'add_stylemenu' );



// エディタスタイルシート
add_editor_style();
add_editor_style( '//maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css' );



// サムネイル画像
function mythumb( $size ) {

	if( has_post_thumbnail() ) {
		$postthumb = wp_get_attachment_image_src( get_post_thumbnail_id(), $size );
		$url = $postthumb[0];
	} else {
		$url = get_template_directory_uri() . '/picnic.jpg';
	}

	return $url;

}



// カスタムメニュー
register_nav_menu( 'sitenav', 'サイトナビゲーション' );
register_nav_menu( 'pickupnav', 'おすすめ記事' );
register_nav_menu( 'pagenav', 'ページナビゲーション' );


// トグルボタン
function navbtn_scripts() {

	wp_enqueue_script( 'navbtn-script', get_template_directory_uri() .'/navbtn.js', array('jquery') );
}
add_action( 'wp_enqueue_scripts', 'navbtn_scripts' );



// ウィジェットエリア
register_sidebar( array(
	'id' => 'submenu',
	'name' => ' サブメニュー',
	'description' => 'サイドバーに表示するウィジェットを指定。',
	'before_widget' => '<aside id="%1$s" class="mymenu widget %2$s">',
	'after_widget' => '</aside>',
	'before_title' => '<h2 class="widgettitle">',
	'after_title' => '</h2>'
) );

register_sidebar( array(
	'id' => 'ad',
	'name' => '広告',
	'description' => 'サイドバーに表示する広告を指定。',
	'before_widget' => '<aside id="%1$s" class="myad mymenu widget %2$s">',
	'after_widget' => '</aside>',
	'before_title' => '<h2 class="widgettitle">',
	'after_title' => '</h2>'
) );


// 検索フォーム
add_theme_support( 'html5', array('search-form') );


// ヘッダー画像
add_theme_support( 'custom-header', array(
	'width' => 1000,
	'height' => 300,
	'header-text' => false
) );


