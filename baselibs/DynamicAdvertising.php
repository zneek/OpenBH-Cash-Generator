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
 *   baselibs/DynamicAdvertising.php
 *   This simply extends the Advertising base class
 *   and uses the first adhook confgiured
 *
 *   @author Neek
 *   @todo Add support for multiple adhooks with some sort of quality score to get the 'best' ad
 */
class DynamicAdvertising extends Advertising
{
	function __construct($keyword,$adhook)
	{
		/*
		 * we basically should loop trhough all available Advertisment Hooks until we got a satisfying result ;)
		 * currently only using the first configured hook 
		 */
		
		if(!class_exists($adhook[0])) {
			return false;
		}
		$ad = new $adhook[0]();
		$this->AdArray = $ad->ReturnData($keyword);
		$this->template = file_get_contents("templates/DynamicAd.html");
	}
}
?>