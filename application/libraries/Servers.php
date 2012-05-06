<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Servers { 

	var $host;
	var $port = 25565;
	var $timeout = 5;

	public function query($host, $port, $timeout) {
		$beginning_time = microtime(true);

		$fp = fsockopen($host, $port, $errno, $errstr, $timeout);

		if ($errstr != '') {
			return false;
		} else {

			$end_time = microtime(true);

			fwrite($fp, "\xFE");
			$d = fread($fp, 256);
			if ($d[0] != "\xFF") return false;
			$d = substr($d, 3);
			$d = mb_convert_encoding($d, 'auto', 'UCS-2');
			$d = explode("\xA7", $d);
			return array(
				'motd'        =>        $d[0],
				'players'     => intval($d[1]),
				'max_players' => intval($d[2]),
				'latency'     => ($end_time - $beginning_time) * 1000);
		}
	}

	public function calcLag($ping) {
		$ping = preg_replace('/^([^.]*).*$/', '$1', $ping);

		if($ping <= 100) {
			return 5;
		} elseif($ping <= 200) {
			return 4;
		} elseif($ping <= 300) {
			return 3;
		} elseif($ping <= 400) {
			return 2;
		} else {
			return 1;
		}
	}

	public function distance($serverip, $clientip) {
		$server = get_geolocation($serverip);
		$client = get_geolocation($clientip);

		$earth_radius = 3960.00; # in miles
		$lat_1 = $server['latitude'];
		$lon_1 = $server['longitude'];
		$lat_2 = $client['latitude'];
		$lon_2 = $client['longitude'];
		$delta_lat = $lat_2 - $lat_1 ;
		$delta_lon = $lon_2 - $lon_1 ;

		$alpha    = $delta_lat/2;
		$beta     = $delta_lon/2;
		$a        = sin(deg2rad($alpha)) * sin(deg2rad($alpha)) + cos(deg2rad($lat_1)) * cos(deg2rad($lat_2)) * sin(deg2rad($beta)) * sin(deg2rad($beta)) ;
		$c        = asin(min(1, sqrt($a)));
		$distance = 2*$earth_radius * $c;
		$distance = round($distance, 4);

		return $distance;
	}

	private function distance_haversine($lat1, $lon1, $lat2, $lon2) {
		global $earth_radius;
		global $delta_lat;
		global $delta_lon;
		

		return $distance;
	}

}