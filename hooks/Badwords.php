<?php 
/*
 * Replaces Badwords from config/badwords.txt in content
 */
class Badwords implements HookBase
{
	function EnrichContent($content,$keyword,$args)
	{
		$badwords = file('config/badwords.txt');
		$content = str_replace($badwords,'',$content);
		return $content;
	}
}

?>