<?php


/**
 * Description of YahooAnswers
 *
 * @author zneek
 */

class YahooAnswers implements HookBase
{
    function EnrichContent($content,$keyword,$args)
    {
        $tmpl = <<<EOT
        <div>
            <div>avaatar/userinfo</div>
            <div>text</div>
        </div>
EOT;

        $url = 'http://answers.yahoo.com/search/search_result?page=1&p=%s&scope=all&fltr=_en&question_status=all&date_submitted=all&category=0&answer_count=any&filter_search=1';
        $data = Internet::Grab(sprintf($url,str_replace(' ','+',$page->keyword)));
        preg_match_all('/h3><a.+?"(.+?)<ul/',$data,$qa);
        $gContent = implode(" ",$cmatches[1]);
        $gContent = preg_replace("/(<\/?)(\w+)([^>]*>)/e"," ",$gContent);
        $content .= $gContent;
        return $content;
    }

    function GrabAvatars($keyword,$num)
    {

    }
}

?>
