<?php


/*
 * Widget blog ngẫu nhiên
 */
class ___echbay_widget_banner_big extends WP_Widget {
    function __construct() {
        parent::__construct( 'echbay_banner_big', 'zEchBay Big Banner', array(
            'description' => 'Nhúng banner loại lớn vào website'
        ) );
    }

    function form( $instance ) {
        $default = array(
            'title' => 'Big Banner',
            'width' => '',
            'custom_style' => '',
            'full_mobile' => '',
            'hide_mobile' => '',
            'cat_ids' => 0,
            'cat_type' => 'post_options',
            'custom_size' => '',
            'num_for_get' => '',
            'for_home' => ''
        );
        $instance = wp_parse_args( ( array )$instance, $default );
        $ops_shortcode = [];
        foreach ( $instance as $k => $v ) {
            $$k = esc_attr( $v );

            $ops_shortcode[] = $k . '="' . $$k . '"';
        }
        //print_r( $instance );

        //
        $arr_field_name = array();
        foreach ( $default as $k => $v ) {
            $arr_field_name[ $k ] = $this->get_field_name( $k );
        }


        // form dùng chung cho phần top, footer
        _eb_top_footer_form_for_widget( $instance, $arr_field_name );


        //
        _eb_widget_echo_widget_input_checkbox( $arr_field_name[ 'for_home' ], $for_home, 'For home', 'Khi sử dụng template page, chức năng load big banner không hoạt động, khi đó cần phải kích hoạt chức năng này để nó có thể lấy big banner theo tiêu chuẩn mặc định.' );


        //
        echo '<p class="bold">Thiết lập big banner riêng theo post_options:</p>';

        //
        __eb_widget_load_cat_select( array(
            //			'cat_ids_name' => $this->get_field_name ( 'cat_ids' ),
            'cat_ids_name' => $arr_field_name[ 'cat_ids' ],
            'cat_ids' => $cat_ids,
            //			'cat_type_name' => $this->get_field_name ( 'cat_type' ),
            'cat_type_name' => $arr_field_name[ 'cat_type' ],
            'cat_type' => 'post_options'
        ), 'post_options', false );

        echo '<p>* Khi muốn lấy banner trong một <strong>post_options</strong> cụ thể nào đó, thì có thể chọn tại đây. Câu lệnh chỉ lấy các banner có trạng thái là: <strong>0</strong></p>';


        //
        echo '<p><strong>Tùy chỉnh size ảnh</strong>: <input type="text" class="widefat fixed-size-for-config" name="' . $arr_field_name[ 'custom_size' ] . '" value="' . $custom_size . '" /> * Điều chỉnh size ảnh theo kích thước riêng (nếu có), có thể đặt <strong>auto</strong> để lấy kích thước tự động của ảnh!</p>';


        //
        echo '<p><strong>Số lượng hiển thị</strong>: <input type="text" class="widefat" name="' . $arr_field_name[ 'num_for_get' ] . '" value="' . $num_for_get . '" /> * Mặc định sẽ lấy theo số lượng được nhập <a href="' . admin_link . 'admin.php?page=eb-coder&edit_key=lang_eb_bigbanner_num" target="_blank">tại đây</a>, nếu bạn muốn tùy chỉnh nó thì nhập một con số khác vào.</p>';


        //
        echo '<p><strong>Shortcode</strong>: <textarea class="widefat" readonly>[echbay_big_banner ' . implode( ' ', $ops_shortcode ) . ']</textarea></p>';

    }

    function update( $new_instance, $old_instance ) {
        $instance = _eb_widget_parse_args( $new_instance, $old_instance );
        return $instance;
    }

    function widget( $args, $instance ) {
        extract( $args );

        //
        //print_r( $instance );
        //$instance[ 'this_name' ] = $this->name;
        //print_r( $instance );

        action_echbay_big_banner( $instance );
    }
}