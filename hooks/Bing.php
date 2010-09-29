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
                $kw = str_replace(" ","+",$keyword);
		$url = "http://www.bing.com/search?q=$kw+language%3Aen&form=QBRE&filt=all&qb=4&count=50";
		preg_match_all("/<h3><a (.+?)<\/p/si",Internet::Grab($url),$cmatches);
		$gContent = implode(" ",$cmatches[1]);
		$gContent = preg_replace("/(<\/?)(\w+)([^>]*>)/e"," ",$gContent);
		$content .= $gContent;
		return $content;
	}
}

?>