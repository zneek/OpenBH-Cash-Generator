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
 *   extlibs/TokenFuncs.php
 *   This functions map onto ((functionName)) in your site.html Template
 *   Put interesting stuff here
 * 
 *   Notice: The output of these functions will NOT be cached 
 *           and will be generated fresh for each hit
 *
 *   @author Neek
 */

function domain() {
    return OpenBHConf::get('domain');
}

?>
