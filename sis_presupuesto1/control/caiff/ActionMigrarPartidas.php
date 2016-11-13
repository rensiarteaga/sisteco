<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarCaiff.php
Prop�sito:				Permite insertar y modificar datos en la tabla tpr_usuario_autorizado
Tabla:					tpr_tpr_usuario_autorizado
Par�metros:				$id_usuario_autorizado
						$id_usuario
						$id_unidad_organizacional
						$nombre_unidad
						$apellido_paterno
						$apellido_materno
						$nombre

Valores de Retorno:    	N�mero de registros guardados
Fecha de Creaci�n:		2008-08-18 17:10:52
Versi�n:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloPresupuesto.php");

$Custom = new cls_CustomDBPresupuesto();
$nombre_archivo = "ActionGuardarAutorizacionPresupuesto.php";

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
		
		
		//Verifica si se har� o no la decodificaci�n(s�lo pregunta en caso del GET)
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
	
	//Envia al Custom la bandera que indica si se decodificar� o no
	$Custom->decodificar = $decodificar;
	
	//Realiza el bucle por todos los ids mandados
	for($j = 0;$j < $cont; $j++)
	{
		if ($get)
		{
			$id_caiff= $_GET["m_id_caiff"];
			$id_gestion= $_GET["id_gestion"];
			$id_periodo= $_GET["id_periodo"];
			$descripcion= $_GET["descripcion"];
			$fecha_ini= $_GET["fecha_inicio"];
			$fecha_fin= $_GET["fecha_fin"];
			$accion= $_GET["accion"];
			
		}
		else
		{
			$id_caiff= $_POST["m_id_caiff"];
			$id_gestion= $_POST["id_gestion"];
			$id_periodo= $_POST["id_periodo"];
			$descripcion= $_POST["descripcion"];
			$fecha_ini= $_POST["fecha_ini"];
			$fecha_fin= $_POST["fecha_fin"];
			$accion= $_POST["accion"];
		}
		
		/*$fecha_ini=date($fecha_ini);
		echo date_format($fecha_ini,'m/d/Y');
		//echo date_format($fecha_fin,'m/d/Y');
		exit;
		*/
		switch ($accion) {
			case 'migrar_sp':
			
								$res = $Custom ->MigrarSP($id_caiff,$id_gestion,$id_periodo,$descripcion,$fecha_ini,$fecha_fin,$estado);
						
									if(!$res)
									{
										//Se produjo un error
										$resp = new cls_manejo_mensajes(true, "406");
										$resp->mensaje_error = $Custom->salida[1] . " (iteracion $cont)";
										$resp->origen = $Custom->salida[2];
										$resp->proc = $Custom->salida[3];
										$resp->nivel = $Custom->salida[4];
										$resp->query = $Custom->query;
										echo $resp->get_mensaje();
										exit;
									}
							break;
			case 'migrar_cp':
								$res = $Custom->MigrarCP($id_caiff,$id_gestion,$id_periodo,$descripcion,$fecha_ini,$fecha_fin,$estado);
						
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
								
				break;
			case '1_validar':
								$res = $Custom->Validar_1($id_caiff,$id_gestion,$id_periodo,$descripcion,$fecha_ini,$fecha_fin,$estado);
													
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
			break;
			case '2_validar':
								$res = $Custom->Validar_2($id_caiff,$id_gestion,$id_periodo,$descripcion,$fecha_ini,$fecha_fin,$estado);
									
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
								break;
			case '3_validar':
								$res = $Custom->Validar_3($id_caiff,$id_gestion,$id_periodo,$descripcion,$fecha_ini,$fecha_fin,$estado);
									
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
								break;
		    case '4_validar':
									$res = $Custom->Validar_4($id_caiff,$id_gestion,$id_periodo,$descripcion,$fecha_ini,$fecha_fin,$estado);
										
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
									break;
		}
     }//END FOR

	//Guarda el mensaje de �xito de la operaci�n realizada
	if($cont > 1) $mensaje_exito = "Se guardaron todos los datos.";
	else $mensaje_exito = $Custom->salida[1];

	//Obtiene el total de los registros. Par�metros del filtro
	if($cant == "") $cant = 100;
	if($puntero == "") $puntero = 0;
	if($sortcol == "") $sortcol = "id_caiff";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "0=0";

	$res = $Custom->ContarCaiff($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
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