<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarSolicitudCompra.php
Propósito:				Permite insertar y modificar datos en la tabla tad_solicitud_compra
Tabla:					tad_tad_solicitud_compra
Parámetros:				$hidden_id_solicitud_compra
						$txt_precio_total
						$txt_observaciones
						$txt_fecha_venc
						$txt_fecha_reg
						$txt_hora_reg
						$txt_localidad
						$txt_num_solicitud
						$txt_estado_reg
						$txt_estado_vigente_solicitud
						$txt_tipo_adjudicacion
						$txt_modalidad
						$txt_id_solicitud_compra_ant
						$txt_id_tipo_categoria_adq
						$txt_id_empleado_frppa_solicitante
						$txt_id_moneda
						$txt_id_rpa
						$txt_id_empleado_frppa_transcriptor
						
						$txt_id_unidad_organizacional
						$txt_id_empleado_frppa_pre_aprobacion
						$txt_id_empleado_frppa_aprobacion
						$txt_id_empleado_frppa_gfa
						$txt_id_estado_compra_categoria_adq
						$txt_codigo_sicoes
						$txt_siguiente_estado
						$txt_periodo
						$txt_gestion
						$txt_num_solicitud_sis
						$txt_id_fina_regi_prog_proy_acti

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2008-05-12 10:00:30
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloAdquisiciones.php");

$Custom = new cls_CustomDBAdquisiciones();
$nombre_archivo = "ActionGuardarSolicitudCompra.php";

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
			$id_solicitud_compra= $_GET["id_solicitud_compra_$j"];
			$id_tipo_categoria_adq= $_GET["id_tipo_categoria_adq_$j"];
			$permite_agrupar=$_GET["permite_agrupar_$j"];
			
			
		}
		else
		{
			$id_solicitud_compra= $_POST["id_solicitud_compra_$j"];
			$id_tipo_categoria_adq= $_POST["id_tipo_categoria_adq_$j"];
			$permite_agrupar=$_POST["permite_agrupar_$j"];
		}

       
//Validación satisfactoria, se ejecuta la inserción en la tabla tad_solicitud_compra
			//echo $permite_agrupar;
			//exit;

			if($permite_agrupar=='true'){
				$pagrupar=1;
				
			}
			else{
				$pagrupar=0;
			}
			$res = $Custom -> ModificarModalidadCompra($id_solicitud_compra,$id_tipo_categoria_adq,$pagrupar);

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
	
	

	}//END FOR

	//Guarda el mensaje de éxito de la operación realizada
	if($cont > 1) $mensaje_exito = "Se guardaron todos los datos.";
	else $mensaje_exito = $Custom->salida[1];

	//Obtiene el total de los registros. Parámetros del filtro
	if($cant == "") $cant = 100;
	if($puntero == "") $puntero = 0;
	if($sortcol == "") $sortcol = "SEGSOL.id_solicitud_compra";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "SEGSOL.siguiente_estado=''presupuesto_verificado''";

	$id_empresa=$_SESSION["ss_id_empresa"];
	
	
	
	$res = $Custom -> ContarSeguimientoSolicitud($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$vista);


	
	if($res) {
		$total_registros = $Custom->salida;
	}
	else
	{
		//Se produjo un error
		$resp = new cls_manejo_mensajes(true,'406');
		$resp->mensaje_error = $Custom->salida[1];
		$resp->origen = $Custom->salida[2];
		$resp->proc = $Custom->salida[3];
		$resp->nivel = $Custom->salida[4];
		$resp->query = $Custom->query;
		echo $resp->get_mensaje();
		exit;
	}

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