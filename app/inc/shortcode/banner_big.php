<?php

function action_echbay_big_banner( $instance ) {


    //
    //		_eb_echo_widget_name( $this->name, $before_widget );
    echo '<!-- ' . __FUNCTION__ . ' -->';
    if ( empty( $instance ) ) {
        echo '<!-- instance empty -->';
    }

    //print_r( $instance );
    //echo 'aaaaaaaaaaaa';
    //return false;
    global $str_big_banner;

    //		$title = apply_filters ( 'widget_title', $instance ['title'] );
    $title = isset( $instance[ 'title' ] ) ? $instance[ 'title' ] : '';
    $width = isset( $instance[ 'width' ] ) ? $instance[ 'width' ] : '';
    if ( $width != '' )$width .= ' lf';

    $custom_style = isset( $instance[ 'custom_style' ] ) ? $instance[ 'custom_style' ] : '';

    $hide_mobile = isset( $instance[ 'hide_mobile' ] ) ? $instance[ 'hide_mobile' ] : 'off';
    //		$hide_mobile = $hide_mobile == 'on' ? ' hide-if-mobile' : '';
    if ( $hide_mobile == 'on' )$width .= ' hide-if-mobile';

    $full_mobile = isset( $instance[ 'full_mobile' ] ) ? $instance[ 'full_mobile' ] : 'off';
    if ( $full_mobile == 'on' )$width .= ' fullsize-if-mobile';

    $cat_ids = isset( $instance[ 'cat_ids' ] ) ? $instance[ 'cat_ids' ] : 0;
    $custom_size = isset( $instance[ 'custom_size' ] ) ? $instance[ 'custom_size' ] : '';
    $num_for_get = isset( $instance[ 'num_for_get' ] ) ? $instance[ 'num_for_get' ] : '';

    $for_home = isset( $instance[ 'for_home' ] ) ? $instance[ 'for_home' ] : 'off';


    //
    if ( $num_for_get == '' ) {
        $num_for_get = EBE_get_lang( 'bigbanner_num' );
    }
    $num_for_get *= 1;


    //
    $echo_banner = '';


    // nếu có lấy theo ID của nhóm -> lấy luôn theo ID nhóm đó
    //		echo $cat_ids;
    if ( $cat_ids > 0 ) {
        // tắt chế độ lấy theo trang chủ
        //			$for_home = 'off';

        //
        $echo_banner = EBE_get_big_banner( $num_for_get, array(
            'tax_query' => array(
                array(
                    'taxonomy' => 'post_options',
                    'field' => 'term_id',
                    'terms' => $cat_ids,
                    'operator' => 'IN'
                )
            )
        ), array(
            // với những banner này -> chỉ lấy trạng thái là 0
            'by_status' => 0,
            // nạp riêng class để gọi tới chức năng tạo slider -> tránh xung đột
            'class_big_banner' => 'oi_big_banner' . $cat_ids . ' each_big_banner',
            'set_size' => $custom_size
        ) );
    } else {
        if ( $str_big_banner == '' ) {
            if ( $for_home == 'on' ) {
                global $__cf_row;

                if ( $__cf_row[ 'cf_global_big_banner' ] != 1 ) {
                    $str_big_banner = EBE_get_big_banner( $num_for_get, array(
                        'category__not_in' => ''
                    ), array(
                        'set_size' => $custom_size
                    ) );
                }

                //
                if ( $str_big_banner == '' ) {
                    return false;
                }
            } else {
                return false;
            }
        }
        $echo_banner = $str_big_banner;
    }

    //
    echo '<div class="' . str_replace( '  ', ' ', trim( 'top-footer-css ' . $width ) ) . '">';
    //echo $before_title . ' bbbbbbbbbbb <br>' . "\n";

    //
    //		_eb_echo_widget_title( $title, 'echbay-widget-blogs-title', $before_title );


    //
    //		echo '<div class="' . str_replace( '  ', ' ', trim( 'oi_big_banner ' . $custom_style ) ) . '">' . $str_big_banner . '</div>';
    echo '<div class="' . $custom_style . '">' . $echo_banner . '</div>';


    //
    echo '</div>';

    //
    //		echo $after_widget;
}
//create_shortcode_wonder_gotadi();

// cách sử dụng -> vào phần nội dung bài viết rồi nhập: [wonder_gotadi]
add_shortcode( 'echbay_big_banner', 'action_echbay_big_banner' );