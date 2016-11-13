<?php

session_start();
include_once('../../LibModeloAdquisiciones.php');
$Custom = new cls_CustomDBAdquisiciones();

$nombre_archivo = 'ActionPDFCotizacion.php';



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

if($sort == '') $sortcol = 'COTIZA.id_cotizacion';
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
	
	$criterio_filtro= $criterio_filtro ." AND COTIZA.id_cotizacion=$m_id_cotizacion";
	
	/*echo "mmm no se que sera no entra a nada".$m_id_Cotizacion_compra;
	exit;
	*/


	$Cotizacion = array();
	$Cotizacion_det = array();
		$Cotizacion = $Custom-> ReporteCotizacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
		//$_SESSION['PDF_Cotizacion']=$Custom->salida;
		/*print_r($Custom->salida);
		exit;*/
			foreach ($Custom->salida as $f)
			{
				$_SESSION['PDF_id_cotizacion'] = $f["id_cotizacion"];
				$_SESSION['PDF_id_proceso_compra']=$f["id_proceso_compra"];
				$_SESSION['PDF_fecha_reg']=$f["fecha_reg"];
				$_SESSION['PDF_num_cotizacion']=$f["num_cotizacion"];
				$_SESSION['PDF_nombres']=$f["nombres"];
				$_SESSION['PDF_casilla']=$f["casilla"];
				$_SESSION['PDF_telefono1']=$f["telefono1"];
				$_SESSION['PDF_telefono2']=$f["telefono2"];
				$_SESSION['PDF_celular1']=$f["celular1"];
				$_SESSION['PDF_celular2']=$f["celular2"];
				$_SESSION['PDF_email1']=$f["email1"];
				$_SESSION['PDF_email2']=$f["email2"];
				$_SESSION['PDF_fax']=$f["fax"];
				$_SESSION['PDF_direccion']=$f["direccion"];
				$_SESSION['PDF_gestion']=$f["gestion"];
			}
		
		$Cotizacion_det = $Custom-> RepCotizacionDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
		$_SESSION['PDF_cotizacion_det']=$Custom->salida;
		
	
			
			header("location: ../../../vista/cotizacion/PDFCotizacion.php");
	}
else
	{
		header("HTTP/1.0 401 No autorizado");
		header('Content-Type: text/plain; charset=iso-8859-1');
		echo "No tiene los permisos necesarios ";
	}

?>