<?php 
/*
 * Syndk8.com OpenBH 2010
 * 
 * Container holding Page object
 * 
 */


/**
 * The Page class is used to store (serialize) and load (deserialize) created pages 
 * or generate new pages as we need them
 * 
 * 
 * Special Page wtf?
 * special pages is simply missusing the page object to 
 * also serve robots/sitemaps/rss feeds/redirects/whatever
 * but is not building any content
 * 
 * @author Neek
 *
 */

class Page
{
	// Content
	public $keyword;
	public $title;
	public $content;
	public $h1;
	public $h2;
	public $metakw;
	public $metadesc;
	
	// Randomized data for quicker access
	public $last;
	public $last_kw;
	public $next;
	public $next_kw;
	public $navlinks = array();
	
	// special cases
	public $responsecode;
	public $dontskin = false;
	public $redirlink;
	
	// datafeed related
	public $advertisment;
	// template
	private $template;
	
	// because of patterns..
	public $filename; // randomized name
	public $filter;  // the filter used ??
	
	// optionally we can configure an advertisment with the initial keyword import (datafeeds etc/csv parser)
	public $staticAdContainer = array();

        private $cachedFuncStorage = array();
	
	function __construct($keyword,$special=false,$advertisment=null,$empty=false) //$title,$content,$h1,$h2,$last,$next,$navlinks)
	{
		if(!file_exists(sprintf('templates/%s/site.html',OpenBHConf::get('template')))) {
			return false;
		}
		$this->template = file_get_contents(sprintf('templates/%s/site.html',OpenBHConf::get('template')));
		
		$this->advertisment = $advertisment;
		
		// default is not a special page ;)
		$this->responsecode = 200;
		$this->dontskin = 1;
		$this->redirlink = null;
		$this->keyword = $keyword;
		$this->filename = $this->BuildFilename();
                
                // static content snippets because this parts should really not be scraped on the fly
                $this->title = $this->TextSnippet($this->keyword,'title.txt');
		$this->h1 = $this->TextSnippet($this->keyword,'h1.txt');
		$this->h2 = $this->TextSnippet($this->keyword,'h2.txt');

		if($special==false && $empty==false) {
			$this->Init();
		}
		if($empty==true) {
			$this->SetCache();
		}
	}
	
	public function Init() {
		$this->content = $this->BuildContent(OpenBHConf::get('hooks'));
		
		$this->metadesc = $this->TextSnippet($this->keyword,'description.txt');
		$this->metakw = '';
		
		// navigation elements
		$this->BuildNav();
		
		$this->dontskin = 0;
		
		// store ..
		$this->SetCache(); 
	}
	
	private function BuildFilename() {
		$filegen = OpenBHConf::get('filename_generator');
		$s = array('%keyword%','%datecreated%');
		$r = array($this->keyword,date('h-i-s'));
		$filegen = str_replace($s,$r,$filegen);
		$filegen = preg_replace_callback(	"/{(.+?)}/",
                                                        create_function(    '$matches',
                                                                            '$expl = explode(",",$matches[1]);
                                                                            if(function_exists($expl[0])) { return $expl[0]($expl[1]); } return "";'
                                                        ),
                                                        $filegen);
		/* cleanup ;) */
		$filegen = str_replace('{','',$filegen);
		$filegen = str_replace('}','',$filegen);
		$filegen = str_replace(' ','-',$filegen);
		return sprintf("%s%s",$filegen,OpenBHConf::get('filetype'));
	}
	
