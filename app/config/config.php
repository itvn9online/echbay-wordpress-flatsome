<?php


/*
 * Kiểm tra người dùng đăng nhập chưa
 */
$mtv_id = 0;
$mtv_email = '';

//
//echo is_user_logged_in();
if ( is_user_logged_in() ) {
    $eb_user_info = wp_get_current_user();
    //	print_r( $eb_user_info );

    //
    $mtv_id = $eb_user_info->ID;
    //echo $mtv_id;

    $mtv_email = $eb_user_info->user_email;
    //echo $mtv_email;
}
define( 'mtv_id', $mtv_id );
define( 'mtv_email', $mtv_email );


// thiết lập url -> có ssl hoặc ko
$eb_web_protocol = 'http';
if ( $_SERVER[ 'SERVER_PORT' ] == 443 ||
    ( isset( $_SERVER[ 'HTTPS' ] ) && $_SERVER[ 'HTTPS' ] == 'on' ) ||
    ( isset( $_SERVER[ 'HTTP_X_FORWARDED_PROTO' ] ) && $_SERVER[ 'HTTP_X_FORWARDED_PROTO' ] == 'https' ) ) {
    $eb_web_protocol = 'https';
}
define( 'eb_web_protocol', $eb_web_protocol );


//
//echo $wpdb->postmeta . '<br>';
define( 'wp_postmeta', $wpdb->postmeta );
//echo wp_postmeta;
define( 'wp_termmeta', $wpdb->termmeta );
//echo $wpdb->posts . '<br>';
define( 'wp_posts', $wpdb->posts );

// 404 monitor
define( 'eb_log_404_id_postmeta', 100000404 );

//
require WGR_APP_PATH . 'inc/functions.php';
require WGR_APP_PATH . 'inc/private_setting.php';
require WGR_APP_PATH . 'inc/default_config.php';
include WGR_APP_PATH . 'inc/lang/vi.php';
require WGR_APP_PATH . 'inc/cache.php';
include EB_THEME_CORE . 'curl.php';


// mảng danh sách các định dạng quảng cáo
$arr_eb_ads_status = array(
    0 => '[ Không hiển thị ]',
    1 => EBE_get_lang( 'ads_status1' ),
    4 => EBE_get_lang( 'ads_status4' ),
    5 => EBE_get_lang( 'ads_status5' ),
    6 => EBE_get_lang( 'ads_status6' ),
    7 => EBE_get_lang( 'ads_status7' ),
    8 => EBE_get_lang( 'ads_status8' ),
    9 => EBE_get_lang( 'ads_status9' ),
    10 => EBE_get_lang( 'ads_status10' ),
    11 => EBE_get_lang( 'ads_status11' ),
    12 => EBE_get_lang( 'ads_status12' ),
    13 => EBE_get_lang( 'ads_status13' ),
    14 => EBE_get_lang( 'ads_status14' ),
    15 => EBE_get_lang( 'ads_status15' )
);

$arr_eb_product_status = array(
    0 => EBE_get_lang( 'product_status0' ),
    1 => EBE_get_lang( 'product_status1' ),
    2 => EBE_get_lang( 'product_status2' ),
    3 => EBE_get_lang( 'product_status3' ),
    4 => EBE_get_lang( 'product_status4' ),
    5 => EBE_get_lang( 'product_status5' ),
    6 => EBE_get_lang( 'product_status6' ),
    7 => EBE_get_lang( 'product_status7' ),
    8 => EBE_get_lang( 'product_status8' ),
    9 => EBE_get_lang( 'product_status9' ),
    10 => EBE_get_lang( 'product_status10' )
);

$arr_eb_product_gender = array(
    0 => EBE_get_lang( 'product_unisex_gender' ),
    1 => EBE_get_lang( 'product_male_gender' ),
    2 => EBE_get_lang( 'product_female_gender' )
);

$arr_eb_category_gender = array(
    0 => EBE_get_lang( 'product_unisex_gender' ),
    1 => EBE_get_lang( 'product_male_gender' ),
    2 => EBE_get_lang( 'product_female_gender' )

);


