<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarProcesoCompraVale.php
Propósito:				Permite insertar y modificar datos en la tabla tad_proceso_compra
Tabla:					tad_tad_proceso_compra
Parámetros:				$id_proceso_compra
						$observaciones
						$codigo_proceso
						$fecha_reg
						$estado_vigente
						$id_tipo_categoria_adq
						$id_moneda
						$num_cotizacion
						$num_proceso
						$siguiente_estado
						$periodo
						$gestion
						$num_cotizacion_sis
						$num_proceso_sis

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2008-05-13 18:03:05
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloAdquisiciones.php");

$Custom = new cls_CustomDBAdquisiciones();
$nombre_archivo = "ActionGuardarProcesoCompraVale.php";

if (!isset($_SESSION["autentificado"]))
{
	$_SESSION["autentificado"]="NO";
}
if($_SESSION["autentificado"]=="SI")
{
	//Verifica si los datos vienen por POST o GET
	if (sizeof($_GET) > 0){
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
	for($j = 0;$j < $cont; $j++){
		if ($get){
			$id_proceso_compra= $_GET["id_proceso_compra_$j"];
			$id_caja=$_GET["id_caja_$j"];
			$id_cajero=$_GET["id_cajero_$j"];
			$id_comprador=$_GET["id_comprador_$j"];
			$obs=$_GET["obs_$j"];
			$observaciones=$_GET["observaciones_$j"];
		}
		else{
			$id_proceso_compra=$_POST["id_proceso_compra_$j"];
			$id_caja=$_POST["id_caja_$j"];
			$id_cajero=$_POST["id_cajero_$j"];
			$id_comprador=$_POST["id_comprador_$j"];
			$obs=$_POST["obs_$j"];
			$observaciones=$_POST["observaciones_$j"];
		}
    
	if ($id_proceso_compra != "undefined" && $id_proceso_compra != ""){
		
        if($obs==0){
           
            $res = $Custom -> AnularProcesoCompra($id_proceso_compra,$observaciones);

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
        }else{
	    
	       $res = $Custom -> InsertarValeProcesoCompra($id_proceso_compra,$id_caja,$id_cajero,$id_comprador);
		    if(!$res){
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
		
	}
		
	}//END FOR

	//Guarda el mensaje de éxito de la operación realizada
	if($cont > 1) $mensaje_exito = "Se guardaron todos los datos.";
	else $mensaje_exito = $Custom->salida[1];

	//Obtiene el total de los registros. Parámetros del filtro
	if($cant == "") $cant = 100;
	if($puntero == "") $puntero = 0;
	if($sortcol == "") $sortcol = "id_proceso_compra";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "0=0";

	$res = $Custom->ContarProcesoCompraDir($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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