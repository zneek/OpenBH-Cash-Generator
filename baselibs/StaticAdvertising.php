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
 *   baselibs/StaticAdvertising.php
 *   using the StaticAd.html template from teh selected template
 *
 *   @author Neek
 */
class StaticAdvertising extends Advertising
{	
	function __construct($adArray) 
	{
		$this->AdArray = $adArray;
		$this->template = file_get_contents(sprintf('templates/%s/StaticAd.html',OpenBHConf::get('template')));
	}
}
?>