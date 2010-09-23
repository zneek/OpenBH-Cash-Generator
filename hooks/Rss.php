<?php 

class Rss implements HookBase
{
	function EnrichContent($content,$keyword,$args)
	{
            $feeder = array(    'http://news.search.yahoo.com/rss?ei=UTF-8&p=%s&fr=sfp',
                                'http://blogsearch.google.com/blogsearch_feeds?hl=en&q=%s&ie=utf-8&num=10&output=rss',
                                'http://www.bing.com/search?q=%s%20language:en&go=&form=QBLH&filt=all&format=rss'
            );
            shuffle($feeder);
            $link = sprintf($feeder[0],str_replace(' ','+',$keyword));
            $feed = Internet::Grab($link);
            preg_match_all('/cription>(.+?)<\//si',$feed,$des);
            preg_match_all('/itle>(.+?)<\//si', $feed, $tit);
            return sprintf('%s %s',$content,implode(' ',shuffle(array_merge($tit,$des))));
	}
}

?>