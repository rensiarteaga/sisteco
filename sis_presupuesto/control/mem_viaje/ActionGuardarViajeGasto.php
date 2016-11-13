<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarViajeGasto.php
Propósito:				Permite insertar y modificar datos en la tabla tpr_mem_viaje
Tabla:					tpr_tpr_mem_viaje
Parámetros:				$id_mem_viaje
						$id_destino
						$id_cobertura
						$nro_dias
						$importe_viaticos
						$total_viaticos
						$importe_hotel
						$total_hotel
						$importe_pasajes
						$importe_otros
						$total_general
						$id_moneda
						$periodo_pres
						$id_memoria_calculo

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2008-07-07 17:57:09
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloPresupuesto.php");

$Custom = new cls_CustomDBPresupuesto();
$nombre_archivo = "ActionGuardarViajeGasto.php";

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
			$id_mem_viaje= $_GET["id_mem_viaje_$j"];
			$nro_dias= $_GET["nro_dias_$j"];
			$importe_viaticos= $_GET["importe_viaticos_$j"];
			$importe_hotel= $_GET["importe_hotel_$j"];
			$importe_otros= $_GET["importe_otros_$j"];
			$periodo_pres= $_GET["periodo_pres_$j"]; 
			$id_moneda= $_GET["id_moneda_$j"];
			$id_cobertura= $_GET["id_cobertura_$j"];
			$id_memoria_calculo= $_GET["id_memoria_calculo_$j"];
			$total_viaticos= $_GET["total_viaticos_$j"];
			$total_hotel= $_GET["total_hotel_$j"];
			$total_general= $_GET["total_general_$j"];
			$id_mem_pasaje= $_GET["id_mem_pasaje_$j"];
			$sw_hotel= $_GET["sw_hotel_$j"];
		}
		else
		{
			$id_mem_viaje= $_POST["id_mem_viaje_$j"];
			$nro_dias= $_POST["nro_dias_$j"];
			$importe_viaticos= $_POST["importe_viaticos_$j"];
			$importe_hotel= $_POST["importe_hotel_$j"];
			$importe_otros= $_POST["importe_otros_$j"];
			$periodo_pres= $_POST["periodo_pres_$j"]; 
			$id_moneda= $_POST["id_moneda_$j"];
			$id_cobertura= $_POST["id_cobertura_$j"];
			$id_memoria_calculo= $_POST["id_memoria_calculo_$j"];
			$total_viaticos= $_POST["total_viaticos_$j"];
			$total_hotel= $_POST["total_hotel_$j"];
			$total_general= $_POST["total_general_$j"];
			$id_mem_pasaje= $_POST["id_mem_pasaje_$j"];
			$sw_hotel= $_POST["sw_hotel_$j"];
		}
		
			

		if ($id_mem_viaje == "undefined" || $id_mem_viaje == "")
		{
			////////////////////Inserción/////////////////////

			//Validación de datos (del lado del servidor)
			$res = $Custom->ValidarViajeGasto("insert",$id_mem_viaje,$nro_dias,$importe_viaticos,$importe_hotel,$importe_otros,$periodo_pres,$id_moneda,$id_cobertura,$id_memoria_calculo,$total_viaticos,$total_hotel,$total_general,$id_mem_pasaje,$sw_hotel);

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

			//Validación satisfactoria, se ejecuta la inserción en la tabla tpr_mem_viaje
			$res = $Custom -> InsertarViajeGasto($id_mem_viaje,$nro_dias,$importe_viaticos,$importe_hotel,$importe_otros,$periodo_pres,$id_moneda,$id_cobertura,$id_memoria_calculo,$total_viaticos,$total_hotel,$total_general,$id_mem_pasaje,$sw_hotel);

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
			$res = $Custom->ValidarViajeGasto("update",$id_mem_viaje,$nro_dias,$importe_viaticos,$importe_hotel,$importe_otros,$periodo_pres,$id_moneda,$id_cobertura,$id_memoria_calculo,$total_viaticos,$total_hotel,$total_general,$id_mem_pasaje,$sw_hotel);

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

			$res = $Custom->ModificarViajeGasto($id_mem_viaje,$nro_dias,$importe_viaticos,$importe_hotel,$importe_otros,$periodo_pres,$id_moneda,$id_cobertura,$id_memoria_calculo,$total_viaticos,$total_hotel,$total_general,$id_mem_pasaje,$sw_hotel);

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
	if($sortcol == "") $sortcol = "id_mem_viaje";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "MEMCAL.id_memoria_calculo=''$m_id_memoria_calculo''";

	$res = $Custom->ContarViajeGasto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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