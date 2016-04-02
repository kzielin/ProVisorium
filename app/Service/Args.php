<?php
namespace Service;
class Args
{
	private $par = array();
	
	function __construct($toLowerCase = false)
	{
		$this->read($toLowerCase);
	}
	
	function get($numer)
	{
		return $this->par[$numer];
	}

   public static function getBaseHref() {
      $base_href = explode('/',$_SERVER['SCRIPT_NAME']); 
      array_pop($base_href);
      return implode('/',$base_href).'/';
   }
   
	function read($toLowerCase)
	{
		$this->par = array();
		$path = isset( $_SERVER['PATH_INFO'] ) ? $_SERVER['PATH_INFO'] : $_SERVER['REQUEST_URI'];
      $path = trim($path, '/');

      $base_href = trim($this->getBaseHref(), '/');
      
      if (substr($path, 0, strlen($base_href)) == $base_href)
         $path = trim(substr($path, strlen($base_href)), '/');
   
		$this->par = explode( '/', $path);
		if ($toLowerCase)
			foreach ($this->par as $k => $v)
				$this->par[$k] = strtolower($v);
		return true;
	}
	
	function len()
	{
		return sizeof($this->par);
	}
	
	function set($key, $value)
	{
		$this->par[$key] = $value;
		return true;
	}
}

