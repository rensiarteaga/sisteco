<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarViaticoCalculo.php
Propósito:				Permite insertar y modificar datos en la tabla tts_viatico_calculo
Tabla:					tts_tts_viatico_calculo
Parámetros:				$id_viatico_calculo
						$id_viatico
						$id_origen
						$id_destino
						$id_cobertura
						$id_entidad
						$fecha_inicio
						$fecha_final
						$nro_dias
						$importe_pasaje
						$importe_viatico
						$importe_hotel
						$importe_otros
						$total_pasaje
						$total_viaticos
						$total_hotel
						$total_general
						$tipo_viaje

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2009-04-16 11:37:06
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloTesoreria.php");

$Custom = new cls_CustomDBTesoreria();
$nombre_archivo = "ActionGuardarViaticoCalculo.php";

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
			$id_viatico_calculo= $_GET["id_viatico_calculo_$j"];
			$id_viatico= $_GET["id_viatico_$j"];
			$id_origen= $_GET["id_origen_$j"];
			$id_destino= $_GET["id_destino_$j"];
			$id_cobertura= $_GET["id_cobertura_$j"];
			$id_entidad= $_GET["id_entidad_$j"];
			
			$fecha_inicio2= $_GET["fecha_inicio_$j"];
			$fecha_final2= $_GET["fecha_final_$j"];
			$hora_inicio2= $_GET["hora_inicio_$j"];
			$hora_final2= $_GET["hora_final_$j"];
			
			if($hora_inicio2== "undefined" || $hora_inicio2 == "")
			{
				$fecha_inicio = $fecha_inicio2;
			}
			else 
			{
				$fecha_inicio = $fecha_inicio2." ".$hora_inicio2;
			}
			
			if($fecha_final2== "undefined" || $fecha_final2 == "")
			{
				$fecha_final = '00/00/0000';
			}
			else 
			{
				if($hora_final2== "undefined" || $hora_final2 == "")
				{				
					$fecha_final = $fecha_final2;
				}
				else 
				{
					$fecha_final = $fecha_final2." ".$hora_final2;
				}			
			}
			
			$nro_dias= $_GET["nro_dias_$j"];
			$importe_pasaje= $_GET["importe_pasaje_$j"];
			$importe_viatico= $_GET["importe_viatico_$j"];
			$importe_hotel= $_GET["importe_hotel_$j"];
			$importe_otros= $_GET["importe_otros_$j"];
			$total_pasaje= $_GET["total_pasaje_$j"];
			$total_viaticos= $_GET["total_viaticos_$j"];
			$total_hotel= $_GET["total_hotel_$j"];
			$total_general= $_GET["total_general_$j"];
			$tipo_transporte= $_GET["tipo_transporte_$j"];
			$importe_retencion= $_GET["importe_retencion_$j"];
			$tipo_registro= $_GET["tipo_registro_$j"];
			$detalle_viaticos= $_GET["detalle_viaticos_$j"];
			$detalle_otros= $_GET["detalle_otros_$j"];
			$tipo_viaje= $_GET["tipo_viaje_$j"];
		}
		else
		{
			$id_viatico_calculo=$_POST["id_viatico_calculo_$j"];
			$id_viatico=$_POST["id_viatico_$j"];
			$id_origen=$_POST["id_origen_$j"];
			$id_destino=$_POST["id_destino_$j"];
			$id_cobertura=$_POST["id_cobertura_$j"];
			$id_entidad=$_POST["id_entidad_$j"];
			
			$fecha_inicio2=$_POST["fecha_inicio_$j"];
			$fecha_final2=$_POST["fecha_final_$j"];
			$hora_inicio2= $_POST["hora_inicio_$j"];
			$hora_final2= $_POST["hora_final_$j"];
			
			if($hora_inicio2== "undefined" || $hora_inicio2 == "")
			{
				$fecha_inicio = $fecha_inicio2;
			}
			else 
			{
				$fecha_inicio = $fecha_inicio2." ".$hora_inicio2;
			}
			
			if($hora_final2== "undefined" || $hora_final2 == "")
			{
				$fecha_final = $fecha_final2;
			}
			else 
			{
				$fecha_final = $fecha_final2." ".$hora_final2;
			}	
			
			$nro_dias=$_POST["nro_dias_$j"];
			$importe_pasaje=$_POST["importe_pasaje_$j"];
			$importe_viatico=$_POST["importe_viatico_$j"];
			$importe_hotel=$_POST["importe_hotel_$j"];
			$importe_otros=$_POST["importe_otros_$j"];
			$total_pasaje=$_POST["total_pasaje_$j"];
			$total_viaticos=$_POST["total_viaticos_$j"];
			$total_hotel=$_POST["total_hotel_$j"];
			$total_general=$_POST["total_general_$j"];
			$tipo_transporte=$_POST["tipo_transporte_$j"];
			$importe_retencion= $_POST["importe_retencion_$j"];
			$tipo_registro=$_POST["tipo_registro_$j"];
			$detalle_viaticos=$_POST["detalle_viaticos_$j"];
			$detalle_otros=$_POST["detalle_otros_$j"];
			$tipo_viaje=$_POST["tipo_viaje_$j"];
		}

		if ($id_viatico_calculo == "undefined" || $id_viatico_calculo == "")
		{
			////////////////////Inserción/////////////////////

			//Validación de datos (del lado del servidor)
			$res = $Custom->ValidarViaticoCalculo("insert",$id_viatico_calculo,$id_viatico,$id_origen,$id_destino,$id_cobertura,$id_entidad,$fecha_inicio,$fecha_final,$nro_dias,$importe_pasaje,$importe_viatico,$importe_hotel,$importe_otros,$total_pasaje,$total_viaticos,$total_hotel,$total_general,$tipo_viaje);

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

			//Validación satisfactoria, se ejecuta la inserción en la tabla tts_viatico_calculo
			$res = $Custom -> InsertarViaticoCalculo($id_viatico_calculo,$id_viatico,$id_origen,$id_destino,$id_cobertura,$id_entidad,$fecha_inicio,$fecha_final,$nro_dias,$importe_pasaje,$importe_viatico,$importe_hotel,$importe_otros,$total_pasaje,$total_viaticos,$total_hotel,$total_general,$tipo_transporte,$importe_retencion,$tipo_registro,$detalle_viaticos,$detalle_otros,$tipo_viaje);

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
			$res = $Custom->ValidarViaticoCalculo("update",$id_viatico_calculo,$id_viatico,$id_origen,$id_destino,$id_cobertura,$id_entidad,$fecha_inicio,$fecha_final,$nro_dias,$importe_pasaje,$importe_viatico,$importe_hotel,$importe_otros,$total_pasaje,$total_viaticos,$total_hotel,$total_general,$tipo_viaje);

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

			$res = $Custom->ModificarViaticoCalculo($id_viatico_calculo,$id_viatico,$id_origen,$id_destino,$id_cobertura,$id_entidad,$fecha_inicio,$fecha_final,$nro_dias,$importe_pasaje,$importe_viatico,$importe_hotel,$importe_otros,$total_pasaje,$total_viaticos,$total_hotel,$total_general,$tipo_transporte,$importe_retencion,$tipo_registro,$detalle_viaticos,$detalle_otros,$tipo_viaje);

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
	if($sortcol == "") $sortcol = "id_viatico_calculo";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "0=0";

	$res = $Custom->ContarViaticoCalculo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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