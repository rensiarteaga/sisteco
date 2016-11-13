<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarFormulacionPresupuesto.php
Propósito:				Permite insertar y modificar datos en la tabla tpr_presupuesto
Tabla:					tpr_tpr_presupuesto
Parámetros:				$id_presupuesto
						$tipo_pres
						$estado_pres
						$id_fina_regi_prog_proy_acti
						$id_unidad_organizacional
						$id_fuente_financiamiento
						$id_parametro
						

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2008-07-10 09:08:14
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloPresupuesto.php");

$Custom = new cls_CustomDBPresupuesto();
$nombre_archivo = "ActionGuardarFormulacionPresupuesto.php";

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
			$id_presupuesto= $_GET["id_presupuesto_$j"];
			$tipo_pres= $_GET["tipo_pres_$j"];
			$estado_pres= $_GET["estado_pres_$j"];
			$id_fina_regi_prog_proy_acti= $_GET["id_fina_regi_prog_proy_acti_$j"];
			$id_unidad_organizacional= $_GET["id_unidad_organizacional_$j"];
			$id_fuente_financiamiento= $_GET["id_fuente_financiamiento_$j"];
			$id_parametro= $_GET["id_parametro_$j"];
			
				$id_financiador = $_GET["txt_id_financiador_$j"];
				$id_regional	= $_GET["txt_id_regional_$j"];
				$id_programa = $_GET["txt_id_programa_$j"];
				$id_proyecto	= $_GET["txt_id_proyecto_$j"];
				$id_actividad	= $_GET["txt_id_actividad_$j"];
				$sw_generacion	= $_GET["sw_generacion_$j"];
				$id_concepto_colectivo	= $_GET["id_concepto_colectivo_$j"];
				
			$cod_fin=$_GET["cod_org_fin_$j"]; 
			$cod_prg=$_GET["cod_prg_$j"];
			$cod_proy=$_GET["cod_proy_$j"];
			$cod_act=$_GET["cod_act_$j"];	
			$id_categoria_prog=$_GET["id_categoria_prog_$j"];
			//jun2015
			$obliga_ot=$_GET["obliga_ot_$j"];
		}
		else
		{
			$id_presupuesto=$_POST["id_presupuesto_$j"];
			$tipo_pres=$_POST["tipo_pres_$j"];
			$estado_pres=$_POST["estado_pres_$j"];
			$id_fina_regi_prog_proy_acti=$_POST["id_fina_regi_prog_proy_acti_$j"];
			$id_unidad_organizacional=$_POST["id_unidad_organizacional_$j"];
			$id_fuente_financiamiento=$_POST["id_fuente_financiamiento_$j"];
			$id_parametro=$_POST["id_parametro_$j"];
			
				$id_financiador= $_POST["txt_id_financiador_$j"];
				$id_regional	= $_POST["txt_id_regional_$j"];
				$id_programa = $_POST["txt_id_programa_$j"];
				$id_proyecto	= $_POST["txt_id_proyecto_$j"];
				$id_actividad	= $_POST["txt_id_actividad_$j"];
				$sw_generacion	= $_POST["sw_generacion_$j"];
				$id_concepto_colectivo	= $_POST["id_concepto_colectivo_$j"];
				
			$cod_fin=$_POST["cod_org_fin_$j"];
			$cod_prg=$_POST["cod_prg_$j"];
			$cod_proy=$_POST["cod_proy_$j"];
			$cod_act=$_POST["cod_act_$j"];
			$id_categoria_prog=$_POST["id_categoria_prog_$j"];
			//jun2015
			$obliga_ot=$_POST["obliga_ot_$j"];
		}
		if($sw_cambio_estado=="si")
		{
			
			$res = $Custom->ValidarCambiarEstado($id_presupuesto_0,$estado_pres_0);

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

			//Validación satisfactoria, se ejecuta la inserción en la tabla tpr_presupuesto
																	
			$res = $Custom->ModificarEstado($id_presupuesto_0, $estado_pres_0);

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
		else if($sw_generacion==1)
		{

			$res = $Custom->ValidarFormulacionPresupuesto("update",$id_presupuesto,$tipo_pres,$estado_pres,$id_unidad_organizacional,$id_fuente_financiamiento,$id_parametro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);

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

			//Validación satisfactoria, se ejecuta la inserción en la tabla tpr_presupuesto
																	
			$res = $Custom->InsertarFormulacionPresupuestoPlantilla($id_presupuesto,$tipo_pres,$estado_pres,$id_unidad_organizacional,$id_fuente_financiamiento,$id_parametro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$cod_fin,$cod_prg,$cod_proy,$cod_act,$id_categoria_prog
					//jun2015
					,$obliga_ot
					);
						

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
		else if($id_concepto_colectivo>0)
		{

			$res = $Custom->ValidarFormulacionPresupuesto("insert",$id_presupuesto,$tipo_pres,$estado_pres,$id_unidad_organizacional,$id_fuente_financiamiento,$id_parametro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);

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

			//Validación satisfactoria, se ejecuta la inserción en la tabla tpr_presupuesto
																	
			$res = $Custom->InsertarPresupuestoColectivoPartida($id_presupuesto,$tipo_pres,$estado_pres,$id_unidad_organizacional,$id_fuente_financiamiento,$id_parametro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_concepto_colectivo,$cod_fin,$cod_prg,$cod_proy,$cod_act,$id_categoria_prog);

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
		else if ($id_presupuesto == "undefined" || $id_presupuesto == "") 
		{

			////////////////////Inserción/////////////////////

			//Validación de datos (del lado del servidor)
			
			
			
			$res = $Custom->ValidarFormulacionPresupuesto("insert",$id_presupuesto,$tipo_pres,$estado_pres,$id_unidad_organizacional,$id_fuente_financiamiento,$id_parametro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);

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

			//Validación satisfactoria, se ejecuta la inserción en la tabla tpr_presupuesto
			$res = $Custom -> InsertarFormulacionPresupuesto($id_presupuesto,$tipo_pres,$estado_pres,$id_unidad_organizacional,$id_fuente_financiamiento,$id_parametro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$cod_fin,$cod_prg,$cod_proy,$cod_act,$id_categoria_prog
					//jun2015
					,$obliga_ot
					);

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
			$res = $Custom->ValidarFormulacionPresupuesto("update",$id_presupuesto,$tipo_pres,$estado_pres,$id_unidad_organizacional,$id_fuente_financiamiento,$id_parametro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);

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

			/*echo ('llegamos al modificar '.$cod_fin);
			exit();*/
			$res = $Custom->ModificarFormulacionPresupuesto($id_presupuesto,$tipo_pres,$estado_pres,$id_unidad_organizacional,$id_fuente_financiamiento,$id_parametro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$cod_fin,$cod_prg,$cod_proy,$cod_act,$id_categoria_prog
			//jun2015
			,$obliga_ot);
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
	if($sortcol == "") $sortcol = "id_presupuesto";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "0=0";

	$res = $Custom->ContarFormulacionPresupuesto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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