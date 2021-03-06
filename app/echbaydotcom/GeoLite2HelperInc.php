<?php

// v1
/*
if ( ! file_exists( GeoLite2Helper_PATH . '/Reader.php' ) && file_exists( GeoLite2Helper_PATH . '/Db/Reader.php' ) ) {
	include GeoLite2Helper_PATH . '/Db/Reader.php';
	include GeoLite2Helper_PATH . '/Db/Reader/Decoder.php';
	include GeoLite2Helper_PATH . '/Db/Reader/InvalidDatabaseException.php';
	include GeoLite2Helper_PATH . '/Db/Reader/Metadata.php';
	include GeoLite2Helper_PATH . '/Db/Reader/Util.php';
}
// v2
else {
	*/
	include GeoLite2Helper_PATH . '/Reader.php';
	include GeoLite2Helper_PATH . '/Reader/Decoder.php';
	include GeoLite2Helper_PATH . '/Reader/InvalidDatabaseException.php';
	include GeoLite2Helper_PATH . '/Reader/Metadata.php';
	include GeoLite2Helper_PATH . '/Reader/Util.php';
//}


//
use MaxMind\Db\Reader;

class WGR_GeoLite2Helper {
//	public $ipAddress;
	
	private $cachePath = '';
	
	private function db_not_found () {
		return 'GeoLite2 DB not found! <a href="https://dev.maxmind.com/geoip/geoip2/geolite2/" rel="nofollow" target="_blank">Click here</a> Download and up to folder: <strong>' . GeoLite2Helper_UploadPATH . '</strong>';
	}
	
	/*
	function __construct() {
		$this->ipAddress = '';
		if (getenv('HTTP_CLIENT_IP'))
			$this->ipAddress = getenv('HTTP_CLIENT_IP');
		else if(getenv('HTTP_X_FORWARDED_FOR'))
			$this->ipAddress = getenv('HTTP_X_FORWARDED_FOR');
		else if(getenv('HTTP_X_FORWARDED'))
			$this->ipAddress = getenv('HTTP_X_FORWARDED');
		else if(getenv('HTTP_FORWARDED_FOR'))
			$this->ipAddress = getenv('HTTP_FORWARDED_FOR');
		else if(getenv('HTTP_FORWARDED'))
		   $this->ipAddress = getenv('HTTP_FORWARDED');
		else if(getenv('REMOTE_ADDR'))
			$this->ipAddress = getenv('REMOTE_ADDR');
		else
			$this->ipAddress = 'UNKNOWN';
	}
	*/
	
	private function ipAddress() {
		if ( isset ( $_SERVER ['HTTP_X_FORWARDED_FOR'] ) ) {
			return $_SERVER ['HTTP_X_FORWARDED_FOR'];
		}
		else if ( isset ( $_SERVER ['HTTP_X_REAL_IP'] ) ) {
			return $_SERVER ['HTTP_X_REAL_IP'];
		}
		else if ( isset ( $_SERVER ['HTTP_CLIENT_IP'] ) ) {
			return $_SERVER ['HTTP_CLIENT_IP'];
		}
		return $_SERVER ['REMOTE_ADDR'];
		
		
		//
		if (getenv('HTTP_CLIENT_IP'))
			$this->ipAddress = getenv('HTTP_CLIENT_IP');
		else if(getenv('HTTP_X_FORWARDED_FOR'))
			$this->ipAddress = getenv('HTTP_X_FORWARDED_FOR');
		else if(getenv('HTTP_X_FORWARDED'))
			$this->ipAddress = getenv('HTTP_X_FORWARDED');
		else if(getenv('HTTP_FORWARDED_FOR'))
			$this->ipAddress = getenv('HTTP_FORWARDED_FOR');
		else if(getenv('HTTP_FORWARDED'))
		   $this->ipAddress = getenv('HTTP_FORWARDED');
		else if(getenv('REMOTE_ADDR'))
			$this->ipAddress = getenv('REMOTE_ADDR');
		else
			$this->ipAddress = 'UNKNOWN';
	}
	
