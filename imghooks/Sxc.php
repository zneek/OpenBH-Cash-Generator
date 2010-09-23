<?php 

class Sxc implements ImagehookBase
{
	function GetImage($keyword)
	{
		$keyword = str_replace(" ","+",$keyword);
		$content = Internet::Grab("http://www.sxc.hu/browse.phtml?f=search&txt={$keyword}&w=1&x=0&y=0");
		if(preg_match_all("/showtrail\(300,[0-9]+,'(.+?)'/",$content,$matches)==0) {
			$keyword = str_replace(" ","-",$keyword);
			$content = Internet::Grab("http://www.sxc.hu/browse.phtml?f=search&txt={$keyword}&w=1&x=0&y=0");
			if(preg_match_all("/showtrail\(300,[0-9]+,'(.+?)'/",$content,$matches)==0) {
				return null;
			}
		}
		shuffle($matches[1]);
		return Internet::Grab(sprintf("http://www.sxc.hu/%s",$matches[1][0]));
	}
}

?>