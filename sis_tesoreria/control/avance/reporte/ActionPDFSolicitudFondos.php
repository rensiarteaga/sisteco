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
	$criterio_filtro= $criterio_filtro." and ava.tipo_avance=1 and ava.id_avance=$m_id_avance and has.estado=''activo'' ";
	

	
	$solicitud_fondo = array();
	$solicitud_fondo = $Custom-> ListarRepSolicitudFondos($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	$_SESSION['PDF_solicitud_fondo']=$Custom->salida;
	
			foreach ($Custom->salida as $f)
			{   $_SESSION['PDF_nro_sol'] = $f["nro_sol"];
				$_SESSION['PDF_fecha_solicitud']=$f["fecha_solicitud"];
				$_SESSION['PDF_nombre_empleado']=$f["nombre_empleado"];
				$_SESSION['PDF_cargo']=$f["cargo"];
				$_SESSION['PDF_centro_responsabilidad'] = $f["centro_responsabilidad"];
				$_SESSION['PDF_concepto_avance'] = $f["concepto_avance"];
				$_SESSION['PDF_lugar'] = $f["lugar"];
				$_SESSION['PDF_fecha_ini'] = $f["fecha_ini"];
				$_SESSION['PDF_monto'] = $f["monto"];
				$_SESSION['PDF_monto_literal'] = $f["monto_literal"];
				$_SESSION['PDF_detalle_gasto'] = $f["detalle_gasto"];
				$_SESSION['PDF_total'] = $f["total"];
				$_SESSION['PDF_observacion_avance'] = $f["observacion_avance"];
					}
		/*echo "no llega?".$_SESSION['PDF_fecha_solicitud'];
		exit;
	   
	*/
	if(count($Custom->salida)!=0){
		header("location: ../../../vista/solicitud_fondos/PDFSolicitudFondos.php");		
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