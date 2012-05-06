<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

define("SERVERDATA_EXECCOMMAND",2);
define("SERVERDATA_AUTH",3);

class Rcon {

	var $params;
	var $password;
	var $host;
	var $port = 27015;
	var $sock = null;
	var $id = 0;

	public function __construct($params) {
		$this->password = $params['password'];
		$this->host = $params['host'];
		$this->port = $params['port'];
		$this->sock = @fsockopen($this->host, $this->port, $errno, $errstr, 5) or
	    		die("Unable to open socket: $errstr ($errno)\n");
		$this->setTimeout($this->sock,2,500);
    }

	public function auth() {
		$packetid = $this->write(SERVERDATA_AUTH, $this->password);

		// Real response (id: -1 = failure)
		$return = $this->packetRead();
		//var_dump($ret);
		if ($return[0]['ID'] == -1) {
			return false;
		}
		return true;
	}

	public function read() {
		$packets = $this->packetRead();
		$return = array();

		foreach($packets as $packet) {
			if (isset($return[$packet['ID']])) {
				$return[$packet['ID']]['S1'] .= $packet['S1'];
				$return[$packet['ID']]['S2'] .= $packet['S1'];
			} else {
				$return[$packet['ID']] = array(
					'Response' => $packet['Response'],
					'S1' => $packet['S1'],
					'S2' =>	$packet['S2'],
				);
			}
		}
		return $return;
	}

	public function sendCommand($command) {
		//$Command = '"'.trim(str_replace(' ','" "', $Command)).'"';
		//$Command="stop";
		$this->write(SERVERDATA_EXECCOMMAND, $command, '');
	}

	public function rconCommand($command) {
		$this->sendCommand($command);

		$return = $this->read();

		//ATM: Source servers don't return the request id, but if they fix this the code below should read as
		// return $ret[$this->_Id]['S1'];
		return $return[$this->id]['S1'];
	}

	private function setTimeout(&$res, $s, $m = 0) {
		if (version_compare(phpversion(),'4.3.0','<')) {
			return socket_set_timeout($res,$s,$m);
		}
		return stream_set_timeout($res,$s,$m);
	}

	private function write($cmd, $s1 = '', $s2 = '') {
		// Get and increment the packet id
		$id = ++$this->id;

		// Put our packet together
		$data = pack("VV", $id, $cmd) . $s1 . chr(0) . $s2 . chr(0);

		// Prefix the packet size
		$data = pack("V",strlen($data)) . $data;

		// Send packet
		fwrite($this->sock,$data,strlen($data));

		// In case we want it later we'll return the packet id
		return $id;
	}

	private function packetRead() {
		//Declare the return array
		$retarray = array();
		//Fetch the packet size
		while ($size = @fread($this->sock, 4)) {
			$size = unpack('V1Size', $size);
			//Work around valve breaking the protocol
			if ($size["Size"] > 4096) {
				//pad with 8 nulls
				$packet = "\x00\x00\x00\x00\x00\x00\x00\x00".fread($this->sock, 4096);
			} else {
				//Read the packet back
				$packet = fread($this->sock, $size["Size"]);
			}
			array_push($retarray, unpack("V1ID/V1Response/a*S1/a*S2", $packet));
		}
		return $retarray;
	}

}

/* End of file Rcon.php */