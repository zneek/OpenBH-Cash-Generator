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
 *   manage/index.php
 *   Very basic admin panel and stats viewer ..
 *
 *   @author Neek
 */

include('alibs/LogParser.php');
include('alibs/Render.php');
include('alibs/Misc.php');

$tmpl = file_get_contents('site.html');

if(!file_exists('../data/logs/installed')) {
    include('install.php');
    exit;
}

$log = new LogParser(7); // loads last 7 days ..

$replace['rightnow'] = sprintf('You served %s Requests so far today (Yesterday %s)..',count($log->logs[0]),count($log->logs[1]));

$replace['hitstoday'] = RenderTable(TransformArray($log->logs[0]),array('keyword','referer','filename'));

$replace['hitsyesterday'] = RenderTable(TransformArray($log->logs[1]),array('keyword','referer','filename'));

$cArr = array();
for($i=0;$i<7;$i++) {
    $cArr['Hits'][$i] = count($log->logs[$i]);
}
$replace['hitslast7'] = RenderTable($cArr);


/* overview - errlog etc etc .. */
$search = array();
foreach(array_keys($replace) as $key) {
    array_push($search,sprintf('{{%s}}',$key));
}

echo str_replace($search,$replace,$tmpl);

?>