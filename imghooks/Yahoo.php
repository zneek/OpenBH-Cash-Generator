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
 *   imghooks/Yahoo.php
 *   Grab Image from yahoo images 
 *
 *   @author Neek
 */
class YahooImages implements ImagehookBase
{
	function GetImage($keyword)
	{
		$keyword = str_replace(" ","+",$keyword);
		$content = Internet::Grab(sprintf("http://images.search.yahoo.com/search/images?p=%s&ei=UTF-8",$keyword));
		if(preg_match_all("/thumbnail\.aspx\?q=(.+?)\"/",$content,$matches)==0) {
			shuffle($matches[1]);	
		}
		return Internet::Grab(sprintf("http://ts3.mm.bing.net/images/thumbnail.aspx?q=%s",str_replace("&amp;","&",$matches[1][0])));
	}
}

?>