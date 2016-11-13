<?php
/**
**********************************************************
Nombre de archivo:	    ActionGenerarBeneficiarios.php

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		20/07/2011
Versión:				1.0.0
Autor:					José Abraham Mita Huanca
**********************************************************
*/
session_start();
include_once("../LibModeloContabilidad.php");

$Custom = new cls_CustomDBContabilidad();
$Custom1 = new cls_CustomDBContabilidad();
$nombre_archivo = 'ActionGenerarBeneficiarios.php';


if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{
	
	
	$res=$Custom -> ListarDetalleBeneficiariosGral(10000,0,'id_archivo_control','asc'," id_archivo_control=$dt_id_archivo_control",'','','','','');
	$res1=$Custom1 -> ListarArchivoControlGral(10000,0,'id_archivo_control','asc'," id_archivo_control=$dt_id_archivo_control",'','','','','');
	//Obtiene el total de los registros
	
	if($res)
	{
		$fp=fopen("../../control/recuperacion_vejez_gral/interface/beneficiarios_$dt_id_archivo_control.txt","w+");
	
		foreach ($Custom->salida as $f)
		{
				
			fwrite($fp,$f["numero_factura_ben"]."|");
			fwrite($fp,$f["numero_autorizacion_fecha_ben"]."|");
			fwrite($fp,'"'.$f["beneficiario"].'"|');//
			fwrite($fp,'"'.$f["tipo_identificacion"].'"|');//
			fwrite($fp,'"'.$f["numero_ident"].'"|');//
			fwrite($fp,'"'.$f["fecha_nacimiento"].'"|');//
			fwrite($fp,$f["consumo"]."|");
			fwrite($fp,$f["importe_des_direc"]."|");
			fwrite($fp,$f["importe_des_indirec"]."|");
			fwrite($fp,$f["importe_facturado"]."|");
			fwrite($fp,'"'.$f["codigo_control_factura_ben"].'"');//
			fwrite($fp,"\r\n");
					
		}
		fclose($fp);
		
		$fp1=fopen("../../control/recuperacion_vejez_gral/interface/control_$dt_id_archivo_control.txt","w+");
	
		foreach ($Custom1->salida as $f1)
		{
			
			fwrite($fp1,$f1["nro_factura"]."|");
			fwrite($fp1,$f1["nro_autoriza"]."|");
			fwrite($fp1,'"'.$f1["fecha_envio"].'"|');//
			fwrite($fp1,$f1["nro_nit"]."|");//
			fwrite($fp1,$f1["codigo_form"]."|");//
			fwrite($fp1,$f1["numero_orden"]."|");//
			fwrite($fp1,$f1["mes_per_fiscal"]."|");
			fwrite($fp1,$f1["anio_per_fiscal"]."|");
			fwrite($fp1,'"'.$f1["fecha_emision"].'"|');//
			fwrite($fp1,$f1["importe_factura"]."|");
			fwrite($fp1,$f1["cantidad_valor_solicitado"]."|");//
			fwrite($fp1,$f1["nro_beneficiarios_directos"]."|");//
			fwrite($fp1,$f1["nro_beneficiarios_indirectos"]."|");//
			fwrite($fp1,$f1["cant_reg_beneficiarios"]."|");//
			fwrite($fp1,$f1["importe_directo"]."|");//
			fwrite($fp1,$f1["importe_indirecto"]."|");//
			fwrite($fp1,$f1["importe_total"]."|");//
			fwrite($fp1,'"'.$f1["cod_control"].'"');//
			fwrite($fp1,"\r\n");
					
		}
		fclose($fp1);
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
/*	if($res1)
	{
		$fp=fopen("../../../control/recuperacion_vejez_gral/interface/control_$dt_id_archivo_control.txt","w+");
	
		foreach ($Custom1->salida as $f)
		{
			
			fwrite($fp,$f["nro_factura"]."|");
			fwrite($fp,$f["nro_autoriza"]."|");
			fwrite($fp,'"'.$f["fecha_envio"].'"|');//
			fwrite($fp,$f["nro_nit"]."|");//
			fwrite($fp,$f["codigo_form"]."|");//
			fwrite($fp,$f["numero_orden"]."|");//
			fwrite($fp,$f["mes_per_fiscal"]."|");
			fwrite($fp,$f["anio_per_fiscal"]."|");
			fwrite($fp,'"'.$f["fecha_emision"].'"|');//
			fwrite($fp,$f["importe_factura"]."|");
			fwrite($fp,$f["cantidad_valor_solicitado"]."|");//
			fwrite($fp,$f["nro_beneficiarios_directos"]."|");//
			fwrite($fp,$f["nro_beneficiarios_indirectos"]."|");//
			fwrite($fp,$f["cant_reg_beneficiarios"]."|");//
			fwrite($fp,$f["importe_directo"]."|");//
			fwrite($fp,$f["importe_indirecto"]."|");//
			fwrite($fp,$f["importe_total"]."|");//
			fwrite($fp,'"'.$f["cod_control"].'"');//
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
}	*/	
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
