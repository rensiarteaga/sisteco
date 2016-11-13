<?php

session_start();
include_once('../../LibModeloTesoreria.php');
$Custom = new cls_CustomDBTesoreria();

$nombre_archivo = 'ActionReporteRendicion.php';



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

if($sort == '') $sortcol = 'CAJREG.id_caja_regis';
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
	//echo $id_viatico;exit;
	$criterio_filtro= $criterio_filtro ." AND CAJREG.id_caja_regis=$id_caja_regis";
	$_SESSION['PDF_id_caja_regis']=$id_caja_regis;
	$_SESSION['PDF_id_caja']=$id_caja;
	//$_SESSION['PDF_sw_cheque']=$sw_cheque;
	
	$rendicion = array();
	$rendicion_det = array();
		$rendicion = $Custom-> ListarReporteRendicionHeader($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
		
			foreach ($Custom->salida as $f)
			{ 
				$_SESSION['PDF_fecha_regis'] = $f["fecha_regis"];
				$_SESSION['PDF_importe_regis']=$f["importe_regis"];
				$_SESSION['PDF_tipo_caja']=$f["tipo_caja"];
				$_SESSION['PDF_nombre_completo']=$f["nombre_completo"];
				$_SESSION['PDF_nombre_unidad']=$f["nombre_unidad"];
				$_SESSION['PDF_nombre_moneda']=$f["nombre"];
				$_SESSION['PDF_fecha_actual'] = $f["fecha_actual"];
			}
			
		//$criterio_filtro= " AND CAJA.id_caja=$id_caja AND CAJREG.fecha_regis between $fecha_regis AND CURRENT_DATE";	
		//$rendicion_det = $Custom-> ListarReporteRendicionReposicion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
		$_SESSION['PDF_rendicion_reposicion']=$Custom->salida;
			/*foreach ($Custom->salida as $f)
			{ 
				$_SESSION['PDF_tipo_documento'] = $f["tipo_documento"];
				$_SESSION['PDF_nombre_documento']=$f["nombre"];
				$_SESSION['PDF_nit_auto']=$f["numeros"];
				$_SESSION['PDF_importe_regis']=$f["importe_regis"];
						
			}	*/
	/*		
	$criterio_filtro=' 0=0 ';
	$criterio_filtro="$criterio_filtro AND VIATI.id_viatico=$id_viatico";	
		
	$solicitud_det = $Custom-> ListarReporteViaticoEP($cant,$puntero,'VIATI.id_fina_regi_prog_proy_acti',$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	
		
	$_SESSION['PDF_EP_rendicion']=$Custom->salida;
	
	$criterio_filtro=' 0=0 ';
	$criterio_filtro="$criterio_filtro AND uniorg.id_unidad_organizacional = $id_unidad_organizacional AND emp_ep.id_fina_regi_prog_proy_acti = $id_fina_regi_prog_proy_acti";	
		//echo $criterio_filtro;exit;
	$solicitud_det = $Custom-> ListarNombreGerente($cant,$puntero,'uniorg.id_unidad_organizacional',$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	
		
	foreach ($Custom->salida as $f)
			{ 
				$_SESSION['PDF_nombre_nivel']=$f["nombre_nivel"];
				$_SESSION['PDF_id_unidad_organizacional'] = $f["id_unidad_organizacional"];
				$_SESSION['PDF_nombre_cargo']=$f["nombre_cargo"];
				$_SESSION['PDF_nombre_geren']=$f["nombre"];
			}			
	*/
	header("location: ../../../control/_reportes/rendicion/PDFReporteRendicion2.php");
	}
else
	{
		header("HTTP/1.0 401 No autorizado");
		header('Content-Type: text/plain; charset=iso-8859-1');
		echo "No tiene los permisos necesarios ";
	}

?>