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
 *   adhooks/Google.php
 *   Adds googel snippets to $content
 *
 *   @author Neek
 */
class Google implements HookBase
{
	function EnrichContent($content,$keyword,$args)
	{
		$url = sprintf("http://www.google.com/search?hl=en&source=hp&q=%s&aq=f&aqi=&aql=&oq=&gs_rfai=&num=100",str_replace(" ","+",$keyword));
		preg_match_all("/class=l>(.+?)<span class=f><cite>/si",Internet::Grab($url),$cmatches);
		$gContent = implode(" ",$cmatches[1]);
		$gContent = preg_replace("/(<\/?)(\w+)([^>]*>)/e"," ",$gContent);
		$content .= $gContent;
		return $content;
	}
}

?>