<?php
session_start();

$nombre_archivo = 'ActionExistenciasFisClasif.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{
	

	
	//Obtiene los parámetros del Padre
	$id_parametro_almacen=$id_parametro_almacen=='' ? '%':$id_parametro_almacen;
	$id_almacen=$id_almacen=='' ? '%':$id_almacen;
	$id_almacen_ep=$id_almacen_ep=='' ? '%':$id_almacen_ep;
	$id_almacen_logico=$id_almacen_logico=='' ? '%':$id_almacen_logico;
	$id_supergrupo=$id_supergrupo=='' ? '%':$id_supergrupo;
	$id_grupo=$id_grupo=='' ? '%':$id_grupo;
	$id_subgrupo=$id_subgrupo=='' ? '%':$id_subgrupo;
	$id_id1=$id_id1=='' ? '%':$id_id1;
	$id_id2=$id_id2=='' ? '%':$id_id2;
	$id_id3=$id_id3=='' ? '%':$id_id3;
	
	
	if($id_item==''||$id_item=='undefined'){
		$id_item='%';
	}
	
	
	echo "id_parametro_almacen: ".$id_parametro_almacen;
	echo "fecha: ".$fecha;
	echo "id_almacen: ".$id_almacen;
	echo "id_almacen_ep: ".$id_almacen_ep;
	echo "id_almacen_logico: ".$id_almacen_logico;
	echo "id_supergrupo: ".$id_supergrupo;
	echo "id_grupo: ".$id_grupo;
	echo "id_subgrupo: ".$id_subgrupo;
	echo "id_id1: ".$id_id1;
	echo "id_id2: ".$id_id2;
	echo "id_id3: ".$id_id3;
	echo "id_item: ".$id_item;
	echo "id_financiador: ".$id_financiador;
	echo "id_regional: ".$id_regional;
	echo "id_programa: ".$id_programa;
	echo "id_proyecto: ".$id_proyecto;
	echo "id_actividad: ".$id_actividad;
	exit;
	
	
	/*$id_almacen='%';
	$id_almacen_ep='%';
	$id_almacen_logico='%';
	$id_supergrupo='%';
	$id_grupo='%';
	$id_subgrupo='%';
	$id_id1='%';
	$id_id2='%';
	$id_id3='%';
	$id_item='%';*/
	
	//$_SESSION['nombre_padre']=$maestro_nombre_padre; 
	
	//Forma la cadena de parámetros para el reporte
	$data='id_parametro_almacen='.$id_parametro_almacen.'&';
	$data.='fecha='.$fecha.'&';
	$data.='id_almacen='.$id_almacen.'&';
	$data.='id_almacen_ep='.$id_almacen_ep.'&';
	$data.='id_almacen_logico='.$id_almacen_logico.'&';
	$data.='id_supergrupo='.$id_supergrupo.'&';
	$data.='id_grupo='.$id_grupo.'&';
	$data.='id_subgrupo='.$id_subgrupo.'&';
	$data.='id_id1='.$id_id1.'&';
	$data.='id_id2='.$id_id2.'&';
	$data.='id_id3='.$id_id3.'&';
	$data.='id_item='.$id_item;
	
	

	//Genera el Reporte
	header("location:PDFExistenciasFisClasif.php?".$data);
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