	public function getPath() {
		
		// n???u c?? r???i -> d??ng lu??n
		if ( $this->cachePath != '' ) {
			return $this->cachePath;
		}
		
		//
		$f_City = '/GeoLite2-City.mmdb';
		$f_Country = '/GeoLite2-Country.mmdb';
		
		// m???c ?????nh l?? NULL
		$path = NULL;
		
		//
//		echo GeoLite2Helper_EBPATH . $f_City . '<br>';
//		echo GeoLite2Helper_EBPATH . $f_Country . '<br>';
		
		// n???p DB, ??u ti??n n???p trong th?? m???c Upload tr?????c
		// n???u c?? c???p ????? City -> l???y theo c???p ????? City
		if ( file_exists( GeoLite2Helper_UploadPATH . $f_City ) ) {
			$path = GeoLite2Helper_UploadPATH . $f_City;
		}
		// echbay hosting
		else if ( @file_exists( GeoLite2Helper_EBPATH . $f_City ) ) {
			$path = GeoLite2Helper_EBPATH . $f_City;
		}
		// v1
		else if ( file_exists( GeoLite2Helper_PATH . $f_City ) ) {
			$path = GeoLite2Helper_PATH . $f_City;
		}
		// localhost
		else if ( file_exists( GeoLite2Helper_DBPATH . $f_City ) ) {
			$path = GeoLite2Helper_DBPATH . $f_City;
		}
		// m???c ?????nh ch??? l???y Country
		else if ( file_exists( GeoLite2Helper_UploadPATH . $f_Country ) ) {
			$path = GeoLite2Helper_UploadPATH . $f_Country;
		}
		// echbay hosting
		else if ( @file_exists( GeoLite2Helper_EBPATH . $f_Country ) ) {
			$path = GeoLite2Helper_EBPATH . $f_Country;
		}
		// v1
		else if ( file_exists( GeoLite2Helper_PATH . $f_Country ) ) {
			$path = GeoLite2Helper_PATH . $f_Country;
		}
		// localhost
		else if ( file_exists( GeoLite2Helper_DBPATH . $f_Country ) ) {
			$path = GeoLite2Helper_DBPATH . $f_Country;
		}
		
		//
		$this->cachePath = $path;
		
		return $path;
		
	}
	
