<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarEPempleado.php
Propósito:				Permite realizar el listado de EP's de empleado
Tabla:					tkp_empleado_tpm_frppa
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		5/07/2008
Versión:				MZM
**********************************************************
*/
session_start();
include_once('../LibModeloKardexPersonal.php');

$Custom = new cls_CustomDBKardexPersonal();
$nombre_archivo = 'ActionListarEPempleado.php';

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

	if($sort == '') $sortcol = 'FINANC.codigo_financiador';
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
	for($i=0;$i<$CantFiltros;$i++)
	{
		$cond->add_condicion_filtro($_POST["filterCol_$i"], $_POST["filterValue_$i"], $_POST["filterAvanzado_$i"]);
	}
	
	$cond->add_condicion_filtro('EMP_EP.id_empleado', $id_empleado, 'true');
	
	$criterio_filtro = $cond -> obtener_criterio_filtro();
	//Obtiene el criterio de orden de columnas
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'EmpleadoTpmFrppa');
	$sortcol = $crit_sort->get_criterio_sort();


	//Obtiene el total de los registros
	$res = $Custom -> ContarEPempleado($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarEPempleado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);
		
		$aux=Array();
		$aux['id_fina_regi_prog_proy_acti']=$Custom->salida[0]['id_fina_regi_prog_proy_acti'];
		$aux['id_financiador']=$Custom->salida[0]['id_financiador'];
		$aux['nombre_financiador']= $Custom->salida[0]['nombre_financiador'];
		$aux['codigo_financiador']=$Custom->salida[0]['codigo_financiador'];
		
		$aux['id_regional']=$Custom->salida[0]['id_regional'];
		$aux['nombre_regional']=$Custom->salida[0]['nombre_regional'];
		$aux['codigo_regional']=$Custom->salida[0]['codigo_regional'];
		
		$aux['id_programa']=$Custom->salida[0]['id_programa'];
		$aux['nombre_programa']=$Custom->salida[0]['nombre_programa'];
		$aux['codigo_programa']=$Custom->salida[0]['codigo_programa'];
		
		$aux['id_proyecto']=$Custom->salida[0]['id_proyecto'];
		$aux['nombre_proyecto']=$Custom->salida[0]['nombre_proyecto'];
		$aux['codigo_proyecto']=$Custom->salida[0]['codigo_proyecto'];
		
		$aux['id_actividad']=$Custom->salida[0]['id_actividad'];
		$aux['nombre_actividad']=$Custom->salida[0]['nombre_actividad'];
		$aux['codigo_actividad']=$Custom->salida[0]['codigo_actividad'];
		
		
		
		echo  json_encode($aux);
		exit;
		
		
		//$xml->mostrar_xml();
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


