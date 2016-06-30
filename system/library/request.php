<?php
final class Request {
	public $get = array();
	public $post = array();
	public $cookie = array();
	public $files = array();
	public $server = array();

	
  	public function __construct() {

		$_GET = $this->clean($_GET);
		$_POST = $this->clean($_POST);
		$_REQUEST = $this->clean($_REQUEST);
		$_COOKIE = $this->clean($_COOKIE);
		$_FILES = $this->clean($_FILES);
		$_SERVER = $this->clean($_SERVER);
		
		$this->get = $_GET;
		$this->post = $_POST;
		$this->request = $_REQUEST;
		$this->cookie = $_COOKIE;
		$this->files = $_FILES;
		$this->server = $_SERVER;

	}

	public function __get($name){
		switch($name){
			case 'get':
			$this->$name = $this->clean($_GET);
			break;
			case 'post':
			$this->$name = $this->clean($_POST);
			break;
			case 'request':
			$this->$name = $this->clean($_REQUEST);
			break;
			case 'cookie':
			$this->$name = $this->clean($_COOKIE);
			break;
			case 'files':
			$this->$name = $this->clean($_FILES);
			break;
			case 'server':
			$this->$name = $this->clean($_SERVER);
			break;
		}
	}

	public function __set($name, $val){
		$this->$name = $val;
	}

	public function is_ajax($key=null){
		return ($_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest');
	}

	/**
	* Fetch the IP Address
	*
	* @return	string
	*/
	public function ip_address($proxy_ips=FALSE){
		if ($this->ip_address !== FALSE){
			return $this->ip_address;
		}

		if ( ! empty($proxy_ips)){
			$proxy_ips = explode(',', str_replace(' ', '', $proxy_ips));
			foreach (array('HTTP_X_FORWARDED_FOR', 'HTTP_CLIENT_IP', 'HTTP_X_CLIENT_IP', 'HTTP_X_CLUSTER_CLIENT_IP') as $header){
				if (($spoof = $this->server($header)) !== FALSE){
					if (strpos($spoof, ',') !== FALSE){
						$spoof = explode(',', $spoof, 2);
						$spoof = $spoof[0];
					}

					if ( ! $this->valid_ip($spoof)){
						$spoof = FALSE;
					}
					else{
						break;
					}
				}
			}

			$this->ip_address = ($spoof !== FALSE && in_array($_SERVER['REMOTE_ADDR'], $proxy_ips, TRUE))
				? $spoof : $_SERVER['REMOTE_ADDR'];
		}else{
			$this->ip_address = $_SERVER['REMOTE_ADDR'];
		}

		if ( ! $this->valid_ip($this->ip_address)){
			$this->ip_address = '0.0.0.0';
		}

		return $this->ip_address;
	}

	// --------------------------------------------------------------------

	/**
	* Validate IP Address
	*
	* @access	public
	* @param	string
	* @param	string	ipv4 or ipv6
	* @return	bool
	*/
	public function valid_ip($ip, $which = ''){
		$which = strtolower($which);

		// First check if filter_var is available
		if (is_callable('filter_var')){
			switch ($which) {
				case 'ipv4':
					$flag = FILTER_FLAG_IPV4;
					break;
				case 'ipv6':
					$flag = FILTER_FLAG_IPV6;
					break;
				default:
					$flag = '';
					break;
			}

			return (bool) filter_var($ip, FILTER_VALIDATE_IP, $flag);
		}

		if ($which !== 'ipv6' && $which !== 'ipv4'){
			if (strpos($ip, ':') !== FALSE){
				$which = 'ipv6';
			}elseif (strpos($ip, '.') !== FALSE){
				$which = 'ipv4';
			}else{
				return FALSE;
			}
		}

		$func = '_valid_'.$which;
		return $this->$func($ip);
	}

	// --------------------------------------------------------------------

	/**
	* Validate IPv4 Address
	*
	* Updated version suggested by Geert De Deckere
	*
	* @access	protected
	* @param	string
	* @return	bool
	*/
	protected function _valid_ipv4($ip){
		$ip_segments = explode('.', $ip);

		// Always 4 segments needed
		if (count($ip_segments) !== 4){
			return FALSE;
		}
		// IP can not start with 0
		if ($ip_segments[0][0] == '0'){
			return FALSE;
		}

		// Check each segment
		foreach ($ip_segments as $segment){
			// IP segments must be digits and can not be
			// longer than 3 digits or greater then 255
			if ($segment == '' OR preg_match("/[^0-9]/", $segment) OR $segment > 255 OR strlen($segment) > 3){
				return FALSE;
			}
		}

		return TRUE;
	}

	// --------------------------------------------------------------------

	/**
	* Validate IPv6 Address
	*
	* @access	protected
	* @param	string
	* @return	bool
	*/
	protected function _valid_ipv6($str){
		// 8 groups, separated by :
		// 0-ffff per group
		// one set of consecutive 0 groups can be collapsed to ::

		$groups = 8;
		$collapsed = FALSE;

		$chunks = array_filter(
			preg_split('/(:{1,2})/', $str, NULL, PREG_SPLIT_DELIM_CAPTURE)
		);

		// Rule out easy nonsense
		if (current($chunks) == ':' OR end($chunks) == ':'){
			return FALSE;
		}

		// PHP supports IPv4-mapped IPv6 addresses, so we'll expect those as well
		if (strpos(end($chunks), '.') !== FALSE){
			$ipv4 = array_pop($chunks);

			if ( ! $this->_valid_ipv4($ipv4)){
				return FALSE;
			}

			$groups--;
		}

		while ($seg = array_pop($chunks)){
			if ($seg[0] == ':'){
				if (--$groups == 0){
					return FALSE;	// too many groups
				}

				if (strlen($seg) > 2){
					return FALSE;	// long separator
				}

				if ($seg == '::'){
					if ($collapsed){
						return FALSE;	// multiple collapsed
					}

					$collapsed = TRUE;
				}
			}elseif (preg_match("/[^0-9a-f]/i", $seg) OR strlen($seg) > 4){
				return FALSE; // invalid segment
			}
		}

		return $collapsed OR $groups == 1;
	}
	
  	public function clean($data) {
    	if (is_array($data)) {
	  		foreach ($data as $key => $value) {
				unset($data[$key]);
				
	    		$data[$this->clean($key)] = $this->clean($value);
	  		}
		} else { 
	  		$data = htmlspecialchars($data, ENT_COMPAT);
		}

		return $data;
	}
}
?>