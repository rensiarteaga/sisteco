<?php
/**
**********************************************************
Fecha de Creación:		2009-11-06
Versión:				1.0.0

**********************************************************
*/
session_start();
include_once('../LibModeloAdquisiciones.php');

$Custom = new cls_CustomDBAdquisiciones();
$nombre_archivo = 'ActionRevertirPresupuesto.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']='NO';
}
if($_SESSION['autentificado']=='SI')
{

//if($_SESSION["ss_id_usuario"]==120){echo $tipo; exit;}
	if($tipo='iud'){
		//Obtiene el conjunto de datos de la consulta
		$res = $Custom->ComprometerPresupuesto($id_proceso_compra);
		if(!$res)
		{
			//Se produjo un error
			$resp = new cls_manejo_mensajes(true,'406');
			$num_convocatoria++;
			$resp->mensaje_error = $Custom->salida[1];
			$resp->origen = $Custom->salida[2];
			$resp->proc = $Custom->salida[3];
			$resp->nivel = $Custom->salida[4];
			$resp->query = $Custom->query;
			echo $resp->get_mensaje();
			exit;
		}
	
		//Devuelve el Id del TUC creado
		$tmp['success']=true;
		$tmp['respuesta'] = $Custom->salida[1];
		echo json_encode($tmp);
		exit;
		
	}else{//sel
		$res = $Custom->ListarComprometido($id_proceso_compra);
	
		if($res)
		{
			$xml = new cls_manejo_xml('ROOT');
			$xml->add_nodo('TotalCount',$total_registros);
	
			foreach ($Custom->salida as $f)
			{
				$xml->add_rama('ROWS');
				$xml->add_nodo('id_solicitud_compra_det',$f["id_solicitud_compra_det"]);
				$xml->add_nodo('precio_referencial_total_as',$f["precio_referencial_total_as"]);
				$xml->add_nodo('id_partida_sgte',$f["id_partida_sgte"]);
				$xml->add_nodo('id_partida_actual',$f["id_partida_actual"]);
				$xml->add_nodo('desc_partida_sgte',$f["desc_partida_sgte"]);
				$xml->add_nodo('desc_partida_actual',$f["desc_partida_actual"]);
				$xml->add_nodo('desc_tipo_categoria_adq',$f["desc_tipo_categoria_adq"]);
				
				$xml->fin_rama();
			}
			$xml->mostrar_xml();
		}
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