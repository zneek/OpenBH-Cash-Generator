<?php 
/******** Syndk8's OpenBH *********
 *
 * This program is free software
 * licensed under the GPLv2 license.
 * You may redistribute it and/or
 * modify it under the terms of
 * the GPLv2 license (see license.txt)
 *
 * Warning:
 * OpenBH is for educational use
 * Use OpenBH at your own risk !
 *
 * Credits:
 * https://www.syndk8.com/openbh/people.html
 *
 ********************************/


/**
 *   baselibs/Advertising.php
 *   Base Class used to parse and than
 *   serve Ads as either:
 *   Html or JavaScript
 *
 *   @author Neek
 *   @todo Explanation, Implement JavaScript, Popup and other serving methods
 *   @return string/html
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

        /**
         *  This will parse the Advertising Template
         *  replaces the key's of AdArray with its values
         *
         *  @return string/html
         */
	private function Parse()
	{
		// adArray either contains data from the datafeed or from exoclick or similar sources as dyn ads ;)
		$output = $this->template;
		foreach($this->AdArray as $key=>$value) {
			$output = str_ireplace("#{$key}#",$value,$output);
		}
		
		/**
		 * @todo since we most likely wont have mod_geoip we should use the country lite csv database from maxmind.com ..
		 */
                if(!isset($_SERVER['COUNTRY_CODE'])) {
                    $_SERVER['COUNTRY_CODE'] = 'NA';
                }
		$s = array('#ref#','#country#');
		$r = array($_SERVER['HTTP_REFERER'],$_SERVER['COUNTRY_CODE']);
		$output = str_ireplace($s,$r,$output);
                return $output;
	}
}

?>