<?php
/*
 * Nạp các file tĩnh cần thiết cho hệ thống
 */
// head
function EB_flatsome_load_header_static() {
    /*
     * nạp base -> mình quen dùng kiểu này
     */
    echo '<base href="' . Wgr::$eb->BaseModelWgr->base_url . '" />';


    /*
     * lấy các màu sắc được được thiết lập trong theme
     */
    $theme_mod = get_theme_mods();
    //print_r( $theme_mod );

    $arr_root_color = [];
    if ( !isset( $theme_mod[ 'color_primary' ] ) ) {
        $theme_mod[ 'color_primary' ] = '#446084';
    }
    //$arr_root_color[] = '--root-color: ' . $theme_mod[ 'color_primary' ];
    $arr_root_color[] = '--main-color: ' . $theme_mod[ 'color_primary' ];
    $arr_root_color[] = '--default-bg: ' . $theme_mod[ 'color_primary' ];

    if ( !isset( $theme_mod[ 'color_secondary' ] ) ) {
        $theme_mod[ 'color_secondary' ] = '#d26e4b';
    }
    $arr_root_color[] = '--sub-color: ' . $theme_mod[ 'color_secondary' ];
    $arr_root_color[] = '--default2-bg: ' . $theme_mod[ 'color_secondary' ];

    if ( !isset( $theme_mod[ 'color_success' ] ) ) {
        $theme_mod[ 'color_success' ] = '#7a9c59';
    }
    $arr_root_color[] = '--success-color: ' . $theme_mod[ 'color_success' ];

    if ( !isset( $theme_mod[ 'color_alert' ] ) ) {
        $theme_mod[ 'color_alert' ] = '#b20000';
    }
    $arr_root_color[] = '--alert-color: ' . $theme_mod[ 'color_alert' ];

    if ( !isset( $theme_mod[ 'color_texts' ] ) ) {
        $theme_mod[ 'color_texts' ] = '#777';
    }
    $arr_root_color[] = '--text-color: ' . $theme_mod[ 'color_texts' ];
    $arr_root_color[] = '--texts-color: ' . $theme_mod[ 'color_texts' ];
    $arr_root_color[] = '--default-color: ' . $theme_mod[ 'color_texts' ];

    if ( !isset( $theme_mod[ 'type_headings_color' ] ) ) {
        $theme_mod[ 'type_headings_color' ] = '#555';
    }
    $arr_root_color[] = '--h-color: ' . $theme_mod[ 'type_headings_color' ];

    if ( !isset( $theme_mod[ 'color_links' ] ) ) {
        $theme_mod[ 'color_links' ] = '#4e657b';
    }
    $arr_root_color[] = '--a-color: ' . $theme_mod[ 'color_links' ];

    if ( !isset( $theme_mod[ 'color_links_hover' ] ) ) {
        $theme_mod[ 'color_links_hover' ] = '#111';
    }
    $arr_root_color[] = '--a-hover-color: ' . $theme_mod[ 'color_links_hover' ];

    // các màu có thì mới in ra
    if ( isset( $theme_mod[ 'color_divider' ] ) ) {
        $arr_root_color[] = '--divider-color: ' . $theme_mod[ 'color_divider' ];
    }
    if ( isset( $theme_mod[ 'color_widget_links' ] ) ) {
        $arr_root_color[] = '--widget-color: ' . $theme_mod[ 'color_widget_links' ];
    }
    if ( isset( $theme_mod[ 'color_widget_links_hover' ] ) ) {
        $arr_root_color[] = '--widget-hover-color: ' . $theme_mod[ 'color_widget_links_hover' ];
    }
    echo '<style>:root {' . implode( ';', $arr_root_color ) . '}</style>';


    /*
     * nạp các file css, js dùng chung từ core
     */
    Wgr::$eb->BaseModelWgr->add_css( __DIR__ . '/public/css/d.css' );
}
add_action( 'wp_head', 'EB_flatsome_load_header_static', 0 );

// footer
function EB_flatsome_load_footer_static() {
    //
}
add_action( 'wp_footer', 'EB_flatsome_load_footer_static', 0 );