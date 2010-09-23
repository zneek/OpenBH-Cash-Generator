<?php 


class Imagetag implements HookBase
{
	function EnrichContent($content,$keyword,$args)
	{
		$filename = str_replace(" ","-",$keyword);
		$content .= "<img src='$filename'/>";
		return $content;
	}
}

?>