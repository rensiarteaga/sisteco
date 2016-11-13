<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarDestino.php
Propósito:				Permite realizar el listado en tpr_destino
Tabla:					t_tpr_destino
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		2008-07-04 08:54:29
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once('../LibModeloPresupuesto.php');

$Custom = new cls_CustomDBPresupuesto();
$nombre_archivo = 'ActionListarConsistencia.php';

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

	if($sort == '') $sortcol = 'contabilidad.codigo_partida';
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
	//if($CantFiltros=='') {$CantFiltros = 0;}

	//Se obtiene el criterio del filtro con formato sql para mandar a la BD
	$cond = new cls_criterio_filtro($decodificar);
	for($i=0;$i<$_POST["CantFiltros"];$i++)
	{
		$cond->add_condicion_filtro($_POST["filterCol_$i"], $_POST["filterValue_$i"], $_POST["filterAvanzado_$i"]);
	}
	
	
	
	$criterio_filtro = $cond -> obtener_criterio_filtro();
	//ECHO $criterio_filtro."  CIRTERIO FLTRO ".$_POST["CantFiltros"] ; exit();
	//Obtiene el criterio de orden de columnas
	
	//$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'Destino');
	
	
	//$sortcol = $crit_sort->get_criterio_sort();
	
 


/*echo $_POST['ids_proyecto'], ;
	exit();*/
 

	//Obtiene el total de los registros
	$res = $Custom -> ContarConsistenciaEjecucion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$m_fecha_fin,$m_fecha_inicio,$_POST['m_ids_presupuesto'],$_POST['m_ids_depto'], $id_moneda);

	if($res) $total_registros= $Custom->salida;


	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarConsistenciaEjecucion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$m_fecha_fin,$m_fecha_inicio,$_POST['m_ids_presupuesto'],$_POST['m_ids_depto'], $id_moneda);
	
	if($res)
	{	$contador=0;
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);
		
		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			
				$xml->add_nodo('id_partida',$f["id_partida"]);
				$xml->add_nodo('codigo_partida',$f["codigo_partida"]);
				$xml->add_nodo('nombre_partida',$f["nombre_partida"]);
				$xml->add_nodo('gasto',$f["gasto"]);
				$xml->add_nodo('devengado',$f["devengado"]);
				$xml->add_nodo('diferencia',$f["diferencia"]);
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
