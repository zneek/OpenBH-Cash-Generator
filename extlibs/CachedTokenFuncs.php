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
 *   extlibs/CachedTokenFuncs.php
 *   This functions map onto ((functionName)) in your site.html Template
 *   Put interesting stuff here
 *
 *   Notice: The output of these functions will be cached and only generated once
 *
 *   @author Neek
 */

/**
 *  @todo make it work lazy bum!
 */
function YahooAnswers($page) {
    $url = 'http://answers.yahoo.com/search/search_result?page=1&p=%s&scope=all&fltr=_en&question_status=all&date_submitted=all&category=0&answer_count=any&filter_search=1';
    $data = Internet::Grab(sprintf($url,str_replace(' ','+',$page->keyword)));
    preg_match_all('/h3><a.+?"(.+?)<ul/',$data,$qa);
    // $gContent = preg_replace("/(<\/?)(\w+)([^>]*>)/e"," ",$gContent);
}

?>
