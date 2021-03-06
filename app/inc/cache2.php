<?php



// tách riêng phần cache config ra -> phần này chỉ có thay đổi khi người dùng update
include_once __DIR__ . '/cache_config.php';
include_once __DIR__ . '/cache_lang.php';



//
$error_admin_log_cache = WGR_check_syntax( $__eb_cache_conf, $file_last_update, true );
$last_update = 0;
if ( $error_admin_log_cache == '' ) {
	@include_once $__eb_cache_conf;
}
else {
	_eb_log_admin( $error_admin_log_cache );
}
// chấp nhận lần đầu truy cập sẽ lỗi
//@include_once $__eb_cache_conf;




// kiểm tra thời gian tạo cache
$__eb_cache_time = date_time - $__eb_cache_time + rand ( 0, 20 );
//$__eb_cache_time += rand ( 0, 60 );
//echo $__eb_cache_time . '<br>';

//$time_for_update_cache = $cf_reset_cache;
$time_for_update_cache = $__cf_row['cf_reset_cache'];
//echo $time_for_update_cache . '<br>';


// nếu thành viên đang đăng nhập hoặc thời gian cache đã hết -> nạp cache theo thời gian thực
if ( mtv_id > 0 || $__eb_cache_time > $time_for_update_cache ) {
//if ( 1 == 2 ) {
	//
	if ( file_exists( $file_last_update ) ) {
		$last_update = filemtime ( $file_last_update );
	}
	
	// nếu thời gian update cache nhỏ quá -> bỏ qua
//	if ( file_exists ( $file_last_update ) && file_exists ( $__eb_cache_conf ) ) {
	if ( $last_update > 0 ) {
		if ( date_time - $last_update < $time_for_update_cache / 2 ) {
			$__eb_cache_time = 0;
			if ( file_exists( $__eb_cache_conf ) ) {
				include_once $__eb_cache_conf;
			}
//			echo '<!-- __eb_cache_time: ' . $__eb_cache_time . ' -->' . "\n";
		}
	}
	
	
	// kiểm tra lại lần nữa cho chắc ăn
	if ( mtv_id > 0 || $__eb_cache_time > $time_for_update_cache ) {
		
		// dọn cache định kỳ -> chỉ dọn khi không phải thao tác thủ công
		if ( mtv_id > 0
//		&& strstr( $_SERVER['REQUEST_URI'], '/' . WP_ADMIN_DIR . '/' ) == true
//		&& is_admin ()
		&& ! isset( $_GET['tab'] ) ) {
			$_GET['time_auto_cleanup_cache'] = 6 * 3600;
			
			include_once WGR_APP_INC_PATH . 'cronjob/cleanup_cache.php';
		}
		
		
		//
		if ( mtv_id == 0 || ! file_exists( $file_last_update ) ) {
//		if ( ! file_exists( $file_last_update ) ) {
			// tạo file cache
			_eb_create_file ( $file_last_update, date_time );
		}
		
		
		
		// tham số để lưu cache
		$arr_new_config = array();
		$__eb_cache_content = '$__eb_cache_time=' . date_time . ';' . "\n";
		
		
		
		
		/*
		* Một số thông số khác
		*/
		
		//
		if ( $__cf_row['cf_web_name'] == '' ) {
//			$web_name = get_bloginfo ( 'name' );
			$web_name = get_bloginfo ( 'blogname' );
//			$web_name = get_bloginfo ( 'sitename' );
		} else {
			$web_name = $__cf_row['cf_web_name'];
		}
		
		//
//		$__eb_cache_content .= '$web_name="' . str_replace( '"', '\"', $web_name ) . '";$web_link="' . str_replace( '"', '\"', $web_link ) . '";' . "\n";
		$__eb_cache_content .= '$web_name="' . str_replace( '"', '\"', $web_name ) . '";' . "\n";
		
		
		//
		$__cf_row['cf_reset_cache'] = (int)$__cf_row['cf_reset_cache'];
		
		// nếu thời gian update config lâu rồi, cache chưa set -> để cache mặc định
		// lần cập nhật config cuối là hơn 3 tiếng trước -> để mặc định
		if ( $__cf_row ["cf_reset_cache"] <= 0 ) {
			// cho cache 120s mặc định
			if ( $__cf_row['cf_ngay'] < date_time - 3 * 3600 ) {
				$arr_new_config ["cf_reset_cache"] = 120;
			}
			// hoặc tối thiểu 10s để còn test cache
			else {
				$arr_new_config ["cf_reset_cache"] = 10;
			}
		}
//		print_r( $__cf_row );
		
		//
//		$arr_new_config ["cf_blog_public"] = get_option( 'blog_public' );
		$arr_new_config ["cf_blog_public"] = _eb_get_option( 'blog_public' );
		
		// định dạng ngày giờ
//		$arr_new_config ["cf_date_format"] = get_option( 'date_format' );
		$arr_new_config ["cf_date_format"] = _eb_get_option( 'date_format' );
//		$arr_new_config ["cf_time_format"] = get_option( 'time_format' );
		$arr_new_config ["cf_time_format"] = _eb_get_option( 'time_format' );
		
		// -> tạo chuỗi để lưu cache
		foreach ( $arr_new_config as $k => $v ) {
			$__eb_cache_content .= '$__cf_row[\'' . $k . '\']="' . str_replace ( '"', '\"', str_replace ( '$', '\$', $v ) ) . '";' . "\n";
			
			//
			$__cf_row [ $k ] = $v;
		}
		
		
		
		// tạo file timezone nếu chưa có
		// chỉ với các website có ngôn ngữ không phải tiếng Việt
		if ( $__cf_row['cf_content_language'] != 'vi'
		// timezone phải tồn tại
		&& $__cf_row['cf_timezone'] != ''
		// file chưa được tạo
		&& ! file_exists ( EB_THEME_CACHE . '___timezone.txt' ) ) {
			_eb_create_file( EB_THEME_CACHE . '___timezone.txt', $__cf_row['cf_timezone'] );
		}
		
		
		
		
		
		// danh sách menu đã được đăng ký
		$menu_locations = get_nav_menu_locations();
//		print_r($menu_locations);
		foreach ( $menu_locations as $k => $v ) {
			$__eb_cache_content .= '$menu_cache_locations[\'' . $k . '\']="' . $v . '";' . "\n";
		}
		
		
		
		
		
		/*
		* lưu cache -> chỉ lưu khi thành viên chưa đăng nhập
		*/
		// không cho tạo cache liên tục
		// chỉ tạo khi khách truy cập hoặc không có file
		if ( mtv_id == 0 || ! file_exists( $__eb_cache_conf ) ) {
//		if ( ! file_exists( $__eb_cache_conf ) ) {
			
//			echo '<!-- ' . $__eb_cache_conf . ' (!!!!!) -->' . "\n";
			_eb_create_file ( $__eb_cache_conf, '<?php ' . str_replace( '\\\"', '\"', $__eb_cache_content ) );
			
			//
			_eb_log_user ( 'Update common_cache: ' . $_SERVER ['REQUEST_URI'] );
			
		}
		
		
		
		
		// Xóa revision
		include_once WGR_APP_INC_PATH . 'cronjob/revision_cleanup.php';
		
		// số bài viết tối đa trên web
		include_once WGR_APP_INC_PATH . 'cronjob/max_post_cleanup.php';
		
		
		
		
	}
}


