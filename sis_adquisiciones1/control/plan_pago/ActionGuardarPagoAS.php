<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarPagoAS.php
Propósito:				Permite insertar y modificar datos en la tabla tad_plan_pago
Tabla:					tad_tad_plan_pago
Parámetros:				$id_plan_pago
						$tipo_pago
						$nro_cuota
						$fecha_pago
						$monto
						$estado
						$id_cotizacion

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloAdquisiciones.php");

$Custom = new cls_CustomDBAdquisiciones();
$nombre_archivo = "ActionGuardarPagoAS.php";

if (!isset($_SESSION["autentificado"]))
{
	$_SESSION["autentificado"]="NO";
}
if($_SESSION["autentificado"]=="SI")
{
	//Verifica si los datos vienen por POST o GET
	
	$id_cotizacion;
	$total_aa;
	$total_as;
	//Envia al Custom la bandera que indica si se decodificará o no
	$Custom->decodificar = $decodificar;

	$res=$Custom->ModificarPagoAS($id_cotizacion,$total_aa,$total_as);
				   if(!$res){
				   	    $resp= new cls_manejo_mensajes(true,"406");
				   	 	$resp->mensaje_error = $Custom->salida[1];
				   	 	$resp->origen = $Custom->salida[2];
						$resp->proc = $Custom->salida[3];
						$resp->nivel = $Custom->salida[4];
						echo $resp->get_mensaje();
						exit;
				   }
	
		   
	

	//Guarda el mensaje de éxito de la operación realizada
	if($cont > 1) $mensaje_exito = "Se guardaron todos los datos.";
	else $mensaje_exito = $Custom->salida[1];

	//Obtiene el total de los registros. Parámetros del filtro
	if($cant == "") $cant = 100;
	if($puntero == "") $puntero = 0;
	if($sortcol == "") $sortcol = "id_cotizacion";
	if($sortdir == "") $sortdir = "desc";
	
	
	if($criterio_filtro == "") $criterio_filtro = "cotiza.id_cotizacion=$id_cotizacion";

	$res = $Custom->ContarCotizacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$m_id_cotizacion);
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