<?php
session_start();
include_once('../../LibModeloTesoreria.php');
$Custom = new cls_CustomDBTesoreria();

$nombre_archivo = 'ActionPDFRendicionPagoCaja.php';



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

    if($sort == '') $sortcol = 'cuedoc.id_cuenta_doc';
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
	//$criterio_filtro= $criterio_filtro." and cuedoc.tipo_avance=1 and ava.id_avance=$m_id_avance and has.estado=''activo'' ";
	$criterio_filtro= $criterio_filtro." and cuedoc.id_cuenta_doc=$m_id_cuenta_doc ";
	/*echo $m_id_cuenta_doc;
	exit;*/
	$solicitud_fondo = array();
	$solicitud_fondo = $Custom-> ListarCabeceraRendicionPagoCaja($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	if(count($Custom->salida)!=0){
		$_SESSION['PDF_solicitud_fondo']=$Custom->salida;
		//$_SESSION['PDF_estado']=$estado;
			foreach ($Custom->salida as $f)
			{
				$_SESSION['PDF_fecha'] = $f["fecha"];
				$_SESSION['PDF_hora']=$f["hora"];
				$_SESSION['PDF_caja']=$f["caja"];
				$_SESSION['PDF_cajero']=$f["cajero"];
				$_SESSION['PDF_nombre_moneda'] = $f["nombre_moneda"];
				$_SESSION['PDF_nombre_lugar'] = $f["nombre_lugar"];
				$_SESSION['PDF_empleado'] = $f["responsable"];
				$_SESSION['PDF_fk_id_cuenta_doc'] = $f["fk_id_cuenta_doc"];
				$_SESSION['PDF_nro_documento'] = $f["nro_documento"];
				$_SESSION['PDF_motivo'] = $f["motivo"];
				$_SESSION['PDF_id_subsistema'] = $f["id_subsistema"];
				$_SESSION['PDF_monto_entregado'] = $f["monto_entregado"];
				$_SESSION['PDF_retencion'] = $f["retencion"];
				$_SESSION['PDF_importe_total'] = $f["importe_total"];
				$_SESSION['PDF_importe_rendicion'] = $f["importe_rendicion"];
				$id_cuenta_doc_rendicion = $f["id_cuenta_doc_rendicion"];
				$_SESSION['PDF_importe_literal'] = $f["importe_literal"];
				$_SESSION['PDF_estado']=$f["estado"];
				$_SESSION['PDF_aprobador']=$f["aprobador"];				
			}
		// Aqui colocare el detalle 
		/*echo $id_cuenta_doc_rendicion;
		exit;*/
		$detalle_solicitud=$Custom->ListarReciboCaja($cant,$puntero,$sortcol,$sortdir,' cuedod.id_cuenta_doc_rendicion='.$id_cuenta_doc_rendicion,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
         		$_SESSION["PDF_recibo_pago_det"]=$Custom->salida;
		
		
		 header("location: ../../../vista/solicitud_viaticos2/PDFRendicionPagoCaja.php");		
	}else{
		 echo"No retorna ningun valor de la base de datos consulte con el Administrador";
	}
			
}
else
	{
		header("HTTP/1.0 401 No autorizado");
		header('Content-Type: text/plain; charset=iso-8859-1');
		echo "No tiene los permisos necesarios ";
	}

?>