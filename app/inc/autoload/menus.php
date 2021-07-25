<?php
$arr_to_add_menu = array(
    'nav-for-mobile' => 'NAV for mobile',

    'top-menu-01' => 'Top menu 01',
    'top-menu-02' => 'Top menu 02',
    'top-menu-03' => 'Top menu 03',
    'top-menu-04' => 'Top menu 04',
    'top-menu-05' => 'Top menu 05',
    'top-menu-06' => 'Top menu 06',

    'footer-menu-01' => 'Footer menu 01',
    'footer-menu-02' => 'Footer menu 02',
    'footer-menu-03' => 'Footer menu 03',
    'footer-menu-04' => 'Footer menu 04',
    'footer-menu-05' => 'Footer menu 05',
    'footer-menu-06' => 'Footer menu 06',
    'footer-menu-07' => 'Footer menu 07',
    'footer-menu-08' => 'Footer menu 08',
    'footer-menu-09' => 'Footer menu 09',
    'footer-menu-10' => 'Footer menu 10',

    'profile-menu-wgr' => 'Profile menu (WGR)'
);

/*
 * Tạo menu cho theme, cứ dựa theo giao diện, thứ tự menu từ trái -> phải, trên -> dưới
 */
foreach ( $arr_to_add_menu as $k => $v ) {
    register_nav_menu( $k, $v );
}