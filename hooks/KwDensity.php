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
 *   Adds keyword to $content until desired density is reached
 *
 *   @author Neek
 */

class KwDensity implements HookBase
{
	/** 
	 * $args density %
	 */
	function EnrichContent($content,$keyword,$args)
	{
		if(substr_count($content,$keyword)/str_word_count($content)*100 >= $args['density']) {
			return $content; // keyword density already sufficent
		}
		$amountToInject = str_word_count($content) / 100 * $args['density'] - substr_count($content,$keyword);
		$cArr = explode(" ",$content);
		for($i=0;$i<$amountToInject;$i++) {
			$rnd = rand(0,count($cArr)-1);
			$cArr[$rnd] = sprintf(" %s ",$keyword);
		}
		return implode(" ",$cArr);
	}
}
?>