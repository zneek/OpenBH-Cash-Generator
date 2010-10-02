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
 *   baselibs/DataFeed.php
 *   The DataFeed class helps us map keywords, urls etc
 *   from DataFeeds like the ones from various Affiliate
 *   Networks either in CSV Format or XML
 *   For the fmap array check the config/config.php file
 *
 *   @author Neek
 *   @todo Finalize XML support
 *   @return obj
 */
class DataFeed
{
	private $feed = array();
	private $fmap = array();
        private $xmlobj;

	function __construct() {
		/* we should not always load the feed ... */
                if(OpenBHConf::get('xmlfeed')==true) {
                    if(!function_exists('simplexml_load_file')){
                        writeLog("SimpleXML support missing");
                        return false;
                    }
                    $this->fmap = OpenBHConf::get('xmlfeedmapping');
                } else {
                    $this->fmap = OpenBHConf::get('feedmapping');
                }
		if(!array_key_exists('keyword',$this->fmap)) {
			writeLog("Missing 'keyword' in 'feedmapping' (see config..php)");
			return false; // ... missing keyword mapping
		}
	}

	private function Load() {
            if(OpenBHConf::get('xmlfeed')==true) {
                $this->xmlobj = simplexml_load_file('config/kw/open.txt');
            } else {
		if (($handle = fopen('config/kw/open.txt', 'r')) !== FALSE) {
			while (($data = fgetcsv($handle, 10000, OpenBHConf::get('csv_delimiter'), OpenBHConf::get('csv_enclosure'))) !== FALSE) { // fuck you ,OpenBHConf::get('csv_escape')
		        array_push($this->feed,$data);
		    }
		    fclose($handle);
		}
            }
	}

        private function LoadOnly($amount) {
            if(OpenBHConf::get('xmlfeed')==true) {
                $this->Load();
            } else {
                $cnt = 0;
                if (($handle = fopen("config/kw/open.txt", "r")) !== FALSE) {
                    while (($data = fgetcsv($handle, 10000, OpenBHConf::get('csv_delimiter'), OpenBHConf::get('csv_enclosure'),OpenBHConf::get('csv_escape'))) !== FALSE) {
                        if($cnt==$amount) {
                            break;
                        }
                        array_push($this->feed,$data);
                        $cnt++;
                    }
                    fclose($handle);
                }
            }
        }

        public function ReturnFirstKeywords($amount) {
            $kwArr = array();
            $this->LoadOnly($amount);
            if(OpenBHConf::get('xmlfeed')==true) {
                $cnt = 0;
                foreach($this->xmlobj->xpath(sprintf('/%s',$this->fmap['keyword'])) as $kw) {
                    array_push($kwArr,$kw);
                    if($cnt++==$amount) {
                        break;
                    }
                }
            } else {
                foreach($this->feed as $line) {
                    array_push($kwArr,$line[$this->fmap['keyword']]);
                }
            }
            return $kwArr;
        }

	public function ReturnPrevKw($kw) {
		if(count($this->feed)==0 && !is_object($this->xmlobj)) {
			$this->Load();
		}
                if(OpenBHConf::get('xmlfeed')==true) {
                    /* previous keyword .. */
                    return false;
                } else {
                    $key = array_search($kw,$this->feed);
                    if($key==0 || $key==false) {
                            return false;
                    }
                    return $this->feed[$key-1][$this->fmap['keyword']];
                }
	}

	public function ReturnNextKw($kw) {
		if(count($this->feed)==0 && !is_object($this->xmlobj)) {
			$this->Load();
		}
                if(OpenBHConf::get('xmlfeed')==true) {
                    /* next keyword .. */
                    return false;
                } else {
                    $key = array_search($kw,$this->feed);
                    if($key==(count($this->feed)-1) || $key==false) {
                            return false;
                    }
                    return $this->feed[$key+1][$this->fmap['keyword']];
                }
	}

	public function ReturnRandomEntries($num) {
		if(count($this->feed)==0) {
			$this->Load();
		}
		$cnt = count($this->feed);
                if($num>$cnt) {
                    $num = $cnt;
                }
		$ret = array();
		while(count($ret)<$num) {
			$rnd = rand(0,$cnt);
			if(!is_numeric(array_search($this->feed[$rnd][$this->fmap['keyword']], $ret))) {
                            array_push($ret,$this->feed[$rnd][$this->fmap['keyword']]);
                        }
		}
		return $ret;
	}

	public function ParseFeed($kw) {
		/*
		 * this needs to be configured inside the config
		 * column to var mapping
		 * separator
		 *
		 * this needs to be an associative array like this:
		 * the key will be used as token so you can map anything you like ;)
		 *
		 * array('prodname'=>12,'keyword'=>2,'url',3);
		 */

		$row = 1;
		$result = null;
		if (($handle = fopen("config/kw/open.txt", "r")) !== FALSE) {
			while (($data = fgetcsv($handle, 10000, OpenBHConf::get('csv_delimiter'), OpenBHConf::get('csv_enclosure'))) !== FALSE) { // ,OpenBHConf::get('csv_escape') escape added php 5.3 .. ;(
				if(str_replace('-',' ',strtolower($data[$this->fmap['keyword']]))!=strtolower($kw)) {
		        	continue;
		        }
		        $result = $data;
		        break; // $data match
		    }
		    fclose($handle);
		}

		// map col<>map
		$linemap = null;
		if(is_array($result)) {
			$lineMap = array();
			foreach($this->fmap as $k=>$v) {
				if(count($data)<$v) {
					continue;
				}
				$lineMap[$k] = $data[$v];
			}
		}

		return $lineMap;
	}
}
?>
