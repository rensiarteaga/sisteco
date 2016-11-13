<?php
function crearArchivo_Vista($direccion,$sistema,$table,$prefijo,$codigo,$meta){
	$sistema = "sis_".$sistema;
	$num_campos = sizeof($meta); //cantidad de columnas que tiene la tabla
	$fecha=date("Y-m-d H:i:s");
	$fp_handler=fopen("$direccion/".$table.".php","w+");

	$sql = "<?php
/**
* Nombre de archivo:	    ".$table."
* Propósito:				Contenedor HTML de los objetos de la vista
* Fecha de Creación:		$fecha
* Autor:					Generado Automaticamente
*/
session_start();
?>
<!--<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.01//EN' 'http://www.w3.org/TR/html4/strict.dtd'>-->
<html>
<head>

<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-15'>
<title>$sistema $table</title>
   <script type='text/javascript' src='../../../".$sistema."/vista/".$table."/js/".$table."_combo.js'></script>
   <script type='text/javascript' src='../../../".$sistema."/vista/".$table."/js/".$table.".js'></script>
   <script type='text/javascript' src='../../../".$sistema."/vista/".$table."/js/".$table."_main.php?idContenedor=<?php echo \"\$idContenedor\";?>'></script>
</head>
<body>
</body>
</html>";

	fwrite($fp_handler,$sql);
	fclose($fp_handler);
}
?>