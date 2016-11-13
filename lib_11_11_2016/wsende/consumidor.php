<?php
	$s = curl_init();
	curl_setopt($s, CURLOPT_URL, 'http://10.100.105.120/endesis/lib/wsende/listarcorrespondenciaarchivadaende');
	curl_setopt($s, CURLOPT_RETURNTRANSFER, true);
	$_out = curl_exec($s);
	$status = curl_getinfo($s, CURLINFO_HTTP_CODE);
	curl_close($s);
	echo $_out;
?>