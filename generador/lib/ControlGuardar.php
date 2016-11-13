<?php
function crearArchivo_ControlGuardar($direccion,$sistema,$table,$prefijo,$codigo,$meta){


	$codigo = $prefijo."_"."$codigo";
	$table_fjava = FormatPhpToJava($table);
	$num_campos = sizeof($meta); //cantidad de columnas que tiene la tabla
	$table = "t".strtolower($prefijo)."_".$table;


	$fp_handler=fopen("$direccion/ActionGuardar".$table_fjava.".php","w+");
	$fecha=date("Y-m-d H:i:s");

	$sql = "<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardar".$table_fjava.".php
Propósito:				Permite insertar y modificar datos en la tabla ".$table."
Tabla:					t".strtolower($prefijo)."_".$table."
Parámetros:";
for($i=0;$i <= $num_campos -1; $i ++){
	if($i == 0){//stripos($meta[$i]["campo"],"id") !== false){	
		if($i == 0){
			$sql.= "\t\t\t\t\$hidden_".$meta[$i]["campo"]."\n";
		}else{		
			$sql.= "\t\t\t\t\t\t\$hidden_".$meta[$i]["campo"]."\n";
		}
	}else{
		$sql.= "\t\t\t\t\t\t\$txt_".$meta[$i]["campo"]."\n";
	}
}
$sql.= "	
Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		$fecha
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once(\"../LibModelo".ucwords($sistema).".php\");

\$Custom = new cls_CustomDB".ucwords($sistema)."();
\$nombre_archivo = \"ActionGuardar$table_fjava.php\";

if (!isset(\$_SESSION[\"autentificado\"]))
{
	\$_SESSION[\"autentificado\"]=\"NO\";
}
if(\$_SESSION[\"autentificado\"]==\"SI\")
{
	//Verifica si los datos vienen por POST o GET
	if (sizeof(\$_GET) > 0)
	{
		\$get=true;
		\$cont=1;
		
		//Verifica si se hará o no la decodificación(sólo pregunta en caso del GET)
		//valores permitidos de \$cod -> \"si\", \"no\"
		switch (\$cod)
		{
			case \"si\":
				\$decodificar = true;
				break;
			case \"no\":
				\$decodificar = false;
				break;
			default:
				\$decodificar = true;
				break;
		}
	}
	elseif(sizeof(\$_POST) > 0)
	{
		\$get = false;
		\$cont =  \$_POST[\"cantidad_ids\"];
		
		//Por Post siempre se decodifica
		\$decodificar = true;
	}
	else
	{
		\$resp = new cls_manejo_mensajes(true, \"406\");
		\$resp->mensaje_error = \"MENSAJE ERROR = No existen datos para almacenar.\";
		\$resp->origen = \"ORIGEN = $nombre_archivo\";
		\$resp->proc = \"PROC = $nombre_archivo\";
		\$resp->nivel = \"NIVEL = 4\";
		echo \$resp->get_mensaje();
		exit;
	}
	
	//Envia al Custom la bandera que indica si se decodificará o no
	\$Custom->decodificar = \$decodificar;

	//Realiza el bucle por todos los ids mandados
	for(\$j = 0;\$j < \$cont; \$j++)
	{
		if (\$get)
		{
";
			for($i=0;$i<=$num_campos -1; $i ++){
				if($i == 0){//stripos($meta[$i]["campo"],"id") !== false){	
					$sql.= "\t\t\t\$hidden_".$meta[$i]["campo"]."\t\t\t\t\t\t= \$_GET[\"hidden_".$meta[$i]["campo"]."_\$j\"];\n";
				}else{
					$sql.= "\t\t\t\$txt_".$meta[$i]["campo"]."\t\t\t\t\t\t= \$_GET[\"txt_".$meta[$i]["campo"]."_\$j\"];\n";
				}
			};
$sql.= "							
		}
		else
		{
";
			for($i=0;$i<=$num_campos -1; $i ++){
				if($i == 0){//stripos($meta[$i]["campo"],"id") !== false){	
					$sql.= "\t\t\t\$hidden_".$meta[$i]["campo"]."\t\t\t\t\t\t= \$_POST[\"hidden_".$meta[$i]["campo"]."_\$j\"];\n";
				}else{
					$sql.= "\t\t\t\$txt_".$meta[$i]["campo"]."\t\t\t\t\t\t= \$_POST[\"txt_".$meta[$i]["campo"]."_\$j\"];\n";
				}
			};
$sql.= "			
		}

		if (\$hidden_".$meta[0]["campo"]." == \"undefined\" || \$hidden_".$meta[0]["campo"]." == \"\")
		{
			////////////////////Inserción/////////////////////

			//Validación de datos (del lado del servidor)
			\$res = \$Custom->Validar".$table_fjava."(\"insert\",";
			for($i=0;$i<=$num_campos -1; $i ++){
				if($i < $num_campos -1 ){
					if($i == 0){//stripos($meta[$i]["campo"],"id") !== false){	
						$sql.= "\$hidden_".$meta[$i]["campo"].", ";
					}else{
						$sql.= "\$txt_".$meta[$i]["campo"].", ";
					}
				}else{
					if($i == 0){//stripos($meta[$i]["campo"],"id") !== false){	
						$sql.= "\$hidden_".$meta[$i]["campo"].");\n";
					}else{
						$sql.= "\$txt_".$meta[$i]["campo"].");\n";
					}
				}
			};
$sql.= "			
			if(!\$res)
			{
				//Error de validación
				\$resp = new cls_manejo_mensajes(true, \"406\");
				\$resp->mensaje_error = \$Custom->salida[1];
				\$resp->origen = \$Custom->salida[2];
				\$resp->proc = \$Custom->salida[3];
				\$resp->nivel = \$Custom->salida[4];
				echo \$resp->get_mensaje();
				exit;
			}

			//Validación satisfactoria, se ejecuta la inserción en la tabla $table
			\$res = \$Custom -> Insertar".$table_fjava."(";
			for($i=0;$i<=$num_campos -1; $i ++){
				if($i < $num_campos -1 ){
					if($i == 0){//stripos($meta[$i]["campo"],"id") !== false){	
						$sql.= "\$hidden_".$meta[$i]["campo"].", ";
					}else{
						$sql.= "\$txt_".$meta[$i]["campo"].", ";
					}
				}else{
					if($i == 0){//stripos($meta[$i]["campo"],"id") !== false){	
						$sql.= "\$hidden_".$meta[$i]["campo"].");\n";
					}else{
						$sql.= "\$txt_".$meta[$i]["campo"].");\n";
					}
				}
			};
$sql.= "
			if(!\$res)
			{
				//Se produjo un error
				\$resp = new cls_manejo_mensajes(true, \"406\");
				\$resp->mensaje_error = \$Custom->salida[1] . \" (iteración \$cont)\";
				\$resp->origen = \$Custom->salida[2];
				\$resp->proc = \$Custom->salida[3];
				\$resp->nivel = \$Custom->salida[4];
				\$resp->query = \$Custom->query;
				echo \$resp->get_mensaje();
				exit;
			}
		}
		else
		{	///////////////////////Modificación////////////////////
			
			//Validación de datos (del lado del servidor)
			\$res = \$Custom->Validar".$table_fjava."(\"update\",";
			for($i=0;$i<=$num_campos -1; $i ++){
				if($i < $num_campos -1 ){
					if($i == 0){//stripos($meta[$i]["campo"],"id") !== false){	
						$sql.= "\$hidden_".$meta[$i]["campo"].", ";
					}else{
						$sql.= "\$txt_".$meta[$i]["campo"].", ";
					}
				}else{
					if($i == 0){//stripos($meta[$i]["campo"],"id") !== false){	
						$sql.= "\$hidden_".$meta[$i]["campo"].");\n";
					}else{
						$sql.= "\$txt_".$meta[$i]["campo"].");\n";
					}
				}
			};
$sql.= "
			if(!\$res)
			{
				//Error de validación
				\$resp = new cls_manejo_mensajes(true, \"406\");
				\$resp->mensaje_error = \$Custom->salida[1];
				\$resp->origen = \$Custom->salida[2];
				\$resp->proc = \$Custom->salida[3];
				\$resp->nivel = \$Custom->salida[4];
				echo \$resp->get_mensaje();
				exit;
			}

			\$res = \$Custom->Modificar".$table_fjava."(";
			for($i=0;$i<=$num_campos -1; $i ++){
				if($i < $num_campos -1 ){
					if($i == 0){//stripos($meta[$i]["campo"],"id") !== false){	
						$sql.= "\$hidden_".$meta[$i]["campo"].", ";
					}else{
						$sql.= "\$txt_".$meta[$i]["campo"].", ";
					}
				}else{
					if($i == 0){//stripos($meta[$i]["campo"],"id") !== false){	
						$sql.= "\$hidden_".$meta[$i]["campo"].");\n";
					}else{
						$sql.= "\$txt_".$meta[$i]["campo"].");\n";
					}
				}
			};
$sql.= "
			if(!\$res)
			{
				//Se produjo un error
				\$resp = new cls_manejo_mensajes(true, \"406\");
				\$resp->mensaje_error = \$Custom->salida[1];
				\$resp->origen = \$Custom->salida[2];
				\$resp->proc = \$Custom->salida[3];
				\$resp->nivel = \$Custom->salida[4];
				\$resp->query = \$Custom->query;
				echo \$resp->get_mensaje();
				exit;
			}
		}

	}//END FOR

	//Guarda el mensaje de éxito de la operación realizada
	if(\$cont > 1) \$mensaje_exito = \"Se guardaron todos los datos.\";
	else \$mensaje_exito = \$Custom->salida[1];

	//Obtiene el total de los registros. Parámetros del filtro
	if(\$cant == \"\") \$cant = 100;
	if(\$puntero == \"\") \$puntero = 0;
	if(\$sortcol == \"\") \$sortcol = \"".$meta[0]["campo"]."\";
	if(\$sortdir == \"\") \$sortdir = \"asc\";
	if(\$criterio_filtro == \"\") \$criterio_filtro = \"0=0\";

	\$res = \$Custom->Contar".$table_fjava."(\$cant,\$puntero,\$sortcol,\$sortdir,\$criterio_filtro,\$id_financiador,\$id_regional,\$id_programa,\$id_proyecto,\$id_actividad);
	if(\$res) \$total_registros = \$Custom->salida;

	//Arma el xml para desplegar el mensaje
	\$resp = new cls_manejo_mensajes(false);
	\$resp->add_nodo(\"TotalCount\", \$total_registros);
	\$resp->add_nodo(\"mensaje\", \$mensaje_exito);
	\$resp->add_nodo(\"tiempo_resp\", \"200\");
	echo \$resp->get_mensaje();
	exit;
}
else
{
	\$resp = new cls_manejo_mensajes(true, \"401\");
	\$resp->mensaje_error = \"MENSAJE ERROR = Usuario no Autentificado\";
	\$resp->origen = \"ORIGEN = \$nombre_archivo\";
	\$resp->proc = \"PROC = \$nombre_archivo\";
	\$resp->nivel = \"NIVEL = 1\";
	echo \$resp->get_mensaje();
	exit;
}
?>";

	fwrite($fp_handler,$sql);
	fclose($fp_handler);
}
?>

