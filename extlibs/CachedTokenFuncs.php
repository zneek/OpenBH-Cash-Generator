<?php

function YahooAnswers($page) {
    $url = 'http://answers.yahoo.com/search/search_result?page=1&p=%s&scope=all&fltr=_en&question_status=all&date_submitted=all&category=0&answer_count=any&filter_search=1';
    $data = Internet::Grab(sprintf($url,str_replace(' ','+',$page->keyword)));
    preg_match_all('/h3><a.+?"(.+?)<ul/',$data,$qa);
    // $gContent = preg_replace("/(<\/?)(\w+)([^>]*>)/e"," ",$gContent);
}

?>
