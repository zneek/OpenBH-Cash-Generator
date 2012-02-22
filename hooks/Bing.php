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
 *   adhooks/Bing.php
 *   Adds Bing snippets to $content
 *
 *   @author Neek
 */
class Bing implements HookBase
{
	function EnrichContent($content,$keyword,$args)
	{
            $feeder = array( 'http://www.bing.com/search?q=%s+language:en&go=&form=QBLH&filt=all&format=rss' );
            shuffle($feeder);
            $link = sprintf($feeder[0],str_replace(' ','+',$keyword));
            $feed = Internet::Grab($link);
            preg_match_all('/<description>(.+?)<\/description>/si',$feed,$des);
            preg_match_all('/<title>(.+?)<\/title>/si', $feed, $tit);
            $retArr = array_merge($tit[1],$des[1]);
            if(count($retArr)==0 || !is_array($retArr)) {
		return $content;
	}
            shuffle($retArr);
            $ret = sprintf('%s %s',$content,implode(' ',$retArr));
            return $ret;
}
}

?>