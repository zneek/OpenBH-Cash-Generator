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
 *   config/config.php
 *   This is the Base Configuration file for your OpenBH Site!
 *
 *   @link https://www.syndk8.com/openbh/config.html
 *   @author Neek
 */

class OpenBHConf
{
    private $conf = array();
    
    private function __construct() 
    {
    	$this->conf['domain'] = 'http://217.150.241.141/syndk8tools/openbh/';

        $this->conf['template'] = 'template1';
        
        $this->conf['db'] = false; 
        $this->conf['dbuser'] = '';
        $this->conf['dbpass'] = '';
        $this->conf['dbname'] = '';

        /* 
           CREATE TABLE `openbh_cache` (
              `oc_id` int(11) NOT NULL AUTO_INCREMENT,
              `oc_identifier` varchar(256) NOT NULL,
              `oc_data` blob NOT NULL,
              PRIMARY KEY (`oc_id`)
            );
        */
		
            /**
             * Hooks Setup
             *
             * Classname of the Hook and
             * probability to be used in %
             * additional arguments
             *
             * Hooks will be applied in this exact order!
             */
            $this->conf['hooks'] = array(	'Flickr'=>array('prob'=>50),
                                                'Google'=>array('prob'=>0,'minlength'=>300,'maxlength'=>400),
                                                'Bing'=>array('prob'=>100),
                                                'Articles'=>array('prob'=>100),
                                                'Rss'=>array('prob'=>100),
                                                'ShuffleSentences'=>array('prob'=>100),
                                                'SynReplace'=>array('prob'=>50,'adv'=>true,'n'=>true,'v'=>false,'adj'=>false,'prep'=>true),
                                                'KwDensity'=>array('prob'=>100,'density'=>5),
                                                'Badwords'=>array('prob'=>100),
                                                'ContentLength'=>array('prob'=>100,'lengthmin'=>1700,'lengthmax'=>3500),
                                                'Format'=>array('prob'=>100,'pmin'=>4,'pmax'=>8,'li'=>50)
            );

            /* ImageHook configuration - hook,probability */
            $this->conf['imghooks'] = array( 	'YahooImages'=>100,
                                                    'Sxc'=>10
            );

            /* deprecated */
            $this->conf['RssNames'] = array(	'feed',
                                                    'rssfeed',
                                                    'rss'
            );

            /* serve ads with this hook (if you're actually using dynamic ads) */
            $this->conf['dynadhook'] = array(	'Exoclick'
            );

            /**
             * Mappings for your datafeeds (in case you are using datafeeds to also produce ads)
             *
             * you ALWAYS have to name your keyword col 'keyword' <- required
             * you ALWAYS have to name the link/url 'url' (so we can later on identify this part, the rest will be replaced dynamically using the key as token) <- not required
             *
             * eg: 'prodname' will replace #prodname# in your ad template
             *
             */

            $this->conf['xmlfeed'] = false; // EXPERIMENTAL : set to true for xml feeds..

            /* csv datafeeds */
             $this->conf['feedmapping'] = array(    'keyword'=>40,
                                                    'url'=>8,
                                                    'description'=>12,
                                                    'price'=>79,
                                                    'imageurl'=>25
            );

             /* in case your feed is in xml */
             $this->conf['xmlfeedparent'] = 'item';
             $this->conf['xmlfeedmapping'] = array( 'keyword'=>'keyword',
                                                    'url'=>'url',
                                                    'description'=>'desc',
                                                    'price'=>'price',
                                                    'imageurl'=>'img'
             );

            /* navigation min/max items */
            $this->conf['navlinks_min'] = 12;
            $this->conf['navlinks_max'] = 20;

            /* start page count */
            $this->conf['startpage'] = 7;

            /* url patterns */
            $this->conf['filename_pattern'] = "/_(.*)_/";
            $this->conf['filename_generator'] = "{countfiles}-{num,3}_%keyword%_%datecreated%"; // {generator,args} %tokens% (special 'stuff')

            /* CSV Setup */
            $this->conf['csv_delimiter'] = ','; // only one character!
            $this->conf['csv_escape'] = '\\';
            $this->conf['csv_enclosure'] = '"';

            /* 404 default output */
            $this->conf['404'] = '404 / Site not Found';
            
            /* cloaking ;) */
            $this->conf['cloak'] = false;

            /* Choose a filetype */
            $this->conf['filetype'] = '.html';

            /* log visitors and bots */
            $this->conf['loghits'] = true;

            /* not working ? try log to errlog.txt */
            $this->conf['errlog'] = true;
    }

    public static function get($key)
    {
        global $OpenBHConf;
        $c = __CLASS__;
        if(!isset($OpenBHConf) || !is_a($OpenBHConf,$c)) {
            $OpenBHConf = new $c;
        }
        if(array_key_exists($key,$OpenBHConf->conf)) {
        	return $OpenBHConf->conf[$key];
        }
        return array();
    }
}


/**
 *  Various Stuff, Logging, TemplateRewrite etc
 */

function autoLog($errornum, $errormsg, $errorfile, $errorline) {
	writeLog(sprintf('(%s) %s in %s on line %s',$errornum, $errormsg, $errorfile, $errorline));
}

function writeLog($err) {
	if(OpenBHConf::get('errlog')==true) {
		file_put_contents("config/errlog.txt",mktime().":".$_SERVER['REMOTE_ADDR'].":".$err.PHP_EOL,FILE_APPEND);
	}
}

function TemplateRewrite($filename) {
    $p = str_replace(str_replace('index.php','',$_SERVER['SCRIPT_NAME']),'',$_SERVER['REQUEST_URI']);
    if($p=='') {
        return;
    }
    $fp = sprintf('templates/%s/%s',OpenBHConf::get('template'),$p);
    if(file_exists($fp)) {
        if(stripos($fp,'.css')!==false) {
            header("Content-type: text/css");
        }
        echo readfile($fp);
        exit;
    }
}

set_error_handler("autoLog");

/* map template files.. ;) */


?>