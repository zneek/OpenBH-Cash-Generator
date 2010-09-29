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
 *   adhooks/Rss.php
 *   Adds titles and descriptions from random RSS Feed to $content
 *
 *   @author Neek
 */
class Rss implements HookBase
{
	function EnrichContent($content,$keyword,$args)
	{
            $feeder = array(    'http://news.search.yahoo.com/rss?ei=UTF-8&p=%s&fr=sfp',
                                'http://blogsearch.google.com/blogsearch_feeds?hl=en&q=%s&ie=utf-8&num=10&output=rss',
                                'http://www.bing.com/search?q=%s+language:en&go=&form=QBLH&filt=all&format=rss'
            );
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