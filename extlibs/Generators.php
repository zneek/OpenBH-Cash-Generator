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
 *   extlibs/Generators.php
 *   Functions that map onto {token} inside your filename configuration
 *   see config/config.php filenamegenerator setup
 *
 *   @author Neek
 */

function num($digits) {
	if(!is_numeric($digits)) {
		return 0;
	}
	return rand(0,10000);
}

function countfiles() {
	return count(glob('data/content/*'));
}
?>