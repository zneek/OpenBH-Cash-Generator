<?php 

class Google implements HookBase
{
	function EnrichContent($content,$keyword,$args)
	{
		$url = sprintf("http://www.google.com/search?hl=en&source=hp&q=%s&aq=f&aqi=&aql=&oq=&gs_rfai=&num=100",str_replace(" ","+",$keyword));
		preg_match_all("/class=l>(.+?)<span class=f><cite>/si",Internet::Grab($url),$cmatches);
		$gContent = implode(" ",$cmatches[1]);
		$gContent = preg_replace("/(<\/?)(\w+)([^>]*>)/e"," ",$gContent);
		$content .= $gContent;
		return $content;
	}
}

?>