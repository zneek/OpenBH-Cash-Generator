<?php 
/*
 * Static Ads meaning datafeeds and stuff like that
 * 
 * token for site.html template #staticad# - it will show the correct entry from the datafeed for the current keyword
 */
class StaticAdvertising extends Advertising
{	
	function __construct($adArray) 
	{
		$this->AdArray = $adArray;
		$this->template = file_get_contents(sprintf('templates/%s/StaticAd.html',OpenBHConf::get('template')));
	}
}
?>