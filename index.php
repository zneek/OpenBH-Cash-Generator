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
 *   index.php
 *   Everything goes trough the index..
 *
 *   @author Neek
 *   @return Website ;)
 *   @tutorial https://www.syndk8.com/openbh/
 */

session_start();

include('config/config.php');

/* base */
include('baselibs/DB.php');
include('baselibs/DataFeed.php');
include('baselibs/HookBase.php');
include('baselibs/ImghookBase.php');
include('baselibs/Page.php');
include('baselibs/Misc.php');
include('baselibs/Images.php');
include('baselibs/AdGrabber.php');
include('baselibs/Advertising.php');
include('baselibs/StaticAdvertising.php');
include('baselibs/DynamicAdvertising.php');
include('baselibs/Internet.php');

/* expand here ;) */
include('extlibs/Generators.php'); // filename generators
include('extlibs/TokenFuncs.php'); // {{token}} funcs that work on the fly
include('extlibs/CachedTokenFuncs.php'); // ((token)) funcs that cache

$settings = Settings($_SERVER['REQUEST_URI']);
TemplateRewrite($settings['filename']);

if(!is_array($settings)) {
	writeLog('settings FAILED to load');
}

if(IsImage($_SERVER['REQUEST_URI'])) {
	// Load all image hooks
	foreach (glob("imghooks/*.php") as $filename) {
		include($filename);
	}	
	ServeImg($settings['filename']);
	exit;
}

// Load all content hooks
foreach (glob("hooks/*.php") as $filename) {
	include($filename);
}

// Load dynamic adserving hooks
foreach (glob("adhooks/*.php") as $filename) {
	include($filename);
}

// setting us up the page
$page = GetPage($settings);

switch($page->responsecode)
{
	case 404:
		header("HTTP/1.0 404 Not Found");
		echo $page->content;
		break;
		
	case 302:
	case 301:
		header("Location: {$page->redirlink}");
		break;
		
	case 200:

		if($page->dontskin==1) {
			echo $page->content;
			break;
		}
		echo utf8_encode($page->Skin());
		break;
}


/* log ... */
if(OpenBHConf::get('loghits')==true) {
    loghit($page,$settings);
}

?>