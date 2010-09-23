<?php 

class Cloaker
{
	private $ip;
	private $ref;
	
	function __construct($ip,$ref)
	{
		/*
		 * Load ip list
		 * Load Geoip stuff
		 * etc etc
		 */
	}
	
	function IsBot()
	{
		// fag
		$addr = gethostbyaddr($this->ip);
		if(stripos($addr,'goog')!==FALSE ||stripos($addr,'yahoo')!==FALSE OR stripos($addr,'microsoft')!==FALSE OR stripos($addr,'bing')!==FALSE ) {
			return true;
		}  
		return false;
	}
}
?>