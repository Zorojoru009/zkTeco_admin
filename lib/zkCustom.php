<?php 

define('CMD_CONNECT', 1000);
define('CMD_EXIT', 1001);
define('CMD_ENABLEDEVICE', 1002);
define('CMD_DISABLEDEVICE', 1003);
define('CMD_RESTART', 1004);
define('CMD_POWEROFF', 1005);
define('CMD_SLEEP', 1006);
define('CMD_RESUME', 1007);
define('CMD_TEST_TEMP', 1011);
define('CMD_TESTVOICE', 1017);
define('CMD_VERSION', 1100);
define('CMD_CHANGE_SPEED', 1101);

define('CMD_ACK_OK', 2000);
define('CMD_ACK_ERROR', 2001);
define('CMD_ACK_DATA', 2002);
define('CMD_PREPARE_DATA', 1500);
define('CMD_DATA', 1501);

define('CMD_USER_WRQ', 8);
define('CMD_USERTEMP_RRQ', 9);
define('CMD_USERTEMP_WRQ', 10);
define('CMD_OPTIONS_RRQ', 11);
define('CMD_OPTIONS_WRQ', 12);
define('CMD_ATTLOG_RRQ', 13);
define('CMD_CLEAR_DATA', 14);
define('CMD_CLEAR_ATTLOG', 15);
define('CMD_DELETE_USER', 18);
define('CMD_DELETE_USERTEMP', 19);
define('CMD_CLEAR_ADMIN', 20);
define('CMD_ENABLE_CLOCK', 57);
define('CMD_STARTVERIFY', 60);
define('CMD_STARTENROLL', 61);
define('CMD_CANCELCAPTURE', 62);
define('CMD_STATE_RRQ', 64);
define('CMD_WRITE_LCD', 66);
define('CMD_CLEAR_LCD', 67);

define('CMD_GET_TIME', 201);
define('CMD_SET_TIME', 202);

define('USHRT_MAX', 65535);

define('LEVEL_USER', 0);          // 0000 0000
define('LEVEL_ENROLLER', 2);       // 0000 0010
define('LEVEL_MANAGER', 12);      // 0000 1100
define('LEVEL_SUPERMANAGER', 14); // 000

class ZKLibrary{
	public $ip = null;
	public $port = null;
	public $socket = null;
	public $protocol = null;
	public $session_id = 0;
	public $received_data = '';
	public $start_data = 0;
	public $user_data = array();
	public $attendance_data = array();
	public $timeout_sec = 5;
	public $timeout_usec = 500000;

	private function reverseHex($input)
	{
		$output = '';
		for($i=strlen($input); $i>=0; $i--)
		{
			$output .= substr($input, $i, 2);
			$i--;
		}
		return $output;
	}
	private function decodeTime($data)
	{
		$second = $data % 60;
		$data = $data / 60;
		$minute = $data % 60;
		$data = $data / 60;
		$hour = $data % 24;
		$data = $data / 24;
		$day = $data % 31+1;
		$data = $data / 31;
		$month = $data % 12+1;
		$data = $data / 12;
		$year = floor( $data + 2000 );
		$d = date("Y-m-d H:i:s", strtotime($year.'-'.$month.'-'.$day.' '.$hour.':'.$minute.':'.$second));
		return $d;

	}

    public function __construct($ip = null, $port = null, $protocol = 'UDP')
	{
		if($ip != null)
		{
			$this->ip = $ip;
		}
		if($port != null)
		{
			$this->port = $port;
		}
		$this->protocol = $protocol;
		if ($protocol == 'TCP') {
			$this->start_data = 8;
			$this->socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
			//$this->setTimeout($this->sec, $this->usec);
			socket_connect($this->socket, $ip, $port);
		}
		else {
			$this->socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
			$this->setTimeout($this->sec, $this->usec);
		}
	}