	private function getDB($ip) {
		/*
		if (!empty($ip)) {
			$this->ipAddress = $ip;
		}
		*/
		if ( $ip == NULL ) {
			$ip = $this->ipAddress();
		}
		// test
//		$ip .= '1';
//		echo $ip . '<br>' . "\n";
		
		//
		$path = $this->getPath();
		
		// kh??ng c?? -> b??? qua
		if ( $path ==  NULL ) {
			return NULL;
		}
		
		//
		$reader = new Reader( $path );
		
		//
//		$r = $reader->get($this->ipAddress);
		$r = $reader->get($ip);
//		print_r( $r );
		
		//
		$reader->close();
		
		return $r;
	}
	
	
	// l???y nhi???u th??ng tin c??ng l??c
	public function getUserOptionByIp($ip = NULL, $o = NULL) {
		$a = $this->getDB( $ip ); if ( $a == NULL || ! isset( $a['location'] ) ) return $this->db_not_found();
//		if ( mtv_id == 1 ) print_r( $a );
		
		//
		$r = array();
		
		// l???y c??c th??ng s??? theo thu???c t??nh
		// t???t c??? c??c gi?? tr???
		if ( $o == NULL || $o == 'all' ) {
			if ( isset( $a['city'] ) ) {
				$r[] = $a['city']['names']['en'];
			}
			
			$r[] = $a['country']['names']['en'];
			$r[] = $a['continent']['names']['en'];
			$r[] = '<a href="https://www.google.com/maps/@' . $a['location']['latitude'] . ',' . $a['location']['longitude'] . ',17z" rel="nofollow" target="_blank" class="small">Xem b???n ?????</a>';
		}
		// t???t c??? m?? v??ng
		else if ( $o == 'all_code' ) {
			if ( isset( $a['subdivisions'] ) ) {
				$r[] = $a['subdivisions'][0]['iso_code'];
			}
			else if ( isset( $a['city'] ) ) {
				$r[] = $a['city']['names']['en'];
			}
			
			$r[] = $a['country']['iso_code'];
			$r[] = $a['continent']['code'];
			$r[] = '<a href="https://www.google.com/maps/@' . $a['location']['latitude'] . ',' . $a['location']['longitude'] . ',17z" rel="nofollow" target="_blank" class="small">Xem b???n ?????</a>';
		}
		// l???y t???ng c??i
		else {
			if ( isset( $o['city'] ) && isset( $a['city'] ) ) {
				$r[] = $a['city']['names']['en'];
			}
			else if ( isset( $o['city_code'] ) ) {
				if ( isset( $a['subdivisions'] ) ) {
					$r[] = $a['subdivisions'][0]['iso_code'];
				}
				else if ( isset( $a['city'] ) ) {
					$r[] = $a['city']['names']['en'];
				}
			}
			
			if ( isset( $o['country'] ) ) {
				$r[] = $a['country']['names']['en'];
			}
			else if ( isset( $o['country_code'] ) ) {
				$r[] = $a['country']['iso_code'];
			}
			
			if ( isset( $o['continent'] ) ) {
				$r[] = $a['continent']['names']['en'];
			}
			else if ( isset( $o['continent_code'] ) ) {
				$r[] = $a['continent']['code'];
			}
			
			if ( isset( $o['location'] ) ) {
				$r[] = '<a href="https://www.google.com/maps/@' . $a['location']['latitude'] . ',' . $a['location']['longitude'] . ',17z" rel="nofollow" target="_blank" class="small">Xem b???n ?????</a>';
			}
		}
		
		//
		return implode( ', ', $r );
	}
	
	
	// l???y v??? tr?? theo t???nh th??nh ho???c qu???c gia
	public function getUserAddressByIp($ip = NULL) {
		$a = $this->getDB( $ip ); if ( $a == NULL ) return $this->db_not_found();
		
		//
		$r = array();
		
		if ( isset( $a['city'] ) ) {
			$r[] = $a['city']['names']['en'];
		}
		
		//
		$r[] = $a['country']['names']['en'];
		
		//
		return implode( ', ', $r );
	}
	
	
	// l???y v??? tr?? theo qu???c gia
	public function getUserCountryByIp($ip = NULL) {
		$a = $this->getDB( $ip ); if ( $a == NULL ) return $this->db_not_found();
		
		//
		return $a['country']['names']['en'];
	}
	
	// l???y v??? tr?? theo qu???c gia (m?? code)
	public function getUserCountryCodeByIp($ip = NULL) {
		$a = $this->getDB( $ip ); if ( $a == NULL ) return $this->db_not_found();
		
		//
		return $a['country']['iso_code'];
	}
	
	
	// l???y v??? tr?? theo t???nh th??nh (m?? code)
	public function getUserCityByIp($ip = NULL) {
		$a = $this->getDB( $ip ); if ( $a == NULL ) return $this->db_not_found();
		
		//
		if ( isset( $a['subdivisions'] ) ) {
			return $a['subdivisions'][0]['names']['en'];
		}
		else if ( isset( $a['city'] ) ) {
			return $a['city']['names']['en'];
		}
		
		return '';
	}
	
	// l???y v??? tr?? theo t???nh th??nh (m?? code)
	public function getUserCityCodeByIp($ip = NULL) {
		$a = $this->getDB( $ip ); if ( $a == NULL ) return $this->db_not_found();
		
		//
		if ( isset( $a['subdivisions'] ) ) {
			return $a['subdivisions'][0]['iso_code'];
		}
		
		return '';
	}
	
	
	// l???y v??? tr?? theo tr??n b???n ????? google
	public function getUserLocByIp($ip = NULL) {
		$a = $this->getDB( $ip ); if ( $a == NULL ) return $this->db_not_found();
		
		//
		if ( isset( $a['location'] ) ) {
			return array(
				'lat' => $a['location']['latitude'],
				'latitude' => $a['location']['latitude'],
				'lon' => $a['location']['longitude'],
				'longitude' => $a['location']['longitude']
			);
		}
		
		return array();
	}
}


