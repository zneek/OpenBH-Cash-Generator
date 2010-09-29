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
 *   baselibs/Cloaker.php
 *   This is only the most basic way to do cloaking
 *   This could basically be enhanced using a real ip list
 *   using GeoIP Lookups etc etc to be more usefull
 *
 *   @author Neek
 *   @todo if we want cloaking - enhance here
 *   @return bool
 */
class Cloaker
{
	private $ip;
	private $ref;
	
	function __construct($ip,$ref)
	{
		/**
		 * Load ip list
		 * Load Geoip stuff
		 * etc etc
		 */
	}
	
	function IsBot()
	{
		$addr = gethostbyaddr($this->ip);
		if(stripos($addr,'goog')!==FALSE ||stripos($addr,'yahoo')!==FALSE OR stripos($addr,'microsoft')!==FALSE OR stripos($addr,'bing')!==FALSE ) {
			return true;
		}  
		return false;
	}
}
?>