	private function BuildNav() {
		/* !!! */
		$datafeed = new DataFeed();
		$filenames = array();
		$keywords = $datafeed->ReturnRandomEntries(rand(OpenBHConf::get('navlinks_min'),OpenBHConf::get('navlinks_max')));
		foreach($keywords as $keyword) {
			/* we need to check if we already generated this page (because of the randomized filename..) */
			$tmpPage = Page::GetCache($keyword);
			if(is_null($tmpPage)) {
				/* we didnt already created it we need to assign a random filename now !! and store it as empty page..) */
				$p = new Page($keyword,false,null,true); // create empty page .. will generate filename 
				array_push($filenames,array('kw'=>$keyword,'filename'=>$p->filename));
				$p = null;
				continue;
			}
			array_push($filenames,array('kw'=>$keyword,'filename'=>$tmpPage->filename));
		}
		$this->navlinks = $filenames;
		
		$this->last_kw = $datafeed->ReturnPrevKw($this->keyword);
		$prevPage = Page::GetCache($this->last_kw);
		if(is_null($prevPage)) {
			$prevPage = new Page($this->last_kw,false,null,true);
			$this->last = $prevPage->filename;
		} else {
			$this->last = $prevPage->filename;
		}
		
		$this->next_kw = $datafeed->ReturnNextKw($this->keyword);
		$nextPage = Page::GetCache($this->next_kw);
		if(is_null($nextPage)) {
			$nextPage = new Page($this->next_kw,false,null,true);
			$this->next = $nextPage->filename;
		} else {
			$this->next = $nextPage->filename;
		}
	}
	
	function SkinIndex($pageArr) {
		/*
		 * replace [[article]] section 
		 */
                 $c = '';
                 preg_match("/\[\[article\]\](.+?)\[\[\/article\]\]/si",$this->template,$articlesection);
                 foreach($pageArr as $p) {
                     $s = array('[[content]]','[[title]]','[[h1]]','[[h2]]','[[keyword]]');
                     $r = array(sprintf('%s <a href="%s">%s</a>...',substr($p->content,0,rand(200,300)),$p->filename,$p->keyword),$p->title,$p->h1,$p->h2,$p->keyword);
                     $c .= str_ireplace($s,$r,$articlesection[1]);
                 }
		$this->template = preg_replace('/\[\[article\]\].+?\[\[\/article\]\]/si',$c,$this->template);
		return $this->Skin();	
	}
	
	function Skin() {
		/* basic elements */
		$this->template = str_ireplace("[[content]]",$this->content,$this->template);
		$this->template = str_ireplace("[[title]]",$this->title,$this->template);
		$this->template = str_ireplace("[[h1]]",$this->h1,$this->template);
		$this->template = str_ireplace("[[h2]]",$this->h2,$this->template);
		
		preg_match("/\[\[nav\]\](.+?)\[\[\/nav\]\]/is",$this->template,$navmatch);
		foreach($this->navlinks as $kwf) {
			$nav .= str_replace("[[nav_url]]",$kwf['filename'],str_replace("[[keyword]]",$kwf['kw'],$navmatch[1]));
		}
		$this->template = preg_replace("/\[\[nav\]\](.+?)\[\[\/nav\]\]/is",$nav,$this->template);
		
		/*
		$this->template = str_ireplace("[[nav_lastkw]]",sprintf('<a href="%s">%s</a>',$this->last,$this->last_kw),$this->template);
		$this->template = str_ireplace("[[nav_nextkw]]",sprintf('<a href="%s">%s</a>',$this->next,$this->next_kw),$this->template);
		*/
		$this->template = str_ireplace("[[nav_last]]",$this->last,$this->template);
		$this->template = str_ireplace("[[nav_next]]",$this->next,$this->template);
		$this->template = str_ireplace("[[nav_lastkw]]",$this->last_kw,$this->template);
		$this->template = str_ireplace("[[nav_nextkw]]",$this->next_kw,$this->template);
		
		$this->template = str_ireplace("[[keyword]]",$this->keyword,$this->template);
		
		/* ads */
		if(stripos($this->template,"[[staticad(js)]]")!==FALSE || stripos($this->template,"[[staticad(html)]]")!==FALSE) {
			$ad = new StaticAdvertising($this->advertisment);
			$this->template = str_ireplace("[[staticad(js)]]",$ad->ServeAdJS(),$this->template);
			$this->template = str_ireplace("[[staticad(html)]]",$ad->ServeAdHTML(),$this->template);
		}
		
		if(stripos($this->template,"[[dynamicad(js)#")!==FALSE || stripos($this->template,"[[dynamicad(html)]]")!==FALSE) {
			$ad = new DynamicAdvertising($this->keyword,OpenBHConf::get('dynadhook'));
			$this->template = str_ireplace("[[dynamicad(js)]]",$ad->ServeAdJS());
			$this->template = str_ireplace("[[dynamicad(html)]]",$ad->ServeAdHTML());
		}

                /* on the fly function tokens.. {{funcName}} */
 		$this->template = preg_replace_callback(	"/{{(.+?)}}/",
                                                                create_function(    '$matches',
                                                                                    '$expl = explode(",",$matches[1]);
                                                                                    if(function_exists($expl[0])) { return $expl[0]($expl[1]); } return "";'
                                                                ),
                                                                $this->template);

                /* cached function tokens ((funcName)) */
                preg_match_all('/\(\((.+?)\)\)/is',$this->template,$cachedFuncs);
                foreach($cachedFuncs[1] as $cachedFunc) {
                    if(!array_key_exists($cachedFunc,$this->cachedFuncStorage)) {
                        if(function_exists($cachedFunc)) {
                            $this->cachedFuncStorage[$cachedFunc] = $cachedFunc($this);
                        } else {
                            $this->cachedFuncStorage[$cachedFunc] = '';
                        }
                    }
                    $this->template = str_ireplace(sprintf('((%s))',$cachedFunc),$this->cachedFuncStorage[$cachedFunc],$this->template);
                }
                /* replace the rest */
		$this->template = preg_replace('/\[\[.+?\]\]/','',$this->template);
                $this->template = preg_replace('/\[\[\/.+?\]\]/','',$this->template);
		
		return $this->template;
	}
	
