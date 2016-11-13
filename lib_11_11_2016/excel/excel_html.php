<?php

function creaArchivo($direccion){
	$fp=fopen($direccion,"w");
	fwrite($fp,"<table>\r\n");
	return $fp;
	
}

function addCabecera($fp,$arreglo){
	addFila($fp,$arreglo,"<strong>","</strong>");
	
	
	
}
function addFilas($fp,$arreglo){
	foreach ($arreglo as $data){
		addFila($fp,$data);
	}
}
function addFila($fp,$arreglo,$apertura='',$cierre=''){
	fwrite($fp,"<tr>\r\n");
	foreach ($arreglo as $data){
		addColumna($fp,$data,$apertura,$cierre);
	}
	fwrite($fp,"</tr>\r\n");
	
}
function addColumna($fp,$valor,$apertura='',$cierre=''){
	fwrite($fp,"<td>".$apertura.$valor.$cierre."</td>");
	
}
function cerrarArchivo($fp){
	fwrite($fp,"</table>\r\n");
	fclose($fp);
}


?>