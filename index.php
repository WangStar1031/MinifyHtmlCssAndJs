<?php
set_time_limit(600);
include 'php-minifier.php';
$dir = '.';
$files = scandir($dir);
$arrFils = array();

for( $i = 0; $i < count($files); $i++){
	array_push( $arrFils, $files[$i]);
}
while(count( $arrFils)){
	$curFile = array_shift( $arrFils);
	if( substr($curFile, -1) == '.' || substr($curFile, -2) == '..'){
		continue;
	}
	if( is_dir($curFile)){
		$subFiles = scandir($curFile);
		for( $j = 0; $j < count($subFiles); $j++){
			if( substr($subFiles[$j], -1) == '.' || substr($subFiles[$j], -2) == '..'){
				continue;
			}
			array_push( $arrFils, $curFile . '/' . $subFiles[$j]);
		}
	} else if( substr($curFile, -3) == '.js'){
		$contents = file_get_contents($curFile);
		file_put_contents( $curFile . '.original', $contents);
		$changed = minify_js($contents);
		file_put_contents($curFile, $changed);
	} else if( substr($curFile, -4) == '.css'){
		$contents = file_get_contents($curFile);
		file_put_contents( $curFile . '.original', $contents);
		$changed = minify_js($contents);
		file_put_contents($curFile, $changed);
	}
}
?>