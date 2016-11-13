<?php
/**
**********************************************************
Nombre de archivo:	    ActionGeneraAscii.php
Propósito:				Permite generar el archivo ascii de la bancarizacion
Tabla:					tct_bancarizacion

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		07-11-2007
Versión:				1.0.0
Autor:					
**********************************************************
*/
session_start();
include_once("../LibModeloContabilidad.php");

$Custom = new cls_CustomDBContabilidad();
$nombre_archivo = 'ActionGeneraAscii.php';


if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{
	
	$criterio_filtro="BANDET.id_bancarizacion=".$id_bancarizacion." AND BANDET.tipo_operacion=''$tipo_operacion''";
	$res=$Custom -> RepBancarizacionDet(10000,0,'BANDET.id_bancarizacion_det','asc',$criterio_filtro,NULL,NULL,NULL,NULL,NULL);
	//Obtiene el total de los registros
	
	if($res)
	{
		$fp=fopen("../../bancarizacion/$tipo_operacion"."_bancarizacion_$id_bancarizacion.txt","w");
	
		foreach ($Custom->salida as $f)
		{
			fwrite($fp,$f["modalidad"]."|");//
			fwrite($fp,$f["fecha_documento"]."|");
			fwrite($fp,$f["tipo_transaccion"]."|");//
			fwrite($fp,$f["nit_proveedor"]."|");//
			fwrite($fp,$f["razon_social"]."|");//
			fwrite($fp,$f["nro_factura"]."|");
			fwrite($fp,$f["monto_factura"]."|");			
			fwrite($fp,$f["nro_autorizacion"]."|");//
			fwrite($fp,$f["cuenta_doc_pago"]."|");//
			fwrite($fp,$f["monto_doc_pago"]."|");			
			fwrite($fp,$f["monto_acumulado"]."|");
			fwrite($fp,$f["nit_entidad_financiera"]."|");//
			fwrite($fp,$f["nro_doc_pago"]."|");//
			fwrite($fp,$f["tipo_doc_pago"]."|");//
			fwrite($fp,$f["fecha_doc_pago"]);			
			fwrite($fp,"\r\n");
					
		}
		fclose($fp);
		$resp = new cls_manejo_mensajes(false);
		$resp->add_nodo('TotalCount', '1');
		$resp->add_nodo('mensaje', 'Archivo Generado con Exito');
		$resp->add_nodo('tiempo_resp', '200');
		echo $resp->get_mensaje();
		exit;
		
	}
		else
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
else
{
	$resp = new cls_manejo_mensajes(true, "401");
	$resp->mensaje_error = 'MENSAJE ERROR = Usuario no Autentificado';
	$resp->origen = "ORIGEN = $nombre_archivo";
	$resp->proc = "PROC = $nombre_archivo";
	$resp->nivel = 'NIVEL = 3';
	echo $resp->get_mensaje();
	exit;

}?>
