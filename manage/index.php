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

$log = new LogParser(7);



/* overview - errlog etc etc .. */


?>