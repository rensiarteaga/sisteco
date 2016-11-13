<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarAvanceDetalle.php
Propósito:				Permite insertar y modificar datos en la tabla tts_avance_detalle
Tabla:					tts_avance_detalle
Parámetros:				$id_avance_detalle
						$id_avance
						$id_concepto_ingas
						$importe_detalle
						$observa_detalle
Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2008-07-02 21:46:09
Versión:				1.0.0
Autor:					Fernando Prudencio
**********************************************************
*/
session_start();
include_once("../LibModeloTesoreria.php");

$Custom = new cls_CustomDBTesoreria();
$nombre_archivo = "ActionGuardarAvanceDetalle.php";

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
			$id_avance_detalle= $_GET["id_avance_detalle_$j"];
			$id_avance= $_GET["id_avance_$j"];
			$id_concepto_ingas= $_GET["id_concepto_ingas_$j"];
			$importe_detalle= $_GET["importe_detalle_$j"];
			$observa_detalle= $_GET["observa_detalle_$j"];
			$sw_valida= $_GET["sw_valida_$j"];
			$id_presupuesto= $_GET["id_presupuesto_$j"];
			}
		else
		{
			$id_avance_detalle= $_POST["id_avance_detalle_$j"];
			$id_avance= $_POST["id_avance_$j"];
			$id_concepto_ingas= $_POST["id_concepto_ingas_$j"];
			$importe_detalle= $_POST["importe_detalle_$j"];
			$observa_detalle= $_POST["observa_detalle_$j"];
			$sw_valida= $_POST["sw_valida_$j"];
			$id_presupuesto= $_POST["id_presupuesto_$j"];
		}
         if ($sw_valida=="true" || $sw_valida==1){
        	$sw_valida_apro=1;
    
        }
        else{
        	$sw_valida_apro=2;
            }
		if ($id_avance_detalle == "undefined" || $id_avance_detalle == "")
		{
			////////////////////Inserción/////////////////////

			//Validación de datos (del lado del servidor)
			$res = $Custom->ValidarAvanceDetalle("insert",$id_avance_detalle,$id_avance,$id_concepto_ingas,$importe_detalle,$observa_detalle);

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

			//Validación satisfactoria, se ejecuta la inserción en la tabla tpr_nivel_partida
			$res = $Custom -> InsertarAvanceDetalle($id_avance_detalle,$id_avance,$id_concepto_ingas,$importe_detalle,$observa_detalle,$sw_valida_apro,$id_presupuesto);

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
			$res = $Custom->ValidarAvanceDetalle("update",$id_avance_detalle,$id_avance,$id_concepto_ingas,$importe_detalle,$observa_detalle);

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

			$res = $Custom->ModificarAvanceDetalle($id_avance_detalle,$id_avance,$id_concepto_ingas,$importe_detalle,$observa_detalle,$sw_valida_apro,$id_presupuesto);

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
	if($sortcol == "") $sortcol = "AVADET.id_avance_detalle";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "AVADET.id_avance=''$m_id_avance''";

	$res = $Custom->ContarAvanceDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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