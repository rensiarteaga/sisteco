<?php
function crearArchivo_VistaCombo($direccion,$sistema,$table,$prefijo,$codigo,$meta){



	$num_campos = sizeof($meta); //cantidad de columnas que tiene la tabla
	$fecha=date("Y-m-d H:i:s");
	$fp_handler=fopen("$direccion/".$table."_combo.js","w+");

	$sql = "/*
 * Ext JS Library 1.0.1
 * Copyright(c) 2006-2007, Ext JS, LLC.
 * licensing@extjs.com
 * 
 * http://www.extjs.com/license
 */
Ext.namespace('Ext.".$table."_combo');\n";


	for ($i=0;$i<$num_campos;$i++){
		$check = array();
		$check = $meta[$i]["check"];
		if($check != null){
			$tam = sizeof($check);
			$sql.= "Ext.".$table."_combo.".$meta[$i]["campo"]." = [";
			for($j=0;$j<$tam-1;$j++){
				$sql.="['".$check[$j]."','".$check[$j]."'],";
			}
			$sql.="['".$check[$j]."','".$check[$j]."']];";
		}
	}

	fwrite($fp_handler,$sql);
	fclose($fp_handler);
}
?>