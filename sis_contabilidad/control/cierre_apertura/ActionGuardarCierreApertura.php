<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarCheque.php
Propósito:				Permite insertar y modificar datos en la tabla tct_cheque
Tabla:					tct_tct_cheque
Parámetros:				

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2008-10-17 11:24:35
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloContabilidad.php");

$Custom = new cls_CustomDBContabilidad();
$nombre_archivo = "ActionGuardarCierreApertura.php";

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
			
			
			$ct_id_cierre_apertura= $_GET["id_cierre_apertura_$j"];
            $ct_id_comprobante= $_GET["id_comprobante_$j"];
            $ct_descripcion= $_GET["descripcion_$j"];
            $ct_nro_cbte= $_GET["nro_cbte_$j"];
            $ct_id_reporte_eeff= $_GET["id_reporte_eeff_$j"];
            $ct_sw_volcar= $_GET["sw_volcar_$j"];
            $ct_sw_siguiente_gestion= $_GET["sw_siguiente_gestion_$j"];
            $ct_id_cuenta_diferencia= $_GET["id_cuenta_diferencia_$j"];
            $ct_sw_actualizacion= $_GET["sw_actualizacion_$j"];
            $ct_id_depto_conta= $_GET["id_depto_conta_$j"];
            $ct_id_gestion_actual= $_GET["id_gestion_actual_$j"];
            $ct_id_gestion_nueva= $_GET["id_gestion_nueva_$j"];
            $ct_sw_estado= $_GET["sw_estado_$j"];
            $ct_id_moneda= $_GET["id_moneda_$j"];
            
            
		}
		else
		{
			
			$ct_id_cierre_apertura= $_POST["id_cierre_apertura_$j"];
            $ct_id_comprobante= $_POST["id_comprobante_$j"];
            $ct_descripcion= $_POST["descripcion_$j"];
            $ct_nro_cbte= $_POST["nro_cbte_$j"];
            $ct_id_reporte_eeff= $_POST["id_reporte_eeff_$j"];
            $ct_sw_volcar= $_POST["sw_volcar_$j"];
            $ct_sw_siguiente_gestion= $_POST["sw_siguiente_gestion_$j"];
            $ct_id_cuenta_diferencia= $_POST["id_cuenta_diferencia_$j"];
            $ct_sw_actualizacion= $_POST["sw_actualizacion_$j"];
            $ct_id_depto_conta= $_POST["id_depto_conta_$j"];
            $ct_id_gestion_actual= $_POST["id_gestion_actual_$j"];
            $ct_id_gestion_nueva= $_POST["id_gestion_nueva_$j"];
            $ct_sw_estado= $_POST["sw_estado_$j"];
            $ct_id_moneda= $_POST["id_moneda_$j"];
		}
			
           
		if ($ct_id_cierre_apertura == "undefined" || $ct_id_cierre_apertura == "")
		{
			////////////////////Inserción/////////////////////
            /*
			echo "LLEGAAAA";
            echo "id_cierre_apertura_: ".$ct_id_cierre_apertura."<br>";
		    echo "id_comprobante_: ".$ct_id_comprobante."<br>";
		    echo "descripcion_: ".$ct_descripcion."<br>";
            echo "nro_cbte_: ".$ct_nro_cbte."<br>";
            echo "id_reporte_eeff_: ".$ct_id_reporte_eeff."<br>";
            echo "sw_volcar_: ".$ct_sw_volcar."<br>";
            echo "id_gestion_actual_: ".$ct_id_gestion_actual."<br>";
            echo "moneda: ".$ct_id_moneda."<br>";
            exit;
            */
            //$ct_id_comprobante=(int)$ct_id_comprobante;
            //$ct_nro_cbte=(Integer)$ct_nro_cbte;
			//Validación satisfactoria, se ejecuta la inserción en la tabla tct_cheque
			$res = $Custom -> InsertarCierreApertura($ct_id_cierre_apertura,
			$ct_id_comprobante,
			$ct_descripcion,
			$ct_nro_cbte,
			$ct_id_reporte_eeff,
			$ct_sw_volcar,
			$ct_sw_siguiente_gestion,
			$ct_id_cuenta_diferencia,
			$ct_sw_actualizacion,
			$ct_id_depto_conta,
			$ct_id_gestion_actual,
			$ct_id_gestion_nueva,
			$ct_sw_estado,
			$ct_id_moneda);
			
	
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
			$res = $Custom->ValidarCierreApertura("update",$ct_id_cierre_apertura,$ct_id_comprobante,$ct_descripcion,$ct_nro_cbte,$ct_id_reporte_eeff,$ct_sw_volcar,$ct_sw_siguiente_gestion,$ct_id_cuenta_diferencia,$ct_sw_actualizacion,$ct_id_depto_conta,$ct_id_gestion_actual,$ct_id_gestion_nueva,$ct_sw_estado,$ct_id_moneda);

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

			$res = $Custom->ModificarCierreApertura($ct_id_cierre_apertura,$ct_id_comprobante,$ct_descripcion,$ct_nro_cbte,$ct_id_reporte_eeff,$ct_sw_volcar,$ct_sw_siguiente_gestion,$ct_id_cuenta_diferencia,$ct_sw_actualizacion,$ct_id_depto_conta,$ct_id_gestion_actual,$ct_id_gestion_nueva,$ct_sw_estado,$ct_id_moneda);

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
	//end for
//Guarda el mensaje de éxito de la operación realizada
	if($cont > 1) $mensaje_exito = "Se guardaron todos los datos.";
	else $mensaje_exito = $Custom->salida[1];

	//Obtiene el total de los registros. Parámetros del filtro
	if($cant == "") $cant = 100;
	if($puntero == "") $puntero = 0;
	if($sortcol == "") $sortcol = "id_gestion";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "0=0";

	$res = $Custom->ContarCierreApertura($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$sw_volcar,$siguiente_gestion,$cta_dif,$sw_act,$dpto_conta,$g_actual,$g_nueva,$moneda,$eeff);
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