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
 *   imghooks/Sxc.php
 *   Grab image from sxc.hu
 *
 *   @todo fallback on partial keywords because the inventory is limited
 *   @author Neek
 */
class Sxc implements ImagehookBase
{
	function GetImage($keyword)
	{
		$keyword = str_replace(" ","+",$keyword);
		$content = Internet::Grab("http://www.sxc.hu/browse.phtml?f=search&txt={$keyword}&w=1&x=0&y=0");
		if(preg_match_all("/showtrail\(300,[0-9]+,'(.+?)'/",$content,$matches)==0) {
			$keyword = str_replace(" ","-",$keyword);
			$content = Internet::Grab("http://www.sxc.hu/browse.phtml?f=search&txt={$keyword}&w=1&x=0&y=0");
			if(preg_match_all("/showtrail\(300,[0-9]+,'(.+?)'/",$content,$matches)==0) {
				return null;
			}
		}
		shuffle($matches[1]);
		return Internet::Grab(sprintf("http://www.sxc.hu/%s",$matches[1][0]));
	}
}

?>