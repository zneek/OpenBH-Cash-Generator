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
 *   baselibs/ImagehookBase.php
 *   Interface for all Image hooks which
 *   will be processed as set up in config/config.php
 *   Example of how its used see: imghooks/*.php
 *
 *   @author Neek
 */
interface ImagehookBase
{
	public function GetImage($keyword);
}


?>