<?php
/*
**********************************************************
Nombre de archivo:	    ActionGuardarGrupoProceso.php
Propósito:				Permite sertar y modificar procesos
Tabla:					taf_proceso
Parámetros:				$hidden_id_procesoa	--> id del proceso
$txt_descripcion
$txt_flag_comprobante
$txt_tipo_comprobante

Valores de Retorno:    	Número de registros
Fecha de Creación:		08-07-10
Versión:				1.0.0
Autor:					Mercedes Zambrana Meneses
**********************************************************
*/
session_start();
include_once("../LibModeloActivoFijo.php");

$Custom = new cls_CustomDBActivoFijo();
$nombre_archivo = 'ActionGuardarGrupoProceso.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
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
		$cont =  $_POST['cantidad_ids'];
		
		//Por Post siempre se decodifica
		$decodificar = true;
	}
	else
	{
		$resp = new cls_manejo_mensajes(true, "406");
		$resp->mensaje_error = "MENSAJE ERROR = No existen datos para almacenar.";
		$resp->origen = "ORIGEN = $nombre_archivo";
		$resp->proc = "PROC = $nombre_archivo";
		$resp->nivel = 'NIVEL = 4';
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
			$id_grupo_proceso = $_GET["id_grupo_proceso_$j"];
			$id_depto_org=$_GET["id_depto_org_$j"];
			$id_proceso=$_GET["id_proceso_$j"];
			$descripcion=$_GET["descripcion_$j"];
			$id_gestion=$_GET["id_gestion_$j"];
			$fecha_contabilizacion=$_GET["fecha_contabilizacion_$j"];
			$id_activo_fijo=$_GET["id_activo_fijo_$j"];
			$id_empleado_org=$_GET["id_empleado_org_$j"];
			$id_empleado_des=$_GET["id_empleado_des_$j"];
			$id_presupuesto_org=$_GET["id_presupuesto_org_$j"];
			$id_presupuesto_des=$_GET["id_presupuesto_des_$j"];
			$codigo_proceso=$_GET["codigo_proceso_$j"];	
			$sw_prestamo=$_GET["sw_prestamo_$j"];	
			$opcion=$_GET["opcion_$j"];
			$fecha_devolucion=$_GET["fecha_devolucion_$j"];			
			
		}
		else
		{
			$id_grupo_proceso = $_POST["id_grupo_proceso_$j"];
			$id_depto_org=$_POST["id_depto_org_$j"];
			$id_proceso=$_POST["id_proceso_$j"];
			$descripcion=$_POST["descripcion_$j"];
			$id_gestion=$_POST["id_gestion_$j"];
			$fecha_contabilizacion=$_POST["fecha_contabilizacion_$j"];
			$id_activo_fijo=$_POST["id_activo_fijo_$j"];
			$id_empleado_org=$_POST["id_empleado_org_$j"];
			$id_empleado_des=$_POST["id_empleado_des_$j"];
			$id_presupuesto_org=$_POST["id_presupuesto_org_$j"];
			$id_presupuesto_des=$_POST["id_presupuesto_des_$j"];
			$codigo_proceso=$_POST["codigo_proceso_$j"];	
			$sw_prestamo=$_POST["sw_prestamo_$j"];	
			$opcion=$_POST["opcion_$j"];
			$fecha_devolucion=$_POST["fecha_devolucion_$j"];					
		}

		if ($id_grupo_proceso== "undefined" || $id_grupo_proceso== "")
		{ 
			////////////////////Inserción/////////////////////

			//Validación de datos (del lado del servidor)
//			$res = $Custom->ValidarProceso("insert",$hidden_id_proceso,$txt_descripcion,$txt_flag_comprobante,$txt_tipo_comprobante);
//			if(!$res)
//			{
//				//Error de validación
//				$resp = new cls_manejo_mensajes(true, "406");
//				$resp->mensaje_error = $Custom->salida[1];
//				$resp->origen = $Custom->salida[2];
//				$resp->proc = $Custom->salida[3];
//				$resp->nivel = $Custom->salida[4];
//				echo $resp->get_mensaje();
//				exit;
//			}

			//Validación satisfactoria, se ejecuta la inserción de la persona
			$res = $Custom -> InsertarGrupoProceso($id_depto_org,$id_proceso,$descripcion,$id_gestion,
													$fecha_contabilizacion,$id_activo_fijo,$id_empleado_org,
													$id_empleado_des,$id_presupuesto_org,$id_presupuesto_des,$codigo_proceso,$sw_prestamo,$fecha_devolucion);
			
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
		{	
//			$res = $Custom->ValidarProceso("update",$hidden_id_proceso,$txt_descripcion,$txt_flag_comprobante,$txt_tipo_comprobante);
//			if(!$res)
//			{
//				//Error de validación
//				$resp = new cls_manejo_mensajes(true, "406");
//				$resp->mensaje_error = $Custom->salida[1];
//				$resp->origen = $Custom->salida[2];
//				$resp->proc = $Custom->salida[3];
//				$resp->nivel =$Custom->salida[4];
//				echo $resp->get_mensaje();
//				exit;
//			}
			
	        if($opcion!=''){
	        		
	              	$res = $Custom->AccionesGrupoProceso($id_grupo_proceso,$opcion);
						if(!$res){
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
	           		
			}else{

				$res = $Custom->ModificarGrupoProceso($id_grupo_proceso,$id_depto_org,$id_proceso,$descripcion,$id_gestion,
													$fecha_contabilizacion,$id_activo_fijo,$id_empleado_org,
													$id_empleado_des,$id_presupuesto_org,$id_presupuesto_des,$codigo_proceso,$sw_prestamo,$fecha_devolucion);
			
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
		}

	}//END FOR

	//Guarda el mensaje de éxito de la operación realizada
	if($cont > 1) $mensaje_exito = 'Se guardaron todos los datos.';
	else $mensaje_exito = $Custom->salida[1];

	//Obtiene el total de los registros. Parámetros del filtro
	if($cant == "") $cant = 100;
	if($puntero == "") $puntero = 0;
	if($sortcol == "") $sortcol = 'descripcion';
	if($sortdir == "") $sortdir = 'asc';
	if($criterio_filtro == "") $criterio_filtro = "gru.estado=''$estado''";

	$res = $Custom->ContarGrupoProceso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	if($res) $total_registros = $Custom->salida;

	//Arma el xml para desplegar el mensaje
	$resp = new cls_manejo_mensajes(false);
	$resp->add_nodo('TotalCount', $total_registros);
	$resp->add_nodo('mensaje', $mensaje_exito);
	$resp->add_nodo('tiempo_resp', '200');
	echo $resp->get_mensaje();
	exit;
}
else
{
	$resp = new cls_manejo_mensajes(true, "401");
	$resp->mensaje_error = 'MENSAJE ERROR = Usuario no Autentificado';
	$resp->origen = "ORIGEN = $nombre_archivo";
	$resp->proc = "PROC = $nombre_archivo";
	$resp->nivel = 'NIVEL = 1';
	echo $resp->get_mensaje();
	exit;
}
?>