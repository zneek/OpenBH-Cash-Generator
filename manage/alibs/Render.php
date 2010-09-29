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
 *   manage/alibs/Render.php
 *   simply rendering tables with headings.. use transform to change format from line to col based
 *   render tables
 *   $arr['key1'] = array(1,2,3,4);
 *   $arr['key2'] = array(1,2,3,4);
 *
 *   @author Neek
 */


function RenderTable($arr,$keys=array()) {
    $width = count($arr);
    $headings = array();
    $data = array();
    foreach(array_keys($arr) as $key=>$val) {
        if(count($keys)>0&&!in_array($val,$keys)) {
            continue;
        }
        array_push($headings,$val);
        for($i=0;$i<count($arr[$val]);$i++) {
            if(!is_array($data[$i])) {
                $data[$i] = array();
            }
            array_push($data[$i],$arr[$val][$i]);
        }
    }
    $head = sprintf('<thead><tr><th>%s</th></tr></thead>',implode('</th><th>',$headings));
    foreach($data as $row) {
        $body .= sprintf('<tr><td>%s</td></tr>',implode('</td><td>',$row));
    }
    return sprintf('<table>%s<tbody>%s</tbody></table>', $head, $body);
}

function TransformArray($arr) {
    $ret = array();
    foreach($arr as $item) {
        foreach(array_keys($item) as $key) {
            if(!is_array($ret[$key])) {
                $ret[$key] = array();
            }
            array_push($ret[$key],$item[$key]);
        }
    }
    return $ret;
}

/*
 * transformarray will help you make it look like this !
 * 
$arr['zipf'] = array(1,2,3);
$arr['winz'] = array(4,5,6);
$arr['hans'] = array(7,8,9);
 */

?>