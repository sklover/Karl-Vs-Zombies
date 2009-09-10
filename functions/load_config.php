<?php
function load_config($config_file_name) {
	$config_file_stream = fopen($config_file_name, "r")
		or die("Couldn't open configuration file -- $config_file_name");
	$config = array();
	while(!feof($config_file_stream)) {
		$buf = trim(fgets($config_file_stream)); 
		if(!(substr($buf,0,1)=='#') && strlen($buf) > 0) {
			$pre = explode("=", $buf, 2);
			$config[trim($pre[0])] = trim($pre[1]);
		}
	}
	fclose($config_file_stream);
	return $config;
}
?>
