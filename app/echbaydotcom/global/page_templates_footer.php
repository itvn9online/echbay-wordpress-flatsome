<?php

// get custom content
$main_content = ob_get_contents();

//
ob_end_clean();
//echo $main_content;



// thay thế dữ liệu
/*
if ( $__cf_row['cf_replace_content'] != '' ) {
	$main_content = WGR_replace_for_all_content( $__cf_row['cf_replace_content'], $main_content );
}

// nếu tồn tại tham số URL cũ -> thay nội dung cũ sang mới
if ( $__cf_row['cf_old_domain'] != '' ) {
	$main_content = WGR_sync_old_url_in_content( $__cf_row['cf_old_domain'], $main_content );
}
*/



// nếu bài viết được đánh dấu để set noindex -> set thuộc tính noindex
if ( _eb_get_post_object( $post->ID, '_eb_product_noindex', 0 ) == 1 ) {
	$__cf_row ["cf_blog_public"] = 0;
}
/*
if ( mtv_id == 1 ) {
	print_r($post);
	print_r($__cf_row);
}
*/



// chỉnh lại phần SEO dành riêng cho trang chủ
//echo _eb_get_option('show_on_front') . '<br>' . "\n";
//echo _eb_get_option('page_on_front') . '<br>' . "\n";

/*
//if ( cf_on_off_echbay_seo == 1 && is_home() ) {
if ( cf_on_off_echbay_seo == 1 && is_front_page() ) {
//	echo 'aaaaaaaaaaaaaaaaaaaaa';
	
	//
	$__cf_row ['cf_title'] = _eb_get_post_object( $post->ID, '_eb_product_title' );
//	echo $__cf_row ['cf_title'] . '<br>' . "\n";
	if ( $__cf_row ['cf_title'] == '' ) {
		$__cf_row ['cf_title'] = _eb_get_option('blogname');
	}
//	echo $__cf_row ['cf_title'] . '<br>' . "\n";
	
	$__cf_row ['cf_keywords'] = _eb_get_post_object( $post->ID, '_eb_product_keywords' );
	if ( $__cf_row ['cf_keywords'] == '' ) {
		$__cf_row ['cf_keywords'] = $__cf_row ['cf_title'];
	}
	
	$__cf_row ['cf_description'] = _eb_get_post_object( $post->ID, '_eb_product_description', $post->post_excerpt );
	if ( $__cf_row ['cf_description'] == '' ) {
		$__cf_row ['cf_description'] = $post->post_title;
	}
	$__cf_row['cf_description'] = _eb_del_line( str_replace( '"', '&quot;', strip_tags( $__cf_row['cf_description'] ) ), ' ' );
}
*/




// thêm phần sidebar vào chân trang
$main_content .= _eb_echbay_get_sidebar( 'page_content_sidebar' );



// giới hạn chiều rộng nếu có
if ( isset( $__cf_row['cf_custom_page_width_main'] ) ) {
	$main_content = '<div class="' . $__cf_row['cf_custom_page_width_main'] . '">' . $main_content . '</div>';
}



//
$private_post_link_javascript = _eb_get_post_object( $post->ID, '_eb_product_link_javascript' );
if ( $private_post_link_javascript != '' ) {
	$main_content .= '<script type="text/javascript" src="' . $private_post_link_javascript . '" async>';
}



// show content
include_once EB_THEME_URL . 'index.php';
