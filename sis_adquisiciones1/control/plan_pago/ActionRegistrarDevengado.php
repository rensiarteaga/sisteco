<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarCategoriaAdq.php
Propósito:				Permite insertar y modificar datos en la tabla tad_categoria_adq
Tabla:					tad_tad_categoria_adq
Parámetros:				$id_categoria_adq
						$nombre
						$observaciones
						$descripcion
						$fecha_reg
						$precio_min
						$precio_max
						$id_moneda

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2008-05-14 16:23:16
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloAdquisiciones.php");

$Custom = new cls_CustomDBAdquisiciones();
$nombre_archivo = "ActionRegistrarDevengado.php";

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
			$id_cotizacion= $_GET["id_cotizacion_$j"];
			$tipo_documento= $_GET["tipo_documento_$j"];
			$num_factura= $_GET["num_factura_$j"];
			$fecha_factura= $_GET["fecha_factura_$j"];
			$observaciones_devengado= $_GET["observaciones_devengado_$j"];
			$fecha_devengado= $_GET["fecha_devengado_$j"];
			$importe_devengar= $_GET["importe_devengar_$j"];
			$id_gestion= $_GET["id_gestion_$j"];
			
		}
		else
		{
			$id_cotizacion= $_POST["id_cotizacion_$j"];
			$tipo_documento= $_POST["tipo_documento_$j"];
			$num_factura= $_POST["num_factura_$j"];
			$fecha_factura= $_POST["fecha_factura_$j"];
			$observaciones_devengado= $_POST["observaciones_devengado_$j"];
			$fecha_devengado= $_POST["fecha_devengado_$j"];
			$importe_devengar= $_POST["importe_devengar_$j"];
			$id_gestion= $_POST["id_gestion_$j"];

		}

		

		$res = $Custom->RegistrarDevengado($id_cotizacion, $tipo_documento, $num_factura, $fecha_factura, $observaciones_devengado, $fecha_devengado, $importe_devengar,$id_gestion);

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
		

	}//END FOR

	//Guarda el mensaje de éxito de la operación realizada
	if($cont > 1) $mensaje_exito = "Se guardaron todos los datos.";
	else $mensaje_exito = $Custom->salida[1];

	//Obtiene el total de los registros. Parámetros del filtro
	if($cant == "") $cant = 100;
	if($puntero == "") $puntero = 0;
	if($sortcol == "") $sortcol = "id_cotizacion";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "COTIZA.id_proceso_compra=''$m_id_proceso_compra''";

	$res = $Custom->ContarCotizacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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