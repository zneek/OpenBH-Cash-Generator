<?php 
/*
 * dynamic Ads
 * 
 * this will show dynamic ads on your site using the referer keyword and/or the current page keyword
 * 
 * token #dynads#
 */

class DynamicAdvertising extends Advertising
{
	function __construct($keyword,$adhook)
	{
		/*
		 * we basically should loop trhough all available Advertisment Hooks until we got a satisfying result ;)
		 * currently only using the first configured hook 
		 */
		
		if(!class_exists($adhook[0])) {
			return false;
		}
		$ad = new $adhook[0]();
		$this->AdArray = $ad->ReturnData($keyword);
		$this->template = file_get_contents("templates/DynamicAd.html");
	}
}
?>