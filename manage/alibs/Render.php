<?php

/* 
 * render tables
 * $arr['key1'] = array(1,2,3,4);
 * $arr['key2'] = array(1,2,3,4);
 */

function RenderTable($arr) {
    $width = count($arr);
    $headings = array();
    $data = array();
    foreach(array_keys($arr) as $key=>$val) {
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