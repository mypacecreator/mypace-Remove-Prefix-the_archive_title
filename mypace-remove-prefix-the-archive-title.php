<?php
/*
Plugin Name: mypace Remove Prefix the_archive_title
Plugin URI: https://github.com/mypacecreator/mypace-remove-prefix-the-archive-title
Description: the_archive_title()タグ使用時に「アーカイブ:」とか「カテゴリー:」とかつかないように
Author: Kei Nomura
Version: 0.1
Author URI: http://mypacecreator.net/
*/

function mypace_remove_prefix( $title ) {
	if( is_category() ) {
		$title = single_cat_title( '', false );
	} elseif ( is_post_type_archive() ) {
		$title = post_type_archive_title( '', false );
	} elseif ( is_tax() ) {
		$tax = get_query_var('taxonomy'); //今見てるアーカイブページのタクソノミー名を取得
		$get_post_type = get_taxonomy( $tax );
		$post_type_slug = $get_post_type->object_type[0]; //タクソノミーに紐付いている投稿タイプのスラッグを取得
		$get_post_type_object = get_post_type_object( $post_type_slug );
		$post_type_name = $get_post_type_object->labels->name;
		$title = $post_type_name . ' - ' . single_term_title( '', false );
	} elseif ( is_home() && !is_front_page() ) {
		$title = single_post_title( '', false );
	}
	return $title;
}
add_filter( 'get_the_archive_title', 'mypace_remove_prefix' );
