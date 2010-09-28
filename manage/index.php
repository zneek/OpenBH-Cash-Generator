<?php 
/*
 * show keyword stats how many open closed built cached etc
 * 
 * 
 * 
 */

include('alibs/LogParser.php');
include('alibs/Render.php');
include('alibs/Misc.php');

$tmpl = file_get_contents('site.html');

$log = new LogParser(7); // loads last 7 days ..

$replace['rightnow'] = sprintf('You served %s Requests so far today (Yesterday %s)..',count($log->logs[0]),count($log->logs[1]));

$replace['hitstoday'] = RenderTable(TransformArray($log->logs[0]),array('keyword','referer','filename'));

$replace['hitsyesterday'] = RenderTable(TransformArray($log->logs[1]),array('keyword','referer','filename'));

/* overview - errlog etc etc .. */
$search = array();
foreach(array_keys($replace) as $key) {
    array_push($search,sprintf('{{%s}}',$key));
}

echo str_replace($search,$replace,$tmpl);

?>