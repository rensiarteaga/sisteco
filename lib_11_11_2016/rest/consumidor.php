<?php 

	$s = curl_init();
	curl_setopt($s, CURLOPT_URL, 'http://localhost/webservice/framework-Slim/index.php');
	curl_setopt($s, CURLOPT_RETURNTRANSFER, true);

	$_out = curl_exec($s);

	$status = curl_getinfo($s, CURLINFO_HTTP_CODE);
	curl_close($s);
	echo $_out;
?>