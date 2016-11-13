<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarDetallePartidaFormulacion.php
Propósito:				Permite insertar y modificar datos en la tabla tpr_partida_presupuesto
Tabla:					tpr_tpr_partida_presupuesto
Parámetros:				$id_partida_presupuesto
						$codigo_formulario
						$fecha_elaboracion
						$id_partida
						$id_presupuesto
						
Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2008-07-10 09:08:17
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloPresupuesto.php");

$Custom = new cls_CustomDBPresupuesto();
$nombre_archivo = "ActionGuardarDetallePartidaPresupuestoAsignacion.php";

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
		//valores permitidos de $cod -> "si". "no"
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
		$resp = new cls_manejo_mensajes(true. "406");
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
			$id_partida_presupuesto= $_GET["id_partida_presupuesto_$j"];
			$codigo_formulario= $_GET["codigo_formulario_$j"];
			$fecha_elaboracion= $_GET["fecha_elaboracion_$j"];
			$id_partida= $_GET["id_partida_$j"];
			$id_presupuesto= $_GET["id_presupuesto_$j"];
			
		}
		else
		{
			$id_partida_presupuesto=$_POST["id_partida_presupuesto_$j"];
			$codigo_formulario=$_POST["codigo_formulario_$j"];
			$fecha_elaboracion=$_POST["fecha_elaboracion_$j"];
			$id_partida=$_POST["id_partida_$j"];
			$id_presupuesto=$_POST["id_presupuesto_$j"];
			

		}

		if ($id_partida_presupuesto == "undefined" || $id_partida_presupuesto == "")
		{
			
			
			////////////////////Inserción/////////////////////

			//Validación de datos (del lado del servidor)
			
			$res = $Custom->ValidarDetallePartidaAsignacion("insert",$id_partida_presupuesto, $codigo_formulario,$fecha_elaboracion,$id_partida,$id_presupuesto);
			if(!$res)
			{
				//Error de validación
				$resp = new cls_manejo_mensajes(true. "406");
				$resp->mensaje_error = $Custom->salida[1];
				$resp->origen = $Custom->salida[2];
				$resp->proc = $Custom->salida[3];
				$resp->nivel = $Custom->salida[4];
				echo $resp->get_mensaje();
				exit;
			}

					
			//Validación satisfactoria. se ejecuta la inserción en la tabla tpr_partida_presupuesto
																	
			$res = $Custom->InsertarPartidaPresupuestoAsignacion($id_partida_presupuesto,$codigo_formulario,$fecha_elaboracion,$id_partida,$id_presupuesto);

			if(!$res)
			{ //. " (iteración $cont)"
				//Se produjo un error
				$resp = new cls_manejo_mensajes(true. "406");
				$resp->mensaje_error = $Custom->salida[1];
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
			$res = $Custom->ValidarDetallePartidaFormulacion("update".$id_partida_presupuesto. $codigo_formulario.$fecha_elaboracion.$id_partida.$id_presupuesto.$id_partida_detalle.$mes_01.$mes_02.$mes_03.$mes_04.$mes_05.$mes_06.$mes_07.$mes_08.$mes_09.$mes_10.$mes_11.$mes_12.$total.$id_partida_presupuesto.$id_moneda);

			if(!$res)
			{
				//Error de validación
				$resp = new cls_manejo_mensajes(true. "406");
				$resp->mensaje_error = $Custom->salida[1];
				$resp->origen = $Custom->salida[2];
				$resp->proc = $Custom->salida[3];
				$resp->nivel = $Custom->salida[4];
				echo $resp->get_mensaje();
				exit;
			}

			$res = $Custom->ModificarDetallePartidaFormulacion($id_partida_presupuesto. $codigo_formulario.$fecha_elaboracion.$id_partida.$id_presupuesto.$id_partida_detalle.$mes_01.$mes_02.$mes_03.$mes_04.$mes_05.$mes_06.$mes_07.$mes_08.$mes_09.$mes_10.$mes_11.$mes_12.$total.$id_partida_presupuesto.$id_moneda);

			if(!$res)
			{
				//Se produjo un error
				$resp = new cls_manejo_mensajes(true. "406");
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
	if($sortcol == "") $sortcol = "id_partida_presupuesto";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "PRESUP.id_presupuesto=''$id_presupuesto''";

	$res = $Custom->ContarDetallePartidaFormulacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);

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
	$resp = new cls_manejo_mensajes(true. "401");
	$resp->mensaje_error = "MENSAJE ERROR = Usuario no Autentificado";
	$resp->origen = "ORIGEN = $nombre_archivo";
	$resp->proc = "PROC = $nombre_archivo";
	$resp->nivel = "NIVEL = 1";
	echo $resp->get_mensaje();
	exit;
}
?>