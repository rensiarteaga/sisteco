<?php

session_start();
include_once('../../LibModeloAdquisiciones.php');
$Custom = new cls_CustomDBAdquisiciones();

$nombre_archivo = 'ActionPDFListaCompras.php';



if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{
    if($limit == "") $cant = 15;
	else $cant = $limit;

	if($start == "") $puntero = 0;
	else $puntero = $start;

if($sort == '') $sortcol = 'PROCOM.id_proceso_compra';
//	if($sort == '') $sortcol = 'PRODET.id_item';
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
	
//	$criterio_filtro= $criterio_filtro ." AND PROCOM.id_proceso_compra=".$m_id_proceso_compra;
	//echo $id_presupuesto;
	//exit;
	/*echo $txt_fecha_desde;
	echo $txt_fecha_hasta;
	exit;*/
	/*$Presupuesto = array();
	$Presupuesto = $Custom-> ListarRepProcesosEnCursoCabPres($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$id_presupuesto);
	
	$_SESSION["PDF_procesos_presupuesto"]=$Custom->salida;*/
	
	$Proceso = array();
	$Proceso = $Custom->ListarRepProcesosEnCurso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_presupuesto,$tipo_adq,$gestion,$txt_fecha_desde,$txt_fecha_hasta,$id_partida);
	
	$_SESSION["PDF_procesos_detalle"]=$Custom->salida;
     	
    header("location: ../../../vista/_reportes/procesos_en_curso/PDFProcesosEnCurso.php");
	}
else
	{
		header("HTTP/1.0 401 No autorizado");
		header('Content-Type: text/plain; charset=iso-8859-1');
		echo "No tiene los permisos necesarios ";
	}

?>