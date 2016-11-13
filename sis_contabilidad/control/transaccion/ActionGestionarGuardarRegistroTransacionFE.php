<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarRegistroTransacion.php
Propósito:				Permite insertar y modificar datos en la tabla tct_transaccion
Tabla:					tct_tct_transaccion
Parámetros:				$id_transaccion
						$id_comprobante
						$id_fuente_financiamiento
						$id_fina_regi_prog_proy_acti
						$id_unidad_organizacional
						$id_cuenta
						$id_partida
						$id_auxiliar
						$id_orden_trabajo
						$id_oec
						$concepto_tran

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2008-09-16 17:57:09
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloContabilidad.php");

$Custom = new cls_CustomDBContabilidad();
$nombre_archivo = "ActionGuardarRegistroTransacion.php";

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
		{	$id_transaccion =  $_GET["id_transaccion_$j"];
			$concepto_tran =   $_GET["concepto_tran_$j"];
			$id_auxiliar =   $_GET["id_auxiliar_$j"];
			$id_comprobante =   $_GET["id_comprobante_$j"];
			$id_oec =   $_GET["id_oec_$j"];
			$id_orden_trabajo =   $_GET["id_orden_trabajo_$j"];
			
			$id_partida =   $_GET["id_partida_$j"];
			$id_cuenta =   $_GET["id_cuenta_$j"];
			
			$id_presupuesto =   $_GET["id_presupuesto_$j"];
			$importe_debe =   $_GET["importe_debe_$j"];
			$importe_haber =   $_GET["importe_haber_$j"];
			$importe_gasto =   $_GET["importe_gasto_$j"];
			$importe_recurso =   $_GET["importe_recurso_$j"];
			 
			
			$importe_debe_flujo =   $_GET["importe_debe_flujo_$j"];
			$importe_haber_flujo =   $_GET["importe_haber_flujo_$j"];

		}
		else
		{	$id_transaccion =  $_POST["id_transaccion_$j"];
			$concepto_tran =   $_POST["concepto_tran_$j"];
			$id_auxiliar =   $_POST["id_auxiliar_$j"];
			$id_comprobante =   $_POST["id_comprobante_$j"];
			$id_oec =   $_POST["id_oec_$j"];
			$id_orden_trabajo =   $_POST["id_orden_trabajo_$j"];
			$id_partida =   $_POST["id_partida_$j"];
			$id_cuenta =   $_POST["id_cuenta_$j"];
			$id_presupuesto =   $_POST["id_presupuesto_$j"];
			$importe_debe =   $_POST["importe_debe_$j"];
			$importe_haber =   $_POST["importe_haber_$j"];
			$importe_gasto =   $_POST["importe_gasto_$j"];
			$importe_recurso =   $_POST["importe_recurso_$j"];

			$importe_debe_flujo =   $_POST["importe_debe_flujo_$j"];
			$importe_haber_flujo =   $_POST["importe_haber_flujo_$j"];
		}
		//echo ($id_comprobante." es id comprobante ".$m_id_comprobante); exit() ;
		if($id_transaccion==0)$id_transaccion="undefined";
		if($id_comprobante==0)$id_comprobante=$m_id_comprobante;
		
	
		
		if ($id_transaccion == "undefined" || $id_transaccion == "")
		{
			////////////////////Inserción/////////////////////

		

			//Validación satisfactoria, se ejecuta la inserción en la tabla tct_transaccion
			$res = $Custom -> InsertarGestionarRegistroTransacionFE($id_transaccion,$concepto_tran,$id_auxiliar ,$id_comprobante,$id_oec,$id_orden_trabajo,$id_partida,$id_cuenta,$id_presupuesto,$importe_debe_flujo,$importe_haber_flujo,$importe_gasto,$importe_recurso);

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
			
			

			$res = $Custom->ModificarGestionarRegistroTransacionFE($id_transaccion,$concepto_tran,$id_auxiliar ,$id_comprobante,$id_oec,$id_orden_trabajo,$id_partida,$id_cuenta,$id_presupuesto,$importe_debe_flujo,$importe_haber_flujo,$importe_gasto,$importe_recurso);

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
	if($sortcol == "") $sortcol = "id_transaccion";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "0=0";

	$res = $Custom->ContarRegistroTransacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_comprobante_0,$id_moneda_0);
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