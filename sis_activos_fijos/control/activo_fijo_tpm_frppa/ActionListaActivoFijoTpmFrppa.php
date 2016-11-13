<?php
/**
* Nombre de archivo:	    ActionListaActivoFijoTpmFrppa.php
* Propósito:				Permite desplegar los registros de las relaciones de la estructura programática con Activos Fijos
* Tabla:					taf_activo_fijo_tpm_frppa
* Parámetros:
* Valores de Retorno:   	Listado de las relaciones de la estructura programática con Activos Fijos, y el total de registros listados
* Autor:					Rodrigo Chumacero Moscoso
* Fecha de Creación:		21-06-2007
*/

session_start();

include_once("../LibModeloActivoFijo.php");

$Custom = new cls_CustomDBActivoFijo();
$nombre_archivo = 'ActionListaActivoFijoTpmFrppa.php';

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

	if($sort == "") $sortcol = 'estado';
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

	//Verifica si se manda la cantidad de filtros
	if($CantFiltros=="") $CantFiltros = 0;

	//Se obtiene el criterio del filtro con formato sql para mandar a la BD
	$cond = new cls_criterio_filtro($decodificar);
	for($i=0;$i<$CantFiltros;$i++)
	{
		$cond->add_condicion_filtro($_POST["filterCol_$i"], $_POST["filterValue_$i"], $_POST["filterAvanzado_$i"]);
	}
	
	//Se aumenta el criterio del maestro (id_tipo_activo)
	$cond->add_criterio_extra("affrppa.id_activo_fijo",$hidden_id_activo_fijo);
	$criterio_filtro = $cond->obtener_criterio_filtro();
	
	//Obtiene el total de los registros
	$res = $Custom->ContarListaActivoFijoTpmFrppa($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarActivoFijoTpmFrppa($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);
		
		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_activo_fijo_frppa', $f["id_activo_fijo_frppa"]);
			$xml->add_nodo('estado', $f["estado"]);
			$xml->add_nodo('fecha_reg', $f["fecha_reg"]);
			$xml->add_nodo('id_activo_fijo', $f["id_activo_fijo"]);
			$xml->add_nodo('id_fina_regi_prog_proy_acti', $f["id_fina_regi_prog_proy_acti"]);
			$xml->add_nodo('nombre_financiador', $f["nombre_financiador"]);
			$xml->add_nodo('nombre_regional', $f["nombre_regional"]);
			$xml->add_nodo('nombre_programa', $f["nombre_programa"]);
			$xml->add_nodo('nombre_proyecto', $f["nombre_proyecto"]);
			$xml->add_nodo('nombre_actividad', $f["nombre_actividad"]);
			$xml->add_nodo('id_financiador', $f["id_financiador"]);
			$xml->add_nodo('id_regional', $f["id_regional"]);
			$xml->add_nodo('id_programa', $f["id_programa"]);
			$xml->add_nodo('id_proyecto', $f["id_proyecto"]);
			$xml->add_nodo('id_actividad', $f["id_actividad"]);
			$xml->add_nodo('desc_epe', $f["desc_epe"]);
			$xml->add_nodo('id_unidad_organizacional', $f["id_unidad_organizacional"]);
			$xml->add_nodo('desc_uo', $f["desc_uo"]);	
			$xml->add_nodo('id_gestion', $f["id_gestion"]);
			$xml->add_nodo('gestion', $f["gestion"]);
			$xml->add_nodo('id_presupuesto', $f["id_presupuesto"]);	
			$xml->add_nodo('estado', $f["estado"]);
			$xml->add_nodo('tipo_ppto', $f["tipo_ppto"]);
			$xml->add_nodo('tipo_pres', $f["tipo_pres"]);
			
			$xml->fin_rama();
		}
		$xml->mostrar_xml();
	}
	else
	{
		//Se produjo un error
		$resp = new cls_manejo_mensajes(true,"406");
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
