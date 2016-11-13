<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarPlanilla.php
Propósito:				Permite el calculo de columna_valor en   planilla para todos los empleados relacionados
Tabla:					tkp_tkp_planilla
Parámetros:				$id_planilla
						$id_tipo_planilla
						$id_periodo
						$id_usuario
						$id_moneda
						$numero
						$estado
						$observaciones
						$fecha_reg

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2010-08-23 11:07:47
Versión:				1.0.0
Autor:					Rensi Arteaga Copari
**********************************************************
*/
session_start();
include_once("../LibModeloKardexPersonal.php");

$Custom = new cls_CustomDBKardexPersonal();
$nombre_archivo = "ActionGuardarPlanilla.php";

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

		if ($get)
		{
			$id_planilla= $_GET["id_planilla"];
			$tipo=$_GET["tipo"];

		}
		else
		{
			$id_planilla=$_POST["id_planilla"];
			$tipo=$_POST["tipo"];

		}


		if($tipo!=''){


			if($tipo=='validar'||$tipo=='revertir' || $tipo=='pago_anticipo' || $tipo=='rev_anticipo' || $tipo=='cbte_costo'|| $tipo=='gen_obligacion' || $tipo=='reg_presupuesto' || $tipo=='pago_anticipado'){ 
			   $res = $Custom->ModificarPlanilla($id_planilla,null,null,null,$tipo,null,null,null);
	
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
			}else{
				
				if($tipo=='anticipo'){
					
					$res = $Custom->calcularPlanillaAnticipo($id_planilla);
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
					$res = $Custom->generarPlanilla($id_planilla,$tipo);
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
		
		}else{ 
		
			//Validación de datos (del lado del servidor)
			$res = $Custom->calcularPlanillaCompleta($id_planilla);

	
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
		

     $mensaje_exito = $Custom->salida[1];

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