	/**
	 * Using the configured hooks (see config.php) to generate the content
	 * 
	 * @param $HookList
	 * @return unknown_type
	 */
	private function BuildContent($HookList)
	{
		$content = '';
		foreach(array_keys($HookList) as $hook) {
			if(!class_exists($hook)) {
				continue;
			}
			if(!array_key_exists('prob',$HookList[$hook])) {
				continue; // missconfigured class - check $conf['hooks'] ..
			}
			if(rand(0,100)<$HookList[$hook]) {
				$h = new $hook();
				$content = $h->EnrichContent($content,$this->keyword,$HookList[$hook]);
			}
		}
		return $this->finalizeContent($content);
	}
	
	private function TextSnippet($keyword,$file) {
		$path = sprintf("config/text/%s",$file);
		if(!file_exists($path)) {
			return false;
		}
		$lines = file($path);
		if(count($lines)<=0) {
			return false;
		} 
		shuffle($lines);
		return str_ireplace("#keyword#",$keyword,$lines[0]);
	}
	
	private function FinalizeContent($content) {
		$content = preg_replace('/\s+/',' ',$content);
		$content = preg_replace_callback('/([\.,;:!\?]+)/',create_function('$matches','return substr($matches[1],0,1);'),$content);
		$content = preg_replace('/\s([,\.;!\?])/','${1}',$content);
		$content = preg_replace('/([,\.;!\?])(\w)/','${1} ${2}',$content);
		$content = preg_replace_callback('/([,\.;!\?])\s(\w)/',create_function('$matches','return sprintf("%s %s",$matches[1],ucfirst($matches[2]));'),$content);
		return $content;
	}
	
	private function SetCache() {
		$path = sprintf('data/content/%s',base64_encode($this->keyword));
		file_put_contents($path,gzcompress(serialize($this)));
	}
	
	// static cache/object loader 
	public static function GetCache($keyword) {
		if(!file_exists(sprintf('data/content/%s',base64_encode($keyword)))) {
			return null;
		}
		return unserialize(gzuncompress(file_get_contents(sprintf('data/content/%s',base64_encode($keyword)))));
	}
}

?>