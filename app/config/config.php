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


//
//echo $wpdb->postmeta . '<br>';
define( 'wp_postmeta', $wpdb->postmeta );
//echo wp_postmeta;
define( 'wp_termmeta', $wpdb->termmeta );
//echo $wpdb->posts . '<br>';
define( 'wp_posts', $wpdb->posts );

//
require WGR_APP_PATH . 'inc/functions.php';
require WGR_APP_PATH . 'inc/private_setting.php';
require WGR_APP_PATH . 'inc/default_config.php';
include WGR_APP_PATH . 'inc/lang/vi.php';
require WGR_APP_PATH . 'inc/cache.php';

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