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
	
	$criterio_filtro= $criterio_filtro ." AND CAJREG.id_caja_regis=$id_caja_regis";
	$_SESSION['PDF_id_Caja_regis']=$id_caja_regis;
	$_SESSION['PDF_tipo']=$tipo;
	
	$solicitud = array();
	$solicitud_det = array();
		$solicitud = $Custom-> ListarReporteValeCaja($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
		
			foreach ($Custom->salida as $f)
			{ 
				$_SESSION['PDF_fecha'] = $f["fecha"];
				$_SESSION['PDF_hora']=$f["hora"];
				$_SESSION['PDF_numero']=$f["numero"];
				$_SESSION['PDF_caja']=$f["caja"];
				$_SESSION['PDF_cajero']=$f["cajero"];
				$_SESSION['PDF_unidad']=$f["unidad"].'';
				$_SESSION['PDF_empleado']=$f["empleado"];
				$_SESSION['PDF_importe_entregado']=$f["importe_entregado"];
				$_SESSION['PDF_concepto']=$f["concepto"];
				$_SESSION['PDF_importe_literal']=$f["importe_literal"];
				$_SESSION['PDF_nombre_completo']=$f["nombre_completo"];
				$_SESSION['PDF_lugar_sus']=$f["lugar_sus"];
				$_SESSION['PDF_moneda']=$f["moneda"];
				$_SESSION['PDF_fecha_regis'] = $f["fecha_regis"];
				
				
			}
	$criterio_filtro=' 0=0 ';
	$criterio_filtro="$criterio_filtro AND CAJREG.fk_id_caja_regis=$id_caja_regis";	
		
	$solicitud_det = $Custom-> ListarReporteRendicionEP($cant,$puntero,'CAJREG.id_fina_regi_prog_proy_acti',$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	
		
	$_SESSION['PDF_EP_rendicion']=$Custom->salida;
				
	
			
	header("location: ../../../vista/vales_caja/PDFRendicion.php");
	}
else
	{
		header("HTTP/1.0 401 No autorizado");
		header('Content-Type: text/plain; charset=iso-8859-1');
		echo "No tiene los permisos necesarios ";
	}

?>