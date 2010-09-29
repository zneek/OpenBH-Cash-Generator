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
 *   adhooks/AD.php
 *   Adds <p> and <li> to $content
 *
 *   @author Neek
 *   @todo Implement more formattings ;)
 */
class Format implements HookBase
{
	/**
	 * args
	 *  pmin
         *  pmax
         *  li (0-100% prob of occurance)
	 *
	 */
	function EnrichContent($content,$keyword,$args)
	{
            if(is_numeric($args['pmin'])&&is_numeric($args['pmax'])) {
                $pcnt = rand($args['pmin'],$args['pmax']);
                $stepsize = strlen($content) / $pcnt;
                $offset = $stepsize;
                $split = array();
                $lend = 0;
                for($i=0;$i<$pcnt;$i++) {
                    if($offset>($pcnt*$stepsize)) {
                        $cend = $pcnt*$stepsize;
                    } else {
                        $cend = stripos($content,'.',$offset)+1;
                    }
                    array_push($split,substr($content,$lend,$cend));
                    $lend = $cend;
                    $offset = $stepsize + $lend;
                }

                /* manipulate splits here ... */


                /* lists */
                if(is_numeric($args['li'])) {
                    /* prob of occurance .. <li> */
                    if(rand(0,100)<$args['li']) {
                        /* we want li! */
                        $n = rand(0,count($split)-1);
                        $split[$n] = sprintf('<ul><li>%s</li></ul>',str_replace('.','</li><li>',$split[$n]));
                    }
                }

                /* join and retrun as paragraphs */
                return sprintf('<p>%s</p>',implode('</p><p>',$split));
            }
        }
}
?>
