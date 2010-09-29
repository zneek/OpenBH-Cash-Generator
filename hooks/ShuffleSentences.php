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
 *   adhooks/ShuffleSentences.php
 *   Shuffles Sentences inside $content
 *
 *   @author Neek
 */
class ShuffleSentences implements HookBase
{
	function EnrichContent($content,$keyword,$args)
	{
		$sentences = preg_split('/[\.\?\!\:]/', $content, -1, PREG_SPLIT_NO_EMPTY);
		shuffle($sentences);
		return implode(". ",$sentences);
	}
}

?>