<?php
/*
**********************************************************
Nombre de archivo:	    ActionListarHorario.php
Propósito:				Permite desplegar los Horarios registrados
Tabla:					tca_horario
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro
						$id_usuario_asignacion

Valores de Retorno:    	Listado de Horarios
Fecha de Creación:		21 - 08 - 07
Versión:				1.0.0
Autor:					Fernando Prudencio Cardona
**********************************************************
*/
session_start();
include_once("../LibModeloControlAsistencia.php");

$Custom = new cls_CustomDBControlAsistencia();
$nombre_archivo='ActionListarHorario.php';

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

	if($sort == "") $sortcol = 'id_codigo_horario';
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
	$res = $Custom->ContarListaFeriado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	if($res) $total_registros= $Custom->salida;
		
	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarHorario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	
	
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		
		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_codigo_horario', $f["id_codigo_horario"]);
			$xml->add_nodo('entra_lunes', $f["entra_lunes"]);
			$xml->add_nodo('sale_lunes', $f["sale_lunes"]);
			$xml->add_nodo('entra_martes', $f["entra_martes"]);
			$xml->add_nodo('sale_martes', $f["sale_martes"]);
			$xml->add_nodo('entra_miercoles', $f["entra_miercoles"]);
			$xml->add_nodo('sale_miercoles', $f["sale_miercoles"]);
			$xml->add_nodo('entra_jueves', $f["entra_jueves"]);
			$xml->add_nodo('sale_jueves', $f["sale_jueves"]);
			$xml->add_nodo('entra_viernes', $f["entra_viernes"]);
			$xml->add_nodo('sale_viernes', $f["sale_viernes"]);
			$xml->add_nodo('entra_sabado', $f["entra_sabado"]);
			$xml->add_nodo('sale_sabado', $f["sale_sabado"]);
			$xml->add_nodo('entra_domingo', $f["entra_domingo"]);
			$xml->add_nodo('sale_domingo', $f["sale_domingo"]);
			$xml->add_nodo('min_tolerancia_entra', $f["min_tolerancia_entra"]);
			$xml->add_nodo('hora_extra_lunes', $f["hora_extra_lunes"]);
			$xml->add_nodo('hora_extra_martes', $f["hora_extra_martes"]);
			$xml->add_nodo('hora_extra_miercoles', $f["hora_extra_miercoles"]);
			$xml->add_nodo('hora_extra_jueves', $f["hora_extra_jueves"]);
			$xml->add_nodo('hora_extra_viernes', $f["hora_extra_viernes"]);
			$xml->add_nodo('hora_extra_sabado', $f["hora_extra_sabado"]);
			$xml->add_nodo('hora_extra_domingo', $f["hora_extra_domingo"]);
			$xml->add_nodo('id_grupo_horario', $f["id_grupo_horario"]);
			$xml->add_nodo('desc_horario', $f["desc_horario"]);
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