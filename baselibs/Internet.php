<?php
/**
 * Description of Internet
 *
 * @author neek
 */
class Internet {

    public static function Grab($url) {
        $data = '';
        $url = str_replace(" ","+",$url);
        $data = Internet::GrabSimple($url);
        if(!empty($data)) {
            return $data;
        }
        $data = Internet::GrabCurl($url);
        if(!empty($data)) {
            return $data;
        }
        $data = Internet::GrabSockets($url);
        return $data;
    }

    private static function GrabCurl($url) {
        if(!function_exists('curl_init')) {
            return;
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        $cdata = curl_exec($ch);
        curl_close($ch);
        return $cdata;
    }

    private static function GrabSockets($url) {
        /* ;) */
        return '';
    }

    private static function GrabSimple($url) {
        return file_get_contents($url);
    }
}
?>