<?php 
/*
 * Generators for filenames etc
 * ...
 */

function num($digits) {
	if(!is_numeric($digits)) {
		return 0;
	}
	return rand(0,10000);
}

function countfiles() {
	return count(glob('data/content/*'));
}
?>