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
 *   Removes badwords from config/badwords.txt in $content
 *
 *   @author Neek
 */

class Badwords implements HookBase
{
	function EnrichContent($content,$keyword,$args)
	{
		$badwords = file('config/badwords.txt');
		$content = str_replace($badwords,'',$content);
		return $content;
	}
}

?>