<?php

session_start();
include_once('../../LibModeloTesoreria.php');
$Custom = new cls_CustomDBTesoreria();

$nombre_archivo = 'ActionPDFCheque.php';



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

    if($sort == '') $sortcol = 'CHEQUE.id_cheque';
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
	/*echo "id_avance".$m_id_avance;
	exit;*/
	//$criterio_filtro= $criterio_filtro ." AND AVANCE.id_avance=$m_id_avance";
	/*if($m_id_avance==0){
	$criterio_filtro= $criterio_filtro ." AND CHEQUE.id_cheque=$m_id_cheque";
	}else{
	*/
	$criterio_filtro= $criterio_filtro ." AND AVANCE.id_avance=$id_avance";
	//}
	$cheque = array();
		$cheque = $Custom-> ReporteReciboFondoAvance($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
		$_SESSION['PDF_recibo_entrega']=$Custom->salida;
			foreach ($Custom->salida as $f)
			{ 
				$_SESSION['PDF_fecha_avance'] = $f["fecha_avance"];
				$_SESSION['PDF_nro_cheque']=$f["nro_cheque"];
				$_SESSION['PDF_nomb_empleado']=$f["nomb_empleado"];
				$_SESSION['PDF_nombre_institucion']=$f["nombre_institucion"];
				$_SESSION['PDF_importe_avance1']=$f["importe_avance"];
				$_SESSION['PDF_importe_avance_literal1']=$f["importe_avance_literal"];
				$_SESSION['PDF_nombre_financiador']=$f["nombre_financiador"];
				$_SESSION['PDF_nombre_regional']=$f["nombre_regional"];
				$_SESSION['PDF_nombre_programa']=$f["nombre_programa"];
				$_SESSION['PDF_nombre_proyecto']=$f["nombre_proyecto"];
				$_SESSION['PDF_nombre_actividad']=$f["nombre_actividad"];
				$_SESSION['PDF_nro_avance']=$f["nro_avance"];
				$_SESSION['PDF_nombre_unidad']=$f["nombre_unidad"];
			}
		
	
			
			header("location: ../../../vista/solicitud_fondos/PDFReciboEntrega.php");
	}
else
	{
		header("HTTP/1.0 401 No autorizado");
		header('Content-Type: text/plain; charset=iso-8859-1');
		echo "No tiene los permisos necesarios ";
	}

?>