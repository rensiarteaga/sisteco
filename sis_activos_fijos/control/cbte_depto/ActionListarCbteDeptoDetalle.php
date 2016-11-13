<?php

session_start();
include_once("../LibModeloActivoFijo.php");

$Custom = new cls_CustomDBActivoFijo();
$nombre_archivo = 'ActionListarCbteDeptoDetalle.php';


if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{
	//Parámetros del filtro
	if($limit == "") $cant = 15;
	else $cant = $limit;

	if($start == "") $puntero = 0;
	else $puntero = $start;

	if($sort == "") $sortcol = 'id_cbte_depto_det';
	else $sortcol = $sort;

	if($dir == "") $sortdir = 'desc';
	else $sortdir = $dir;
	
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

	//Verifica si se manda la cantidad de filtros
	if($CantFiltros=="") $CantFiltros = 0;

	//Se obtiene el criterio del filtro con formato sql para mandar a la BD
	$cond = new cls_criterio_filtro($decodificar);
	for($i=0;$i<$CantFiltros;$i++)
	{
		$cond->add_condicion_filtro($_POST["filterCol_$i"], $_POST["filterValue_$i"], $_POST["filterAvanzado_$i"]);
	}
	
	$criterio_filtro = $cond->add_criterio_extra("det.estado", "''activo''");
	
	if(isset($id_cbte_depto)  && $id_cbte_depto > 0)
	{
		$criterio_filtro = $cond->add_criterio_extra("det.id_cbte_depto",$id_cbte_depto);
	}
	else 
	{
		$criterio_filtro = $cond->add_criterio_extra("det.id_cbte_depto",-1);
	}
	
	$criterio_filtro = $cond->obtener_criterio_filtro();
	
	//Obtiene el total de los registros
	$res = $Custom->ContarCbteDeptoDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro);
	
	if($res) $total_registros= $Custom->salida; 

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarCbteDeptoDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro);

	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			
			$xml->add_nodo('id_cbte_depto_det', $f["id_cbte_depto_det"]);
			$xml->add_nodo('id_cbte_depto', $f["id_cbte_depto"]);
			$xml->add_nodo('descripcion', $f["descripcion"]);
			$xml->add_nodo('estado', $f["estado"]);
			$xml->add_nodo('usuario_reg', $f["usuario_reg"]);			
			$xml->add_nodo('fecha_reg', $f["fecha_reg"]);
			$xml->add_nodo('id_fina_regi_prog_proy_acti', $f["id_fina_regi_prog_proy_acti"]);
			$xml->add_nodo('nombre_financiador', $f["nombre_financiador"]);
			$xml->add_nodo('nombre_regional', $f["nombre_regional"]);
			$xml->add_nodo('nombre_programa', $f["nombre_programa"]);
			$xml->add_nodo('nombre_proyecto', $f["nombre_proyecto"]);
			$xml->add_nodo('nombre_actividad', $f["nombre_actividad"]);
			$xml->add_nodo('desc_epe', $f["desc_epe"]);			
			
			$xml->fin_rama();
		}
		$xml->mostrar_xml();
	}
	else
	{
		//Se produjo un error
		$resp = new cls_manejo_mensajes(true, "406");
		$resp->mensaje_error = $CustomActivos->salida[1];
		$resp->origen = $CustomActivos->salida[2];
		$resp->proc = $CustomActivos->salida[3];
		$resp->nivel = $CustomActivos->salida[4];
		$resp->query = $CustomActivos->query;
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
