<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarDestino.php
Prop�sito:				Permite realizar el listado en tpr_destino
Tabla:					t_tpr_destino
Par�metros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creaci�n:		2008-07-04 08:54:29
Versi�n:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once('../LibModeloPresupuesto.php');

$Custom = new cls_CustomDBPresupuesto();
$nombre_archivo = 'ActionListarEjecucionFech.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']='NO';
}
if($_SESSION['autentificado']=='SI')
{
//Par�metros del filtro
	if($limit == '') $cant = 15;
	else $cant = $limit;

	if($start == '') $puntero = 0;
	else $puntero = $start;

	if($sort == '') $sortcol = 'codigo_partida';
	else $sortcol = $sort;

	if($dir == '') $sortdir = 'asc';
	else $sortdir = $dir;

	//Verifica si se har� o no la decodificaci�n(s�lo pregunta en caso del GET)
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

	$fecha= substr( $_POST['fecha_fin'],3,2)."/".substr( $_POST['fecha_fin'],0,2)."/".substr( $_POST['fecha_fin'],6,4);
	$fecha_ini= substr( $_POST['fecha_ini'],3,2)."/".substr( $_POST['fecha_ini'],0,2)."/".substr( $_POST['fecha_ini'],6,4);

	//Obtiene el total de los registros
	$res = $Custom -> ContarEjecucionPartidaFech($cant,$puntero,$sortcol ,$sortdir,$criterio_filtro,$_POST['id_financiador'],$_POST['id_regional'],$_POST['id_programa'],$_POST['id_proyecto'],$_POST['id_actividad'],$_POST['tipo_pres'],$_POST['id_parametro'],$_POST['id_moneda'],$_POST['ids_u_o'],$_POST['ids_financiador'],$_POST['ids_regional'],$_POST['ids_programa'],$_POST['ids_proyecto'],$_POST['ids_actividad'],$_POST['sw_vista'],$fecha,$fecha_ini);

	
	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarEjecucionPartidaFech($cant,$puntero,$sortcol ,$sortdir,$criterio_filtro,$_POST['id_financiador'],$_POST['id_regional'],$_POST['id_programa'],$_POST['id_proyecto'],$_POST['id_actividad'],$_POST['tipo_pres'],$_POST['id_parametro'],$_POST['id_moneda'],$_POST['ids_u_o'],$_POST['ids_financiador'],$_POST['ids_regional'],$_POST['ids_programa'],$_POST['ids_proyecto'],$_POST['ids_actividad'],$_POST['sw_vista'],$fecha,$fecha_ini);
	
	//echo $Custom->query;
		//exit;
		
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
				$xml->add_nodo('sw_transaccional',$f["sw_transaccional"]);
				$xml->add_nodo('traspaso',$f["traspaso"]);
				$xml->add_nodo('reformulacion',$f["reformulacion"]);
				$xml->add_nodo('comprometido',$f["comprometido"]);				
				$xml->add_nodo('devengado',$f["devengado"]);				
				$xml->add_nodo('pagado',$f["pagado"]);
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
	