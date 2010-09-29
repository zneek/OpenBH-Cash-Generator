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
 *   baselibs/Images.php
 *   Bunch of Methods for Image processing
 *
 *   @author Neek
 */

/**
 * Checks if the filename is possibly an image
 * @param <type> $filename
 * @return bool
 */
function IsImage($filename) {
	$types = array('.jpg','.png','.bmp','.gif','.jpeg','.tiff','.tga');
	if(stripos($filename,".")!==false) {
		$ftype = strtolower(substr($filename,strrpos($filename,".")));
		if(!in_array($ftype,$types)) {
			return false;
		}
	} else {
		return false;
	}
	return true;
}
/**
 *  Actually Serving an image to the browser
 *
 */
function ServeImg($filename) {
	$img = null;
	if(file_exists("data/img/".base64_encode($filename))) {
		$img = file_get_contents("data/img/".base64_encode($filename));
		header('Content-Type: image/jpeg');
		echo $img;
		return;
	}
	// download from one choosen hook and cache
	$cnt = 0;
	$imgHooks = OpenBHConf::get('imghooks');
	foreach($imgHooks as $key=>$val) {
		$cnt += $val;
	}
	$rnd = rand(0,$cnt);
	$cnt = 0;
	$i = 0;
        $s = array('-','%20');
        $r = array(' ',' ');
        $kw = str_replace($s,$r,substr($filename,0,strripos($filename,'.')));
	foreach(array_keys($imgHooks) as $imghook) {
		$i++;
		$cnt += $imgHooks[$imghook];
		if($i==count($imgHooks)) {
			$ih = new $imghook();
			$img = $ih->GetImage($kw);
			break;
		}
		if($rnd<$cnt && $rnd>($cnt-$imgHooks[$imghook])) {
			$ih = new $imghook();
			$img = $ih->GetImage($kw);
			break;
		}
	}

	if($img!=null) {
		file_put_contents("data/img/".base64_encode($filename),$img);
	} else {
		$img = file_get_contents("config/nopic.png");
	}
	
	// serve new image
	header('Content-Type: image/jpeg');
	echo $img;
	return;
}
?>