	public function setUser($uid, $userid, $name, $password, $role)
	{
		$uid = (int) $uid;
		$role = (int) $role;
		if($uid > USHRT_MAX)
		{
			return FALSE;
		}
		if($role > 255) $role = 255;
		$name = substr($name, 0, 28);
		$command = CMD_USER_WRQ;
		$byte1 = chr((int)($uid % 256));
		$byte2 = chr((int)($uid >> 8));
		$command_string = $byte1.$byte2.chr($role).str_pad($password, 8, chr(0)).str_pad($name, 28, chr(0)).str_pad(chr(1), 9, chr(0)).str_pad($userid, 8, chr(0)).str_repeat(chr(0),16);
		return $this->execCommand($command, $command_string);
	}
	
	public function testVoice()
	{
		$command = CMD_TESTVOICE;
		$command_string = chr(0).chr(0);
		return $this->execCommand($command, $command_string);
	}


    function createHeader($command, $chksum, $session_id, $reply_id, $command_string)
	{
		$buf = pack('SSSS', $command, $chksum, $session_id, $reply_id).$command_string;
		$len = strlen($buf);
		$buf = unpack('C'.(8+strlen($command_string)).'c', $buf);
		$u = unpack('S', $this->checkSum($buf));
		if(is_array($u)) {
			foreach($u as $key => $value) {
				$u = $value;
				break;
			}
		}
		
		$chksum = $u;
		$reply_id += 1;
		if($reply_id >= USHRT_MAX)
		{
			$reply_id -= USHRT_MAX;
		}
		if ($this->protocol == 'TCP') {
            $buf = pack('SSLSSSS', 20560, 32130, $len, $command, $chksum, $session_id, $reply_id);
        }
        else {
            $buf = pack('SSSS', $command, $chksum, $session_id, $reply_id);
        }
		return $buf.$command_string;
	}


	private function checkSum($p)
	{
		/* This function calculates the chksum of the packet to be sent to the time clock */
		$l = count($p);
		$chksum = 0;
		$i = $l;
		$j = 1;
		while($i > 1)
		{
			$u = unpack('S', pack('C2', $p['c'.$j], $p['c'.($j+1)]));
			$chksum += $u[1];
			if($chksum > USHRT_MAX)
			{
				$chksum -= USHRT_MAX;
			}
			$i-=2;
			$j+=2;
		}
		if($i)
		{
			$chksum = $chksum + $p['c'.strval(count($p))];
		}
		while ($chksum > USHRT_MAX)
		{
			$chksum -= USHRT_MAX;
		}
		if ( $chksum > 0 )
		{
			$chksum = -($chksum);
		}
		else
		{
			$chksum = abs($chksum);
		}
		$chksum -= 1;
		while ($chksum < 0)
		{
			$chksum += USHRT_MAX;
		}
		return pack('S', $chksum);
	}

    public function send($buf) {
		if ($this->protocol == 'TCP') {
			socket_write($this->socket, $buf, strlen($buf));
		}
		else {
			socket_sendto($this->socket, $buf, strlen($buf), 0, $this->ip, $this->port);
		}
	}

    public function recv($length = 1024) {
		$data = '';
		if ($this->protocol == 'TCP') {
			$data = socket_read($this->socket, $length);
		}
		else {
			socket_recvfrom($this->socket, $data, $length, 0, $this->ip, $this->port);
		}
		return $data;
	}

