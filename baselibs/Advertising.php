<?php 

/*
 * 
 * our base class to serve the ad and parse it since this is always the same 
 * 
 */

class Advertising
{
	public $AdArray = array(); // our associative array holding key and value (key is also your replacement token!)
	public $template;
	
	function __construct()
	{
		// ...
	}
	
	function ServeAdJS() 
	{
		// document.write bla bla
		return $this->Parse();
	}
	
	function ServeAdHTML()
	{
		return $this->Parse();
	}
	
	private function Parse()
	{
		// adArray either contains data from the datafeed or from exoclick or similar sources as dyn ads ;)
		$output = $this->template;
		foreach($this->AdArray as $key=>$value) {
			$output = str_ireplace("#{$key}#",$value,$output);
		}
		
		/*
		 * since we most likely wont have mod_geoip 
		 * we should use the country lite csv database from maxmind.com ..
		 */
		$s = array('#ref#','#country#');
		$r = array($_SERVER['HTTP_REFERER'],$_SERVER['COUNTRY_CODE']);
		return str_ireplace($s,$r,$output);
	}
}

?>