<?php 

class KwDensity implements HookBase
{
	/** 
	 * $args density %
	 */
	function EnrichContent($content,$keyword,$args)
	{
		if(substr_count($content,$keyword)/str_word_count($content)*100 >= $args['density']) {
			return $content; // keyword density already ok
		}
		$amountToInject = str_word_count($content) / 100 * $args['density'] - substr_count($content,$keyword);
		$cArr = explode(" ",$content);
		for($i=0;$i<$amountToInject;$i++) {
			$rnd = rand(0,count($cArr)-1);
			$cArr[$rnd] = sprintf(" %s ",$keyword);
		}
		return implode(" ",$cArr);
	}
}

?>