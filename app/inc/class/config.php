<?php




// bật/ tắt chế độ test code
//define( 'eb_code_tester', false );

/*
if ( eb_web_protocol == 'https' ) {
	header ( 'Location: http:' . _eb_full_url (), true, 301 ); exit();
}
*/




// localhost
//echo $_SERVER ['HTTP_HOST'];
//echo $_SERVER['REQUEST_URI'];

//
$d = array(
	DB_NAME,
	DB_USER,
	DB_PASSWORD
);

//
$localhost = 0;
$dbhost = 'localhost';




// test
//echo $_SERVER ['HTTP_HOST'] . "\n";

if ( $_SERVER ['HTTP_HOST'] == 'localhost:8888' || $_SERVER ['HTTP_HOST'] == 'localhost' ) {
	$d = array(
		DB_NAME,
		DB_USER,
		DB_PASSWORD
	);
	
	//
	$localhost = 1;
}



