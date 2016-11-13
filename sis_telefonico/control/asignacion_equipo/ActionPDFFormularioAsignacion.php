<?php

session_start();
include_once('../LibModeloSistemaTelefonico.php');
$Custom = new cls_CustomDBSistemaTelefonico();
$Custom1 = new cls_CustomDBSistemaTelefonico();
$nombre_archivo = 'ActionPDFFormularioAsignacion.php';



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

	if($sort == '') $sortcol = 'a.id_asignacion_equipo';
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
	
	$criterio_filtro= $criterio_filtro ." AND a.id_asignacion_equipo=$id_asignacion_equipo";
	
	$solicitud = array();
	
		$solicitud = $Custom-> ListarRepAsignacionEquipo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	
			foreach ($Custom->salida as $f)
			{ 
				$_SESSION['PDF_nro_asignacion'] = $f["nro_asignacion"];
				$_SESSION['PDF_numero_telefono']=$f["numero_telefono"];
				$_SESSION['PDF_nombre']=$f["nombre"];
				$_SESSION['PDF_monto_llamada']=$f["monto_llamada"];
				$_SESSION['PDF_monto_datos']=$f["monto_datos"];
				$_SESSION['PDF_marca']=$f["marca"].'';
				$_SESSION['PDF_modelo']=$f["modelo"];
				$_SESSION['PDF_imei']=$f["imei"];
				$_SESSION['PDF_sim_card']=$f["sim_card"];
				$_SESSION['PDF_observaciones']=$f["observaciones"];
				$_SESSION['PDF_fecha_ini']=$f["fecha_ini"];
				$_SESSION['PDF_resp_asignacion']=$f["resp_asignacion"];
				$_SESSION['PDF_empleado']=$f["empleado"];
				$_SESSION['PDF_desc_correspondencia']=$f["desc_correspondencia"];
				$_SESSION['PDF_tipo_asignacion']=$f["tipo_asignacion"];
					
			}
			header("Content-Type: application/pdf");

			header("location: ../../vista/asignacion_equipo/PDFSolicitudAsignacion.php?hora=".date('H:i:s'));
	}
else
	{
		header("HTTP/1.0 401 No autorizado");
		header('Content-Type: text/plain; charset=iso-8859-1');
		echo "No tiene los permisos necesarios ";
	}

?>