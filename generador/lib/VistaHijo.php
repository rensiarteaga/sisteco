<?php
function crearArchivo_VistaHijo($direccion,$db,$sistema,$table,$prefijo,$codigo,$meta,$datos_generales){
	$sistema = "sis_".$sistema;
	$num_campos = sizeof($meta); //cantidad de columnas que tiene la tabla
	$fecha=date("Y-m-d H:i:s");
	$fp_handler=fopen("$direccion/".$table."_det.php","w+");
	
	//datos del padre
	$padre=$datos_generales["datos_abuelo"];
	

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
   <script type='text/javascript' src='../../../".$sistema."/vista/".$table."/js/".$table."_det.js'></script>\n";
	
  			
		$table_padre=$padre["nombre_tabla"];
		$prefijo_padre=$padre["prefijo"];
		$meta_padre=metadata($db,$prefijo_padre,$table_padre);
		$id_table_padre = $meta_padre[0]["campo"];
		$table_padre=$padre["nombre_tabla"];
		$aux = $meta_padre[0]["descripcion_tabla"];
		$descripcion_tabla_padre= decodificarForamto($aux);
		$sistema_padre=$descripcion_tabla_padre["sistema"];
		
		
		
	     $data="&m_$id_table_padre=<?php echo \$m_$id_table_padre;?>";
			
			//definicion de los datos del padre que seran transmitidos al hijo
			for($j=1;$j<=$descripcion_tabla_padre["num_dt"];$j++){
			
				$data.="&m_".$descripcion_tabla_padre["dt_$j"]."=<?php echo \$m_".$descripcion_tabla_padre["dt_$j"].";?>";
				} 
   //para la captura de variables que vienen del padre
   $sql.=" <script type='text/javascript' src='../../../".$sistema."/vista/".$table."/js/".$table."_det_main.php?idContenedorPadre=<?php echo \"\$idContenedorPadre\";?>&idContenedor=<?php echo \"\$idContenedor\";?>$data'></script>	

   
   </head>
<body>
</body>
</html>";

	fwrite($fp_handler,$sql);
	fclose($fp_handler);
}
?>