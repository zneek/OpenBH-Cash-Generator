<?php 

class ShuffleSentences implements HookBase
{
	function EnrichContent($content,$keyword,$args)
	{
		$sentences = preg_split('/[\.\?\!\:]/', $content, -1, PREG_SPLIT_NO_EMPTY);
		shuffle($sentences);
		return implode(". ",$sentences);
	}
}

?>