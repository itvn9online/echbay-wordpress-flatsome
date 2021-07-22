<?php
//if ( !defined( 'WGR_APP_PATH' ) )die( 'No direct script access allowed #' . basename( __FILE__ . ':' . __LINE__ ) );

/*
* Cách sử dụng:
Wgr::$eb->BaseModelWgr->functionName();
*/

class BaseModelWgr {
    public $base_url = '';

    public function __construct() {
        //
        $this->base_url = get_site_url() . '/';
    }

    public function add_css( $f ) {
        if ( !file_exists( $f ) ) {
            echo '<!-- File not exist: ' . basename( $f ) . ' -->';
            return false;
        }

        //
        echo '<link rel="stylesheet" href="' . str_replace( ABSPATH, '', $f ) . '?v=' . filemtime( $f ) . '" type="text/css" media="all" />';
        return true;
    }
}