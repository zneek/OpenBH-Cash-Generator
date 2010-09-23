<?php

foreach(glob("*.csv") as $filename) {
	file_put_contents($filename,gzcompress(file_get_contents($filename)));
}
