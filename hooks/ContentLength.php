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
 *   trims $content to desired length
 *
 *   @author Neek
 */
class ContentLength implements HookBase
{
	function EnrichContent($content,$keyword,$args)
	{
            if(!is_numeric($args['lengthmin']) || !is_numeric($args['lengthmax'])) {
                return $content;
            }
            $length = rand($args['lengthmin'],$args['lengthmax']);
            return substr($content,0,stripos($content,".",$length)+1);
	}
}

?>