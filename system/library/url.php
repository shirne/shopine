<?php
class Url {
	private $url;
	private $ssl;
	private $hook = array();
	
	public function __construct($url, $ssl) {
		$this->url = $url;
		$this->ssl = $ssl;
	}
	
	public function link($route, $args = '', $connection = 'NONSSL') {
		if ($connection ==  'NONSSL') {
			$url = $this->url;	
		} else {
			$url = $this->ssl;	
		}
		
		$url .= 'index.php?route=' . $route;
			
		if ($args) {
			$url .= str_replace('&', '&amp;', '&' . ltrim($args, '&')); 
		}
		
		return $this->rewrite($url);
	}

	public function buildQuery(& $from, $keys){
		if(!is_array($keys)){
			$keys=explode(',', $keys);
		}
		$url='';
		foreach ($keys as $key) {
			if(isset($from[$key])){
				$url .= '&'.$key.'='.$from[$key];
			}
		}
		return $url;
	}
		
	public function addRewrite($hook) {
		$this->hook[] = $hook;
	}

	public function rewrite($url) {
		foreach ($this->hook as $hook) {
			$url = $hook->rewrite($url);
		}
		
		return $url;		
	}
}
?>