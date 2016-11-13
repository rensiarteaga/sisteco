<?php
/*
**********************************************************
Nombre de archivo:	    ActionListaActivoFijoCompCaract.php
Propósito:				Permite desplegar los ActivoFijoCompCaract  registrados
Tabla:					taf_activo_fijo_comp_caract
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro
						$id_usuario_asignacion

Valores de Retorno:    	Listado de ActivoFijoCompCaract
Fecha de Creación:		12- 06 - 07
Versión:				1.0.0
Autor:					Mercedes Zambrana
**********************************************************
*/
session_start();
include_once("../LibModeloActivoFijo.php");
$CustomActivos = new cls_CustomDBActivoFijo();
$nombre_archivo='ActionListaActivoFijoCompCaract.php';

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

	if($sort == "") $sortcol = 'descripcion';
	else $sortcol = $sort;

	if($dir == "") $sortdir = 'asc';
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
	
	/*echo "bien";
	exit;*/
	
	//Verifica si se manda la cantidad de filtros
	if($CantFiltros=="") $CantFiltros = 0;

	//Se obtiene el criterio del filtro con formato sql para mandar a la BD
	$cond = new cls_criterio_filtro($decodificar);
	for($i=0;$i<$CantFiltros;$i++)
	{
		$cond->add_condicion_filtro($_POST["filterCol_$i"], $_POST["filterValue_$i"], $_POST["filterAvanzado_$i"]);
	}
	
		//Se aumenta el criterio del maestro (id_tipo_activo)
	$cond->add_criterio_extra("cc.id_componente",$maestro_id_componente);
	$criterio_filtro = $cond->obtener_criterio_filtro();
	
	$res = $CustomActivos->ContarListaActivoFijoCompCaract($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	if($res)
	{//echo $res;
		$total_registros= $CustomActivos->salida[0][0];
		
	}
	
	//Obtiene el conjunto de datos de la consulta
	$res = $CustomActivos->ListarActivoFijoCompCaract($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);

	
	if($res)
	{ 
	//exit;
		// PREPARA EL ARCHIVO XML
		$xml= new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);
		
		foreach ($CustomActivos->salida as $f)
		{ 
		    $xml->add_rama('ROWS');
		    $xml->add_nodo('id_activo_fijo_comp_caract',$f["id_activo_fijo_comp_caract"]);
		    $xml->add_nodo('descripcion',$f["descripcion"]);
		    $xml->add_nodo('id_caracteristica',$f["id_caracteristica"]);
		    $xml->add_nodo('id_componente',$f["id_componente"]);
		    $xml->add_nodo('des_caracteristica',$f["des_caracteristica"]);
		    $xml->add_nodo('des_componente',$f["des_componente"]);
		    $xml->fin_rama();
		}
		$xml->mostrar_xml();
	}
	else
	{
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

}
	 
	 
?>