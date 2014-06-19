<?php 
/******** Syndk8's OpenBH *********
 *
 * This program is free software
 * licensed under the GPLv2 license.
 * You may redistribute it and/or
 * modify it under the terms of
 * the GPLv2 license (see license.txt)
 *
 * Warning:
 * OpenBH is for educational use
 * Use OpenBH at your own risk !
 *
 * Credits:
 * https://www.syndk8.com/openbh/people.html
 *
 ********************************/


/**
 *   baselibs/Misc.php
 *   Various Functions
 *
 *   @author Neek
 *   @todo Implement sockets ;)
 */

/**
 *  Load Settings from uri
 * 
 *  @return array
 */
function Settings($uri) {
        if($uri==str_replace('index.php','',$_SERVER['SCRIPT_NAME'])) {
            /* index ... */
            return array('filename'=>'index','uri'=>'index', 'keyword'=>'index');
        }
        $filename = '';
	if(stripos($uri,"/")!==false) {
		$filename = substr($uri,strrpos($uri,"/")+1);
	} else {
		$filename = $uri;
	}
	preg_match(OpenBHConf::get('filename_pattern'),$filename,$kwmatch);
        $keyword = '';
	if(count($kwmatch)>0) {
		$keyword = $kwmatch[1];
	}
	$s = array('-',OpenBHConf::get('filetype'));
	$r = array(' ','');
	$keyword = str_replace($s,$r,$keyword);
	// possible rss feed ?
	if(in_array($filename,OpenBHConf::get('RssNames'))) {
		$filename = 'rss';
	}
	if(stripos($uri,'sitemap.xml')!==FALSE) {
		$filename = 'sitemap.xml';
	}
	$settings = array(	'filename' => $filename,
						'keyword' => $keyword,
						'uri' => $uri
	);
	return $settings;
}

function GetPage($settings) {
	$page = null;
	switch($settings['filename'])
	{
		case 'robots.txt':
			// robots
			$page = new Page($settings['keyword'],true);
			$page->content = "Sitemap: sitemap.xml";
			break;
			
		case 'sitemap.xml':
			$loc = '';
			$page = new Page($settings['keyword'],true);
			foreach(glob('data/content/*',GLOB_NOSORT) as $filename) {
				// ...
				$p = Page::GetCache(base64_decode(str_replace('data/content/','',$filename)));
				$loc .= sprintf('<loc><url>%s%s</url></loc>',OpenBHConf::get('domain'),$p->filename);
			}
			$page->content = sprintf('	<?xml version="1.0" encoding="UTF-8"?>
											<urlset
      											xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
      											xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
      											xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
            								http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
            								%s
            								</urlset>',
											$loc);
			break;
			
		case 'rss':
			$rss = '';
			$time = array();
			$page = new Page($settings['keyword'],true);
			foreach(glob('data/content/*') as $filename) {
				$time[$filename] = filemtime($filename);  
			}
			if(count($time)==0) {
				break;
			}
			arsort($time);
			$newest = array_slice($time, 0, 10);
			foreach($newest as $key=>$val) {
				$p = Page::GetCache(base64_decode(str_replace('data/content/','',$key)));
				$rss .= sprintf('<item>
	    							<title>%s</title>
	    							<link>%s%s</link>
	    							<description><![CDATA[%s]]></description>
	    							<author>admin</author>
	    							<pubDate>%s</pubDate>   							
        						</item>',
								$p->keyword,
								OpenBHConf::get('domain'),
								$p->filename,
								$p->h1,
								date ("F d Y H:i:s.", $val)
								);
			}
			$page->content = sprintf('	<?xml version="1.0" encoding="ISO-8859-1"?>
										<rss version="2.0">
										    <channel>
										        <title>%s</title>
										        <description>%s</description>
										        <link>%s</link>
										        <lastBuildDate></lastBuildDate>
										        <generator>RSS</generator>
            								%s
            							    </channel>
										</rss>',
										'',
										'',
										OpenBHConf::get('domain'),
										$rss);
			break;		
			
		case 'index':
			// homepage - bloglike
                        $pages = array();
                        $df = new DataFeed();
                        foreach($df->ReturnFirstKeywords(OpenBHConf::get('startpage')) as $kw) {
                            // check if we already cached this page otherwise open dummy for filename
                            $page = null;
                            $page = Page::GetCache($kw);
                            if($page==null) {
                                $page = new Page($kw,false,null,true); // create empty page .. will generate filename
                            }
                            array_push($pages,$page);
                        }
                        // first hit ?
			if(empty($pages[0]->content)) {
				$datafeed = new DataFeed();
				$pages[0]->advertisment = $datafeed->ParseFeed($pages[0]->keyword);
				$pages[0]->Init(); // this page isnt built yet because its only a skeleton holding the fake filename for navigation use
			}
                        $pages[0]->SkinIndex($pages);
                        $page = $pages[0];
			break;
			
		default:
			$page = null;
			// is this page already built/cached ?
			if(!empty($settings['keyword'])) {
				$page = Page::GetCache($settings['keyword']);
			} else {
				// no keyword no page
				$page = new Page('',true);
				$page->responsecode = 404;
				$page->content = OpenBHConf::get('404');
				break;
			}
			if($page==null) {
				// check datafeed
				$datafeed = new DataFeed();
				$feedData = $datafeed->ParseFeed($settings['keyword']);	
				if(!is_array($feedData)) {
					$page = new Page('',true);
					$page->responsecode = 404;
					$page->content = OpenBHConf::get('404');
					break;
				}
				
				// build page
				$page = new Page($settings['keyword'],false,$feedData);
				
				/* we could do cloaking here this way ;) - this only works for datafeeds including an url  */
				if(array_key_exists('url',$feedData) && OpenBHConf::get('cloak')==true) {
					$cloak = new Cloaker($_SERVER['REMOTE_ADDR'],$_SERVER['HTTP_REFERER']);
					if($cloak->IsBot()==false) {
						$page->responsecode = 301;
						$page->redirlink = $feedData['url'];
					}
				}
			}
			// only a skeleton ?
			if(empty($page->content)) {
				$datafeed = new DataFeed();
				$page->advertisment = $datafeed->ParseFeed($settings['keyword']);	
				$page->Init(); // this page isnt built yet because its only a skeleton holding the fake filename for navigation use
			}
			break;
	}
	return $page;
}


/* log hits... ;) */
function loghit($page,$settings) {
    /* since this is flatfile it sucks a bit ;)
     * we are going to use session_id to track visitors over multiple clicks/hits etc ..
     */

    $logstr = sprintf('"%s";"%s";"%s";"%s";"%s";%s;"%s";"%s"',
                      session_id(),
                      $settings['keyword'],
                      $settings['filename'],
                      $_SERVER['REMOTE_ADDR'],
                      gethostbyaddr($_SERVER['REMOTE_ADDR']),
                      time(),
                      $_SERVER['HTTP_REFERER'],
                      $_SERVER['HTTP_USER_AGENT']
    );

    /* find current logfile or cycle */
    $path = sprintf('data/logs/%s.txt',strtotime("today"));
    if(!file_exists($path)) {
        // time to cycle..
        touch($path);
        if(is_writable($path)) {
            if(!chmod($path,0777)) {
                writeLog("no permission to chmod logfile ;(");
            }
        }
    }
    file_put_contents($path,$logstr.PHP_EOL, FILE_APPEND);
}


?>