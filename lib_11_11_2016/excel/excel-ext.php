<?php
function createExcel($filename) {
	
	$excelfile = "xlsfile://opt/lampp/htdocs/endesis_desarrollo/sis_facturacion/interface/BD07/".$filename;
	$fp = fopen($excelfile, "wb");  

	if (!is_resource($fp)) {  
		die("Error al crear $excelfile");  
	}
	
	return $fp;
	 
}

function escribir($fp,$arraydata){
	fwrite($fp, serialize($arrydata));  
}

function cerrar($fp,$filename){
	$excelfile = "xlsfile://opt/lampp/htdocs/endesis_desarrollo/sis_facturacion/interface/BD07/".$filename;
	fclose($fp);
	header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");  
	header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");  
	header ("Cache-Control: no-cache, must-revalidate");  
	header ("Pragma: no-cache");  
	header ("Content-type: application/x-msexcel");  
	header ("Content-Disposition: attachment; filename=\"" . $filename . "\"" );
	readfile($excelfile); 
	
}
?>