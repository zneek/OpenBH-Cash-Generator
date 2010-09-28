<?php 

class Bing implements HookBase
{
	function EnrichContent($content,$keyword,$args)
	{
                $kw = str_replace(" ","+",$keyword);
		$url = "http://www.bing.com/search?q=$kw+language%3Aen&form=QBRE&filt=all&qb=4&count=50";
		preg_match_all("/<h3><a (.+?)<\/p/si",Internet::Grab($url),$cmatches);
		$gContent = implode(" ",$cmatches[1]);
		$gContent = preg_replace("/(<\/?)(\w+)([^>]*>)/e"," ",$gContent);
		$content .= $gContent;
		return $content;
	}
}

?>