<?php
/*
**********************************************************
Nombre de archivo:	    ActionListarGrupoHorario.php
Propósito:				Permite desplegar los Grupo de Horarios registrados
Tabla:					tca_grupo_horario
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro
						$id_usuario_asignacion

Valores de Retorno:    	Listado de Grupo de Horarios
Fecha de Creación:		21 - 08 - 07
Versión:				1.0.0
Autor:					Fernando Prudencio Cardona
**********************************************************
*/
session_start();
include_once("../LibModeloControlAsistencia.php");

$Custom = new cls_CustomDBControlAsistencia();
$nombre_archivo='ActionListarGrupoHorario.php';

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

	if($sort == "") $sortcol = 'id_grupo_horario';
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
	$criterio_filtro = $cond->obtener_criterio_filtro();
	
	//Obtiene el total de los registros
	$res = $Custom->ContarListaGrupoHorario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	if($res) $total_registros= $Custom->salida;
		
	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarGrupoHorario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	
	
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		
		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_grupo_horario', $f["id_grupo_horario"]);
			$xml->add_nodo('nombre_horario', $f["nombre_horario"]);
			$xml->add_nodo('acronimo_horario', $f["acronimo_horario"]);
			$xml->add_nodo('descripcion', $f["descripcion"]);
			$xml->fin_rama();
		}
		//$xml->add_nodo('query',$Custom->query);
		$xml->mostrar_xml();
	}
	else
	{
		//Se produjo un error
		$resp = new cls_manejo_mensajes(true, "503");
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

}
	 
	 
?>