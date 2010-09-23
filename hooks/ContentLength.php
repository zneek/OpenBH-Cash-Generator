<?php

class ContentLength implements HookBase
{
	function EnrichContent($content,$keyword,$args)
	{
            if(!is_numeric($args['lengthmin']) || !is_numeric($args['lengthmax'])) {
                return $content;
            }
            $length = rand($args['lengthmin'],$args['lengthmax']);
            return substr($content,0,stripos($content,".",$length)+1);
	}
}

?>