<?php
session_start();
include_once('../../LibModeloTesoreria.php');

$Custom = new cls_CustomDBTesoreria();

$nombre_archivo = 'ActionPDFSolViaje.php';


if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}

if($_SESSION['autentificado']=="SI")
{
	
    if($limit == '') $cant = 1500;
	else $cant = $limit;

	if($start == '') $puntero = 0;
	else $puntero = $start;

	if($sort == '') $sortcol = ' ';   /// tengo que   cambiar de acuerdo a la consulta
	else $sortcol = $sort;

	if($dir == '') $sortdir = 'desc';
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
	/*echo $m_id_cuenta_doc;
	exit;*/
	$criterio_filtro = $criterio_filtro.' AND cuedoc.id_cuenta_doc='.$m_id_cuenta_doc;
	/*echo $m_id_cuenta_doc;
	exit;*/
	//$Proceso = array();
	$SolViaje = array();
	//$DetRendicionCuenta = array();
	
	
	
	$SolViaje= $Custom-> ListarSolicitudViajes($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	 
	if(count($Custom->salida)!=0){
		 
	
	$_SESSION['PDF_solicitud_viaje']=$Custom->salida;
	$_SESSION['PDF_estado']=$estado;
	
	
     $detalle_solicitud=$Custom->ListarSolicitudViajesDetalle($cant,$puntero,$sortcol,$sortdir,' cuedod.id_cuenta_doc='.$m_id_cuenta_doc,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
     $_SESSION['PDF_solicitud_viaje_det']=$Custom->salida;
    /* print_r($detalle_solicitud);
    
     exit;*/
      header("location: ../../../vista/cuenta_doc_rendicion/PDFSolicitudViaje1.php");
	}
 else{
		echo"No retorna ningún valor de la base de datos consulte con el Administrador";
	}

	}
else
	{
		header("HTTP/1.0 401 No autorizado");
		header('Content-Type: text/plain; charset=iso-8859-1');
		echo "No tiene los permisos necesarios ";
	}

?>