    private function checkValid($reply)
	{
		$u = unpack('H2h1/H2h2', substr($reply, $this->start_data, 8));
		$command = hexdec( $u['h2'].$u['h1'] );
		if ($command == CMD_ACK_OK)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	function execCommand($command, $command_string = '', $offset_data = 8)
	{
		$chksum = 0;
		$offset_data += $this->start_data;
		$session_id = $this->session_id;
		$u = unpack('H2h1/H2h2/H2h3/H2h4/H2h5/H2h6/H2h7/H2h8', substr( $this->received_data, $this->start_data, 8) );
		$reply_id = hexdec( $u['h8'].$u['h7'] );
		$buf = $this->createHeader($command, $chksum, $session_id, $reply_id, $command_string);
		$this->send($buf);
		try
		{
			$this->received_data = $this->recv();
			$u = unpack('H2h1/H2h2/H2h3/H2h4/H2h5/H2h6', substr( $this->received_data, $this->start_data, 8 ) );
			$this->session_id =  hexdec( $u['h6'].$u['h5'] );
			return substr($this->received_data, $offset_data);
		}
		catch(ErrorException $e)
		{
			return FALSE;
		}
		catch(exception $e)
		{
			return FALSE;
		}
	}
	
	public function connect($ip = null, $port = 4370)
	{
		if($ip != null)
		{
			$this->ip = $ip;
		}
		if($port != null)
		{
			$this->port = $port;
		}
		if($this->ip == null || $this->port == null)
		{
			return false;
		}
		$command = CMD_CONNECT;
		$command_string = '';
		$chksum = 0;
		$session_id = 0;
		$reply_id = -1 + USHRT_MAX;
		$buf = $this->createHeader($command, $chksum, $session_id, $reply_id, $command_string);
		$this->send($buf);
		try
		{
			$this->received_data = $this->recv();
			if(strlen($this->received_data)>0)
			{
				$u = unpack('H2h1/H2h2/H2h3/H2h4/H2h5/H2h6', substr($this->received_data, $this->start_data, 8));
				$this->session_id = hexdec($u['h6'].$u['h5']);
				return $this->checkValid($this->received_data);
			}
			else
			{
				return FALSE;
			}
		}
		catch(ErrorException $e)
		{
			return FALSE;
		}
		catch(exception $e)
		{
			return FALSE;
		}
	}

	public function getUser()
	{
		if ($this->protocol == 'TCP') {
			$command = 1503;
	        $command_string = pack('CCLLC', 1, 9, 1280, 0, 0);
	        $chksum = 0;
	        $session_id = $this->session_id;
	        $u = unpack('H2h1/H2h2/H2h3/H2h4/H2h5/H2h6/H2h7/H2h8', substr($this->received_data, $this->start_data, 8));
	        $ucs = unpack('H' . (strlen($command_string) * 2), substr($command_string, 0));
	        $udat = unpack('H' . (strlen($this->received_data) * 2), substr($this->received_data, 0));
	        $reply_id = hexdec($u['h8'] . $u['h7']);
	        $buf = $this->createHeader($command, $chksum, $session_id, $reply_id, $command_string);
	        $this->send($buf);
	        $this->received_data = $this->recv();
	        $udat = unpack('H' . (strlen($this->received_data) * 2), substr($this->received_data, 0));
	        $u = unpack('H2h1/H2h2/H2h3/H2h4/H2h5/H2h6/H2h7/H2h8', substr($this->received_data, $this->start_data, 8));
	        $reply_id = hexdec($u['h8'] . $u['h7']);
	        $comando = hexdec($u['h2'] . $u['h1']);

	        if ($comando == CMD_ACK_OK) {
	            $u = unpack('H2h1/H2h2', substr($this->received_data, 17, 2));
	            $size = hexdec($u['h2'] . $u['h1']);
	        } else {
	            $u = unpack('H2h1/H2h2', substr($this->received_data, 16, 2));
	            $size = hexdec($u['h2'] . $u['h1']);
	        }

	        if ($size > 1024) {
	            $buf = $this->createHeader(1504, $chksum, $session_id, $reply_id, pack('LL', 0, $size));
	            $this->send($buf);
	        }
		}
		else {
			$command = CMD_USERTEMP_RRQ;
			$command_string = chr(5);
			$chksum = 0;
			$session_id = $this->session_id;
			$u = unpack('H2h1/H2h2/H2h3/H2h4/H2h5/H2h6/H2h7/H2h8', substr( $this->received_data, $this->start_data, 8) );
			$reply_id = hexdec( $u['h8'].$u['h7'] );
			$buf = $this->createHeader($command, $chksum, $session_id, $reply_id, $command_string);
			$this->send($buf);
		}

		try
		{
			if ($this->protocol == 'TCP') {
				if ($size > 1024) {
	                $this->received_data = $this->recv();
	                $bytes = $size;
	                $bytes2 = 0;
	                $tembytes = $bytes;

	                if ($bytes) {

	                    array_push($this->user_data, substr($this->received_data, 16));
	                    $bytes -= strlen($this->received_data);

	                    while ($bytes > 0) {
	                        $received_data = $this->recv();
	                        $bytes2 += strlen($received_data);
	                        $longitud = strlen($received_data);
	                        if ($bytes2 > 1024) {
	                            if (substr($received_data, 0, 2) == 'PP') {
	                                $received_data = substr($received_data, 16);
	                                $bytes2 -= 1024;
	                            } else {
	                                $received_data = substr($received_data, 0, $longitud - ($bytes2 - 1024)) . substr($received_data, $longitud - ($bytes2 - 1024) + 16);
	                                $bytes2 -= 1024;
	                            }
	                        }
	                        array_push($this->user_data, substr($received_data, 0));
	                        $bytes -= strlen($received_data);

	                        if (strlen($received_data) == 0) {
	                            $bytes = 0;
	                        }
	                    }
	                    $this->session_id = hexdec($u['h6'] . $u['h5']);
	                    $received_data = $this->recv();
	                }

	                array_push($this->user_data, substr($this->user_data, 0));
	                if (count($this->user_data) > 0) {
	                    $this->user_data[0] = substr($this->user_data[0], 8);
	                    $this->user_data[1] = substr($this->user_data[1], 8);
	                }
	            } else {
	                array_push($this->user_data, substr($this->received_data, 0));
	                $u = unpack('H' . (strlen($this->received_data) * 2), substr($this->received_data, 0));
	                $size -= strlen($this->received_data);
	                if ($size > 0) {
	                	$size += 12;
	                }

	                while ($size > 0) {
	                    $received_data = $this->recv();
	                    $u = unpack('H' . (strlen($received_data) * 2), substr($received_data, 0));
	                    array_push($this->user_data, substr($received_data, 0));
	                    $size -= strlen($received_data);

	                    if (strlen($received_data) == 0) {
	                        $size = 0;
	                    }
	                }

	                $this->user_data[0] = substr($this->user_data[0], 8);
	            }
			}
			else {
				$this->received_data = $this->recv();
				$u = unpack('H2h1/H2h2/H2h3/H2h4/H2h5/H2h6', substr( $this->received_data, $this->start_data, 8 ) );
				$bytes = $this->getSizeUser();
				if($bytes)
				{
					while($bytes > 0)
					{
						$received_data = $this->recv(1032);
						array_push( $this->user_data, $received_data);
						$bytes -= 1024;
					}
					$this->session_id =  hexdec( $u['h6'].$u['h5'] );
					$received_data = $this->recv();
				}
			}
			
			$users = array();
			if(count($this->user_data) > 0)
			{
				if ($this->protocol != 'TCP') {
					for($x=0; $x<count($this->user_data); $x++)
					{
						if ($x > 0)
						{
							$this->user_data[$x] = substr($this->user_data[$x], 8);
						}
					}
				}
				$user_data = implode('', $this->user_data);
				
				$user_data = substr($user_data, 11);
				 
				while(strlen($user_data) > 72)
				{
					$u = unpack('H144', substr($user_data, 0, 72));
					$u1 = hexdec(substr($u[1], 2, 2));
					$u2 = hexdec(substr($u[1], 4, 2));
					$uid = $u1+($u2*256);                               // 2 byte
					$role = hexdec(substr($u[1], 6, 2)).' ';            // 1 byte
					$password = hex2bin(substr( $u[1], 8, 16 )).' ';    // 8 byte
					$name = hex2bin(substr($u[1], 24, 74 )). ' ';      // 37 byte
					$userid = hex2bin(substr($u[1], 98, 72)).' ';      // 36 byte
					$passwordArr = explode(chr(0), $password, 2);       // explode to array
					$password = $passwordArr[0];                        // get password
					$useridArr = explode(chr(0), $userid, 2);           // explode to array
					$userid = $useridArr[0];                            // get user ID
					$nameArr = explode(chr(0), $name, 3);               // explode to array
					$name = $nameArr[0];                                // get name
					if($name == "")
					{
						$name = $uid;
					}
					$users[$uid] = array($userid, $name, intval($role), $password);
					$user_data = substr($user_data, 72);
				}
			}
			return $users;
			
		}
		catch(ErrorException $e)
		{
			return FALSE;
		}
		catch(exception $e)
		{
			return FALSE;
		}
	}

	public function getAttendance()
	{
		if ($this->protocol == 'TCP') {
			$command = 1503;
	        $command_string = pack('CCLLC', 1, 13, 0, 0, 0);
	        $chksum = 0;
	        $session_id = $this->session_id;
	        $patron = "";
	        $u = unpack('H2h1/H2h2/H2h3/H2h4/H2h5/H2h6/H2h7/H2h8', substr($this->received_data, $this->start_data, 8));
	        $ucs = unpack('H' . (strlen($command_string) * 2), substr($command_string, 0));
	        $udat = unpack('H' . (strlen($this->received_data) * 2), substr($this->received_data, 0));
	        $reply_id = hexdec($u['h8'] . $u['h7']);
	        $buf = $this->createHeader($command, $chksum, $session_id, $reply_id, $command_string);
	        $this->send($buf);
	        $this->received_data = $this->recv();
	        $udat = unpack('H' . (strlen($this->received_data) * 2), substr($this->received_data, 0));
	        $u = unpack('H2h1/H2h2/H2h3/H2h4/H2h5/H2h6/H2h7/H2h8', substr($this->received_data, $this->start_data, 8));
	        $reply_id = hexdec($u['h8'] . $u['h7']);
	        $comando = hexdec($u['h2'] . $u['h1']);

	        if ($comando == CMD_ACK_OK) {
	            $u = unpack('H2h1/H2h2/H2h3/H2h4', substr($this->received_data, 17, 4));
	            $size = hexdec($u['h4'] . $u['h3'] . $u['h2'] . $u['h1']);
	        } else {
	            $u = unpack('H2h1/H2h2/H2h3/H2h4', substr($this->received_data, 16, 4));
	            $size = hexdec($u['h4'] . $u['h3'] . $u['h2'] . $u['h1']);
	        }

	        if ($size > 1024) {
	            $buf = $this->createHeader(1504, $chksum, $session_id, $reply_id, pack('LL', 0, $size));
	            $this->send($buf);
	        }
		}
		else {
			$command = CMD_ATTLOG_RRQ;
			$command_string = '';
			$chksum = 0;
			$session_id = $this->session_id;
			$u = unpack('H2h1/H2h2/H2h3/H2h4/H2h5/H2h6/H2h7/H2h8', substr($this->received_data, $this->start_data, 8));
			$reply_id = hexdec($u['h8'].$u['h7']);
			$buf = $this->createHeader($command, $chksum, $session_id, $reply_id, $command_string);
			$this->send($buf);
		}

		try
		{
			if ($this->protocol == 'TCP') {
				if ($size > 1024) {
	                $this->received_data = $this->recv();
	                $bytes = $this->getSizeAttendance();
	                $lonreceived_data = strlen($this->received_data);
	                $bytes2 = 0;
	                $tembytes = $bytes;

	                if ($lonreceived_data > 24) {
	                    array_push($this->attendance_data, substr($this->received_data, 24));
	                    $bytes3 = ($lonreceived_data - 24);
	                    $bytes2 = $lonreceived_data - 24;
	                    $bytes -= $bytes3;
	                }

	                if ($bytes) {
	                    while ($bytes > 0) {
	                        $received_data = $this->recv();
	                        $bytes2 += strlen($received_data);
	                        $longitud = strlen($received_data);
	                        if ($bytes2 > 1024) {
	                            if (substr($received_data, 0, 2) == 'PP') {
	                                $received_data = substr($received_data, 16);
	                                $bytes2 -= 1024;
	                            } else {
	                                $received_data = substr($received_data, 0, $longitud - ($bytes2 - 1024)) . substr($received_data, $longitud - ($bytes2 - 1024) + 16);
	                                $bytes2 -= 1024;
	                            }
	                        }
	                        array_push($this->attendance_data, substr($received_data, 0));
	                        $bytes -= strlen($received_data);

	                        if (strlen($received_data) == 0) {
	                            $bytes = 0;
	                        }
	                    }
	                    $this->session_id = hexdec($u['h6'] . $u['h5']);
	                    $received_data = $this->recv();
	                }
	                if ($lonreceived_data > 24) {
	                    array_push($this->attendance_data, substr($this->received_data, 0, 24));
	                } else {
	                    array_push($this->attendance_data, substr($this->received_data, 0));
	                }
	                if (count($this->attendance_data) > 0) {
	                    $this->attendance_data[0] = substr($this->attendance_data[0], 8);
	                }
	            } else {

	                $ssize = $size;

	                $sizerecibido = 0;

	                array_push($this->attendance_data, substr($this->received_data, 8));

	                if ($size > 0) {
	                    $u = unpack('H' . (strlen($this->received_data) * 2), substr($this->received_data, 0));
	                    $size -= strlen($this->received_data);

	                    $sizerecibido += strlen($this->received_data);

	                    while ($size > 0) {
	                        $received_data = $this->recv();
	                        $u = unpack('H' . (strlen($received_data) * 2), substr($received_data, 0));
	                        array_push($this->attendance_data, substr($received_data, 0));
	                        $size -= strlen($received_data);

	                        $sizerecibido += strlen($received_data);

	                        if (strlen($received_data) == 0) {
	                            $size = 0;
	                        }
	                    }

	                    if ($sizerecibido <> ($ssize + 20)) {
	                        $received_data = $this->recv();
	                        $u = unpack('H' . (strlen($received_data) * 2), substr($received_data, 0));
	                        array_push($this->attendance_data, substr($received_data, 0));

	                        $sizerecibido += strlen($received_data);
	                    }
	                }
	            }
			}
			else {
				$this->received_data = $this->recv();
				$bytes = $this->getSizeAttendance();
				if($bytes)
				{
					while($bytes > 0)
					{
						$received_data = $this->recv(1032);
						array_push($this->attendance_data, $received_data);
						$bytes -= 1024;
					}
					$this->session_id = hexdec($u['h6'].$u['h5']);
					$received_data = $this->recv();
				}
			}
			
			$attendance = array();
			if(count($this->attendance_data) > 0)
			{
				if ($this->protocol != 'TCP') {
					for($x=0; $x<count($this->attendance_data); $x++)
					{
						if($x > 0)
						{
							$this->attendance_data[$x] = substr($this->attendance_data[$x], 8);
						}
					}
				}
				$attendance_data = implode('', $this->attendance_data);
				$attendance_data = substr($attendance_data, 10);
				while(strlen($attendance_data) > 40)
				{
					$u = unpack('H80', substr($attendance_data, 0, 40));
					$u1 = hexdec(substr($u[1], 4, 2));
					$u2 = hexdec(substr($u[1], 6, 2));
					$uid = $u1+($u2*256);
					$id = str_replace("\0", '', hex2bin(substr($u[1], 8, 16)));
					$state = hexdec($this->reverseHex(substr($u[1], 66, 2 )) );
					// $state = hexdec(substr( $u[1], 56, 2 ) );
					$timestamp = $this->decodeTime(hexdec($this->reverseHex(substr($u[1], 58, 8))));
					array_push($attendance, array($uid, $id, $state, $timestamp));
					$attendance_data = substr($attendance_data, 40 );
				}
			}
			return $attendance;
		}
		catch(ErrorException $e)
		{
			return FALSE;
		}
		catch(exception $e)
		{
			return FALSE;
		}

	}


}

?>