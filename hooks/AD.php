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
 *   adhooks/AD.php
 *   Adds articles to $content
 *
 *   @author Neek
 */

class Articles implements HookBase
{
	function EnrichContent($content,$keyword,$args)
	{
		$ArticleDashboards = array(	'http://www.afroarticles.com/article-dashboard/indexser.php?search=%s',
									'http://www.keywordarticles.org/indexser.php?search=%s',
									'http://www.purearticle.com/indexser.php?search=%s',
									'http://www.upublish.info/indexser.php?search=%s'
		);
		shuffle($ArticleDashboards);
		$url = sprintf($ArticleDashboards[0],str_replace(" ","+",$keyword));
		preg_match_all("/<li><a href=\"(.+?)\"/",Internet::Grab($url),$umatches);
		if(count($umatches[1])==0) {
                    return $content;
                }
                shuffle($umatches[1]);
		preg_match_all("/<p class=\"articletext\">(.+?)<\/p/",Internet::Grab($umatches[1][0]),$cmatches);
		foreach($cmatches[1] as $c) {
			if(strlen($c)>=1000) {
				$adContent .= $c;
				break;
			}
		}
		
		$adContent = preg_replace("/(<\/?)(\w+)([^>]*>)/e","",$adContent);
		$content .= $adContent;
		return $content;
	}
	
}

?>