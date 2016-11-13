<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarDestino.php
Propósito:				Permite insertar y modificar datos en la tabla tpr_destino
Tabla:					tpr_tpr_destino
Parámetros:				$id_destino
						$importe_pasaje
						$importe_hotel
						$importe_viaticos
						$id_categoria
						$id_lugar
						$id_moneda

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2008-07-04 08:54:28
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloPresupuesto.php");

$Custom = new cls_CustomDBPresupuesto();
$nombre_archivo = "ActionGuardarDestino.php";

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
			$id_destino= $_GET["id_destino_$j"];
			$importe_pasaje= $_GET["importe_pasaje_$j"];
			$importe_hotel= $_GET["importe_hotel_$j"];
			$importe_viaticos= $_GET["importe_viaticos_$j"];
			$id_categoria= $_GET["id_categoria_$j"];
			$id_lugar= $_GET["id_lugar_$j"];
			$id_moneda= $_GET["id_moneda_$j"];
			$tipo_destino= $_GET["tipo_destino_$j"];
		}
		else
		{
			$id_destino=$_POST["id_destino_$j"];
			$importe_pasaje=$_POST["importe_pasaje_$j"];
			$importe_hotel=$_POST["importe_hotel_$j"];
			$importe_viaticos=$_POST["importe_viaticos_$j"];
			$id_categoria=$_POST["id_categoria_$j"];
			$id_lugar=$_POST["id_lugar_$j"];
			$id_moneda= $_POST["id_moneda_$j"];
			$tipo_destino=$_POST["tipo_destino_$j"];
		}

		if ($id_destino == "undefined" || $id_destino == "")
		{
			////////////////////Inserción/////////////////////

			//Validación de datos (del lado del servidor)
			$res = $Custom->ValidarDestino("insert",$id_destino, $importe_pasaje,$importe_hotel,$importe_viaticos,$id_categoria,$id_lugar,$id_moneda);

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

			//Validación satisfactoria, se ejecuta la inserción en la tabla tpr_destino
			$res = $Custom -> InsertarDestino($id_destino, $importe_pasaje,$importe_hotel,$importe_viaticos,$id_categoria,$id_lugar,$id_moneda,$tipo_destino);

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
			$res = $Custom->ValidarDestino("update",$id_destino, $importe_pasaje,$importe_hotel,$importe_viaticos,$id_categoria,$id_lugar,$id_moneda);

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

			$res = $Custom->ModificarDestino($id_destino, $importe_pasaje,$importe_hotel,$importe_viaticos,$id_categoria,$id_lugar,$id_moneda,$tipo_destino);

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
	if($sortcol == "") $sortcol = "id_destino";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "CATEGO.id_categoria=''$m_id_categoria''";

	$res = $Custom->ContarDestino($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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