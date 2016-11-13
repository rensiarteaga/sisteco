<?php
function crearArchivo_ControlEliminar($direccion,$sistema,$table,$prefijo,$codigo,$meta){
	
	
	$codigo = $prefijo."_"."$codigo";
	$table_fjava = FormatPhpToJava($table);
	$num_campos = sizeof($meta); //cantidad de columnas que tiene la tabla
	$table = "t".strtolower($prefijo)."_".$table;
	
	
	$fp_handler=fopen("$direccion/ActionEliminar".$table_fjava.".php","w+");
	$fecha=date("Y-m-d H:i:s");
	
	$sql = "<?php
/**
**********************************************************
Nombre de archivo:	    ActionEliminar".$table_fjava.".php
Propósito:				Permite eliminar registros de la tabla $table
Tabla:					t".strtolower($prefijo)."_".$table."
Parámetros:";
$sql.= "\t\t\t\t\$hidden_".$meta[0]["campo"]."\n";	
$sql.= "

Valores de Retorno:    	Número de registros
Fecha de Creación:		$fecha
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();

include_once(\"../LibModelo".ucwords($sistema).".php\");

\$Custom = new cls_CustomDB".ucwords($sistema)."();
\$nombre_archivo = \"ActionEliminar$table_fjava.php\";

if (!isset(\$_SESSION[\"autentificado\"]))
{
	\$_SESSION[\"autentificado\"]=\"NO\";
}

if(\$_SESSION[\"autentificado\"]==\"SI\")
{
	if (sizeof(\$_GET) >0)
	{
		\$get=true;
		\$cont=1;
	}
	elseif(sizeof(\$_POST) >0)
	{
		\$get=false;
		\$cont =  \$_POST[\"cantidad_ids\"];
	}
	else
	{
		\$resp = new cls_manejo_mensajes(true, \"406\");
		\$resp->mensaje_error = \"MENSAJE ERROR = No existen datos para Eliminar.\";
		\$resp->origen = \"ORIGEN = \$nombre_archivo\";
		\$resp->proc = \"PROC = \$nombre_archivo\";
		\$resp->nivel = \"NIVEL = 4\";
		echo \$resp->get_mensaje();
		exit;
	}

	for(\$j = 0;\$j < \$cont; \$j++)
	{
		if (\$get)
		{
			\$hidden_".$meta[0]["campo"]." = \$_GET[\"hidden_".$meta[0]["campo"]."_\$j\"];
		}
		else
		{
			\$hidden_".$meta[0]["campo"]." = \$_POST[\"hidden_".$meta[0]["campo"]."_\$j\"];				
		}

		if (\$hidden_".$meta[0]["campo"]." == \"undefined\" || \$hidden_".$meta[0]["campo"]." == \"\")
		{
			\$resp = new cls_manejo_mensajes(true, \"406\");
			\$resp->mensaje_error = \"MENSAJE ERROR = No existe el registro especificado para eliminar.\";
			\$resp->origen = \"ORIGEN = \$nombre_archivo\";
			\$resp->proc = \"PROC = \$nombre_archivo\";
			\$resp->nivel = \"NIVEL = 4\";
			echo \$resp->get_mensaje();
			exit;
		}
		else
		{	//Eliminación
			\$res = \$Custom-> Eliminar".$table_fjava."(\$hidden_".$meta[0]["campo"].");
			if(!\$res)
			{
				\$resp = new cls_manejo_mensajes(true, \"406\");
				\$resp->mensaje_error = \$Custom->salida[1] ;
				\$resp->origen = \$Custom->salida[2];
				\$resp->proc = \$Custom->salida[3];
				\$resp->nivel = \$Custom->salida[4];
				\$resp->query = \$Custom->query;
				echo \$resp->get_mensaje();
				exit;
			}
		}
	}//end for

	//Guarda el mensaje de éxito de la operación realizada
	if(\$cont>1) \$mensaje_exito = \"Se eliminaron los registros especificados.\";
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
	\$resp->add_nodo(\"mensaje\",\$mensaje_exito);
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