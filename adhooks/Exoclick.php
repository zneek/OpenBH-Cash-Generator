<?php 


class Exoclick implements AdGrabber
{
	function ReturnData($keyword)
	{
		$login="syndk8";
		$search=$keyword;
		$n=10;
		$ads=@file("http://syndication.exoclick.com/feeds.php?login=$login&keyword=$search&type=1&n=$n&ip=".$_SERVER[REMOTE_ADDR]."&referer=http://".urlencode($_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"])."&useragent=".urlencode($_SERVER["HTTP_USER_AGENT"]));
		$ret = array();
		foreach($ads as $ad) {
			$ad=explode("|",$ad);
			$ret[] = array(	'prodname'=>$ad[0],
							'url'=>$ad[4],
							'desc'=>$ad[1]				
			);
		}
		return $ret;
	}
}

?>