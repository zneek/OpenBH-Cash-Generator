<?php 

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