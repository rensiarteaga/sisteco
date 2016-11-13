<?php
session_start();
include_once('../../LibModeloTesoreria.php');
$Custom = new cls_CustomDBTesoreria();

$nombre_archivo = 'ActionPDFSolicitudFondos.php';



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

    if($sort == '') $sortcol = 'ava.id_avance';
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
	
	$solicitud_fondo = array();
	$solicitud_fondo = $Custom-> ListarSolicitudFondosCab($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	if(count($Custom->salida)!=0){
		$_SESSION['PDF_solicitud_fondo']=$Custom->salida;
		foreach ($Custom->salida as $f)
			{
				$_SESSION['PDF_nro_sol'] = $f["nro_sol"];
				$_SESSION['PDF_fecha_solicitud']=$f["fecha_solicitud"];
				$_SESSION['PDF_nombre_empleado']=$f["nombre_empleado"];
				$_SESSION['PDF_cargo']=$f["cargo"];
				$_SESSION['PDF_centro_responsabilidad'] = $f["centro_responsabilidad"];
				$_SESSION['PDF_concepto_avance'] = $f["concepto_avance"];
				$_SESSION['PDF_lugar'] = $f["lugar"];
				$_SESSION['PDF_fecha_ini'] = $f["fecha_ini"];
				$_SESSION['PDF_observaciones'] = $f["observaciones"];
				$_SESSION['PDF_simbolo'] = $f["simbolo"];
				$_SESSION['PDF_motivo'] = $f["motivo"];
				$_SESSION['PDF_tipo_pago'] = $f["tipo_pago"];
			}
		
		 $detalle_solicitud=$Custom->ListarSolicitudViajesDetalle($cant,$puntero,$sortcol,$sortdir,' cuedod.id_cuenta_doc='.$m_id_cuenta_doc,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
         $_SESSION['PDF_solicitud_viaje_det']=$Custom->salida;
		 header("location: ../../../vista/solicitud_viaticos2/PDFSolicitudFondos.php");		
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