<?php

session_start();
include_once('../../LibModeloAdquisiciones.php');
$Custom = new cls_CustomDBAdquisiciones();

$nombre_archivo = 'ActionPDFNuevaConvocatoria.php';

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

if($sort == '') $sortcol = 'procom.id_proceso_compra';
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
	
	
	$criterio_filtro= $criterio_filtro ." AND procom.id_proceso_compra=".$id_proceso_compra_0;
	
	$Pago= array();
    $Pago = $Custom-> RepNuevaConvocatoria($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
		
			foreach ($Custom->salida as $f)
			{  
			    $_SESSION['PDF_codigo'] = $f["codigo"];
				$_SESSION['PDF_num_convocatoria_sig'] = $f["num_convocatoria_sig"];
				$_SESSION['PDF_observaciones']=$f["observaciones"];
				$_SESSION['PDF_num_convocatoria']=$f["num_convocatoria"];
				$_SESSION['PDF_num_proceso']=$f["num_proceso"];
				$_SESSION['PDF_tipo_adq']=$f["tipo_adq"];
				$_SESSION['PDF_gestion']=$f["gestion"];
			}
	
			header("location: ../../../vista/proceso_compra/PDFNuevaConvocatoria.php");
	}
else
	{
		header("HTTP/1.0 401 No autorizado");
		header('Content-Type: text/plain; charset=iso-8859-1');
		echo "No tiene los permisos necesarios ";
	}

?>