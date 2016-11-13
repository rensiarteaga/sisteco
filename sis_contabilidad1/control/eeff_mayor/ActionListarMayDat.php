<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarMayDat.php
Propósito:				Permite realizar el listado en tt_tct_maydat
Tabla:					tt_tct_maydat
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		2013-09-04 08:54:29
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once('../LibModeloContabilidad.php');

$Custom = new cls_CustomDBContabilidad();
$nombre_archivo = 'ActionListarMayDat.php';

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

	if($sort == '') $sortcol = 'codigo';
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

	//Verifica si se manda la cantidad de filtros
	if($CantFiltros=='') $CantFiltros = 0;

	//Se obtiene el criterio del filtro con formato sql para mandar a la BD
	$cond = new cls_criterio_filtro($decodificar);
	
	for($i=0;$i<$_POST['CantFiltros'];$i++){
		$cond->add_condicion_filtro($_POST["filterCol_$i"], $_POST["filterValue_$i"], $_POST["filterAvanzado_$i"]);
	}

	$criterio_filtro = $cond -> obtener_criterio_filtro();
	
 //echo 	$_POST['id_reporte_eeff'].$_POST['id_parametro'].$_POST['id_moneda'].$_POST['fecha_trans'].$_POST['nivel'];  exit ();
//echo $criterio_filtro; exit();
	//Obtiene el total de los registros
 	$res = $Custom -> ContarMayDat($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,
 	$_POST['id_gestion'],$_POST['id_depto'],$_POST['fecha_inicio'],$_POST['fecha_final'],$_POST['sw_cuenta'],$_POST['sw_auxiliar'],$_POST['sw_partida'],$_POST['sw_epe'],$_POST['sw_uo'],$_POST['sw_ot'],
	$_POST['id_cuenta_inicial'],$_POST['id_cuenta_final'],$_POST['id_auxiliar_inicial'],$_POST['id_auxiliar_final'],$_POST['id_partida_inicial'],$_POST['id_partida_final'],
	$_POST['id_epe_inicial'],$_POST['id_epe_final'],$_POST['id_uo_inicial'],$_POST['id_uo_final'],$_POST['id_ot_inicial'],$_POST['id_ot_final'],
	$_POST['sw_estado_cbte'],$_POST['sw_listado'],$_POST['id_moneda'] ,$_POST['sw_actualizacion'],$_POST['sw_orden']);
  	//echo $Custom -> query;exit;
 	//$res=true;
	if($res) $total_registros= $Custom->salida;
	
	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarMayDat($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,
	$_POST['id_gestion'],$_POST['id_depto'],$_POST['fecha_inicio'],$_POST['fecha_final'],$_POST['sw_cuenta'],$_POST['sw_auxiliar'],$_POST['sw_partida'],$_POST['sw_epe'],$_POST['sw_uo'],$_POST['sw_ot'],
	$_POST['id_cuenta_inicial'],$_POST['id_cuenta_final'],$_POST['id_auxiliar_inicial'],$_POST['id_auxiliar_final'],$_POST['id_partida_inicial'],$_POST['id_partida_final'],
	$_POST['id_epe_inicial'],$_POST['id_epe_final'],$_POST['id_uo_inicial'],$_POST['id_uo_final'],$_POST['id_ot_inicial'],$_POST['id_ot_final'],
	$_POST['sw_estado_cbte'],$_POST['sw_listado'],$_POST['id_moneda'] ,$_POST['sw_actualizacion'],$_POST['sw_orden']);
		
	//echo $Custom -> query;exit;
	if($res)
	{	$contador=0;
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);
		
		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_maydat',$f["id_maydat"]);
			$xml->add_nodo('codigo',$f["codigo"]);
			$xml->add_nodo('nombre',$f["nombre"]);
			$xml->add_nodo('codigo_nombre',$f["codigo"]." - ".$f["nombre"]);
			$xml->fin_rama();
		$contador++;
		}
		$xml->mostrar_xml();
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
