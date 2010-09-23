<?php 

class YahooImages implements ImagehookBase
{
	function GetImage($keyword)
	{
		$keyword = str_replace(" ","+",$keyword);
		$content = Internet::Grab(sprintf("http://images.search.yahoo.com/search/images?p=%s&ei=UTF-8",$keyword));
		if(preg_match_all("/thumbnail\.aspx\?q=(.+?)\"/",$content,$matches)==0) {
			shuffle($matches[1]);	
		}
		return Internet::Grab(sprintf("http://ts3.mm.bing.net/images/thumbnail.aspx?q=%s",str_replace("&amp;","&",$matches[1][0])));
	}
}

?>