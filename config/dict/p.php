<?php 
$file = file("base.csv");
$res = array();
foreach($file as $line) {
	$arr = str_getcsv($line,';;','"','\\');

	if(!is_array($res[$arr[4]])) {
		$res[$arr[4]] = array();
	}
	$line = $arr[2].",".$arr[6].",".$arr[8];
	$line = preg_replace("/\s+/"," ",$line);
	$line = str_replace(", ",",",$line);
	$line = str_replace(" ,",",",$line);
	$line = preg_replace("/\(.+?\)/","",$line);
	$line = str_replace(";",",",$line);
	$line = $line.PHP_EOL;
	$line = str_replace(",".PHP_EOL,PHP_EOL,$line);
	file_put_contents($arr[4]."_en.csv",$line,FILE_APPEND);
}

?>