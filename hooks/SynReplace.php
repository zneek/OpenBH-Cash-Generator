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
 *   adhooks/SynReplace.php
 *   Replace Synonyms in $content
 *
 *   Select from ajd,n,adv,prep,v
 *
 *   @todo enhance language support
 *   @author Neek
 */

class SynReplace implements HookBase
{
	private $dict = array();
	private $lang = "en"; 
	/**
	 * args bool
	 *  adj
	 *  n
	 *  adv
	 *  prep
	 *  v
	 *  
	 * 
	 */
	function EnrichContent($content,$keyword,$args)
	{
		$this->dict['adj'] = $this->Read(sprintf("config/dict/adj_%s.csv",$this->lang));
		$this->dict['n'] = $this->Read(sprintf("config/dict/n_%s.csv",$this->lang));
		$this->dict['adv'] = $this->Read(sprintf("config/dict/adv_%s.csv",$this->lang));
		$this->dict['prep'] = $this->Read(sprintf("config/dict/prep_%s.csv",$this->lang));
		$this->dict['v'] = $this->Read(sprintf("config/dict/v_%s.csv",$this->lang));
		
		foreach($args as $key=>$value) {
			if(array_key_exists($key,$this->dict)) {
				if($value==false) {
					continue;
				}
				$content = $this->DoSynReplace($content,$keyword,$key);
			}	
		}
		return $content;
	}
	
	private function Read($file) {
		$csv = gzuncompress(file_get_contents($file));
		return explode(PHP_EOL,$csv);
	}
	
	private function DoSynReplace($content,$keyword,$key) {
		/* 
		 * dict format
		 * 
		 * word,syn1,syn2,syn3
		 * ward,syn1,syn2
		 * wurd,syn1,syn2,syn3,syn4
		 *  
		 */
		
		/* 2 options
		 * slow 
		 * high mem usage * this one
		 */
                $tmp = array();
                for($i = 0; $i < count($this->dict[$key]); $i++) {
                    foreach(explode(',',$this->dict[$key][$i]) as $word) {
                        $word = trim($word);
                        if(!array_key_exists($word, $tmp)) {
                            $tmp[$word] = $i;
                        }
                    }
                }
                $r = '';
                $w = '';
                $c = '';
                $arr = array('.','!','?',',',' '); // possible word delimiters ;)
                foreach(str_split($content) as $char) {
                    if(in_array($char,$arr)) {
                        if(strlen($w)>3 && stripos($keyword,$w)===false) {
                            if(array_key_exists(strtolower($w),$tmp)) {
                                $l = explode(',',$this->dict[$key][$tmp[strtolower($w)]]);
                                shuffle($l);
                                if(ctype_upper($w[0])) {
                                    $w = ucfirst($l[0]);
                                } else {
                                    $w = $l[0];
                                }
                            }
                        }
                        $c .= $w.$char;
                        $r = false;
                        $w = '';
                    }
                    if($r==true) {
                        $w .= $char;
                    }
                    $r = true;
                }
		return $c;
	}
}

?>