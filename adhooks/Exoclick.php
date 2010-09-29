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
    adhooks/Exoclick.php
    Grabs an XML feed from Exoclick
    performing a lookup on the keyword
    of the current Page loaded.

    @author Neek
    @todo enhance search for long tail keywords, fix in general
    @return array
 */
class Exoclick implements AdGrabber
{
	function ReturnData($keyword)
	{
		$login="syndk8";
		$search=$keyword;
		$n=10;
		$ads=@file("http://syndication.exoclick.com/feeds.php?login=$login&keyword=$search&type=1&n=$n&ip=".$_SERVER[REMOTE_ADDR]."&referer=http://".urlencode($_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"])."&useragent=".urlencode($_SERVER["HTTP_USER_AGENT"]));
		$ret = array();
		foreach($ads as $ad) {
			$ad=explode("|",$ad);
			$ret[] = array(	'prodname'=>$ad[0],
							'url'=>$ad[4],
							'desc'=>$ad[1]				
			);
		}
		return $ret;
	}
}

?>