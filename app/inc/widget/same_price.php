<?php




/*
* Widget lấy sản phẩm cùng mức giá (thường dùng trong trang chi tiết sản phẩm)
*/

class ___echbay_widget_same_same_price extends WP_Widget {
	function __construct() {
		parent::__construct ( 'eb_get_same_same_price', 'EchBay same price', array (
				'description' => 'Lấy các sản phẩm có mức giá xấp xỉ (mặc định là 10%) với sản phẩm đang xem! Chỉ hoạt động trong trang chi tiết sản phẩm.'
		) );
	}
	
	function form($instance) {
		$default = array (
			'title' => 'EchBay same price',
			// phạm vi giá sẽ lấy so với giá sản phẩm đang xem
			'min_price' => 10,
			'post_number' => 5,
			'custom_style' => '',
			'num_line' => 'thread-list20',
		);
		$instance = wp_parse_args ( ( array ) $instance, $default );
		foreach ( $instance as $k => $v ) {
			$$k = esc_attr ( $v );
		}
		
		
		echo '<p>Title: <input type="text" class="widefat" name="' . $this->get_field_name ( 'title' ) . '" value="' . $title . '" /></p>';
		
		
		echo '<p>Same price (± %): ';
		__eb_widget_load_select(
			array (
				5 => 5,
				10 => 10,
				15 => 15,
				20 => 20,
				25 => 25,
				30 => 30,
				35 => 35,
				40 => 40,
				45 => 45,
				50 => 50,
				55 => 55,
			),
			$this->get_field_name ( 'min_price' ),
			$min_price
		);
		echo '</p>';
		
		
		_eb_widget_echo_number_of_posts_to_show( $this->get_field_name ( 'post_number' ), $post_number );
		
		
		_eb_widget_number_of_posts_inline( $this->get_field_name('num_line'), $num_line );
		
		
		echo '<p>Custom CSS: <input type="text" class="widefat" name="' . $this->get_field_name('custom_style') . '" value="' . $custom_style . '"/> * Tạo class CSS để custom riêng:
		- <strong>title-center</strong>: căn chữ ra giữa đồng thời tạo style mới cho tiêu đề chính.<br>
		- <strong>title-bold</strong>: in đậm tiêu đề chính.<br>
		- <strong>title-upper</strong>: viết HOA tiêu đề chính.<br>
		- <strong>title-line</strong>: thêm gạch ngang trên tiêu đề chính.<br>
		- <strong>title-line50</strong>: kết hợp với title-line with: 50%<br>
		- <strong>title-line-bg</strong>: + <strong>title-line</strong> + default-bg<br>
		- <strong>title-top-line</strong>: + <strong>title-line</strong> + top<br>
		- <strong>title-bottom-line</strong>: + <strong>title-line</strong> + bottom<br>
		- <strong>title-line20</strong>: + <strong>title-line</strong> + width 20%, max-width 90px<br>
		- <strong>title-line38</strong>: + <strong>title-line</strong> + width 38%, max-width 250px<br>
		- <strong>home-hot2-title</strong>: Style mới cho phần widget tilte.<br>
		- <strong>noborder-widget-title</strong>: Ẩn border của widget.<br>
		- <strong>hide-widget-title</strong>: Ẩn tiêu đề của widget.</p>';
		
	}
	
	function update($new_instance, $old_instance) {
		$instance = _eb_widget_parse_args ( $new_instance, $old_instance );
		return $instance;
	}
	
	function widget($args, $instance) {
		global $pid;
		
		//
		if ( $pid == 0 ) {
			echo '<p>Widget same price has been call, but PID not found!</p>';
			return false;
		}
		
		extract ( $args );
		
		$title = apply_filters ( 'widget_title', $instance ['title'] );
		$min_price = isset( $instance ['min_price'] ) ? $instance ['min_price'] : 0;
		$post_number = isset( $instance ['post_number'] ) ? $instance ['post_number'] : 5;
		$custom_style = isset( $instance ['custom_style'] ) ? $instance ['custom_style'] : '';
		$num_line = isset( $instance ['num_line'] ) ? $instance ['num_line'] : '';
//		echo $num_line;
//		echo $post_number;
		
		//
//		_eb_echo_widget_title( $title, 'echbay-widget-price-title', $before_title );
		
		//
		$trv_giamoi = _eb_float_only( _eb_get_post_object( $pid, '_eb_product_price', 0 ) );
		if ( $trv_giamoi <= 0 ) {
			echo '<!-- Widget same price has been call, but price is ZERO! -->';
			return false;
		}
		$percent_price = $trv_giamoi/ 100 * $min_price;
//		echo $percent_price;
		
		//
		$price_in = array(
			'key' => '_eb_product_price',
			// value should be array of (lower, higher) with BETWEEN
			'value' => array( $trv_giamoi - $percent_price, $trv_giamoi + $percent_price ),
			'type' => 'NUMERIC',
//			'type' => 'numeric',
			'compare' => 'BETWEEN'
		);
//		print_r( $price_in );
		
		//
		$str_same_price = _eb_load_post(
			$post_number,
			array(
				'post__not_in' => array( $pid ),
				'meta_query' => array( $price_in ),
				'ignore_sticky_posts' => 1
			),
			__eb_thread_template,
			// lấy hết, bỏ qua bộ lọc post__not_in
			1
		);
		
		//
		_eb_echo_widget_name( $this->name, $before_widget );
		
		//
		if ( $str_same_price != '' ) {
			echo '<div class="' . trim( 'eb-same-price widget-other-post hide-if-quickview ' . $custom_style ) . '">';
			
			echo WGR_show_home_hot( array(
				'tmp.num_post_line' => $num_line,
				'tmp.home_hot_title' => WGR_widget_title_with_bbcode( $title ),
				'tmp.home_hot' => $str_same_price
			) );
			
			echo '</div>';
		}
		else {
			echo '<!-- same_price == NULL -->';
		}
		
		//
		echo $after_widget;
	}
}




