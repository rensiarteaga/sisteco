<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarPartidaModificacion.php
Propósito:				Permite insertar y modificar datos en la tabla tpr_partida_modificacion
Tabla:					tpr_tpr_partida_modificacion
Parámetros:				$id_partida_modificacion
						$id_modificacion
						$id_partida_presupuesto
						$id_usuario_autorizado
						$id_partida_ejecucion
						$tipo_modificacion
						$id_moneda
						$importe
						$estado
						$id_usuario_reg
						$fecha_reg

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2010-05-10 18:19:16
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloPresupuesto.php");

$Custom = new cls_CustomDBPresupuesto();
$nombre_archivo = "ActionGuardarPartidaModificacion.php";

//echo 'recurso:'.$_POST["id_partida_0"].'gasto:'.$_POST["id_partida_gasto_0"]; exit;
//echo 'part pres:'.$_POST["id_partida_presupuesto_0"]; exit;

if (!isset($_SESSION["autentificado"]))
{
	$_SESSION["autentificado"]="NO";
}
if($_SESSION["autentificado"]=="SI")
{
	//Verifica si los datos vienen por POST o GET
	if (sizeof($_GET) > 0)
	{
		$get=true;
		$cont=1;
				
		//Verifica si se hará o no la decodificación(sólo pregunta en caso del GET)
		//valores permitidos de $cod -> "si", "no"
		switch ($cod)
		{
			case "si":
				$decodificar = true;
				break;
			case "no":
				$decodificar = false;
				break;
			default:
				$decodificar = true;
				break;
		}
	}
	elseif(sizeof($_POST) > 0)
	{
		$get = false;
		$cont =  $_POST["cantidad_ids"];
		
		//Por Post siempre se decodifica
		$decodificar = true;
	}
	else
	{
		$resp = new cls_manejo_mensajes(true, "406");
		$resp->mensaje_error = "MENSAJE ERROR = No existen datos para almacenar.";
		$resp->origen = "ORIGEN = ";
		$resp->proc = "PROC = ";
		$resp->nivel = "NIVEL = 4";
		echo $resp->get_mensaje();
		exit;
	}
	
	//Envia al Custom la bandera que indica si se decodificará o no
	$Custom->decodificar = $decodificar;

	//Realiza el bucle por todos los ids mandados
	for($j = 0;$j < $cont; $j++)
	{
		if ($get)
		{
			$id_partida_modificacion= $_GET["id_partida_modificacion_$j"];
			$id_modificacion= $_GET["id_modificacion_$j"];
			$id_partida_presupuesto= $_GET["id_partida_presupuesto_$j"];
			$id_usuario_autorizado= $_GET["id_usuario_autorizado_$j"];
			$id_partida_ejecucion= $_GET["id_partida_ejecucion_$j"];
			$tipo_modificacion= $_GET["tipo_modificacion_$j"];
			$id_moneda= $_GET["id_moneda_$j"];
			$importe= $_GET["importe_$j"];
			$estado= $_GET["estado_$j"];
			$id_usuario_reg= $_GET["id_usuario_reg_$j"];
			$fecha_reg= $_GET["fecha_reg_$j"];
			$id_partida= $_GET["id_partida_$j"];
			$id_partida_gasto= $_GET["id_partida_gasto_$j"];
			$id_presupuesto= $_GET["id_presupuesto_$j"];
			$id_tipo_presupuesto = $_GET["id_tipo_presupuesto"];

		}
		else
		{
			$id_partida_modificacion=$_POST["id_partida_modificacion_$j"];
			$id_modificacion=$_POST["id_modificacion_$j"];
			$id_partida_presupuesto=$_POST["id_partida_presupuesto_$j"];
			$id_usuario_autorizado=$_POST["id_usuario_autorizado_$j"];
			$id_partida_ejecucion=$_POST["id_partida_ejecucion_$j"];
			$tipo_modificacion=$_POST["tipo_modificacion_$j"];
			$id_moneda=$_POST["id_moneda_$j"];
			$importe=$_POST["importe_$j"];
			$estado=$_POST["estado_$j"];
			$id_usuario_reg=$_POST["id_usuario_reg_$j"];
			$fecha_reg=$_POST["fecha_reg_$j"];
			$id_partida=$_POST["id_partida_$j"];
			$id_partida_gasto= $_POST["id_partida_gasto_$j"];
			$id_presupuesto=$_POST["id_presupuesto_$j"];
			$id_tipo_presupuesto=$_POST["id_tipo_presupuesto"];			
		}	

		if ($id_partida_modificacion == "undefined" || $id_partida_modificacion == "")
		{
			////////////////////Inserción/////////////////////
			   
			if($id_partida == "undefined" || $id_partida == "")
			{
				$id_partida = $id_partida_gasto;
			}
			
			
			//echo 'id partida'.$id_partida.' - id pres'.$id_presupuesto; exit;
			
			//Validación de datos (del lado del servidor)
			$res = $Custom->ValidarPartidaModificacion("insert",$id_partida_modificacion,$id_modificacion,$id_partida_presupuesto,$id_usuario_autorizado,$id_partida_ejecucion,$tipo_modificacion,$id_moneda,$importe,$estado,$id_usuario_reg,$fecha_reg);

			if(!$res)
			{
				//Error de validación
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = $Custom->salida[1];
				$resp->origen = $Custom->salida[2];
				$resp->proc = $Custom->salida[3];
				$resp->nivel = $Custom->salida[4];
				echo $resp->get_mensaje();
				exit;
			}						

			//Validación satisfactoria, se ejecuta la inserción en la tabla tpr_partida_modificacion
			$res = $Custom -> InsertarPartidaModificacion($id_partida_modificacion,$id_modificacion,$id_partida_presupuesto,$id_usuario_autorizado,$id_partida_ejecucion,$tipo_modificacion,$id_moneda,$importe,$estado,$id_usuario_reg,$fecha_reg,$id_partida,$id_presupuesto);

			if(!$res)
			{
				//Se produjo un error
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = $Custom->salida[1] . " (iteración $cont)";
				$resp->origen = $Custom->salida[2];
				$resp->proc = $Custom->salida[3];
				$resp->nivel = $Custom->salida[4];
				$resp->query = $Custom->query;
				echo $resp->get_mensaje();
				exit;
			}
		}
		else
		{	///////////////////////Modificación////////////////////
			
			//Validación de datos (del lado del servidor)
			$res = $Custom->ValidarPartidaModificacion("update",$id_partida_modificacion,$id_modificacion,$id_partida_presupuesto,$id_usuario_autorizado,$id_partida_ejecucion,$tipo_modificacion,$id_moneda,$importe,$estado,$id_usuario_reg,$fecha_reg);

			if(!$res)
			{
				//Error de validación
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = $Custom->salida[1];
				$resp->origen = $Custom->salida[2];
				$resp->proc = $Custom->salida[3];
				$resp->nivel = $Custom->salida[4];
				echo $resp->get_mensaje();
				exit;
			}

			$res = $Custom->ModificarPartidaModificacion($id_partida_modificacion,$id_modificacion,$id_partida_presupuesto,$id_usuario_autorizado,$id_partida_ejecucion,$tipo_modificacion,$id_moneda,$importe,$estado,$id_usuario_reg,$fecha_reg,$id_partida,$id_presupuesto);

			if(!$res)
			{
				//Se produjo un error
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = $Custom->salida[1];
				$resp->origen = $Custom->salida[2];
				$resp->proc = $Custom->salida[3];
				$resp->nivel = $Custom->salida[4];
				$resp->query = $Custom->query;
				echo $resp->get_mensaje();
				exit;
			}
		}

	}//END FOR

	//Guarda el mensaje de éxito de la operación realizada
	if($cont > 1) $mensaje_exito = "Se guardaron todos los datos.";
	else $mensaje_exito = $Custom->salida[1];

	//Obtiene el total de los registros. Parámetros del filtro
	if($cant == "") $cant = 100;
	if($puntero == "") $puntero = 0;
	if($sortcol == "") $sortcol = "id_partida_modificacion";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "0=0";

	$res = $Custom->ContarPartidaModificacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	if($res) $total_registros = $Custom->salida;

	//Arma el xml para desplegar el mensaje
	$resp = new cls_manejo_mensajes(false);
	$resp->add_nodo("TotalCount", $total_registros);
	$resp->add_nodo("mensaje", $mensaje_exito);
	$resp->add_nodo("tiempo_resp", "200");
	echo $resp->get_mensaje();
	exit;
}
else
{
	$resp = new cls_manejo_mensajes(true, "401");
	$resp->mensaje_error = "MENSAJE ERROR = Usuario no Autentificado";
	$resp->origen = "ORIGEN = $nombre_archivo";
	$resp->proc = "PROC = $nombre_archivo";
	$resp->nivel = "NIVEL = 1";
	echo $resp->get_mensaje();
	exit;
}
?>