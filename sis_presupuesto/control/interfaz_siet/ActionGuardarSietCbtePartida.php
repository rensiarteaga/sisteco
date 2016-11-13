<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarSietCbtePartida.php
Propósito:				Permite insertar y modificar datos en la tabla tsi_siet_cbte_partida
Tabla:					tsi_siet_cbte_partida
Parámetros:				$id_siet_cbte
						

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		01/11/2015
Versión:				1.0.0
Autor:					avq
**********************************************************
*/
session_start();
include_once("../LibModeloPresupuesto.php");

$Custom = new cls_CustomDBPresupuesto();
$nombre_archivo = "ActionGuardarSietCbtePartida.php";

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
		{   $id_siet_cbte_partida= $_GET["id_siet_cbte_partida_".$j];
			$id_siet_cbte= $_GET["id_siet_cbte_".$j];
			$id_partida= $_GET["id_partida_".$j];
			$id_oec= $_GET["id_oec_".$j];
			$importe= $_GET["importe_".$j];
			$id_siet_ent_ua_transf=$_GET["id_siet_ent_ua_transf_".$j];
			
		}
		else 
		{    $id_siet_cbte_partida= $_POST["id_siet_cbte_partida_".$j];
	        $id_siet_cbte= $_POST["id_siet_cbte_".$j];
	        $id_partida= $_POST["id_partida_".$j];
	        $id_oec= $_POST["id_oec_".$j];
	        $importe= $_POST["importe_".$j];
	        $id_siet_ent_ua_transf=$_POST["id_siet_ent_ua_transf_".$j];
			
		}

			////////////////////Inserción/////////////////////

		if ($id_siet_cbte_partida == "undefined" || $id_siet_cbte_partida == "")
		{
		
           
			//Validación satisfactoria, se ejecuta la inserción en la tabla tpr_categoria
			$res = $Custom -> InsertarSietCbtePartida($id_siet_cbte_partida,$id_siet_cbte,$id_partida,$importe,$id_oec,$id_siet_ent_ua_transf);
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
				
			
			
			$res = $Custom->ModificarSietCbtePartida($id_siet_cbte_partida,$id_siet_cbte,$id_partida,$importe,$id_oec,$id_siet_ent_ua_transf);
			
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
	if($sortcol == "") $sortcol = "id_siet_cbte";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "0=0";

	$res = $Custom->ContarSietCbtePartida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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