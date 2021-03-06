<?php
final class Language {
  	private $directory;
	private $data = array();
 
	public function __construct($directory) {
		$this->directory = $directory;
	}
	
  	public function get($key) {
   		return (isset($this->data[$key]) ? $this->data[$key] : $key);
  	}
	
	public function load($filename, & $target=null) {
		$file = DIR_LANGUAGE . $this->directory . '/' . $filename . '.php';
    	
		if (file_exists($file)) {
			$_ = array();
	  		
			require($file);
			if(!is_null($target)){
				$target=array_merge($target, $_);
			}
			$this->data = array_merge($this->data, $_);
			
			return $this->data;
		} else {
			echo 'Error: Could not load language ' . $filename . '!';
			exit();
		}
  	}
}
?>