//
$arr_active_for_404_page = array(
    "eb_export_products" => 1,
    "order_export" => 1,

    "test_email" => 1,
    "billing_print" => 1,

    "cart" => 1,
    "contact" => 1,

    "favorite" => 1,
    "golden_time" => 1,
    "products_hot" => 1,
    "products_new" => 1,
    "products_selling" => 1,
    "products_sales_off" => 1,
    "products_all" => 1,

    "hoan-tat" => 1,
    "ebsearch" => 1,
    "duplicate_post" => 1,

    // sitemap tổng
    "sitemap" => 1,
    // cho category, tags, post options
    "sitemap-tags" => 1,
    // sitemap cho post
    "sitemap-post" => 1,
    "sitemap-post-images" => 1,
    "sitemap-all-images" => 1,
    // cho blogs
    //	"sitemap-blogs" => 1,
    // cho blog
    "sitemap-blog" => 1,
    // sitemap sitemap cho hình ảnh (sản phẩm)
    "sitemap-images" => 1,
    // sitemap sitemap cho hình ảnh (blog)
    "sitemap-blog-images" => 1,
    // for page
    "sitemap-page" => 1,
    "sitemap-page-images" => 1,
    "sitemap-other-images" => 1,

    "temp" => 1,

    // cài đặt tự động tài khoản admin
    "wgr-install" => 1,

    "profile" => 1,
    "password" => 1,
    "process" => 1,

    "eb-login" => 1,
    "eb-register" => 1,
    "eb-quick-register" => 1,
    "eb-fogotpassword" => 1,
    "resetpassword" => 1,

    "eb-ajaxservice" => 1,
    "download_img_to_site" => 1,
    "get_post_id_for_menu" => 1,

    "php_info" => 1,
    "eb-load-quick-search" => 1
);

// nếu theme có hỗ trợ nhiều định dạng q.cáo khác -> add vào
if ( isset( $arr_eb_ads_custom_status ) ) {
    //	print_r( $arr_eb_ads_custom_status );

    foreach ( $arr_eb_ads_custom_status as $k => $v ) {
        $arr_eb_ads_status[ $k ] = $v;
    }
    //	print_r( $arr_eb_ads_status );
}


// chế độ kiểm thử
//define( 'cf_tester_mode', true );
if ( $__cf_row[ 'cf_tester_mode' ] == 1 ) {
    define( 'eb_code_tester', true );
} else {
    define( 'eb_code_tester', false );
}

// chế độ riêng của trang rao vặt
define( 'cf_set_raovat_version', $__cf_row[ 'cf_set_raovat_version' ] );
define( 'cf_remove_raovat_meta', $__cf_row[ 'cf_remove_raovat_meta' ] );

// sidebar mặc định
define( 'WGR_DEFAULT_SIDEBAR', 'main_sidebar' );

// Định dang riêng cho post type blog
define( 'EB_BLOG_POST_TYPE', 'blog' );
define( 'EB_BLOG_POST_LINK', 'blogs' );

if ( !defined( 'FTP_HOST' ) ) {
    //	define( 'FTP_HOST', $_SERVER['HTTP_HOST'] );
    define( 'FTP_HOST', $_SERVER[ 'SERVER_ADDR' ] );
}

/*
 * Mặc định là không cho edit theme, plugin nếu sử dụng bản miễn phí
 * Kích hoạt bằng cách set thủ công trong wp-config.php
 */
if ( !defined( 'DISALLOW_FILE_EDIT' ) ) {
    if ( $__cf_row[ 'cf_alow_edit_plugin_theme' ] != 1 ) {
        define( 'DISALLOW_FILE_EDIT', true );
    } else {
        define( 'DISALLOW_FILE_EDIT', false );
    }
}

/*
 * Mặc định là không cho update, install theme, plugin nếu sử dụng bản miễn phí
 * Kích hoạt bằng cách set thủ công trong wp-config.php
 */
if ( !defined( 'DISALLOW_FILE_MODS' ) ) {
    if ( $__cf_row[ 'cf_alow_edit_plugin_theme' ] != 1 ) {
        define( 'DISALLOW_FILE_MODS', true );
    } else {
        define( 'DISALLOW_FILE_MODS', false );
    }
}

/*
 * Giới hạn số lần tối đa để lưu các bản nháp của bài viết, tự động xóa khi có quá 3 bài
 */
if ( !defined( 'WP_POST_REVISIONS' ) ) {
    define( 'WP_POST_REVISIONS', 3 );
}

/*
 * Gán mặc định tham số cho thư mục của admin nếu chưa có
 */
if ( !defined( 'WP_ADMIN_DIR' ) ) {
    define( 'WP_ADMIN_DIR', 'wp-admin' );
}

//
define( 'admin_link', web_link . WP_ADMIN_DIR . '/' );