<?php
//if ( !defined( 'ABSPATH' ) )die( 'No direct script access allowed #' . basename( __FILE__ . ':' . __LINE__ ) );

/*
 * Thêm đoạn code này vào file function trong child-theme flatsome
require dirname( dirname( __DIR__ ) ) . '/echbay-wordpress-flatsome/autoload.php';
 */

// path to MVC
define( 'WGR_APP_PATH', __DIR__ . '/app/' );
require WGR_APP_PATH . 'config/config.php';


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
require WGR_APP_PATH . 'inc/add_action.php';

// custom post type/ taxonomy
require WGR_APP_PATH . 'inc/taxonomy.php';
require WGR_APP_PATH . 'inc/post-type.php';

// nạp tất cả các file trong autoload
foreach ( glob( WGR_APP_PATH . 'inc/autoload/*.php' ) as $filename ) {
    //echo $filename . '<br>' . "\n";
    include $filename;
}

$arr_wgr_autoload = [
    // nạp các shortcode
    'shortcode',
];

foreach ( $arr_wgr_autoload as $v ) {
    foreach ( glob( WGR_APP_PATH . 'inc/autoload/' . $v . '/*.php' ) as $filename ) {
        //echo $filename . '<br>' . "\n";
        include $filename;
    }
}