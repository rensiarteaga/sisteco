<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarTipoCuentaCuenta.php
Propósito:				Permite realizar el listado en taf_tipo_cuenta_cuenta
Tabla:					taf_taf_tipo_cuenta_cuenta
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		2010-11-08 18:08:55
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once('../LibModeloActivoFijo.php');

$Custom = new cls_CustomDBActivoFijo();
$nombre_archivo = 'ActionListarTipoCuentaCuenta.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']='NO';
}
if($_SESSION['autentificado']=='SI')
{
//Parámetros del filtro
	if($limit == '') $cant = 15;
	else $cant = $limit;

	if($start == '') $puntero = 0;
	else $puntero = $start;

	if($sort == '') $sortcol = 'id_tipo_cuenta_cuenta';
	else $sortcol = $sort;

	if($dir == '') $sortdir = 'asc';
	else $sortdir = $dir;

	//Verifica si se hará o no la decodificación(sólo pregunta en caso del GET)
	//valores permitidos de $cod -> 'si', 'no'
	
	switch ($cod)
	{
		case 'si':
			$decodificar = true;
			break;
		case 'no':
			$decodificar = false;
			break;
		default:
			$decodificar = true;
			break;
	}

	
	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarTipoCuentaCuenta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$id_gestion,$node,$id_tipo_cuenta);
	
	if($res)
	{
		if(count($Custom->salida)>0){
			$res_array=$Custom->salida;
			$count=0;
			foreach ($res_array as $data){
				$data['qtipTitle']='Cuenta y Auxiliar';
				
				$data['leaf']=($data['leaf']=='false')?false:true;
				$data['allowDelete']=($data['allowdelete']=='false')?false:true;
				$data['allowEdit']=($data['allowedit']=='false')?false:true;
				$data['allowDrag']=($data['allowdrag']=='false')?false:true;

								
				$data=array_map('utf8_encode',$data);
							
				$res_array[$count]=$data;
				$count++;
			}
			
			$res_json=json_encode($res_array);
			
		}
		else 
			$res_json="{}";
		echo $res_json;
		exit;
	}
	else
	{
		//Se produjo un error
		$resp = new cls_manejo_mensajes(true,'406');
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