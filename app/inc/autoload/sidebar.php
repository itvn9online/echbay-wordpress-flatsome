<?php

/*
 * Tạo sidebar cho theme
 */

$arr_to_add_sidebar = array(
    // main_sidebar
    WGR_DEFAULT_SIDEBAR => 'Sidebar chính của website (dùng cho nhiều trang). Mặc định khi các sidebar khác không có dữ liệu thì side này sẽ được gọi ra để lấp chỗ trống.',

    'home_sidebar' => 'Sidebar cho trang chủ (home)',
    'home_content_top_sidebar' => 'Sidebar cho phần top nội dung của trang chủ (home)',
    'home_content_sidebar' => 'Sidebar cho phần footer nội dung của trang chủ (home)',
    'home_content_bottom_sidebar' => 'Sidebar cho phần bottom nội dung của trang chủ (home)',

    'category_sidebar' => 'Sidebar cho trang danh sách sản phẩm (category)',
    'category_top_content_sidebar' => 'Sidebar cho phần top của trang danh sách sản phẩm (category)',
    'category_content_sidebar' => 'Sidebar cho phần nội dung của trang danh sách sản phẩm (category)',

    'post_sidebar' => 'Sidebar cho trang chi tiết sản phẩm (post)',
    'post_top_content_sidebar' => 'Sidebar cho phần top của trang chi tiết sản phẩm (post)',
    'post_content_sidebar' => 'Sidebar cho phần nội dung của trang chi tiết sản phẩm (post)',

    'blog_sidebar' => 'Sidebar cho trang tin tức (blog)',
    'blog_content_sidebar' => 'Sidebar cho phần nội dung của trang tin tức (blog)',

    'blog_details_sidebar' => 'Sidebar cho trang chi tiết tin (blog details)',
    'blog_content_details_sidebar' => 'Sidebar cho phần nội dung của trang chi tiết tin (blog details)',

    'page_sidebar' => 'Sidebar cho trang tĩnh (page)',
    'page_content_sidebar' => 'Sidebar cho phần nội dung của trang tĩnh (page)',

    'search_product_options' => 'Options cho phần tìm kiếm nâng cao',

    'eb_top_global' => 'Sidebar cho phần TOP của website (* Sử dụng zEchBay Open/ zEchBay Close Tag Tag để tạo các bộ thẻ đóng mở cho từng khối HTML).',
    'eb_footer_global' => 'Sidebar cho phần FOOTER của website (* Sử dụng zEchBay Open Tag/ zEchBay Close Tag để tạo các bộ thẻ đóng mở cho từng khối HTML).',

    'eb_z1_custom_site' => 'Sidebar dự phòng cho một số site sử dụng module riêng',
    //		'eb_z2_custom_site' => 'Sidebar dự phòng cho một số site sử dụng module riêng',
    'eb_z1_recycle_bin' => 'Sidebar này gần như không bao giờ được gọi, nó làm nơi lưu trữ các widget đã được tạo ra, không muốn sử dụng nữa nhưng cũng không muốn xóa hẳn.',
);

// chạy vòng lặp add sidebat
foreach ( $arr_to_add_sidebar as $k => $v ) {
    WGR_register_sidebar( $k, $v );
}