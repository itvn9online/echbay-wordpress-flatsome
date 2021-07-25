<?php
//if ( !defined( 'ABSPATH' ) )die( 'No direct script access allowed #' . basename( __FILE__ . ':' . __LINE__ ) );

/*
 * Thêm đoạn code này vào file function trong child-theme flatsome
require dirname( dirname( __DIR__ ) ) . '/echbay-wordpress-flatsome/autoload.php';
 */

require_once __DIR__ . '/ebcache.php';


// nếu thư mục content đã được khai báo -> lấy thư mục theo thông số này
if ( defined( 'WP_CONTENT_DIR' ) ) {
    define( 'EB_DIR_CONTENT', basename( WP_CONTENT_DIR ) );
    define( 'EB_THEME_CONTENT', WP_CONTENT_DIR . '/' );
}
// Không thì khai báo mặc định
else {
    // tên thư mục chứa content
    define( 'EB_DIR_CONTENT', 'wp-content' );

    // thư mục đầy đủ của content
    define( 'WP_CONTENT_DIR', ABSPATH . EB_DIR_CONTENT );

    //	define( 'EB_THEME_CONTENT', EB_WEB_PUBLIC_HTML . EB_DIR_CONTENT . '/' );
    define( 'EB_THEME_CONTENT', WP_CONTENT_DIR . '/' );
}

// path to MVC
define( 'WGR_APP_PATH', __DIR__ . '/app/' );
define( 'EB_THEME_URL', __DIR__ . '/' );
define( 'EB_THEME_PLUGIN_INDEX', EB_THEME_URL );
define( 'EB_URL_TUONG_DOI', EB_DIR_CONTENT . '/echbaydotcom/' );
define( 'eb_default_vaficon', EB_URL_TUONG_DOI . 'favicon.png' );
// thời gian mặc định cho cache
define( 'eb_default_cache_time', 120 );
define( 'EB_THEME_THEME', EB_THEME_URL );
define( 'EB_THEME_HTML', EB_THEME_THEME . 'html/' );

//
$default_all_site_lang = 'vi';
$default_all_timezone = 'Asia/Ho_Chi_Minh';
$date_time = time();
define( 'date_time', $date_time );


// global static class
class Wgr {
    public static $eb = [];
}


//  using an anonymous function for autoload class
/*
if ( function_exists( 'spl_autoload_register' ) ) {
    //echo 'Using: spl_autoload_register <br>' . "\n";

    //
    spl_autoload_register( function ( $class ) {
        $arr_wgr_autoload = [
            // autoload system file (main file)
            'system',
            // autoload model
            'app/models',
            // autoload controllers
            'app/controllers',
            // autoload library and conts file
            'app/libraries',
        ];

        foreach ( $arr_wgr_autoload as $v ) {
            $path = __DIR__ . '/' . $v . '/' . $class . '.php';
            if ( file_exists( $path ) ) {
                //echo $path . '<br>' . "\n";
                include $path;
                break;
            }
        }
    } );
}
// each to autoload all file in folder app
else {
*/
// autoload MVC file
$arr_wgr_autoload = [
    // autoload system file (main file)
    'system',
    // autoload model
    'app/models',
    // autoload controllers
    'app/controllers',
];

foreach ( $arr_wgr_autoload as $v ) {
    foreach ( glob( __DIR__ . '/' . $v . '/*.php' ) as $filename ) {
        //echo $filename . '<br>' . "\n";
        include $filename;

        //
        $classNoExt = basename( $filename, '.php' );
        //echo $classNoExt . '<br>' . "\n";
        Wgr::$eb[ $classNoExt ] = new $classNoExt();
    }
}

// autoload library and conts file
foreach ( glob( __DIR__ . '/app/libraries/*.php' ) as $filename ) {
    //echo $filename . '<br>' . "\n";
    include $filename;
}
/*
}
*/

// conver to object
//print_r( Wgr::$eb );
Wgr::$eb = ( object )Wgr::$eb;
//print_r( Wgr::$eb );

// TEST autoload
//Wgr::$eb->BaseModelWgr->a();
//Wgr::$eb->PostModelWgr->test();
//echo PostType::SHOW . '<br>' . "\n";
/*
$baseModelWgr = new BaseModelWgr();
$baseModelWgr->a();
$postModelWgr = new PostModelWgr();
$postModelWgr->test();
*/

//
require WGR_APP_PATH . 'config/config.php';

//
require WGR_APP_PATH . 'inc/add_action.php';

// custom post type/ taxonomy
require WGR_APP_PATH . 'inc/taxonomy.php';
require WGR_APP_PATH . 'inc/post-type.php';

// nạp tất cả các file trong autoload
foreach ( glob( WGR_APP_PATH . 'inc/autoload/*.php' ) as $filename ) {
    //echo $filename . '<br>' . "\n";
    include $filename;
}

// nạp thư viện shortcode tương ứng cho các widget
foreach ( glob( WGR_APP_PATH . 'inc/shortcode/*.php' ) as $filename ) {
    //echo $filename . '<br>' . "\n";
    include $filename;
}

// sau đó nạp widget để wiget có function mà hiển thị dữ liệu
require WGR_APP_PATH . 'inc/widget.php';

/*
//Bổ sung 1 số trường cho admin
if ( is_admin() ) {
    require WGR_APP_PATH . 'inc/admin-menu.php';
}
*/